<?php
namespace admin\modules\api\controllers;

use admin\models\video\ActorArea;
use admin\modules\api\models\Actor;
use common\models\video\VideoSource;
use admin\modules\api\models\Video;
use admin\modules\api\models\VideoChapter;
use common\models\video\VideoActor;
use common\models\video\VideoArea;
use common\models\video\VideoCategory;
use common\models\video\VideoChannel;
use common\models\video\VideoYear;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class PublishController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => ['*' => ['POST']],
            ],
        ];
    }

    /**
     * 发布影片文件
     */
    public function actionVideo()
    {
        $post = Yii::$app->request->post();

        // 处理视频信息
        $videoParams = $this->_getVideoParams($post);
        $videoId = $this->_videoInfo($videoParams);

        // 处理视频章节
        $chapterParams = $this->_getChapterParams($post, $videoId);
        foreach ($chapterParams as $chapter) {
            $this->_chapterInfo($chapter);
        }
        $this->updateVideoInfo($videoId);

        echo '保存成功';
    }

    //更新视频信息
    private function updateVideoInfo($videoId) {
        //更新总集数
        $totalChapter = VideoChapter::find()
            ->andWhere(['video_id' => $videoId])
            ->count();

        $objVideo = Video::findOne($videoId);
        if (empty($objVideo)) {
            return ;
        }

        $objVideo->episode_num = $totalChapter;
        $objVideo->save();
    }

    /**
     * 演员
     */
    public function actionActor() {
        $post = Yii::$app->request->post();

        //先保存地域
//        $area = $this->_getValue($post, 'area', '');
//        $areaId = 1;
//        if (!empty($area)) {
//            $areaId = $this->_actorArea($area);
//        }

        $areaId = $this->_getValue($post, 'area_id', 1);

        $post['area_id'] = $areaId;
        $actorParams = $this->_getActorParams($post);

        $this->_actorInfo($actorParams);
        echo '保存成功';
    }

    /**
     * 获取视频需要的参数
     * @param $data
     * @return array
     */
    private function _getVideoParams($data)
    {
        return [
//            'channelName' => $this->_getValueOrFail($data, 'channelName'),
//            'catName'    => $this->_getValueOrFail($data, 'catName'),
            'channel_id' => $this->_getValueOrFail($data, 'channel_id'),
            'category_ids'    => $this->_getValueOrFail($data, 'category_ids'),
            'title'     => $this->_getValueOrFail($data, 'title'),
            'type'      => $this->_getValue($data, 'type', 1),
//            'areaName'      => $this->_getValue($data, 'areaName'),
//            'yearName'      => $this->_getValue($data, 'yearName'),
            'area'      => $this->_getValue($data, 'area'),
            'year'      => $this->_getValue($data, 'year'),
            'description'   => $this->_getValue($data, 'description'),
            'score'         => $this->_getValue($data, 'score', 90),
            'issue_date'    => $this->_getValue($data, 'issue_date', time()),
            'cover'         => $this->_getValue($data, 'cover'),
            'horizontal_cover' => $this->_getValue($data, 'horizontal_cover'),
            'total_views'   => $this->_getValue($data, 'total_views', 0),
            'total_favors'  => $this->_getValue($data, 'total_favors', 0),
            'likes_num'     => $this->_getValue($data, 'likes_num', 0),
            'status'        => $this->_getValue($data, 'status', 1),
            'is_finished'   => $this->_getValue($data, 'is_finished', 1),
            'is_sensitive'  => $this->_getValue($data, 'is_sensitive', 1),
            'is_down'       => $this->_getValue($data, 'is_down', 0),
            'total_price'   => $this->_getValue($data, 'total_price', 0),
            'actorName'     => $this->_getValue($data, 'actorName'),
            'play_limit'    => $this->_getValue($data, 'play_limit', 1),
        ];
    }

    /**
     * 章节参数
     * @param $data
     * @return array
     */
    private function _getChapterParams($data, $videoId)
    {

        $urlList = explode(',', $data['resource_url']);
        $titleList = explode(',', $data['chapter_title']);
        $durationTime = explode(',', $this->_getValue($data, 'duration_time', 0));

        $chapter = [];
        foreach ($urlList as $k => $url) {
            $tmp = [];

            $tmp['video_id'] = $videoId;
            $tmp['title'] = isset($titleList[$k]) ? $titleList[$k] : '第'.$k.'集';
            $tmp['resource_url'] = $url;
            $tmp['source'] = $this->_getValueOrFail($data, 'source');
            $tmp['play_limit'] = $this->_getValue($data, 'play_limit', 1);
            $tmp['duration_time'] = isset($durationTime[$k]) ?: 0;
            $tmp['display_order'] = $k;

            $chapter[] = $tmp;
        }

        return $chapter;
    }

    /**
     * 演员参数
     * @param $data
     * @return array
     */
    private function _getActorParams($data) {
        return [
            'actor_name' => $this->_getValueOrFail($data, 'actor_name'),
            'avatar' => $this->_getValue($data, 'avatar'),
            'weight' => $this->_getValue($data, 'weight', 1),
            'type' => $this->_getValue($data, 'type', 1),
            'area_id' => $this->_getValue($data, 'area_id', 1),
        ];
    }

    private function _actorInfo($params) {
        $actor = new Actor();
        $actor->load(['Actor' => $params]);

        $findActor = Actor::findOne(['actor_name' => $actor->actor_name]);
        if ($findActor) {
            return $findActor->actor_id;
        }

        if (!$actor->save()) { // 保存失败
            Yii::warning($actor->errors);
            exit('演员保存失败' . json_encode($actor->errors, JSON_UNESCAPED_UNICODE));
        }

        return $actor->actor_id;
    }

    /**
     * 获取影片id，如果已经存在则返回id，不存在创建后返回id
     * @param $params
     * @return int
     */
    private function _videoInfo($params)
    {
        $video = new Video();
        $video->load(['Video' => $params]);

        // 频道id
//        $video->channel_id = $this->_getChannelId($video->channelName);
        // 查询影片是否已经存在
        $findVideo = Video::findOne(['channel_id' => $video->channel_id, 'title' => $video->title]);
        if ($findVideo) {
            if ($video->play_limit > $findVideo->play_limit) {
                $findVideo->play_limit = $video->play_limit;
                $findVideo->save();
            }
            return $findVideo->id;
        }
//
//        $video->category_ids = $this->_getCategoryId($video->catName, $video->channel_id); // 分类
//        $video->area = $this->_getAreaInfo($video->areaName); // 地区
//        $video->year = $this->_getYearInfo($video->yearName); // 年份
        $actorId = $this->_getActorInfo($video->actorName);

        if (!$video->save()) { // 保存失败
            Yii::warning($video->errors);
            exit('视频保存失败' . json_encode($video->errors, JSON_UNESCAPED_UNICODE));
        }

        // 保存演员信息
        $data = [];
        foreach ($actorId as $id) {
            $data[] = [
                'video_id' => $video->id,
                'actor_id' => $id,
                'display_order' => 0,
            ];
        }
        Yii::$app->db->createCommand()->batchInsert(VideoActor::tableName(), ['video_id', 'actor_id', 'display_order'], $data)->execute();

        return $video->id;
    }

    /**
     * 演员地区
     * @param $area
     * @return int
     */
    public function _actorArea($area) {
        $actorArea = ActorArea::findOne(['area' => $area]);
        if (!$actorArea) {
            $actorArea = new ActorArea();
            $actorArea->area = $area;
            $actorArea->display_order = 0;
            if (!$actorArea->save()) {
                exit('演员保存失败' . json_encode($actorArea->errors, JSON_UNESCAPED_UNICODE));
            }
        }
        return $actorArea->id;
    }

    /**
     * 频道id
     * @param $channelName
     * @return int
     */
    private function _getChannelId($channelName)
    {
        // 查询频道是否存在
        $channelInfo = VideoChannel::findOne(['channel_name' => $channelName]);
        if (!$channelInfo) {
            $channelInfo = new VideoChannel();
            $channelInfo->channel_name = $channelName;
            $channelInfo->display_order = 0;
            if (!$channelInfo->save()) {
                Yii::warning($channelInfo->errors);
                exit('视频频道信息保存失败' . json_encode($channelInfo->errors, JSON_UNESCAPED_UNICODE));
            }
        }
        return $channelInfo->id;
    }

    /**
     * 分类id
     * @param $catName
     * @param $channelId
     * @return string
     */
    private function _getCategoryId($catName, $channelId)
    {
        // 分类
        $sorts = explode(',', $catName);
        $newSort = [];
        foreach ($sorts as $sort) { // 循环遍历
            $sort = trim($sort);
            // 查询是否已经存在
            $category = VideoCategory::findOne(['title' => $sort, 'channel_id' => $channelId]);
            if (!$category) { // 不能存在分类新增
                $category = new VideoCategory();
                $category->title = $sort;
                $category->display_order = 0;
                $category->channel_id = $channelId;
                if (!$category->save()) {
                    exit('分类保存失败' . json_encode($category->errors, JSON_UNESCAPED_UNICODE));
                }
            }
            $newSort[] = $category->id;
        }
        return implode(',', $newSort);
    }


    /**
     * 地区信息
     * @param $areaName
     * @return int
     */
    private function _getAreaInfo($areaName)
    {
        $videoArea = VideoArea::findOne(['area' => $areaName]);
        if (!$videoArea) {
            $videoArea = new VideoArea();
            $videoArea->area = $areaName;
            $videoArea->display_order = 0;
            if (!$videoArea->save()) {
                exit('地区保存失败' . json_encode($videoArea->errors, JSON_UNESCAPED_UNICODE));
            }
        }
        return $videoArea->id;
    }

    /**
     * 生成演员信息
     * @param $actorName
     * @return array
     */
    private function _getActorInfo($actorName)
    {
        $actors = explode(',', $actorName);
        $actorId = [];
        foreach ($actors as $actor) {
            $actorInfo = Actor::findOne(['actor_name' => $actor]);
            if ($actorInfo) { // 已有演员id
                $actorId[] = $actorInfo->actor_id;
                continue;
            }

            $actorInfo = new Actor();
            $actorInfo->actor_name = $actor;
            $actorInfo->area_id = 1;//默认1
            if (!$actorInfo->save()) {
                exit('演员信息保存失败' . json_encode($actorInfo->errors, JSON_UNESCAPED_UNICODE));
            }
            $actorId[] = $actorInfo->actor_id;
        }
        return $actorId;
    }

    /**
     * 年份信息
     * @param $yearName
     * @return int
     */
    private function _getYearInfo($yearName)
    {
        $videoYear = VideoYear::findOne(['year' => $yearName]);
        if (!$videoYear) {
            $videoYear = new VideoYear();
            $videoYear->year = $yearName;
            $videoYear->display_order = 0;
            if (!$videoYear->save()) {
                exit('年份保存失败' . json_encode($videoYear->errors, JSON_UNESCAPED_UNICODE));
            }
        }
        return $videoYear->id;
    }

    private function _chapterInfo($params)
    {
        $videoChapter = new VideoChapter();
        $videoChapter->load(['VideoChapter' => $params]);
        // 验证作品是否存在
        if (!Video::findOne($videoChapter->video_id)) { // 视频不存在
            exit('视频不存在');
        }

        // 验证源是否存在
        $videoSource = VideoSource::findOne(['name' => $videoChapter->source]);
        if (!$videoSource) {
            $videoSource = new VideoSource();
            $videoSource->display_order = 0;
            if (!$videoSource->save()) {
                exit('来源保存失败' . json_encode($videoSource->errors, JSON_UNESCAPED_UNICODE));
            }
        }


        // 验证章节是否已重复
        $findChapter = VideoChapter::findOne(['video_id' => $videoChapter->video_id, 'title' => $videoChapter->title]);
        if ($findChapter) { // 如果章节已存在，则更新已有章节
            $resourceUrl = json_decode($findChapter->resource_url, true);
            if (empty($resourceUrl)) {
                $resourceUrl = [];
            }
            $resourceUrl[$videoSource->id] = $videoChapter->resource_url;
            $findChapter->resource_url = json_encode($resourceUrl, JSON_UNESCAPED_UNICODE);
            if (!$findChapter->save()) {
                exit('章节保存失败' . json_encode($findChapter->errors, JSON_UNESCAPED_UNICODE));
            }
            return true;
        }

        // 章节不存在则新增
        if (!$videoChapter->display_order) {
            //查询已有的最大序号
            $chapter_order = VideoChapter::find()
                ->select('display_order')
                ->where(['video_id' => $videoChapter->video_id])
                ->orderBy('display_order desc')
                ->scalar();
            $display_order = $chapter_order ? ($chapter_order + 1) : 1; //有的话则序号+1,没有序号是1
            $videoChapter->display_order = $display_order;
        }

        $videoChapter->resource_url = json_encode([$videoSource->id => $videoChapter->resource_url], JSON_UNESCAPED_UNICODE);
        if (!$videoChapter->save()) {
            exit('章节保存失败' . json_encode($videoChapter->errors, JSON_UNESCAPED_UNICODE));
        }

        return true;
    }


    /**
     * 获取字段值
     * @param        $arr
     * @param        $key
     * @param string $default
     * @return string
     */
    private function _getValue($arr, $key, $default = '')
    {
        return isset($arr[$key]) ? $arr[$key] : $default;
    }

    /**
     * 获取必填字段值
     * @param $arr
     * @param $key
     * @return mixed
     */
    private function _getValueOrFail($arr, $key)
    {
        if (isset($arr[$key])) {
            return $arr[$key];
        }
        exit('字段' . $key . '不能传空');
    }
}
