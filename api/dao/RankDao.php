<?php
namespace api\dao;

use api\data\ActiveDataProvider;
use api\models\video\Rank;
use api\models\video\RankVideo;
use api\models\video\Video;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\helpers\Tool;
use yii\helpers\ArrayHelper;

class RankDao extends BaseDao
{
    /**
     * 获取每个频道，排序最大的排行榜缓存
     * @param $channelId
     * @return array|mixed
     */
    public function topRank($channelId)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Rank::find()
                ->where(['channel_id' => $channelId])
        ]);
        $data = $dataProvider->toArray([
            'rank_id',
            'channel_id',
            'title',
            'description',
            'display_order'
        ]);
        $data = array_shift($data);

        return $data;
    }

    /**
     * 排行榜影片，支持分页，其他位置使用视情况而定
     * @param $rankId
     * @param $period 排行周期 1周
     * @return array|mixed
     */
    public function getRankVideo($rankId, $period)
    {
        $redis = new RedisStore();
        $rankKey = RedisKey::videoRankList($rankId, $period);
        if ($data = $redis->get($rankKey)) { // 如果命中缓存
            return json_decode($data, true);
        }

        $fields = ['video_id', 'video_name', 'score', 'category', 'cover', 'horizontal_cover', 'episode_num', 'cats', 'flag', 'intro', 'director', 'artist'];
        
        $videoName = Video::tableName();
        $rankName = RankVideo::tableName();
        $dataProvider = new ActiveDataProvider([
            'query' => RankVideo::find()
                ->leftJoin($videoName, $rankName.'.video_id=' . $videoName.'.id')
                ->andWhere([$rankName.'.period' => $period, $videoName.'.status' => Video::STATUS_ENABLED])
                ->orderBy([$rankName . '.display_order' => SORT_DESC, $rankName . '.id' => SORT_DESC])
                ->andFilterWhere([$rankName.'.rank_id' => $rankId])
        ]);
        $data = $dataProvider->setPagination()->toArray();

        $videoId = ArrayHelper::getColumn($data['list'], 'video_id');

        $videoDao = new VideoDao();
        $videoInfo = $videoDao->batchGetVideo($videoId, $fields, true);

        foreach ($videoInfo as &$video) {
            $video['cats'] = implode('/', explode(' ', $video['category']));
        }

        $data['list'] = array_values(Tool::arrKeySort($videoInfo, $videoId));
        $redis->setEx($rankKey, json_encode($data, JSON_UNESCAPED_UNICODE));
        return $data;
    }
}
