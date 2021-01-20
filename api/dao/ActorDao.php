<?php
namespace api\dao;


use api\data\ActiveDataProvider;
use api\models\video\Actor;
use api\models\video\ActorArea;
use api\models\video\VideoActor;
use common\helpers\RedisKey;
use common\helpers\RedisStore;

class ActorDao extends BaseDao
{
    /**
     * 获取主演的影片信息,返回影片主要信息
     * @param $actorId
     * @return mixed
     */
    public function actorVideo($actorId)
    {
        //查询当前演员参演的电影
        $dataProvider = new ActiveDataProvider([
            'query' => VideoActor::find()
                ->where(['actor_id' => $actorId])
                ->orderBy(['created_at' => SORT_DESC])
        ]);
        $videoActor = $dataProvider->setPagination()->toArray();
        $videoId = array_column($videoActor['list'], 'video_id'); //所有影片id

        //获取所有影片信息
        $videoDao = new VideoDao();
        $seriesInfo = $videoDao->batchGetVideo($videoId, ['video_id', 'video_name', 'cover', 'horizontal_cover', 'flag', 'tag', 'summary', 'intro']);

        $videoActor['list'] = $seriesInfo;
        return $videoActor;
    }

    /**
     * @return array 所有演员地域信息
     */
    public function allActorArea()
    {
        $key = RedisKey::actorArea();
        $redis = new RedisStore();
        if ($data = $redis->get($key)) {
            return json_decode($data, true);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => ActorArea::find()
        ]);

        $data = $dataProvider->toArray();
        $redis->setEx($key, json_encode($data, JSON_UNESCAPED_UNICODE));
        return $data;
    }

    /**
     * 根据地域获取该地域下演员信息列表,支持分页,仅返回演员信息
     * @param $areaId
     * @param $pageNum
     * @param $pageSize
     * @return array
     */
    public function actorsByArea($areaId, $pageNum = 1, $pageSize = DEFAULT_PAGE_SIZE)
    {
        $key = RedisKey::areaActor($areaId, $pageNum, $pageSize);
        $redis = new RedisStore();
        if ($data = $redis->get($key)) {
            return json_decode($data, true);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Actor::find()
                ->where(['area_id' => $areaId, 'type' => Actor::TYPE_ACTOR])
        ]);

        $data = $dataProvider->setPagination()->toArray();
        $redis->setEx($key, json_encode($data, JSON_UNESCAPED_UNICODE));
        return $data;
    }
}
