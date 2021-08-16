<?php
namespace api\dao;

use api\data\ActiveDataProvider;

use api\exceptions\ApiException;
use api\helpers\Common;
use api\helpers\ErrorCode;
use api\logic\ChannelLogic;
use api\models\video\Actor;
use api\models\video\Banner;
use api\models\video\HotRecommend;
use api\models\video\HotRecommendList;
use api\models\video\Video;
use api\models\video\VideoActor;
use api\models\video\VideoArea;
use api\models\video\VideoChannel;
use api\models\video\VideoChapter;
use api\models\video\VideoFeedback;
use api\models\video\VideoFeedbackinfo;
use api\models\video\VideoFeedcountry;
use api\models\video\VideoSeek;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\helpers\Tool;
use common\models\IpAddress;
use console\models\AnalyzeApiLog;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii;

class VideoDao extends BaseDao
{
    //影片字段,影片缓存的所有字段
    private $_fields = ['video_id', 'channel_id', 'category_ids', 'video_name', 'intro', 'issue_date',
        'score', 'category', 'type', 'flag', 'tag','play_times','cover', 'horizontal_cover', 'area',
        'year', 'cats', 'episode_num', 'total_views', 'actors_id', 'play_limit', 'total_price', 'is_down',
        'summary', 'created_at'];

    public static $chapterInfo = [];

    //静态变量缓存
    public static $videoChannel;
    public static $videoAreaInfo;
    public static $yearsInfo;

    /**
     * @param $channelId
     * @param array $fields
     * @return array|mixed
     */
    public function banner($channelId, $fields = [], $city='')
    {
        
        $redis = new RedisStore();
        
        $key = RedisKey::videoBanner($channelId);
        if($channelId == 0){
            $key = RedisKey::videoBannerProduct(\Yii::$app->common->product);
        }
        
        if ($city != '') {
            $key = $key.'_'.md5($city);
        }
        
        if ($str = $redis->get($key)) {
            $data = json_decode($str, true);
        } else {
            $citylist = IpAddress::find()->select('id')->andWhere(['city' => $city])->column();
            array_push($citylist, 0);
            $bannerDataProvider = new ActiveDataProvider([
                'query' => Banner::find()->andWhere(['channel_id' => $channelId])->andWhere(['in','product',[\Yii::$app->common->product,Common::PRODUCT_UNKNOWN]]),
            ]);
            
            if ($city != '')
            {
                $bannerDataProvider = new ActiveDataProvider([
                    'query' => Banner::find()->andWhere(['channel_id' => $channelId])
                        ->andWhere(['in','product',[\Yii::$app->common->product,Common::PRODUCT_UNKNOWN]])
                        ->andWhere(["city_id" => $citylist]),
                ]);
            }
        
            $data = $bannerDataProvider->toArray();
            // todo 优化
            foreach ($data as $k => $banner) {
                if ($banner['action'] != Banner::ACTION_VIDEO) {
                    continue;
                }
                /**
                 * @var $video Video
                 */
                $video = Video::findOne($banner['content']);
                if (!$video || $video->status == Video::STATUS_DISABLED) {
                    unset($data[$k]);
                }

            }
            $data = array_values($data);
            $redis->setEx($key, json_encode($data));
        }

        //$redis->del($key);
       
        //非APP端 过滤掉APP页面跳转
        foreach ($data as $k => &$v) {
            if ($v['action'] == Banner::ACTION_SCHEME && \Yii::$app->common->product != Common::PRODUCT_APP) {
                unset($data[$k]);
            }

            //跳转链接
            if ($v['action'] == Banner::ACTION_VIDEO && \Yii::$app->common->product != Common::PRODUCT_APP) {
                $v['content'] = '/video/detail?video_id='. $v['content'];
            }
        }
      
        //重新索引数据
        $data = array_values($data);
      
        // 过滤字段
        $data = $this->filter($data, $fields);

        return $data;
    }

    /**
     * 影片系列缓存,actors_id是演员id用逗号拼接
     * @param       $videoId
     * @param array $fields 查询的字段
     * @return array
     */
    public function videoInfo(int $videoId, array $fields = [])
    {
        $key = RedisKey::videoInfoPrefix($videoId);
        $redis = new RedisStore();

        $viewsKey = RedisKey::scriptVideoViews();
        $incViews = (int)$redis->hGet($viewsKey, $videoId);

        //需要查询的字段
        if ($seriesInfo = $redis->get($key)) {  //命中缓存
            $data = json_decode($seriesInfo, true);

            //格式化处理缓存后的数据
            $data = $this->batchInt($data, ['video_id', 'channel_id', 'issue_date', 'type', 'episode_num', 'total_views', 'is_down']);
            //补充 热度
            if ($data) {
                $totalViews = $data['total_views'] + $incViews;
                $data['total_views'] = $totalViews;
                $data['play_times'] = Tool::formatTotalViews($totalViews, 2);
            }
        } else {
            /** @var Video $videoObj */
            $videoObj = Video::findOne(['id' => $videoId]);
            
            if (!$videoObj) {
                return [];
            }
            //将缓存浏览数 落库
            $videoObj->total_views += $incViews;
            $videoObj->save();
            //保存之后model会变
            $videoObj = Video::findOne(['id' => $videoId]);

            $data = $videoObj->toArray($this->_fields);
            //写入缓存
            $redis->setEx($key, json_encode($data));

            //将缓存清0
            $redis->hSet($viewsKey, $videoId, 0);
        }

        if (empty($fields) && in_array('channel_name', $fields)) {
            //获取频道缓存信息
            $channelInfo = $this->_getVideoChannel();
            //根据影片的channel_id,获取影片的频道名称
            $data['channel_name'] = ArrayHelper::getValue($channelInfo, $data['channel_id'] . '.channel_name', '');
        }

        //影片的演员id信息,只查id并缓存起来
        $actorId = VideoActor::find()
            ->select('actor_id')
            ->andWhere(['video_id' => $videoId])
            ->column();
        $data['actors_id'] = implode(',', $actorId);

        // 地区
        $videoAreaInfo = $this->_getVideoAreaInfo();
        $data['area'] = isset($videoAreaInfo[$data['area']]['area']) ? $videoAreaInfo[$data['area']]['area'] : '未知';
        // 年代
        $yearsInfo = $this->_getYearsInfo();
        $data['year'] = isset($yearsInfo[$data['year']]['year']) ? $yearsInfo[$data['year']]['year'] : '未知';
        //拼接标签
        $data['cats'] = $data['area'] . '/' . $data['year'];

        //过滤字段
        if ($fields) {
            return ArrayHelper::filter($data, $fields);
        }

        return $data;
    }

    /**
     * 视频频道
     * @return array|mixed
     */
    private function _getVideoChannel() {
        if (self::$videoChannel !== null) {
            return self::$videoChannel;
        }

        //获取频道缓存信息
        $commonDao = new CommonDao();
        self::$videoChannel = $commonDao->videoChannel(['channel_id', 'channel_name'], true);

        return self::$videoChannel;
    }

    /**
     * 视频区域
     * @return array
     */
    private function _getVideoAreaInfo() {
        if (self::$videoAreaInfo !== null) {
            return self::$videoAreaInfo;
        }
        $commonDao = new CommonDao();
        self::$videoAreaInfo = $commonDao->videoAreas(true);
        return self::$videoAreaInfo;
    }

    /**
     * 视频年代
     * @return array
     */
    private function _getYearsInfo () {
        if (self::$yearsInfo !== null) {
            return self::$yearsInfo;
        }
        $commonDao = new CommonDao();
        self::$yearsInfo = $commonDao->videoYears(true);

        return self::$yearsInfo;
    }

    /**
     * 影片系列批量缓存,支持额外字段信息
     * @param array $videoIds
     * @param array $fields
     * @param bool  $index
     * @param array $params
     * @return array
     */
    public function batchGetVideo(array $videoIds, array $fields = [], $index = false, array $params = [])
    {
        $bakIds = $videoIds;
        $redis = new RedisStore();
        //浏览数 keys
        $viewsKey = RedisKey::scriptVideoViews();

        $videosInfo = [];
        foreach ($videoIds as $k => $id) {
            $key = RedisKey::videoInfoPrefix($id);
            if ($seriesInfo = $redis->get($key)) {
                $info = json_decode($seriesInfo, true);
                //格式化处理缓存后的数据
                $tmpData = $this->batchInt($info, ['video_id', 'channel_id', 'issue_date', 'type', 'episode_num', 'total_views', 'is_down']);

                $incViews = (int)$redis->hGet($viewsKey, $id);
                //补充 热度
                if ($tmpData) {
                    $totalViews = $tmpData['total_views'] + $incViews;
                    $tmpData['total_views'] = $totalViews;
                    $tmpData['play_times'] = Tool::formatTotalViews($totalViews, 2);
                }

                $videosInfo[] = $tmpData;
                unset($videoIds[$k]);
            }
        }

        //视频信息
        if ($videoIds) {
            $videosInfo = array_merge($this->getVideoInfoFromDb($videoIds), $videosInfo);
        }

        //获取频道信息
        $commonDao = new CommonDao();
        $channelInfo = $commonDao->videoChannel(['channel_id', 'channel_name'], true);
        //获取需要查询的演员id
        $actorDataProvider = new ActiveDataProvider([
            'query' => VideoActor::find()
                ->where(['video_id' => $bakIds])
        ]);
        $actorsId = [];
        foreach ($actorDataProvider->toArray() as $item) { //键值对的形式处理影片和演员关系
            $actorsId[$item['video_id']][] = $item['actor_id'];
        }

        // 地区
        $videoAreaInfo = $this->_getVideoAreaInfo();
        // 年代
        $yearsInfo = $this->_getYearsInfo();

        //循环处理channel_name等信息
        foreach ($videosInfo as &$video) {
            //未缓存的缓存一下
            if (in_array($video['video_id'], $videoIds)) {
                //先写缓存, 额外信息 不需要写到视频缓存里面
                $key = RedisKey::videoInfoPrefix($video['video_id']);
                //写入缓存
                $redis->set($key, json_encode($video));
            }

            $actor = ArrayHelper::getValue($actorsId, $video['video_id'], []);
            $video['channel_name'] = ArrayHelper::getValue($channelInfo, $video['channel_id'] . '.channel_name');
            $video['actors_id']    = $actor ? implode(',', $actor) : ''; //演员id
            $video['area']         = isset($videoAreaInfo[$video['area']]) ? $videoAreaInfo[$video['area']]['area'] : '';
            $video['year']         = isset($yearsInfo[$video['year']]['year']) ? $yearsInfo[$video['year']]['year'] : '';
            $video['cats']         = $video['area'] . '/' . $video['year'];
            $chapProvider= new ActiveDataProvider([
                'query' => VideoChapter::find()
                    ->where(['video_id' => $video['video_id']])
                    ->orderBy('display_order asc, id asc')
            ]);
            $video['chapters']     = $chapProvider->toArray();
            //改动新版本
            $sources = $commonDao->videoSource(Yii::$app->common->product);
            foreach ($video['chapters'] as $k=>$cp)
            {
                $can_play = false;
                $chapterurlArr = $cp['resource_url'];
                foreach ($chapterurlArr as $kk=>$val)
                {
                    if (in_array($kk, array_column($sources, 'source_id'))){
                        $can_play = true;
                    }
                }
                if (!$can_play)
                    unset($video['chapters'][$k]);
            }
        }

        //获取额外的字段,传入的时候才进行查询,提高性能
        if ($params) {
            if (in_array('actors', $params)) {  //演员
                foreach ($videosInfo as &$video) {
                    $video['actors'] = $this->actorsInfo(explode(',', $video['actors_id']));

                    $director = $actors = [];
                    foreach ($video['actors'] as &$actor) {  //循环影片所有的演员信息
                        if ($actor['type'] == Actor::TYPE_ACTOR) {
                            $actors[]   = $actor['actor_name'];
                        } else {
                            $director[] = $actor['actor_name'];
                        }
                    }

                    $video['director'] = '导演:' . implode(' ', $director);
                    $video['artist']   = '演员:' . implode(' ', $actors);
                }
            }
        }

        $indexData = ArrayHelper::index($videosInfo, 'video_id');
        $rData = [];
        //按照给的id进行排序
        foreach ($bakIds as $id) {
            if (!isset($indexData[$id])) {
                continue;
            }
            $rData[] = $indexData[$id];
        }

        if ($index) {
            $rData = ArrayHelper::index($rData, 'video_id');
        }

        //过滤字段
        if ($fields) {
            $fields = array_merge($fields, $params);  //额外的字段不会过滤
            $rData = $this->filter($rData, $fields);
        }

        return $rData;
    }

    /**
     * 根据id从 db中获取数据
     * @param $videoIds
     * @return array
     */
    public function getVideoInfoFromDb($videoIds) {
        $redis = new RedisStore();
        //浏览数 keys
        $viewsKey = RedisKey::scriptVideoViews();

        //先处理一下缓存的浏览数
        $allObj = Video::find()->where(['id' => $videoIds])->all();
        foreach ($allObj as $videoObj) {
            $videoObj->detachBehaviors();
            $incViews = (int)$redis->hGet($viewsKey, $videoObj->id);
            //将缓存浏览数 落库
            $videoObj->total_views += $incViews;
            $videoObj->save();

            //将缓存清0
            $redis->hSet($viewsKey, $videoObj->id, 0);
        }

        $videoDataProvider = new ActiveDataProvider([
            'query' => Video::find()
                ->andWhere(['id' => $videoIds])
        ]);

        $videosInfo = $videoDataProvider->toArray($this->_fields);

        return $videosInfo;
    }

    /**
     * 获取演员缓存信息
     * @param array $actorsId
     * @return array
     */
    public function actorsInfo(array $actorsId = [])
    {
        $data  = []; //最终返回的数据
        $noHitKeys  = []; //没有命中缓存的key

        $redis = new RedisStore();
        foreach ($actorsId as $actor_id) {
            $key = RedisKey::actorInfo($actor_id);
            if ($redisSeries = $redis->get($key)) {  //有缓存
                $data[] = json_decode($redisSeries, true, 512, JSON_UNESCAPED_UNICODE);
            } else {
                $noHitKeys[] = $actor_id;
            }
        }

        if ($noHitKeys) {
            //查询所有没有命中的数据
            $dataProvider = new ActiveDataProvider([
                'query' => Actor::find()
                    ->where(['actor_id' => $noHitKeys])->orderBy('type desc')
            ]);
            $actors = $dataProvider->toArray();

            //循环写入缓存
            foreach ($actors as $actor) {
                $key = RedisKey::actorInfo($actor['actor_id']);
                $redis->setEx($key, json_encode($actor, JSON_UNESCAPED_UNICODE));
            }

            $data = array_merge($data, $actors);
        }

        return $data;
    }

    /**
     * 视频筛选
     * @param $channelId
     * @param $sort
     * @param $tag
     * @param $area
     * @param $year
     * @param $type
     * @param $page
     * @param $playLimit
     * @param $pageSize
     * @return array|mixed
     */
    public function filterVideoList($channelId, $sort, $tag, $area, $year, $type, $playLimit, $page, $pageSize)
    {
        // 不传channel_id时，默认获取第一个
        if (empty($channelId)) {
            $commonDao = new CommonDao();
            $videoChannel = $commonDao->videoChannel(['channel_id', 'channel_name'], true); //获取频道并建立索引
            $channelId = reset($videoChannel)['channel_id'];
        }
        $this->checkFilterParams($channelId, $tag, $area);

        $key = RedisKey::videoFilterList([$channelId, $sort, $tag, $area, $year, $type, $page, $pageSize, $playLimit]);

        $redis = new RedisStore();
        if ($data = $redis->get($key)) {
            return json_decode($data, true);
        }

        $order = $sort == 'new' ? 'created_at' : ($sort == 'score' ? 'score' : 'total_views');

        // 根据条件查询
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()
                ->select('id')
                ->andFilterWhere(['channel_id' => $channelId])
                ->andFilterWhere(['like', 'category_ids' , $tag])
                ->andFilterWhere(['area' => $area])
                ->andFilterWhere(['year' => $year])
                ->andFilterWhere(['play_limit' => $playLimit])
                ->orderBy("$order desc, id desc")
        ]);

        //根据条件查询 视频id
        $data = $dataProvider->setPagination(['page_num' => $page, 'page_size' => $pageSize])->toArray([
            'video_id',
        ]);

        $ids = ArrayHelper::getColumn($data['list'], 'video_id');

       $list = $this->batchGetVideo($ids, [
            'video_id',
            'video_name',
            'tag',
            'flag',
            'play_times',
            'cover',
            'score',
            'horizontal_cover',
            'intro',
            'category',
        ], true, ['channel_id', 'actors_id', 'actors', 'director', 'artist', 'chapters']);
        
        $data['list'] = array_values($list);

        // 写入缓存
        $redis->setEx($key, json_encode($data, JSON_UNESCAPED_UNICODE), 600);

        return $data;
    }


    /**
     * 视频筛选
     * @param $channelId
     * @param $sort
     * @param $sorttype
     * @param $tag
     * @param $area
     * @param $year
     * @param $type
     * @param $page
     * @param $playLimit
     * @param $pageSize
     * @return array|mixed
     */
    public function filterVideoList2($channelId, $sort, $sorttype, $tag, $area, $year, $type, $playLimit, $page, $pageSize, $status)
    {
        // 不传channel_id时，默认获取第一个
        if (empty($channelId)) {
            $commonDao = new CommonDao();
            $videoChannel = $commonDao->videoChannel(['channel_id', 'channel_name'], true); //获取频道并建立索引
            $channelId = reset($videoChannel)['channel_id'];
        }
        $this->checkFilterParams($channelId, $tag, $area);

        $key = RedisKey::videoFilterList([$channelId, $sort, $tag, $area, $year, $type, $page, $pageSize, $playLimit,$sorttype, $status]);

        $redis = new RedisStore();
        if ($data = $redis->get($key)) {
            return json_decode($data, true);
        }

        $order = $sort == 'new' ? 'created_at' : ($sort == 'score' ? 'score' : 'total_views');

        // 根据条件查询
        if($status == 1 || $status == 2){
            $dataProvider = new ActiveDataProvider([
                'query' => Video::find()
                    ->select('id')
                    ->andFilterWhere(['channel_id' => $channelId])
                    ->andFilterWhere(['like', 'category_ids' , $tag])
                    ->andFilterWhere(['area' => $area])
                    ->andFilterWhere(['year' => $year])
                    ->andFilterWhere(['play_limit' => $playLimit])
                    ->andFilterWhere(['is_finished' => $status])
                    ->andFilterWhere(['id in (select video_id from sf_video_chapter)'])
                    ->orderBy("{$order} {$sorttype}")
            ]);
        }else{
            $dataProvider = new ActiveDataProvider([
                'query' => Video::find()
                    ->select('id')
                    ->andFilterWhere(['channel_id' => $channelId])
                    ->andFilterWhere(['like', 'category_ids' , $tag])
                    ->andFilterWhere(['area' => $area])
                    ->andFilterWhere(['year' => $year])
                    ->andFilterWhere(['play_limit' => $playLimit])
                    ->orderBy("{$order} {$sorttype}")
            ]);
        }

        //根据条件查询 视频id
        $data = $dataProvider->setPagination(['page_num' => $page, 'page_size' => $pageSize])->toArray([
            'video_id',
        ]);

        $ids = ArrayHelper::getColumn($data['list'], 'video_id');

        $list = $this->batchGetVideo($ids, [
            'video_id',
            'video_name',
            'tag',
            'flag',
            'play_times',
            'cover',
            'score',
            'horizontal_cover',
            'intro',
            'category',
        ], true, ['channel_id', 'actors_id', 'actors', 'director', 'artist', 'chapters']);

        $data['list'] = array_values($list);

        // 写入缓存
        $redis->setEx($key, json_encode($data, JSON_UNESCAPED_UNICODE), 600);

        return $data;
    }

    /**
     * 切换频道时，判断tag，area是否存在当前频道下，不存在则重置为空
     * @param $channelId
     * @param $tag
     * @param $area
     */
    public function checkFilterParams($channelId, &$tag, &$area)
    {
        // tag检索项
        $channelLogic = new ChannelLogic();
        $videoCategory = $channelLogic->channelCategory($channelId, ['cat_id', 'name']);
        // 如果上传的tag不存在改频道下，则重置为tag无效
        $catId = array_column($videoCategory, 'cat_id');
        if (!in_array($tag, $catId)) {
            $tag = '';
        }
        // 如果上传的area不存在改频道下，则重置为area无效
        $videoArea = $channelLogic->channelArea($channelId, ['area_id', 'area']);
        $areaId = array_column($videoArea, 'area_id');
        if (!in_array($area, $areaId)) {
            $area = '';
        }
    }

    /**
     * 根据video_id获取视频剧集信息,返回信息格式为以主键带数组
     * @param       $videoId
     * @param array $fields
     * @param bool  $index
     * @return array
     */
    public function videoChapter($videoId, $fields = [], $index = false)
    {
        //静态缓存
        if (self::$chapterInfo) {
            $data = self::$chapterInfo;
        } else {
            $key = RedisKey::videoChapter($videoId);
            $redis = new RedisStore();
            if ($data = $redis->get($key)) { //命中缓存
                $data = json_decode($data, true);
            } else {
                $dataProvider= new ActiveDataProvider([
                    'query' => VideoChapter::find()
                        ->where(['video_id' => $videoId])
                        ->orderBy('display_order asc, id asc')
                ]);
                $data = $dataProvider->toArray();
                $redis->setEx($key, json_encode($data, JSON_UNESCAPED_UNICODE));
            }
            // 做静态缓存
            self::$chapterInfo = $data;
        }

        if ($fields) {
            $data = $this->filter($data, $fields);
        }

        return $index ? ArrayHelper::index($data, 'chapter_id') : $data;
    }

    /**
     * 换一换缓存,猜你喜欢缓存
     * @param array $where
     * @param int $limit 返回个数
     * @param array $exclude 排除
     * @param array $fields
     * @return array
     */
    public function refreshVideo(array $where, $fields, $limit = 6, $exclude = [])
    {
        $redis = new RedisStore();
        $key = RedisKey::refreshVideo(json_encode($where));
        if ($videoId = $redis->get($key)) {
            $videoId = json_decode($videoId, true);
        } else {
            // 获取200条影视id
            $dataProvider = new ActiveDataProvider([
                'query' => Video::find()
                    ->andFilterWhere($where)
                    ->andFilterWhere(['not in', 'id', $exclude])
                    ->limit(200)
                    ->orderBy('year asc, created_at desc')
            ]);
            $seriesList = $dataProvider->toArray([
                'video_id',
            ]);
            $videoId = array_column($seriesList, 'video_id', 'video_id');
            foreach ($videoId as $k=>$dd)
            {
                $objChapters = VideoChapter::find();
                $objChapters->andWhere(['video_id' => $dd]);
                $chapters = $objChapters->asArray()->all();
                if (empty($chapters))
                {
                    unset($videoId[$k]);
                    continue;
                }

                $isvalid = false;
                foreach ($chapters as $cp)
                {
                    $chapterurlArr = json_decode($cp['resource_url'], true);
                    foreach ($chapterurlArr as $val)
                    {
                        if(!empty($val))
                        {
                            $isvalid = true;
                            break;
                        }
                    }
                    if ($isvalid)
                        break;
                }
                if (!$isvalid)
                    unset($videoId[$k]);
            }
            // 缓存
            $redis->setEx($key, json_encode($videoId));
        }

        // 随机打乱数组截取个数
        shuffle($videoId);
        $videoId = array_slice($videoId, 0, $limit);

        $videoInfo = $this->batchGetVideo($videoId, $fields);
        shuffle($videoInfo);
        return $videoInfo;
    }

    /**
     * 搜索页热词,返回搜索页热词信息,影片只返回id
     */
    public function searchHotWord()
    {
        $key = RedisKey::searchHotWord();

        $redis = new RedisStore();
        if ($data = $redis->get($key)) {
            return json_decode($data, true);
        }

        // 获取顶部热搜标题信息
        $dataProvider = new ActiveDataProvider([
            'query' =>  HotRecommend::find()
        ]);
        $hotRecommend = $dataProvider->toArray();

        // 获取热门视频列表,只包含id
        $recommendList = HotRecommendList::find()
            ->where(['recommend_id' => array_column($hotRecommend, 'recommend_id')])
            ->asArray()
            ->all();
        $videoId = []; // 根据推荐位将影片id分组
        foreach ($recommendList as $item) {
            $videoId[$item['recommend_id']][] = $item['video_id'];
        }

        $data = []; //最终返回数组
        foreach ($hotRecommend as $recommend) { //循环遍历热搜组,热搜id信息
            $data[] = [
                'title' =>  $recommend['title'],
                'list'  =>  ArrayHelper::getValue($videoId, $recommend['recommend_id'], [])
            ];
        }

        $redis->setEx($key, json_encode($data, JSON_UNESCAPED_UNICODE));

        return $data;
    }

    /**
     * 剧集评论数增加
     * @param $videoId
     * @param $chapterId
     * @throws ApiException
     */
    public function addTotalComment($videoId, $chapterId)
    {
        $videoChapter = VideoChapter::findOne(['video_id' => $videoId, 'id' => $chapterId]);
        if (!$videoChapter) {
            throw new ApiException(ErrorCode::EC_VIDEO_CHAPTER_NOT_EXIST);
        }
        $videoChapter->total_comment += 1;
        $videoChapter->save();
    }

    /*
     * 查询频道和地区
     */
    public function findAreasAndChannels(){
        $data = [];
        // 地区
        $areas = new ActiveDataProvider([
            'query' =>  VideoArea::find()
        ]);
        $channels = new ActiveDataProvider([
            'query' =>  VideoChannel::find()
        ]);

        $data['areas'] = $areas->toArray();
        $data['channels'] = $channels->toArray();
        return $data;
    }

    /*
     * 提交求片信息
     */
    public function saveSeekInfo($video_name,$channel_id,$area_id,$year,$director_name,$actor_name){
        $seek = new VideoSeek();
        $seek->video_name = $video_name;
        $seek->channel_id = $channel_id;
        $seek->area_id = $area_id;
        $seek->year = $year;
        $seek->director_name = $director_name;
        $seek->actor_name = $actor_name;
        $result = $seek->insert();
        return $result;
    }

    /*
     * 在线反馈信息查询
     */
    public function findFeedbackinfo(){
        $data = [];
        $internet = new ActiveDataProvider([
                    'query' => VideoFeedbackinfo::find()
                        ->where(['type' => 1])
                        ->orderBy('id asc')
                    ]);
        $data['internet'] = $internet->toArray();
        $system = new ActiveDataProvider([
                    'query' => VideoFeedbackinfo::find()
                        ->where(['type' => 2])
                        ->orderBy('id asc')
                  ]);
        $data['system'] = $system->toArray();
        $browser = new ActiveDataProvider([
                    'query' => VideoFeedbackinfo::find()
                        ->where(['type' => 3])
                        ->orderBy('id asc')
                   ]);
        $data['browser'] = $browser->toArray();
        $country = new ActiveDataProvider([
            'query' => VideoFeedcountry::find()
        ]);
        $data['country'] = $country->toArray();
        return $data;
    }

    /*
     * 保存反馈信息
     */
    public function saveFeedbackinfo($country,$internets,$systems,$browsers,$description){
        $feedback = new VideoFeedback();
        $feedback->country = $country;
        $feedback->internets = $internets;
        $feedback->systems = $systems;
        $feedback->browsers = $browsers;
        $feedback->description = $description;
        $result = $feedback->insert();
        return $result;
    }

    /*
     * 查询各个频道24小时内更新剧集数
     */
    public function findVideoNumByChannelId($channel_id){
        $time24 = strtotime("-1 day");
        $num = Video::find()
               ->andWhere(['channel_id' => $channel_id ])
               ->andFilterWhere(['and',['>=' , 'created_at', $time24]])
               ->count();
        return $num;
    }

    /*
     * 查询指定剧的24小时更新总数
     */
    public function findVideoChapterNumByVideoId($video_id){
        $time24 = strtotime("-1 day");
        $num = VideoChapter::find()
            ->andWhere(['video_id' => $video_id ])
            ->andFilterWhere(['and',['>=' , 'created_at', $time24]])
            ->count();
        return $num;
    }

    /*
     * 查询指定剧在24小时内更新数据
     */
    public function findVideoChapterByVideoId($video_id){
        $time24 = strtotime("-1 day");
        $num = VideoChapter::find()
            ->select('id,video_id,title')
            ->andWhere(['video_id' => $video_id ])
            ->andFilterWhere(['and',['>=' , 'created_at', $time24]])
            ->all();
        return $num;
    }

    /*
     * 获取指定连续剧最大集数-display_order
     */
    public function getMaxChapterNum($video_id){
        $maxnum = VideoChapter::find()
            ->select('id,video_id')
            ->andWhere(['video_id' => $video_id ])
            ->max('display_order');
        return $maxnum;
    }

    /*
     * 获取指定连续剧最大集数-display_order
     */
    public function getMaxChapter($video_id){
        $maxnum = VideoChapter::find()
            ->andWhere(['video_id' => $video_id ])
            ->max('display_order');
        $chapter = VideoChapter::find()
            ->select('id,video_id,title,display_order')
            ->andWhere(['video_id' => $video_id ])
            ->andWhere(['display_order' => $maxnum ])
            ->one();
        return $chapter;
    }

    /*
     * 根据$country_code获取国家信息
     */
    public function findCountryInfo($country_code){
        $country = VideoFeedcountry::find()
                    ->andWhere(['country_code' => $country_code ])
                    ->one();
        return $country;
    }
}
