<?php
namespace api\logic;

use api\helpers\Common;
use api\models\user\TaskInfo;
use api\models\video\Actor;
use api\models\video\UserWatchLog;
use api\models\video\VideoFavorite;
use common\helpers\Tool;
use common\services\Setting;
use Yii;
use api\dao\CommentDao;
use api\dao\CommonDao;
use api\dao\TopicDao;
use api\dao\VideoDao;
use api\data\ActiveDataProvider;
use api\exceptions\ApiException;
use api\helpers\ErrorCode;
use api\models\advert\AdvertPosition;
use api\models\user\UserCoupon;
use api\models\video\Comment;
use api\models\video\Video;
use api\models\video\VideoChapter;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use yii\helpers\ArrayHelper;

class VideoLogic
{
    /**
     * 筛选页面
     * @param $channelId
     * @param $sort
     * @param $tag
     * @param $area
     * @param $year
     * @param $type
     * @param $playLimit
     * @return mixed
     */
    public function filterHeader($channelId, $sort, $tag, $area, $year, $type, $playLimit)
    {
        $commonDao = new CommonDao();
        $videoChannel = $commonDao->videoChannel(['channel_id', 'channel_name'], true); //获取频道并建立索引
        // 检索项
        $data['search_box'] = [];

        // 不传channel_id时，默认获取第一个
        if (empty($channelId)) {
            $channelId = reset($videoChannel)['channel_id'];
        }
        // 标题头
        $data['title'] = $videoChannel[$channelId]['channel_name'];

        // 当传入1时，未点击分类进入，返回所有频道筛选项
        if ($type == 1) {
            $searchChannel = [];
            foreach ($videoChannel as $channel) {
                $searchChannel[] = [
                    'display' => $channel['channel_name'],
                    'value'   => $channel['channel_id'],
                    'checked' => $channel['channel_id'] == $channelId ? 1 : 0,
                ];
            }

            $data['search_box'][] = [
                'label' => '频道',
                'field' => 'channel_id',
                'list'  => $searchChannel
            ];
        }
        // 筛选项
        $data['search_box'] = array_merge($data['search_box'], $this->searchBox($channelId, $sort, $tag, $area, $year, $playLimit));

        return $data;
    }
    /**
     * 组合筛选项
     * @param $channelId
     * @param $sort
     * @param $tag
     * @param $area
     * @param $year
     * @param $playLimit
     * @return array
     */
    public function searchBox($channelId, $sort, $tag, $area, $year, $playLimit)
    {
        // 排序
        $sortItem['label'] = '排序';
        $sortItem['field'] = 'sort';
        $sortItem['list'] = [
            [
                'display' => '热门',
                'value'   => 'hot',
                'checked' => $sort == 'hot' ? 1 : 0,
            ],
            [
                'display' => '最新',
                'value'   => 'new',
                'checked' => $sort == 'new' ? 1 : 0,
            ],
            [
                'display' => '评分',
                'value'   => 'score',
                'checked' => $sort == 'score' ? 1 : 0,
            ],
        ];
        $data[] = $sortItem;
        // tag检索项
        $channelLogic = new ChannelLogic();
        $videoCategory = $channelLogic->channelCategory($channelId, ['cat_id', 'name']);
        $tagItem['label'] = '类型';
        $tagItem['field'] = 'tag';

        $tagChecked = 0;
        foreach ($videoCategory as $key => $value) {
            $tagItem['list'][$key]['display'] = $value['name'];
            $tagItem['list'][$key]['value']   = $value['cat_id'];
            if ($tag == $value['cat_id']) {
                $tagItem['list'][$key]['checked'] = 1;
                $tagChecked = 1;
            } else {
                $tagItem['list'][$key]['checked'] = 0;
            }
        }

        // 把全部选项塞到数组中
        if (isset($tagItem['list'])) {
            array_unshift($tagItem['list'], ['display' => '全部', 'value' => 0, 'checked' => $tagChecked == 0 ? 1 : 0]);
        } else {
            $tagItem['list'] = [];
        }

        $data[] = $tagItem;

        // 地区
        $videoArea = $channelLogic->channelArea($channelId, ['area_id', 'area']);
        $areaItem['label'] = '地区';
        $areaItem['field'] = 'area';
        $areaChecked = 0;
        
        foreach ($videoArea as $key => $value) {
            $areaItem['list'][$key]['display'] = $value['area'];
            $areaItem['list'][$key]['value']   = $value['area_id'];
            if ($area == $value['area_id']) {
                $areaItem['list'][$key]['checked'] = 1;
                $areaChecked = 1;
            } else {
                $areaItem['list'][$key]['checked'] = 0;
            }
        }
        // 把全部选项塞到数组中
        if (isset($areaItem['list'])) {
            array_unshift($areaItem['list'], ['display' => '全部', 'value' => 0, 'checked' => $areaChecked == 0 ? 1 : 0]);
        } else {
            $areaItem['list'] = [];
        }

        $data[] = $areaItem;

        $commonDao = new CommonDao();
        $videoYear = $commonDao->videoYears(['year_id', 'year']);
        $yearItem['label'] = '年代';
        $yearItem['field'] = 'year';

        foreach ($videoYear as $value) {
            $yearItem['list'][$value['year_id']]['display'] = $value['year'];
            $yearItem['list'][$value['year_id']]['value']   = $value['year_id'];
            if ($year == $value['year_id']) {
                $yearItem['list'][$value['year_id']]['checked'] = 1;
            } else {
                $yearItem['list'][$value['year_id']]['checked'] = 0;
            }
        }
        // 把全部选项塞到数组中
        if (isset($yearItem['list'])) {
            array_unshift($yearItem['list'], ['display' => '全部', 'value' => 0, 'checked' => $year == 0 ? 1 : 0]);
        } else {
            $yearItem['list'] = [];
        }
        $data[] = $yearItem;
        /** 去掉用券和免费筛选条件
        $limit = [
            'label' => '播放限制',
            'field' => 'play_limit',
            'list'  => [],
        ];
        foreach (Video::$playLimitMap as $key => $desc) {
            $limit['list'][] = [
                'display' => $desc,
                'value'   => $key,
                'checked' => $key == $playLimit ? 1 : 0,
            ];
        }
        // 把全部选项塞到数组中
        array_unshift($limit['list'], ['display' => '全部', 'value' => 0, 'checked' => $playLimit == 0 ? 1 : 0]);
        $data[] = $limit;
        */
        return $data;
    }

    /**
     * 新增影片观看数
     * @param $videoId
     */
    public function increaseViews($videoId)
    {
        // 更新redis信息
//        $key = RedisKey::videoInfoPrefix($videoId);
        $redis = new RedisStore();

        // 视频详情增加观看数
//        $redis->hmIncrBy($key, 'total_views');

        // 添加观看次数
        $scriptKey = RedisKey::scriptVideoViews();
        $redis->hmIncrBy($scriptKey, $videoId);
    }

    /**
     * 视频详情页面评论信息
     * @param $videoId
     * @param $chapterId
     * @return array
     */
    public function videoInfoComment($videoId, $chapterId)
    {
        $commentLogic = new CommentLogic();
        $commentList  = $commentLogic->commentList($videoId, $chapterId, 1);
        
        $comments = $commentList['list'];
        return array_slice($comments, 0, 3);
    }

    /**
     * 专题下影片信息
     * @param $topicId
     * @param $videoFields
     * @param $page
     * @return array
     */
    public function topicVideoInfo($topicId, $videoFields, $page)
    {
        // 获取专题下影片id
        $topicDao = new TopicDao();
        $videoList = $topicDao->topicVideo($topicId, $page);
        // 影视id
        $videoId = array_column($videoList['list'], 'video_id');
        // 获取影片信息
        $videoDao = new VideoDao();
        $videoList['list'] = $videoDao->batchGetVideo($videoId, $videoFields, false, ['actors', 'director', 'artist']);
        return $videoList;
    }

    /**
     * @return array
     */
    public function hotWord()
    {
        $videoDao   = new VideoDao();
        $searchTab  = $videoDao->searchHotWord();

        $videoDao = new VideoDao();
        foreach ($searchTab as &$tab) {
            //所有需要查询的视频信息
            $tab['list'] = $videoDao->batchGetVideo($tab['list'], ['video_id', 'video_name', 'score', 'tag', 'play_times', 'cover', 'summary'], false, ['actors_id', 'actors', 'director', 'artist']);
        }
        $data['tab'] = $searchTab;
        return $data;
    }

    /**
     * 首页检索词
     */
    public function searchWord()
    {
        $videoDao   = new VideoDao();
        $searchTab = $videoDao->searchHotWord();
        $list = [];
        foreach ($searchTab as $item) {
            $list = array_merge($list, $item['list']);
        }
        $videos = $videoDao->batchGetVideo(array_unique($list), ['video_name']);
        return array_slice(array_column($videos, 'video_name'), 0, 5);
    }

    /**
     * 检索页面检索逻辑
     * @param $channelId
     * @param $keyword
     * @return array
     */
    public function searchResult($channelId, $keyword)
    {
        $commonDao = new CommonDao();
        $videoChannel = $commonDao->videoChannel(['channel_id', 'channel_name']);

        if (!$channelId) { //如果没有传channel id,则默认查询所有的频道
            $channelId = array_column($videoChannel, 'channel_id');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()
                ->andWhere(['like', 'title', $keyword])
                ->andFilterWhere(['channel_id' => $channelId]),
        ]);
        $data = $dataProvider->setPagination()->toArray(['video_id']);

        //根据查询的video_id获取影片信息
        $seriesId = array_column($data['list'], 'video_id');

        $videoDao = new VideoDao();
        $videos = $videoDao->batchGetVideo($seriesId, ['video_id', 'video_name', 'category', 'cover', 'horizontal_cover', 'intro', 'flag', 'score', 'play_times','title', 'area', 'year', 'tag', 'director', 'artist'], false, ['channel_id', 'actors_id', 'actors', 'director', 'artist', 'chapters']);

        foreach ($videos as &$videoInfo) {
            $videoInfo['cats'] = implode('/', explode(' ', $videoInfo['category']));
        }

        $data['list'] = $videos;

        array_unshift($videoChannel,  ['channel_id' => '', 'channel_name' => '全部']);
        $data['tabs'] = $videoChannel;

        return $data;
    }

    /**
     * 检索页面检索逻辑
     * @param $channelId
     * @param $keyword
     * @return array
     */
    public function searchResult1($channelId, $keyword, $sort, $tag, $area, $year, $type, $playLimit, $page, $pageSize)
    {
        $commonDao = new CommonDao();
        $videoChannel = $commonDao->videoChannel(['channel_id', 'channel_name']);

        if (!$channelId) { //如果没有传channel id,则默认查询所有的频道
            $channelId = array_column($videoChannel, 'channel_id');
        }
        $order = $sort == 'new' ? 'created_at' : ($sort == 'score' ? 'score' : 'total_views');

        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()
                ->select('id')
                ->andWhere(['like', 'title', $keyword])
                ->andFilterWhere(['channel_id' => $channelId])
                ->andFilterWhere(['like', 'category_ids' , $tag])
                ->andFilterWhere(['area' => $area])
                ->andFilterWhere(['year' => $year])
                ->andFilterWhere(['play_limit' => $playLimit])
                ->orderBy("$order desc, id desc")
        ]);
        $data = $dataProvider->setPagination(['page_num' => $page, 'page_size' => $pageSize])->toArray([
            'video_id',
        ]);

        //根据查询的video_id获取影片信息
        $seriesId = array_column($data['list'], 'video_id');

        $videoDao = new VideoDao();
        $videos = $videoDao->batchGetVideo($seriesId, ['video_id', 'video_name', 'category', 'cover', 'horizontal_cover', 'intro', 'flag', 'score', 'play_times','title', 'area', 'year', 'tag', 'director', 'artist'], false, ['channel_id', 'actors_id', 'actors', 'director', 'artist', 'chapters']);

        foreach ($videos as &$videoInfo) {
            $videoInfo['cats'] = implode('/', explode(' ', $videoInfo['category']));
        }

        $data['list'] = $videos;

        array_unshift($videoChannel,  ['channel_id' => '', 'channel_name' => '全部']);
        $data['tabs'] = $videoChannel;

        return $data;
    }

    /**
     * 播放页详情信息
     * @param $videoId
     * @param $chapterId
     * @param $sourceId
     * @return array
     * @throws ApiException
     */
    public function playInfo($videoId, $chapterId, $sourceId)
    {
        //获取影片信息
        $videoDao = new VideoDao();
        $videoInfo = $videoDao->videoInfo($videoId, ['channel_id', 'video_id', 'video_name', 'actors_id', 'area', 'score', 'category', 'type', 'year', 'intro', 'intro', 'cover', 'horizontal_cover', 'flag', 'tag', 'play_limit', 'total_views','episode_num', 'is_down', 'total_price']);

        if (!$videoInfo) { //视频不存在
            throw new ApiException(ErrorCode::EC_VIDEO_NOT_EXIST);
        }
        
        // 获取影片剧集信息
        $videos = $videoDao->videoChapter($videoId, [], true);
        if (!$videos) { // 没有剧集抛出异常
            throw new ApiException(ErrorCode::EC_VIDEO_CHAPTER_NOT_EXIST);
        }

        // 获取上次播放记录,如果传入的id为空，则获取上次播放历史续播
        $lastPlayLInfo = $this->lastPlayInfo($videoId, $chapterId);
        // 根据章节id获取章节内容,没有此id默认获取第一章
        $chapterInfo = ArrayHelper::getValue($videos, $lastPlayLInfo['chapter_id'], reset($videos));
        if (empty($chapterInfo['resource_url'])) {
            throw new ApiException(ErrorCode::EC_VIDEO_PLAY_URL_ERROR);
        }

        // source_id异常时,将 source_id 置空
        if (!$sourceId || !isset($chapterInfo['resource_url'][$sourceId]) || empty($chapterInfo['resource_url'][$sourceId])) {
            $sourceId = '';
        }

        // 获取源信息
        $commonDao = new CommonDao();
        $sources = $commonDao->videoSource();

        //APP端 全走视频流, 网页端全走IFrame嵌套
        $resourceType = Yii::$app->common->product == Common::PRODUCT_APP ? VideoChapter::RESOURCE_TYPE_DATA : VideoChapter::RESOURCE_TYPE_HTML;

        $source = [];
        foreach ($sources as $item) {
            if (!in_array($item['source_id'], array_keys($chapterInfo['resource_url'])) || empty($chapterInfo['resource_url'][$item['source_id']])) { // source_id不在视频里面或者没有视频播放连接
                continue;
            }

            if (!$sourceId) {
                $sourceId = $item['source_id'];
            }

            $source[] = [
                'source_id'    => $item['source_id'],
                'name'         => $item['name'],
                'icon'         => $item['icon'],
                'resource_url' => $this->parseUrl($chapterInfo['resource_url'][$item['source_id']], Yii::$app->common->product),
                'resource_type' => $resourceType,
                'checked'      => $sourceId == $item['source_id'] ? 1 : 0
            ];
        }

        $videoInfo['catalog_style'] = 1; //目录样式 1连续剧 2综艺

        $purchaseInfo = $this->_purchaseInfo($videoId, $videoInfo, $chapterInfo['chapter_id'], $videos);
        // 重新格式化数据
        $videos = array_values($videos);
        // 格式化章节信息
        foreach ($videos as $key => &$video) {
            if (mb_strlen($video['title']) > 6) {
                $videoInfo['catalog_style'] = 2;
            }
            $video['checked']       = $chapterInfo['chapter_id'] == $video['chapter_id'] ? 1 : 0; // 是否当前选中状态
            $video['cover']         = $videoInfo['horizontal_cover'];
            $video['download_name'] = md5($videoInfo['video_name'] . ' ' . $video['title']);
            $video['mime_type']     = substr(strrchr($video['resource_url'][$sourceId], '.'), 1);
            $video['last_chapter']  = isset($videos[$key-1]) ? $videos[$key-1]['chapter_id'] : 0;
            $video['next_chapter']  = isset($videos[$key+1]) ? $videos[$key+1]['chapter_id'] : 0;
            unset($video['resource_url']); // 安全考虑，删除剧集播放连接，防止全部播放连接一次性全返回
        }

        // 演员信息
        $actorsId = $videoInfo['actors_id'] ? explode(',', $videoInfo['actors_id']) : [];
        $actors = $videoDao->actorsInfo($actorsId);

        //将演员 分成 导演和主演两组
        $actorsGroup = ArrayHelper::index($actors, null, 'type');
        $director = '';
        if (isset($actorsGroup[Actor::TYPE_DIRECTOR])) {
            $director = implode(' ', ArrayHelper::getColumn($actorsGroup[Actor::TYPE_DIRECTOR], 'actor_name'));
        }

        $actor = '';
        if (isset($actorsGroup[Actor::TYPE_ACTOR])) {
            $actor = implode(' ', ArrayHelper::getColumn($actorsGroup[Actor::TYPE_ACTOR], 'actor_name'));
        }

        // 收藏信息
        $userLogic = new UserLogic();
        $isFav = $userLogic->isFav($videoId) ? 1 : 0;
        // 增加观看次数
        $this->increaseViews($videoId);
        // 猜你喜欢
        $guessLike = $videoDao->refreshVideo(['channel_id' => $videoInfo['channel_id']], ['video_id', 'video_name', 'tag', 'flag', 'play_times', 'cover', 'horizontal_cover', 'intro', 'summary'], 12, [$videoInfo['video_id']]);
        // 评论信息
        $commentData = $this->videoInfoComment($videoId, $chapterInfo['chapter_id']);
        // 获取用户观看视频任务状态
        $taskLogic = new TaskLogic();
        $taskStatus = $taskLogic->taskStatus(Yii::$app->user->id, TaskInfo::TASK_ACTION_PLAY_VIDEO);
        $data = [
            'info' => array_merge($videoInfo,
                [
                    'is_fav'          => $isFav,
                    'cats'            => STYLE_SIGN . $videoInfo['score'] . STYLE_SIGN . '/' . $videoInfo['category'] . '/' . $videoInfo['area'] . '/' . $videoInfo['year'],
                    'play_chapter_id' => $chapterInfo['chapter_id'],
                    'chapter_title'   => $chapterInfo['title'],
                    'play_video_id'   => $chapterInfo['video_id'],
                    'resource_url'    => $this->parseUrl($chapterInfo['resource_url'][$sourceId], Yii::$app->common->product),
                    'resource_type'   => $resourceType,
                    'total_comment'   => VideoChapter::getTotalComment($chapterInfo['chapter_id']), // 获取评论总数
//                    'total_views'     => $chapterInfo['total_views'],
                    'play_limit'      => $chapterInfo['play_limit'],
                    'last_play_time'  => intval($lastPlayLInfo['lastPlayTime']),
                    'next_chapter'    => ArrayHelper::index($videos, 'chapter_id')[$chapterInfo['chapter_id']]['next_chapter'],
                    'video_task_time' => $taskStatus ? 0 : 60, //TODO
                    'videos'          => $videos,
                    'source'          => $source,
                    'actors'          => array_values($actors),
                    'director'        => $director,
                    'actor'           => $actor,
                ]),
            'guess_like'    => $guessLike, // 猜你喜欢
            'comments'      => $commentData, // 评论
            "purchase_info" => $purchaseInfo, // 是否可播放信息
            'channel_id'    => $videoInfo['channel_id'],
        ];

        //添加广告
        $advertLogic = new AdvertLogic();
        $data['advert'] = [
            (object)$advertLogic->advertByPosition(AdvertPosition::POSITION_PLAY_BEFORE),
            (object)$advertLogic->advertByPosition(AdvertPosition::POSITION_PLAY_STOP),
            (object)$advertLogic->advertByPosition(AdvertPosition::POSITION_LIKE_TOP),
            (object)$advertLogic->advertByPosition(AdvertPosition::POSITION_LIKE_BOTTOM),
        ];

        return $data;
    }

    /**
     * 根据url判断资源类型
     * @param $url
     * @return mixed
     */
    public function getResourceType($url) {
        //判断url是否资源类型
        $ext = ['mp4', 'wma', 'wmv', 'mp3', 'avi', 'rm', 'rmvb', 'flv', 'mpg', 'mpeg', 'mov', 'mkv', 'asf', 'qt', 'dat', 'm3u8'];

        $urlList = explode('.', $url);

        $suffix = array_pop($urlList);
        if (in_array(strtolower($suffix), $ext)) {
            return VideoChapter::RESOURCE_TYPE_DATA;
        }

        return VideoChapter::RESOURCE_TYPE_HTML;
    }

    /**
     * 解析url
     * @param $url
     * @param $product
     * @return string
     */
    public function parseUrl($url, $product) {
        if ($product == Common::PRODUCT_APP) {
            $resourceType = $this->getResourceType($url);
            if ($resourceType == VideoChapter::RESOURCE_TYPE_DATA) {
                return $url;
            }
            //执行开始时间
            $startTime = microtime(true) * 1000;
            //请求接口获取地址
            $query = VIDEO_JSON_URL.'?v='. urlencode($url);

            $i = 2;
            do {
                $response = Tool::httpGet($query);

                $i--;
                if (!$response['data']) {
                    continue;
                }

                $data = json_decode($response['data'], true);
                if (empty($data) || $data['code'] != 200) {
                    continue;
                }

                $url = $data['url'];
                break;
            } while($i>0);

            //计算结束时间，打印日志
            $endTime = microtime(true) * 1000;
            $intTimeUsed = $endTime - $startTime;
            Yii::warning("360apitv req cost: " . $intTimeUsed);

            return $url;

        } else if($product == Common::PRODUCT_PC){
            return '/360apitv/jiexi/jianghu.php?v='.urlencode($url);
//            return $url;
        } else {
            return VIDEO_JIXI_URL_WAP.'?v='.urlencode($url);
        }
    }

    /**
     * 视频播放信息
     * @param $videoId
     * @param $chapterId
     * @param $videoInfo
     * @param $videos
     * @return array
     * @throws ApiException
     */
    private function _purchaseInfo($videoId, $videoInfo, $chapterId, $videos)
    {
        // 检测剧集是否可播放
        $canPlay = $this->checkCanPlay($videoId, $chapterId, $videos);
        // 返回信息
        $content = [];
        $items   = [];

        if (!$canPlay) {
            $userLogic = new UserLogic();
            $vipStatus = $userLogic->vipStatus();
            // 获取用户资产
            $assets = $userLogic->assets();
            $couponRemain = $assets ? intval($assets->coupon_remain) : 0;
            // 用券视频
            if ($videoInfo['play_limit'] == Video::PLAY_LIMIT_COUPON) {
                $content = [
                    '试看结束，继续观看需要使用' . STYLE_SIGN . $videoInfo['total_price'] . '张' . STYLE_SIGN . '观影券',
                    '您剩余'. Yii::$app->setting->get('system.currency_coupon') .'：' . STYLE_SIGN . $couponRemain . STYLE_SIGN,
                ];

                if ($vipStatus) {
                    $items = [
                        [
                            "title"  => $videoInfo['total_price'] > $couponRemain ? '会员折扣购买' : '立即观看',
                            "action" => $videoInfo['total_price'] > $couponRemain ? 'buy_coupon' : 'dialog' // cost_coupon 消费观影券，buy_coupon 购买观影券 buy_vip 购买会员 dialog 弹出对话框
                        ],
                    ];
                } else {
                    $items = [
                        [
                            "title"  => $videoInfo['total_price'] > $couponRemain ? '购买' . Yii::$app->setting->get('system.currency_coupon') : '立即观看',
                            "action" => $videoInfo['total_price'] > $couponRemain ? 'buy_coupon' : 'dialog' // cost_coupon 消费观影券，buy_coupon 购买观影券 buy_vip 购买会员 dialog 弹出对话框
                        ],
                        [
                            "title" => "开通会员折扣购买",
                            "action" => "buy_vip" // cost_coupon 消费观影券，buy_coupon 购买观影券 buy_vip 购买会员 dialog 弹出对话框
                        ]
                    ];
                }

            } else {
                // 会员视频
                $content = [
                    '试看结束，继续观看需要开通会员或使用' . STYLE_SIGN . $videoInfo['total_price'] . '张' . STYLE_SIGN . Yii::$app->setting->get('system.currency_coupon'),
                    '您剩余'. Yii::$app->setting->get('system.currency_coupon') .'：' . STYLE_SIGN . $couponRemain . STYLE_SIGN,
                ];

                $items = [
                    [
                        "title" => $videoInfo['total_price'] > $couponRemain ? '购买'.Yii::$app->setting->get('system.currency_coupon') : '立即观看',
                        "action" => $videoInfo['total_price'] > $couponRemain ? 'buy_coupon' : 'dialog' // cost_coupon 消费观影券，buy_coupon 购买观影券 buy_vip 购买会员 dialog 弹出对话框
                    ],
                    [
                        "title" => "开通会员免费看",
                        "action" => "buy_vip" // cost_coupon 消费观影券，buy_coupon 购买观影券 buy_vip 购买会员 dialog 弹出对话框
                    ]
                ];

            }
        }
        
        return [ // 购买相关信息
            "probation"          => $canPlay ? 0 : 1, // 试看
            'probation_time'     => 360,
            "probation_title"    => '试看6分钟，观看完整版请' . STYLE_SIGN . '购买本片' . STYLE_SIGN,
            "probation_purchase" => '购买本片', // 试看完购买文案
            'action'             => 'dialog', // 动作，coupon时候调用接口
            "purchase_content"   => [ // 购买文案内容
                "content" => $content,
                "items"   => $items,
            ]
        ];
    }

    /**
     * 检测当前剧集是否存在，不存在则返回第一集
     * @param $videoId
     * @param $chapterId
     * @return mixed
     * @throws ApiException
     */
    public function getFirstChapter($videoId, $chapterId)
    {
        $videoDao = new VideoDao();
        // 获取影片剧集信息
        $videos = $videoDao->videoChapter($videoId, [], true);
        if (!$videos) { // 没有剧集抛出异常
            throw new ApiException(ErrorCode::EC_VIDEO_CHAPTER_NOT_EXIST);
        }
        // 根据章节id获取章节内容,没有此id默认获取第一章
        $chapterId = ArrayHelper::getValue($videos, $chapterId, reset($videos))['chapter_id'];

        return $chapterId;
    }

    /**
     * 专题列表
     * @param $channelId
     * @param $pageNum
     * @param $where
     * @return array|mixed
     */
    public function topicList($channelId, $pageNum, $where)
    {
        $topicDao = new TopicDao();
        $topicList = $topicDao->topicList($channelId, $pageNum, $where);
        // 获取广告
        $advertLogic = new AdvertLogic();
        $advert = $advertLogic->advertByPosition(AdvertPosition::POSITION_VIDEO_TOPIC);
        $advertKey = 0;

        $topic = [];
        foreach ($topicList['list'] as $index => $list) {
            // 添加广告
            if ($advert) {
                if ($index != 0 && $index % 3 == 0) {
                    $advertKey = isset($advert[$advertKey]) ? $advertKey : 0;
                    // 插入广告数据
                    array_push($topic, $advert[$advertKey]);
                    $advertKey ++;
                }
            }
            // 插入返回数据
            array_push($topic, $list);
        }
        // 替换list数据
        $topicList['list'] = $topic;
        return $topicList;
    }

    /**
     * 检测当前视频是否可播放
     * @param $videoId
     * @param $chapterId
     * @param $videos
     * @return bool
     * @throws ApiException
     */
    public function checkCanPlay($videoId, $chapterId, $videos = [])
    {
        if (!$videos) {
            // 获取视频章节信息
            $videoDao = new VideoDao();
            $videos = $videoDao->videoChapter($videoId);
        }
        // 根据章节id获取章节内容
        $chapterInfo = ArrayHelper::getValue($videos, $chapterId);
        if (empty($chapterInfo['resource_url'])) {
            throw new ApiException(ErrorCode::EC_VIDEO_PLAY_URL_ERROR);
        }
        // 免费
        if ($chapterInfo['play_limit'] == VideoChapter::PLAY_LIMIT_FREE) {
            return true;
        }
        // 获取用户会员状态 是会员 1
        $userLogic = new UserLogic();
        $vipStatus = $userLogic->vipStatus();
        if ($chapterInfo['play_limit'] == VideoChapter::PLAY_LIMIT_VIP && $vipStatus) {
            return true;
        }
        // 如果开启全站可播放
        if ($vipStatus && Yii::$app->setting->get('system.vip_play_all') == Setting::SWITCH_ON) {
            return true;
        }
        // 查看用户是否已经购买
        $isBuy = UserCoupon::find()
            ->where(['video_id' => $videoId, 'uid' => Yii::$app->user->id, 'type' => UserCoupon::TYPE_USE])
            ->andWhere(['>', 'expire_time', time()])
            ->one();

        if ($isBuy) {
            return true;
        }
        return false;
    }

    /**
     * 下载
     * @param $videoId
     * @param $chapterId
     * @return array
     * @throws ApiException
     */
    public function down($videoId, $chapterId)
    {
        $uid = Yii::$app->user->id;
        $videoDao = new VideoDao();
        $videoChapter = $videoDao->videoChapter($videoId, ['chapter_id', 'title', 'resource_url', 'play_limit'], true);

        $canPlay = true;
        $data    = [
            'status'    => 1,
            'down_list' => [],
            'alter'     => (object)[],
        ];

        foreach ($chapterId as $key => $id) {
            if (!isset($videoChapter[$id])) { //视频不存在
                continue;
            }
            $canPlay = $this->checkCanPlay($videoId, $id, $videoChapter);
            if (!$canPlay) {
                break;
            }
            $data['down_list'][] = reset($videoChapter[$id]['resource_url']);
        }

        // 不可下载
        if (!$canPlay) {
            $playLimit = max(array_column($videoChapter, 'play_limit'));
            $userLogic = new UserLogic();
            $vipStatus = $userLogic->vipStatus();
            // 判断返回按钮
            $data['alter'] = $this->_buyOptionBtn($videoId, $playLimit, $vipStatus, true);
            $data['status'] = 0;
            unset($data['down_list']);
        }
        return $data;
    }

    /**
     * 购买选项
     * @param $videoId
     * @return array
     * @throws ApiException
     */
    public function buyOption($videoId)
    {
        $videoDao = new VideoDao();
        $videoChapter = $videoDao->videoChapter($videoId, ['chapter_id', 'title', 'resource_url', 'play_limit'], true);
        // 获取用户剩余观影券
        $userLogic = new UserLogic();
        $playLimit = max(array_column($videoChapter, 'play_limit'));
        $vipStatus = $userLogic->vipStatus();
        // 判断返回按钮
        $data['status'] = 0;
        $data['alter']  = $this->_buyOptionBtn($videoId, $playLimit, $vipStatus);

        return $data;
    }

    /**
     * 购买选项按钮
     * @param $videoId
     * @param $playLimit
     * @param $vipStatus
     * @param $isDown
     * @return array
     * @throws ApiException
     */
    private function _buyOptionBtn($videoId, $playLimit, $vipStatus, $isDown = false)
    {
        $videoDao = new VideoDao();
        $video = $videoDao->videoInfo($videoId);
        if (!$video) {
            throw new ApiException(ErrorCode::EC_VIDEO_NOT_EXIST);
        }
        // 获取用户剩余观影券
        $userLogic = new UserLogic();
        $assets = $userLogic->assets();
        $couponRemain = !empty($assets) ? $assets->coupon_remain : 0;

        // 返回数据
        $data = [
            'title'     => '本视频需要付费购买',
            'desc' => [
                '所需'. Yii::$app->setting->get('system.currency_coupon') .'：' . $video['total_price'] . '张',
                '您还有' . STYLE_SIGN . $couponRemain . '张' . STYLE_SIGN . Yii::$app->setting->get('system.currency_coupon'),
                '观看有效期' . Yii::$app->setting->get('system.coupon_expire_time') . '天',
            ],
            'items' => [
                [
                    'title'  => $isDown ? STYLE_SIGN . '立即下载' . STYLE_SIGN : STYLE_SIGN . '立即观看' . STYLE_SIGN,
                    'action' => $isDown ? 'down' : 'play',
                ]
            ]
        ];
        // 判断返回按钮
        if ($playLimit == VideoChapter::PLAY_LIMIT_COUPON) { // 用券视频
            if ($vipStatus){
                $data['items'] = [
                    [
                        "title"  => $video['total_price'] > $couponRemain ? STYLE_SIGN . '会员折扣购买' . STYLE_SIGN : ($isDown ? STYLE_SIGN . '立即下载' . STYLE_SIGN : STYLE_SIGN . '立即观看' . STYLE_SIGN),
                        "action" => $video['total_price'] > $couponRemain ? 'buy_coupon' : 'cost_coupon' // cost_coupon 消费观影券，buy_coupon 购买观影券 buy_vip 购买会员 dialog 弹出对话框
                    ],

                ];
            } else {
                $data['items'] = [
                    [
                        'title'  => $video['total_price'] > $couponRemain ? '购买' . Yii::$app->setting->get('system.currency_coupon') : '立即购买',
                        'action' => $video['total_price'] > $couponRemain ? 'buy_coupon' : 'cost_coupon',
                    ],
                    [
                        'title'  => STYLE_SIGN . '开通会员折扣购买' . STYLE_SIGN,
                        'action' => 'buy_vip',
                    ],
                ];
            }
        } else { // 会员视频
            $data['items'] = [
                [
                    'title'  => $video['total_price'] > $couponRemain ?  '购买' . Yii::$app->setting->get('system.currency_coupon') : '立即购买',
                    'action' => $video['total_price'] > $couponRemain ? 'buy_coupon' : 'cost_coupon',
                ],
                [
                    'title'  => $isDown ? STYLE_SIGN . '开通会员免费下载' . STYLE_SIGN : STYLE_SIGN . '开通会员免费看' . STYLE_SIGN,
                    'action' => 'buy_vip',
                ],
            ];
        }

        return $data;
    }

    /**
     * 收藏列表
     * @return array
     */
    public function favList()
    {
        $uid = Yii::$app->user->id;
        $listDataProvider = new ActiveDataProvider([
            'query'  => VideoFavorite::find()
                ->where(['uid' => $uid, 'status' => VideoFavorite::STATUS_YES])
        ]);
        $data = $listDataProvider->setPagination()->toArray();
        $videoId = ArrayHelper::getColumn($data['list'], 'video_id');
        $VideoDao = new VideoDao();
        $video = $VideoDao->batchGetVideo($videoId, ['video_id', 'video_name', 'score', 'cover', 'horizontal_cover', 'flag', 'tag', 'play_times']);
        $data['list'] = $video;

        return $data;
    }

    /**
     * 获取视频上次播放记录
     * @param $videoId
     * @param $chapterId
     * @return array|int
     */
    public function lastPlayInfo($videoId, $chapterId = '')
    {
        // 初始数据
        $data = [
            'chapter_id' => $chapterId,
            'lastPlayTime' => 0
        ];

        $uid = Yii::$app->user->id;
        if (!$uid) {
            return $data;
        }
        $watchLog = UserWatchLog::find()
            ->where(['uid' => $uid, 'video_id' => $videoId])
            ->andFilterWhere(['chapter_id' => $chapterId])
            ->one();

        if ($watchLog) {
            $data = ['chapter_id' => $watchLog->chapter_id, 'lastPlayTime' => $watchLog->time];
        }

        return $data;
    }

    /**
     * 缓存策略:缓存第一页数据,缓存10分钟
     * vip 列表
     * @param $channelId
     * @return array
     */
    public function vipList($channelId)
    {
        $listDataProvider = new ActiveDataProvider([
            'query'  => Video::find()
                ->andWhere(['play_limit' => Video::PLAY_LIMIT_VIP])
                ->andFilterWhere(['channel_id' => $channelId])
        ]);
        $videoList = $listDataProvider->setPagination()->toArray(['video_id']);
        $videoId = array_column($videoList['list'], 'video_id');

        $videoDao = new VideoDao();
        $fields = ['video_id', 'video_name', 'tag', 'score', 'cover', 'horizontal_cover', 'cats', 'flag', 'play_times', 'director', 'artist'];
        $videoList['list'] = $videoDao->batchGetVideo($videoId, $fields);

        return $videoList;
    }
}
