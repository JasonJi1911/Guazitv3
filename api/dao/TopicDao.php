<?php
namespace api\dao;

use api\data\ActiveDataProvider;
use api\models\video\Topic;
use api\models\video\TopicVideo;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use yii\helpers\ArrayHelper;

class TopicDao extends BaseDao
{
    /**
     * 栏目缓存专题
     * @param $channelId
     * @param array $fields
     * @return array|mixed
     */
    public function topicLabel($channelId, $fields = [])
    {
        $key = RedisKey::topicLabel($channelId);
        $redis = new RedisStore();

        if ($str = $redis->get($key)) {
            $data = json_decode($str, true);
        } else {
            $bannerDataProvider = new ActiveDataProvider([
                'query' => Topic::find()->where(['channel_id' => $channelId]),
            ]);
            $data = $bannerDataProvider->toArray();
            $redis->setEx($key, json_encode($data, JSON_UNESCAPED_UNICODE));
        }

        // 过滤字段
        if (!empty($fields) && !empty($data)) {
            $data = $this->filter($data, $fields);
        }

        return $data;
    }


    /**
     * 专题下的影视
     * @param $topicId
     * @param $page
     * @return array
     */
    public function topicVideo($topicId, $page)
    {
        $key = RedisKey::topicVideoList($topicId, $page);
        $redis = new RedisStore();

        if ($pageInfo = $redis->get($key)) {
            $pageInfo = json_decode($pageInfo, true);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => TopicVideo::find()->where(['topic_id' => $topicId]),
            ]);
            $pageInfo = $dataProvider->setPagination()->toArray(['video_id']);
            $redis->setEx($key, json_encode($pageInfo, JSON_UNESCAPED_UNICODE), 300);
        }

        return $pageInfo;
    }

    /**
     * 专题列表缓存，只用于列表分页缓存，其他位置使用视情况而定
     * @param $channelId
     * @param $where
     * @param $pageNum
     * @return array|mixed
     */
    public function topicList(int $channelId, int $pageNum, array $where = [])
    {
        $key = RedisKey::topicList($channelId, $pageNum);
        $redis = new RedisStore();

        if ($str = $redis->get($key)) {
            $data = json_decode($str, true);
        } else {
            $topicDataProvider = new ActiveDataProvider([
                'query' => Topic::find()->andFilterWhere($where)
            ]);
            $data = $topicDataProvider->setPagination()->toArray([
                'topic_id',
                'topic_name',
                'cover',
                'horizontal_cover',
                'play_num',
                'video_num',
                'create_time'
            ]);
            $redis->setEx($key, json_encode($data));
        }
        return $data;
    }
}