<?php
namespace api\logic;

use api\dao\CommentDao;
use api\dao\UserDao;
use api\dao\VideoDao;
use api\data\ActiveDataProvider;
use api\models\user\TaskInfo;
use api\models\user\User;
use common\helpers\Tool;
use common\models\setting\SettingSystem;
use Yii;
use api\exceptions\ApiException;
use api\exceptions\LoginException;
use api\helpers\ErrorCode;
use api\models\video\Comment;
use api\models\video\CommentLike;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use yii\helpers\ArrayHelper;

class CommentLogic
{
    /**
     * 提交评论
     * @param $uid
     * @param $content
     * @param $videoId
     * @param $chapterId
     * @param $commentPid
     * @return array
     * @throws ApiException
     * @throws LoginException
     */
    public function postComment($uid, $content, $videoId, $chapterId, $commentPid)
    {
        // 处理并发
        $redis = new RedisStore();

        $redisKey = RedisKey::getApiLockKey('comment/post-comment', [
                'uid'        => $uid,
                'videoId'    => $videoId,
                'chapterId'  => $chapterId,
                'commentPid' => $commentPid
            ]
        );

        if ($redis->checkLock($redisKey)) {
            throw new LoginException(ErrorCode::EC_SYSTEM_OPERATING);
        }

        // 获取影片剧集信息
        $videoDao = new VideoDao();
        if (!$chapterId) {
            $videos = $videoDao->videoChapter($videoId, [], true);
            if (!$videos) { // 没有剧集抛出异常
                throw new ApiException(ErrorCode::EC_VIDEO_CHAPTER_NOT_EXIST);
            }
            $chapterId = reset($videos)['chapter_id'];
        }

        $comment = new Comment();
        if (!$commentPid) { // 一级评论 pid 为0
            $comment->pid     = 0;
            $comment->content = $content;
        } else {
            if (!Comment::findOne(['id' => $commentPid])) { // 异常数据,父级评论不存在
                $redis->releaseLock($redisKey);
                throw new ApiException(ErrorCode::EC_PARAM_INVALID);
            }
            $comment->pid     = $commentPid;
        }
        $comment->content    = $content;
        $comment->uid        = $uid;
        $comment->video_id   = $videoId;
        $comment->chapter_id = $chapterId;
        $comment->source     = Yii::$app->common->source;

        // 评论是否需要审核
        $isReview = Yii::$app->setting->get('system.comment_switch');

        if ($isReview == SettingSystem::COMMENT_REVIEW_ON) {
            $comment->status = Comment::STATUS_EXAMINE_ING;
        } else {
            $comment->status = Comment::STATUS_EXAMINE_YES;
        }
        if (!$comment->save()) {
            $redis->releaseLock($redisKey);
            throw new ApiException(ErrorCode::EC_DB_ERROR);
        }
        
        // 剧集评论数增加
        $videoDao->addTotalComment($videoId, $chapterId);
        // 完成任务
        $taskLogic = new TaskLogic();
        $taskLogic->finishTask(TaskInfo::TASK_ACTION_COMMENT_ONCE);
        // 释放锁
        $redis->releaseLock($redisKey);
        // 获取用户信息
        $user = Yii::$app->user;
        //评论总数
        $total = Comment::find()
               ->joinWith('user')
               ->andWhere(['video_id' => $videoId, Comment::tableName().'.status' => Comment::STATUS_EXAMINE_YES])
               ->andWhere([User::tableName().'.status' => User::STATUS_ENABLED])
               ->andFilterWhere(['chapter_id' => $chapterId])
               ->count();

        $data = [
            'comment_id' => $comment->id,
            'uid'        => $uid,
            'pid'        => $comment->pid,
            'content'    => $comment->content,
            'likes_num'  => 0,
            'time_flag'  => '刚刚',
            'reply_num'  => 0,
            'avatar'     => $user->avatar->toUrl(),
            'nickname'   => $user->nickname,
            'is_like'    => 0,
            'total'      => intval($total),
            'reply_info' => '',
        ];

        if ($comment->pid) {
            $data['reply_info'] = array_shift($this->batchGetReplyInfo($comment->pid));
        }

        return ['is_review' => $comment->status, 'data' => $data];
    }

    /**
     * 评论列表
     * @param $videoId
     * @param $pageNum
     * @param $chapterId
     * @return array|mixed
     */
    public function commentList($videoId, $chapterId = 0, $pageNum = 1)
    {
        $key = RedisKey::videoComment($videoId, $chapterId, $pageNum);
        $redis = new RedisStore();
        if ($data = $redis->get($key)) {
            $data = json_decode($data, true);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Comment::find()
                    ->andWhere(['video_id' => $videoId])
                    ->andFilterWhere(['chapter_id' => ($chapterId ? $chapterId : '')])
            ]);
            $data = $dataProvider->setPagination(['page_num' => $pageNum])->toArray();
            // 获取用户头像，昵称等信息
            $uid = array_column($data['list'], 'uid');
            $userDao = new UserDao();
            $userInfo = ArrayHelper::index($userDao->batchGetUser($uid), 'uid');
            foreach ($data['list'] as &$item) {
                if (empty($userInfo[$item['uid']])) {
                    $userInfo[$item['uid']] = [
                        'uid' => $item['uid'],
                        'nickname' => '',
                        'avatar' => '',
                    ];
                }
                $item = array_merge($item, $userInfo[$item['uid']]);
            }
            // 获取父级评论
            $data['list'] = $this->_getParentComment($data['list']);
            $redis->setEx($key, json_encode($data, JSON_UNESCAPED_UNICODE));
        }

        return $data;
    }

    /**
     * 获取评论的父级评论
     * @param array $data
     * @return array
     */
    private function _getParentComment(array $data)
    {
        // 获取父级评论
        $arrPid = array_unique(array_column($data, 'pid'));
        ArrayHelper::removeValue($arrPid, 0);
        $replayInfo = $this->batchGetReplyInfo($arrPid);
        foreach ($data as &$item) {
            $item['reply_info'] = isset($replayInfo[$item['pid']]) ? $replayInfo[$item['pid']] : '';
        }

        return $data;
    }


    /**
     * 取评论回复信息
     * @param $commentIds
     * @return array
     */
    public function batchGetReplyInfo($commentIds) {
        if (empty($commentIds)) {
            return [];
        }

        $b = Comment::tableName();
        $comments = Comment::find()
            ->select("$b.content, $b.uid, $b.id, u.nickname")
            ->leftJoin(User::tableName().' u', $b.'.uid=u.uid')
            ->andWhere([
                $b.'.id' => $commentIds,
            ])
            ->asArray()
            ->all();

        $replayInfo = [];

        foreach ($comments as $info) {
            $nickname = $info['nickname'] ? $info['nickname'] : USER_NICKNAME_PREFIX;
            $replayInfo[$info['id']] = '回复'. $nickname. '：'. $info['content'];
        }
        return $replayInfo;
    }

    /*
     * 提交评论
     */
    public function postCommentPC($uid, $content, $videoId, $chapterId, $commentPid)
    {
        //判断同一用户10S内评论一次
        $maxtime = Comment::find()->select('updated_at')
                    ->andWhere(['uid'=>$uid])->andWhere(['video_id'=>$videoId])->andWhere(['chapter_id'=>$chapterId])
                    ->max('updated_at');
        if(time()-$maxtime<=10){
            return ['is_review' => -1];
        }
        // 处理并发
        $redis = new RedisStore();

        $redisKey = RedisKey::getApiLockKey('comment/post-comment', [
                'uid'        => $uid,
                'videoId'    => $videoId,
                'chapterId'  => $chapterId,
                'commentPid' => $commentPid
            ]
        );

        if ($redis->checkLock($redisKey)) {
            throw new LoginException(ErrorCode::EC_SYSTEM_OPERATING);
        }

        // 获取影片剧集信息
        $videoDao = new VideoDao();
        if (!$chapterId) {
            $videos = $videoDao->videoChapter($videoId, [], true);
            if (!$videos) { // 没有剧集抛出异常
                throw new ApiException(ErrorCode::EC_VIDEO_CHAPTER_NOT_EXIST);
            }
            $chapterId = reset($videos)['chapter_id'];
        }

        $comment = new Comment();
        if (!$commentPid) { // 一级评论 pid 为0
            $comment->pid     = 0;
            $comment->content = $content;
        } else {
            if (!Comment::findOne(['id' => $commentPid])) { // 异常数据,父级评论不存在
                $redis->releaseLock($redisKey);
                throw new ApiException(ErrorCode::EC_PARAM_INVALID);
            }
            $comment->pid     = $commentPid;
        }
        $comment->content    = $content;
        $comment->uid        = $uid;
        $comment->video_id   = $videoId;
        $comment->chapter_id = $chapterId;
        $comment->source     = Yii::$app->common->source;

        // 评论是否需要审核
        $isReview = Yii::$app->setting->get('system.comment_switch');

        if ($isReview == SettingSystem::COMMENT_REVIEW_ON) {
            $comment->status = Comment::STATUS_EXAMINE_ING;
        } else {
            $comment->status = Comment::STATUS_EXAMINE_YES;
        }
        if (!$comment->insert()) {
            $redis->releaseLock($redisKey);
            throw new ApiException(ErrorCode::EC_DB_ERROR);
        }

        // 剧集评论数增加
        $videoDao->addTotalComment($videoId, $chapterId);
        // 完成任务
        $taskLogic = new TaskLogic();
        $taskLogic->finishTask(TaskInfo::TASK_ACTION_COMMENT_ONCE,$uid);
        // 释放锁
        $redis->releaseLock($redisKey);
        // 获取用户信息
        $user = User::find()->andWhere(['uid'=>$uid])->asArray()->one();
        //评论总数
        $total = Comment::find()
            ->joinWith('user')
            ->andWhere(['video_id' => $videoId, Comment::tableName().'.status' => Comment::STATUS_EXAMINE_YES])
            ->andWhere([User::tableName().'.status' => User::STATUS_ENABLED])
            ->andFilterWhere(['chapter_id' => $chapterId])
            ->count();

        $data = [
            'comment_id' => $comment->id,
            'uid'        => $uid,
            'pid'        => $comment->pid,
            'content'    => $comment->content,
            'likes_num'  => 0,
            'time_flag'  => '刚刚',
            'reply_num'  => 0,
            'avatar'     => ($user['avatar']!=''?$user['avatar']->toUrl():''),
            'nickname'   => $user['nickname'],
            'gender'     => $user['gender'],
            'is_like'    => 0,
            'total'      => intval($total),
            'reply_info' => '',
            'created_time' => date("Y-m-d",time())
        ];

        if ($comment->pid) {
            $data['reply_info'] = array_shift($this->batchGetReplyInfo($comment->pid));
        }
        return ['is_review' => $comment->status, 'data' => $data];
    }


    /*
     * 评论列表(默认排序)
     */
    public function commentListPC($videoId, $chapterId = 0, $pageNum = 1){
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()
                ->andWhere(['video_id' => $videoId])
                ->andFilterWhere(['chapter_id' => ($chapterId ? $chapterId : '')])
                ->andFilterWhere(['pid' => 0])
        ]);
        $data = $dataProvider->setPagination(['page_num' => $pageNum])->toArray();
        // 获取用户头像，昵称等信息
        $uid = array_column($data['list'], 'uid');
        $userDao = new UserDao();
        $userInfo = ArrayHelper::index($userDao->batchGetUser($uid), 'uid');
        foreach ($data['list'] as &$item) {
            if (empty($userInfo[$item['uid']])) {
                $userInfo[$item['uid']] = [
                    'uid' => $item['uid'],
                    'nickname' => '',
                    'avatar' => '',
                ];
            }
            $item = array_merge($item, $userInfo[$item['uid']]);
        }
        // 获取子级评论
        $data['list'] = $this->_getParentCommentPC($data['list']);

        return $data;
    }
    /*
     * 评论列表(回复数排序)： order->replynum
     */
    public function commentListPCByReply($videoId, $chapterId = 0, $pageNum = 1){
        $pageSize = 10;
        $commentList = Comment::find()
            ->andWhere(['video_id' => $videoId])
            ->andWhere(['chapter_id' => $chapterId])
            ->andWhere(['pid' => 0])
            ->asArray()->all();
        if(!$commentList){
            return [];
        }
        foreach ($commentList as &$c){
            $c['comment_id'] = $c['id'];
            $count = Comment::find()->andWhere(['pid' => $c['id']])->count();
            $c['rnum'] = $count;
            $nar[] = $count;
        }
        array_multisort($nar,SORT_DESC,SORT_NUMERIC,$commentList);
        $data = array_slice($commentList, ($pageSize*($pageNum-1)), ($pageSize*$pageNum-1));
        // 获取用户头像，昵称等信息
        $uid = array_column($data, 'uid');
        $userDao = new UserDao();
        $userInfo = ArrayHelper::index($userDao->batchGetUser($uid), 'uid');
        foreach ($data as &$item) {
            if (empty($userInfo[$item['uid']])) {
                $userInfo[$item['uid']] = [
                    'uid' => $item['uid'],
                    'nickname' => '',
                    'avatar' => '',
                ];
            }
            $item = array_merge($item, $userInfo[$item['uid']]);
        }
        // 获取子级评论
        $data = $this->_getParentCommentPC($data);

        return $data;
    }

    /*
     * 获取评论的子级评论
     * @param array $data
     * @return array
     */
    private function _getParentCommentPC(array $data)
    {
        // 获取子级评论
        foreach ($data as &$comment){
            $dataProvider = new ActiveDataProvider([
                'query' => Comment::find()
                    ->select("content, uid, id, likes_num, created_at")//, u.nickname,u.avatar,u.gender
                    ->andWhere(['pid' => $comment['comment_id']])
            ]);
            $replylist = $dataProvider->setPagination()->toArray();
            if(isset($replylist['list'])){
                foreach ($replylist['list'] as &$c){
                    $u = User::find()->andWhere(['uid' => $c['uid']])->asArray()->one();
                    if($u){
                        $c['nickname'] = $u['nickname'];
                        $c['avatar'] = $u['avatar'];
                        $c['gender'] = $u['gender'];
                    }
                }
            }
            $comment['reply_info'] = isset($replylist) ? $replylist : [];
        }
        return $data;
    }

    /*
     * 取评论回复信息
     * @param $commentIds
     * @return array
     */
    public function getReplyMorePC($pid, $pageNum = 1) {
        if (empty($pid)) {
            return [];
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()
                ->select("content, uid, id, likes_num, created_at")//, u.nickname,u.avatar,u.gender
                ->andWhere(['pid' => $pid])
//                ->andWhere(['video_id' => $videoId])
//                ->andWhere(['chapter_id' => ($chapterId ? $chapterId : '')])
        ]);
        $replylist = $dataProvider->setPagination(['page_num' => $pageNum])->toArray();
        if(isset($replylist['list'])){
            foreach ($replylist['list'] as &$c){
                $u = User::find()->andWhere(['uid' => $c['uid']])->asArray()->one();
                if($u){
                    $c['nickname'] = $u['nickname'];
                    $c['avatar'] = $u['avatar'];
                    $c['gender'] = $u['gender'];
                }
                $c['created_time'] = date("Y-m-d",$c['created_at']);
            }
        }
        return $replylist['list'];
    }
}
