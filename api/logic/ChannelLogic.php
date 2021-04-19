<?php
namespace api\logic;

use api\dao\AdvertDao;
use api\dao\CommonDao;
use api\dao\RankDao;
use api\dao\RecommendDao;
use api\data\ActiveDataProvider;
use api\helpers\Common;
use api\models\advert\AdvertPosition;
use api\models\video\VideoChannel;
use yii\helpers\ArrayHelper;
use yii;

class ChannelLogic
{
    //视频字段
    private $videoFields = ['video_id', 'video_name', 'score', 'cover', 'horizontal_cover', 'flag', 'tag', 'play_times', 'intro', 'category', 'actors_id', 'summary', 'year'];

    /**
     * 频道首页数据
     * @return mixed
     */
    public function channelIndexData($city='')
    {
        // 首页金刚位
        $data['king_kong'] = $this->_kingKong();
        $data['label']     = []; // 首页数据
        // 获取频道
        $fields = [
            'channel_id',
            'channel_name'
        ];
        $commonDao = new CommonDao();
        $channelList  = $commonDao->videoChannel($fields);

        // 获取每个频道权重最高的数据
        $videoRecommend = new RecommendDao();
        // 字段
        $recommendFields = ['recommend_id', 'title', 'search', 'style'];

        // 获取广告
        $advertLogic = new AdvertLogic();
        //        $advert = $advertLogic->advertByPosition(AdvertPosition::POSITION_VIDEO_INDEX);
        $adposition = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_VIDEO_INDEX_PC : AdvertPosition::POSITION_VIDEO_INDEX;
        $advert = $advertLogic->advertByPosition($adposition, $city);
        // 广告循环key
        $advertKey = 0;
        foreach ($channelList as $index => $channel) {
            // 获取分类数据
            $tagFields = ['cat_id', 'name'];
            $channelTags = $this->channelCategory($channel['channel_id'], $tagFields);
            foreach ($channelTags as $key => &$value){
                $value['search'] = [
                    [
                        'field' => 'tag',
                        'value' => $value['cat_id'],
                    ],
                    [
                        'field' => 'channel_id',
                        'value' => $channel['channel_id'],
                    ],
                ];
                unset($value['id']);
            }
            // 获取推荐位
            $recommend = $videoRecommend->recommendByChannel($channel['channel_id'], $recommendFields);
            if (empty($recommend)) {
                continue;
            }
            // 获取权重最高的一个推荐位
            $recommend = $recommend[0];
            // marge 其他信息
            $recommend['tags'] = $channelTags;
            $recommend['can_more']    = true;
            $recommend['can_refresh'] = true;
            $recommend['search']      = json_decode($recommend['search'], true);
            $recommend['search'][]    = ['field' => 'channel_id', 'value' => $channel['channel_id']];
            // 推荐位频道下影片
            $recommend['list'] = $videoRecommend->recommendVideo($recommend['recommend_id'], $this->videoFields);
            // 每两个推荐位插入广告
            if ($advert) {
                if ($index != 0 && $index % 2 == 0) {
                    $advertKey = isset($advert[$advertKey]) ? $advertKey : 0;
                    array_push($data['label'], $advert[$advertKey]);
                    $advertKey ++;
                }
            }
            array_push($data['label'], $recommend);
        }
        
        $flashPos = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_FLASH_PC : AdvertPosition::POSITION_FLASH_WAP;
        $flash = $advertLogic->advertByPosition($flashPos, $city);
        $data['flash'] = $flash;

        return $data;
    }

    /**
     * 获取频道数据
     * @param $channelId
     * @return array
     */
    public function channelLabelData($channelId, $city='')
    {
        $data = [];
        // 获取分类数据
        $tagFields = ['cat_id', 'name'];
        $channelTags = $this->channelCategory($channelId, $tagFields);
        // 获取前三个分类
        $channelTags = array_slice($channelTags, 0, 3);

        foreach ($channelTags as $key => &$value){
            $value['search'] = [
                [
                    'field' => 'tag',
                    'value' => $value['cat_id'],
                ],
                [
                    'field' => 'channel_id',
                    'value' => $channelId,
                ],
            ];
            unset($value['id']);
        }
        array_unshift($channelTags, ['name' => '全部', 'search' => [['field' => 'tag', 'value' => 0], ['field' => 'channel_id', 'value' => $channelId]]]);
        $data['tags'] = $channelTags;

        // 栏目版数据
        $videoRecommend = new RecommendDao();
        $recommendFields = ['recommend_id', 'title', 'search', 'style'];
        $recommend = $videoRecommend->recommendByChannel($channelId, $recommendFields);

        // 获取广告
        $advertLogic = new AdvertLogic();
        // $advert = $advertLogic->advertByPosition(AdvertPosition::POSITION_VIDEO_INDEX);
        $adposition = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_VIDEO_INDEX_PC : AdvertPosition::POSITION_VIDEO_INDEX;
        $advert = $advertLogic->advertByPosition($adposition, $city);
        // 广告循环key
        $advertKey = 0;
        $label = [];

        foreach ($recommend as $index => $item) {
            $item['can_more']    = true;
            $item['can_refresh'] = true;
            $item['search']      = json_decode($item['search'], true);
            $item['search'][]    = ['field' => 'channel_id', 'value' => $channelId];
            // 影视数据
            $item['list'] = $videoRecommend->recommendVideo($item['recommend_id'], $this->videoFields);
            if (empty($item['list'])) {
                continue;
            }
            // 添加广告
            if ($advert) {
                if ($index != 0 && $index % 2 == 0) {
                    $advertKey = isset($advert[$advertKey]) ? $advertKey : 0;
                    array_push($label, $advert[$advertKey]);
                    $advertKey ++;
                }
            }
             // 添加返回值
            array_push($label, $item);
        }

        $data['label'] = $label;
        $flashPos = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_FLASH_PC : AdvertPosition::POSITION_FLASH_WAP;
        $flash = $advertLogic->advertByPosition($flashPos, $city);
        $data['flash'] = isset($flash[0]) ? $flash[0] : [];
        return $data;
    }


    /**
     * 根据channel 来获取分类
     * @param $channelId
     * @param array $fields
     * @return array|mixed
     */
    public function channelCategory($channelId, $fields = [])
    {
        $commonDao = new CommonDao();
        $category = ArrayHelper::index($commonDao->videoCategory(), null, 'channel_id');
        $data = isset($category[$channelId]) ? $category[$channelId] : [];
        if (!$data) {
            return [];
        }
        if ($fields) {
            // 过滤字段
            $data = $commonDao->filter($data, $fields);
        }
        return $data;
    }

    /**
     * 根据频道获取地域信息,返回此频道下所有地域信息
     * @param $channelId
     * @param $fields
     * @return array|mixed
     */
    public function channelArea($channelId, $fields = [])
    {
        //获取所有地域和频道信息
        $commonDao = new CommonDao();
        $channelInfo = ArrayHelper::getValue($commonDao->videoChannel(['channel_id', 'channel_name', 'areas'], true), $channelId);
        if (!$channelInfo) {
            return [];
        }

        //解析频道的area
        $data = [];
        $areas = explode(',', $channelInfo['areas']);
        $videoArea = $commonDao->videoAreas();
        foreach ($videoArea as $item) {
            if (in_array($item['area_id'], $areas)) {
                $data[] = $item;
            }
        }
        if ($data){
            // 过滤字段
            $data = $commonDao->filter($data, $fields);
        }
        return $data;
    }

    /**
     * 每个频道下排行最高的排行榜
     * @return array|mixed
     */
    public function channelRankTab()
    {
        // 获取当前分类
        $common = new CommonDao();
        $channel = $common->videoChannel(['channel_id', 'channel_name']);
        $rank = new RankDao();
        // 获取每个分类排序最大的一个排行榜
        foreach ($channel as $key => &$value) {
            $rankId = $rank->topRank($value['channel_id'])['rank_id'];
            if ($rankId) {
                $value['rank_id'] = $rank->topRank($value['channel_id'])['rank_id'];
                unset($value['channel_id']);
            } else {
                unset($channel[$key]);
            }
        }
        array_values($channel);
        // 添加全部
        array_unshift($channel, ['rank_id' => '', 'channel_name' => '全部']);

        return $channel;
    }

    /**
     * @return array
     * 首页金刚位
     */
    private function _kingKong()
    {
        $kingKong = [
//            [
//                'title'  => '会员',
//                'icon'   => API_HOST_PATH . '/img/king_kong/vip.png',
//                'action' => 'vip',
//                'search' => [],
//            ],
        ];

        $dataProvider = new ActiveDataProvider([
            'query'  => VideoChannel::find()
                ->andWhere(['is_kingkong' => 1])
        ]);
        $channel = $dataProvider->toArray(['icon', 'channel_name', 'channel_id']);

        //目前网页端 没有 排行和明显入口 多放2个频道入口
        $num = Yii::$app->common->product == Common::PRODUCT_APP ? 3 : 5;
        $channel = array_slice($channel, 0, $num);

        foreach ($channel as $item){
            $value = [
                'title'  => $item['channel_name'],
                'action' => 'video',
                'icon'   => $item['icon'],
                'search' => [
                    [
                        'field' => 'channel_id',
                        'value' => $item['channel_id']
                    ]
                ],
            ];
            array_push($kingKong, $value);
        }

        if (Yii::$app->common->product == Common::PRODUCT_APP) {
            array_push($kingKong,
                [
                    'title'  => '明星',
                    'icon'   => API_HOST_PATH . '/img/king_kong/actor.png',
                    'action' => 'actor',
                    'search' => [],
                ],
                [
                    'title'  => '排行榜',
                    'icon'   => API_HOST_PATH . '/img/king_kong/rank.png',
                    'action' => 'rank',
                    'search' => [],
                ]
            );
        }

        return $kingKong;
    }
}