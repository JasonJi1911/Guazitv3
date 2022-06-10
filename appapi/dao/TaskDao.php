<?php
namespace appapi\dao;

use appapi\data\ActiveDataProvider;
use appapi\models\user\TaskInfo;
use common\helpers\RedisKey;
use common\helpers\RedisStore;

class TaskDao extends BaseDao
{
    /**
     * 任务详情
     */
    public function taskInfo()
    {
        $redis = new RedisStore();
        $key = RedisKey::taskInfo();

        if ($data = $redis->get($key)) {
            return json_decode($data, true);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => TaskInfo::find()
        ]);
        $data = $dataProvider->toArray();
        $redis->setEx($key, json_encode($data, true));
        return $data;
    }
}
