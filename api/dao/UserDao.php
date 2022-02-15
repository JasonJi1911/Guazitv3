<?php
namespace api\dao;

use api\data\ActiveDataProvider;
use api\exceptions\LoginException;
use api\helpers\ErrorCode;
use api\models\Expend;
use api\models\user\TaskInfo;
use api\models\user\User;
use api\models\user\UserAssets;
use api\models\user\UserCoupon;
use api\models\user\UserAuthApp;
use api\models\user\UserMessage;
use api\models\user\UserRelations;
use api\models\user\UserVip;
use api\models\video\Comment;
use api\models\video\Video;
use api\models\video\VideoChapter;
use api\models\video\VideoFavorite;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\models\SettingRules;
use yii\helpers\ArrayHelper;
use Yii;

class UserDao extends BaseDao
{
    /**
     * 获取用户信息
     * @return array|bool
     */
    public function userInfo()
    {
        $uid = Yii::$app->user->id;
        if (!$uid) {
            return [];
        }
        return Yii::$app->user->toArray();
    }
    
    /**
     * 获取用户收藏记录,返回只有影片id的数组
     * @param $uid
     * @return mixed
     */
    public function favoriteId($uid)
    {
        if (!$uid) { // 非法的用户uid
            return [];
        }
        
        $key = RedisKey::videoUserFavorite($uid);
        $redis = new RedisStore();
        $data = $redis->get($key);
        if ($data) {
            return json_decode($data, true);
        }

        //查询用户的收藏记录,只查id
        $data = VideoFavorite::find()
            ->select('video_id')
            ->where(['uid' => $uid, 'status' => VideoFavorite::STATUS_YES])
            ->column();
        $redis->setEx($key, json_encode($data));
        return $data;
    }

    /**
     * 批量获取用户信息
     * @param array $uid
     * @return array
     */
    public function batchGetUser(array $uid)
    {
        $userDataProvider = new ActiveDataProvider([
            'query' => User::find()
                ->where(['uid' => $uid])
        ]);
        $users = $userDataProvider->toArray();
        $data = ArrayHelper::index($users, 'uid'); //重建索引

        return $data;
    }

    /**
     * 会员信息
     */
    public function vipInfo()
    {
        $uid = Yii::$app->user->id;
        if (!$uid) {
            return [];
        }

        $userVip = UserVip::findOne($uid);
        if (!$userVip) {
            return [];
        }

        return $userVip->toArray();
    }

    /**
     * 绑定列表
     */
    public function bindList()
    {
        $uid = Yii::$app->user->id;
        if (!$uid) {
            return [];
        }

        // 微信和qq绑定情况
        $wechatBind = UserAuthApp::findOne(['uid' => $uid, 'type' => UserAuthApp::TYPE_WECHAT]);
        $qqBind = UserAuthApp::findOne(['uid' => $uid, 'type' => UserAuthApp::TYPE_QQ]);

        return [
            [
                'label' => '手机号', //绑定类型
                'action' => 'bindPhone', //绑定操作
                'status' => Yii::$app->user->mobile ? User::BIND_STATUS_YES : User::BIND_STATUS_NO, //绑定状态 0-未绑定 1-已绑定
                'display' => Yii::$app->user->mobile ? substr_replace(Yii::$app->user->mobile, '****', 3, 4) : '未绑定'
            ],
            [
                'label' => '微信', //绑定类型
                'action' => 'bindWechat', //绑定操作
                'status' => $wechatBind ? User::BIND_STATUS_YES : User::BIND_STATUS_NO,
                'display' => $wechatBind ? $wechatBind->name : '未绑定'
            ],
            [
                'label' => 'QQ', //绑定类型
                'action' => 'bindQq', //绑定操作
                'status' => $qqBind ? User::BIND_STATUS_YES : User::BIND_STATUS_NO,
                'display' => $qqBind ? $qqBind->name : '未绑定'
            ],
        ];
    }


    /**
     * 使用观影券
     */
    public function userCoupon()
    {
        $uid = Yii::$app->user->id;
        $videoName = Video::tableName();
        $userName  = UserCoupon::tableName();

        //连表查询video_id
        $dataProvider = new ActiveDataProvider([
            'query' => UserCoupon::find()
                ->leftJoin($videoName, $userName.'.video_id='.$videoName.'.id')
                ->where(['uid' => $uid])
                ->andWhere([$videoName.'.status' => Video::STATUS_ENABLED])

        ]);

        $data = $dataProvider->setPagination()->toArray();
        $videoId = array_column($data['list'], 'video_id');
        // 根据video id批量视频信息
        $video = new VideoDao();
        $videoList = $video->batchGetVideo($videoId,['video_id', 'video_name', 'cover', 'horizontal_cover'], true);


        foreach ($data['list'] as &$v) {
            $v['video_name'] = $videoList[$v['video_id']]['video_name'];
            $v['cover']      = $videoList[$v['video_id']]['horizontal_cover'];
            $v['expire_at']  = '有效期至：' . $v['expire_time'];
            $v['cost']       = $v['num'];
            unset($v['uid'],$v['recv_time'],$v['use_time'],$v['expire_time'],$v['type'],$v['num']); // 去掉多余信息
        }

        //观影券使用
        $total = UserAssets::findOne(['uid' => $uid]);
        $num = $total['total_coupon'] - $total['coupon_remain'];

        $data['unused_num'] = intval($total['coupon_remain']);
        $data['used_num']   = $num;

        return $data;
    }

    /**
     * 我的观影券
     */
    public function userList()
    {
        $uid = Yii::$app->user->id;
        // 查询用券的video_id
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()
                ->where(['play_limit' => Video::PLAY_LIMIT_COUPON])
        ]);
        $data = $dataProvider->setPagination()->toArray(['video_name', 'video_id', 'flag', 'cover', 'horizontal_cover', 'tag']);

        //观影券使用
        $total = UserAssets::getUserAssets(['uid' => $uid]);
        $num = $total['total_coupon'] - $total['coupon_remain'];
        $desc = Yii::$app->setting->get('rules.coupon_intro');

        $data['unused_num'] = $total['coupon_remain'];
        $data['used_num']   = $num;
        $data['desc']       = '全场付费内容用券随便看';
        $data['intro']      = $desc;

        return $data;
    }

    /*
     * 根据条件查询user
     */
    public function finduserInfo($param){
        $userlist = User::find();
        if($param['email']){
            $userlist = $userlist->andWhere(['email' => $param['email']]);
        }else if($param['mobile']){
            $userlist = $userlist->andWhere(['mobile' => $param['mobile']]);
        }
        if($param['security_question']){
            $userlist->andWhere(['security_question' => $param['security_question'] ]);
        }
        if($param['security_answer']){
            $userlist->andWhere(['security_answer' => $param['security_answer'] ]);
        }
        $user = $userlist->one();
        if($param['password_hash']){
            $tab = $user->validatePassword($param['password_hash']);
            if(!$tab){
                return [];
            }
        }
        return $user->toArray();
    }

    /*
     * 验证用户并返回原因
     */
    public function finduserInfoToReason($param){
        $data = [];
        $userlist = User::find();
        if($param['email']){
            $userlist = $userlist->andWhere(['email' => $param['email']]);
        }else if($param['mobile']){
            $userlist = $userlist->andWhere(['mobile' => $param['mobile']]);
        }
        $u = $userlist->one();
        if($u){
//            if($param['security_question']){ }
            $userlist->andWhere(['security_question' => $param['security_question'] ]);//
            $u = $userlist->one();
            if($u){
//                if($param['security_answer']){ }
                $userlist->andWhere(['security_answer' => $param['security_answer'] ]);
                $u = $userlist->one();
                if($u){
                    $data['reason'] = '';
                    $data['errno'] = 0;
                    $data['user'] = $u->toArray();
                }else{
                    $data['reason'] = '您的密保答案填写不正确';
                    $data['errno'] = -1;
                    $data['user'] = [];
                }
            }else{
                $data['reason'] = '您的密保问题选择不正确';
                $data['errno'] = -1;
                $data['user'] = [];
            }
        }else{
            $data['reason'] = '您的账号输入错误';
            $data['errno'] = -1;
            $data['user'] = [];
        }

        return $data;
    }

    /*
     * 根据uid查用户信息
     */
    public function finduserByuid($uid){
        $userlist = User::find()->andWhere(['uid'=>$uid])->asArray()->one();
        return $userlist;
    }

    /*
     * 修改密码
     */
    public function modifypassword($uid,$password){
        $user = new User();
        $user->oldAttributes = User::find()->andWhere(['uid' => $uid])->asArray()->one();
        $param['password_hash'] = $password;
        $param['password_flag'] = User::PASSWORD_FLAG_YES;
        $rows = $user->updateAttributes($param);
        return $rows;
    }
    /*
     * 修改密码
     */
    public function modifypasswordByMobile($mobile,$password){
        if(!$mobile){
            return 0;
        }
        $user = new User();
        $user->oldAttributes = User::findOne(['mobile' => $mobile]);
        $param['password_hash'] = $password;
        $param['password_flag'] = User::PASSWORD_FLAG_YES;
        $rows = $user->updateAttributes($param);
        return $rows;
    }

    /*
     * 修改邮箱
     */
    public function modifyemail($param){
        if(!$param['mobile'] || !$param['email']){
            return 0;
        }
        $user = new User();
        $user->oldAttributes = User::findOne(['mobile' => $param['mobile']]);
        $param['email'] = $param['email'];
        $rows = $user->updateAttributes($param);
        return $rows;

    }
    /*
     * PC查vip
     */
    public function validuservipPC($uid){
        $userVip = UserVip::find()
            ->andWhere(['uid' => $uid ])
            ->andWhere(['and',['>=' , 'end_time', time()]])
            ->one();
        if (!$userVip) {
            return [];
        }
        return $userVip->toArray();
    }

    /*
     * 根据条件查询user
     */
    public function finduserById($uid,$other_uid,$type){
        if(!$uid){
            return [];
        }
        $userlist['user'] = User::find()->andWhere(['uid' => $other_uid])->asArray()->one();
        //查询该uid是否是用户的关注者 / 黑名单
        $relation = UserRelations::find()
            ->andWhere(['uid' => $uid])
            ->andWhere(['other_uid' => $other_uid])
            ->andWhere(['type' => $type])
            ->andWhere(['status' => 1])
            ->asArray()->one();
        $userlist['relation'] = $relation;
        //粉丝量
        $userlist['user']['fans'] = UserRelations::find()
            ->andWhere(['other_uid' => $other_uid])
            ->andWhere(['type' => 1])
            ->andWhere(['status' => 1])->count();
        return $userlist;
    }
    /*
     * 关注 / 拉黑
     */
    public function addRelations($uid,$other_uid,$type){
        $objrelation = new UserRelations();
        $userrelation = UserRelations::find()
            ->andWhere(['uid' => $uid])
            ->andWhere(['other_uid' => $other_uid])
            ->andWhere(['type' => $type])->asArray()->one();
        if ($userrelation){
            $objrelation->oldAttributes = $userrelation;
            if ($userrelation['status'] == UserRelations::STATUS_YES){
                $param['status'] = UserRelations::STATUS_NO;
                if($type==1){//uid-follow--;other_uid-fans_num--
                    User::updateAllCounters(['follow_num' => -1],
                        ['uid' => $uid]);
                    User::updateAllCounters(['fans_num' => -1],
                        ['uid' => $other_uid]);
                }
                $status = 0;
            }else{
                $param['status'] = UserRelations::STATUS_YES;
                if($type==1){//uid-follow++;other_uid-fans_num++
                    User::updateAllCounters(['follow_num' => +1],
                        ['uid' => $uid]);
                    User::updateAllCounters(['fans_num' => +1],
                        ['uid' => $other_uid]);
                }
                $status = 1;
            }
            $objrelation->updateAttributes($param);
        } else {
            $objrelation->uid        = $uid;
            $objrelation->other_uid  = $other_uid;
            $objrelation->type       = $type;
            $objrelation->status     = UserRelations::STATUS_YES;
            $objrelation->created_at = time();
            $objrelation->insert();
            if($type==1){//uid-follow++;other_uid-fans_num++
                User::updateAllCounters(['follow_num' => +1],
                    ['uid' => $uid]);
                User::updateAllCounters(['fans_num' => +1],
                    ['uid' => $other_uid]);
            }
            $status = 1;
        }
        return [
            'status' => $status
        ];
    }


    /*
     * 关注名单 或 黑名单
     * $type-1-关注；2-黑名单
     */
    public function findRelationsByCondition($uid,$type,$order,$searchword,$page_num=1){
        $users = UserRelations::find()
            ->andWhere(['uid' => $uid])
            ->andWhere(['type' => $type])
            ->andWhere(['status' => 1])
            ->orderBy(['created_at' => SORT_DESC])->asArray()->all();
        $uu = User::find()->andWhere(['in','uid',array_column($users,'other_uid')])
            ->andWhere(['like','nickname',$searchword]);
        if($order=='relations'){
            $uu = $uu->orderBy(['follow_num' => SORT_DESC]);
        }else if($order=='fans'){
            $uu = $uu->orderBy(['fans_num' => SORT_DESC]);
        }
//        $uu = $uu->asArray()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $uu
        ]);
        $data = $dataProvider->setPagination(['page_num'=>$page_num])->toArray();
        $uu = $data['list'];
        if($uu){
            foreach ($uu as $k=>$u){
                $u['other_uid'] = $u['uid'];
                $u['uid'] = $uid;
                $u['fannum'] = $u['fans_num'];
                $uu[$k] = $u;
            }
            $uu[0]['total_page'] = $data['total_page'];//总页数
        }
        return $uu;
    }

    /*
     * 粉丝名
     */
    public function findFansByCondition($uid,$order,$searchword,$page_num=1){
        $users = UserRelations::find()
            ->andWhere(['other_uid' => $uid])
            ->andWhere(['type' => 1])
            ->andWhere(['status' => 1])
            ->orderBy(['created_at' => SORT_DESC])->asArray()->all();
        $uu = User::find()->andWhere(['in','uid',array_column($users,'uid')])
            ->andWhere(['like','nickname',$searchword]);
        if($order=='relations'){
            $uu = $uu->orderBy(['follow_num' => SORT_DESC]);
        }else if($order=='fans'){
            $uu = $uu->orderBy(['fans_num' => SORT_DESC]);
        }
//        $uu = $uu->asArray()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $uu
        ]);
        $data = $dataProvider->setPagination(['page_num'=>$page_num])->toArray();
        $uu = $data['list'];
        if($uu){
            foreach ($uu as $k=>$u){
                $r = UserRelations::find()
                    ->andWhere(['uid' => $uid])
                    ->andWhere(['other_uid' => $u['uid']])
                    ->andWhere(['type' => 1])
                    ->andWhere(['status' => 1])->asArray()->one();
                if($r){
                    $u['tab'] = 1;//互关
                }else{
                    $u['tab'] = 0;
                }
                $u['other_uid'] = $uid;
                $u['fannum'] = $u['fans_num'];
                $uu[$k] = $u;
            }
            $uu[0]['total_page'] = $data['total_page'];//总页数
        }
        return $uu;
    }


    /*
     * 评论列表
     */
    public function commentListPC($uid,$page_num=1){
        $user = User::find()->andWhere(['uid' => $uid])->asArray()->one();

        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()->andWhere(['uid' => $uid])
        ]);
        $data = $dataProvider->setPagination(['page_num' => $page_num])->toArray(['comment_id','uid', 'content', 'video_id', 'created_at', 'likes_num']);
        if ($data['list']) {
            $videoId = array_column($data['list'], 'video_id');
            $videoDao = new VideoDao();
            $videoInfo = $videoDao->batchGetVideo($videoId, ['video_id', 'video_name', 'cover', 'flag'], true);
            foreach ($data['list'] as &$comment) {
                $comment['avatar']    = $user['avatar'];
                $comment['username']  = $user['nickname'];
                $comment['gender']    = $user['gender'];
                $comment['score']     = 0;
                $comment['grade']     = 1;
                $comment['film_name'] = $videoInfo[$comment['video_id']]['video_name'];
                $comment['date']      = date('Y-m-d', $comment['created_at']);
                unset($comment['created_at']);
            }
            $data['list'][0]['total_page'] = $data['total_page'];//总页数
        }
        return $data['list'];
    }
    /*
     * 回复评论列表
     * @return array
     */
    public function replyListPC($uid,$page_num=1){
        //取所有我的评论id
        $commentlist = Comment::find()->andWhere(['uid' => $uid])->asArray()->all();

        //取（pid=我的评论id） 的评论，即回复
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()
                ->where(['in', 'pid', array_column($commentlist, 'id')])
        ]);
        $data = $dataProvider->setPagination(['page_num' => $page_num])->toArray(['comment_id', 'uid', 'content', 'video_id', 'created_at', 'likes_num']);
        if ($data['list']) {
            $videoId = array_column($data['list'], 'video_id');
            $videoDao = new VideoDao();
            $videoInfo = $videoDao->batchGetVideo($videoId, ['video_id', 'video_name', 'cover', 'flag'], true);
            foreach ($data['list'] as &$comment) {
                $user = User::find()->andWhere(['uid' => $comment['uid'] ])->asArray()->one();
//                $comment['id']    = $comment['id'];
                $comment['avatar']    = $user['avatar'];
                $comment['username']  = $user['nickname'];
                $comment['gender']    = $user['gender'];
                $comment['score']     = 0;
                $comment['grade']     = 1;
                $comment['film_name'] = $videoInfo[$comment['video_id']]['video_name'];
                $comment['date']      = date('Y-m-d', $comment['created_at']);
                unset($comment['created_at']);
            }
            $data['list'][0]['total_page'] = $data['total_page'];//总页数
        }
        return $data['list'];
    }

    /*
     * 系统消息
     * @return array
     * @throws \api\exceptions\LoginException
     */
    public function messagePC($uid,$page_num=1){
        if (!$uid) {
            throw new LoginException(ErrorCode::EC_USER_TOKEN_EXPIRE);
        }
        // 所有消息置位已读
        // UserMessage::updateAll(['status' => UserMessage::STATUS_YES], ['uid' => $uid]);
        $dataProvider = new ActiveDataProvider([
            'query' => UserMessage::find()
                ->andWhere(['uid' => $uid])
                ->andWhere(['status' => UserMessage::STATUS_NO])
                ->orderBy(['created_at' => SORT_DESC])
        ]);
        $data = $dataProvider->setPagination(['page_num' => $page_num])->toArray();

        foreach ($data['list'] as &$v) {
            $v['title']   = UserMessage::$messageMap[$v['type']];
            $v['content'] = $v['type'] ==  UserMessage::TYPE_MESSAGE ? $v['content'] : '回复内容：' . $v['content'];
            $v['date']    = $v['created_at'];
            $current_time = time();
            $updated_at = intval($v['created_time']);
            $t = $current_time - $updated_at;
            if($t<60){
                $v['time_diff'] = $t.'秒前';
            }else if($t<3600){
                $m = floor($t / 60);
                $v['time_diff'] = $m.'分钟前';
            }else if($t < (3600*24)){
                $h = floor($t / 3600);
                $v['time_diff'] = $h.'小时前';
            }else if($t < (3600*24*7)){
                $d = floor($t / (3600*24));
                $v['time_diff'] = $d.'天前';
            }else{
                $v['time_diff'] = date('Y-m-d', $v['created_time']);
            }
            unset($v['created_at']);
            unset($v['type']);
        }
        if($data['list']){
            $data['list'][0]['total_page'] = $data['total_page'];//总页数
        }
        Yii::warning($data['list']);
        return $data['list'];
    }
    /*
     * 点赞
     */
    public function addlikesNumPC($comment_id,$cal){
        $id = intval($comment_id);
        if($cal=='plus'){
            Comment::updateAllCounters(['likes_num' => +1],
                ['id' => $id]);
        }else{
            Comment::updateAllCounters(['likes_num' => -1],
                ['id' => $id]);
        }
        $comment = Comment::find()->select('likes_num')->andWhere(['id'=>$id])->asArray()->one();
        if(!$comment){
            return 0;
        }
        return $comment['likes_num'];
    }
    /*
     * 删除系统消息
     */
    public function removeMessagePC($message_id,$uid=''){
        if($message_id=='all'){
//            $m = UserMessage::find()->andWhere(['uid'=>$uid])->asArray()->all();
            $row = UserMessage::updateAll(['status'=>UserMessage::STATUS_YES,'deleted_at'=>time()], ['uid'=>$uid]);
        }else{
            $m = UserMessage::find()->andWhere(['id'=>$message_id])->asArray()->one();
            $message = new UserMessage();
            $message->oldAttributes = $m;
            $param['status'] = UserMessage::STATUS_YES;
            $param['deleted_at'] = time();
            $row = $message->updateAttributes($param);
        }
        return $row;
    }
    /*
     * 删除评论
     */
    public function removeCommentPC($comment_id){
        $comment = new Comment();
        $c = Comment::find()->andWhere(['id'=>$comment_id])->asArray()->one();
        $comment->oldAttributes = $c;
        $param['deleted_at'] = time();
        $row = $comment->updateAttributes($param);
        if($row > 0){
            VideoChapter::updateAllCounters(['total_comment' => -1],
                ['id' => $c['chapter_id']]);
        }
        return $row;
    }

}
