<?php
namespace common\services;

use common\helpers\RedisKey;
use common\helpers\RedisStore;

/**
 * 马甲包 APP配置相关
 * Class Apps
 * @package common\services
 */
class Apps
{
    /**
     * @param string $key 获取的配置
     * @param int $appId 应用id
     * @return mixed
     */
    public function get($key, $appId=1)
    {
        // 从缓存中读取配置
//        $redisKey = RedisKey::appsSettingKey($key, $appId);
        $redisKey = RedisKey::getSettingKey($key, ['app_id' => $appId]);
        $redis = new RedisStore();
        if ($data = $redis->get($redisKey)) {
            return json_decode($data, true);
        }

        //查询表
        $modelClass = 'common\models\apps\Apps' . ucfirst($key);
        $modelData = call_user_func([$modelClass, 'findOne'], ['app_id' => $appId]);

        $data = $modelData->toArray(); //转成数组
        //写入redis
        $redis->set($redisKey, json_encode($data, JSON_UNESCAPED_UNICODE));
        return $data;
    }
}
