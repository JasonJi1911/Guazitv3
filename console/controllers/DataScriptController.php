<?php
namespace console\controllers;

use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\helpers\Tool;
use Yii;
use yii\console\Controller;

/**
 * 脚本数据入库类
 * Class DataScriptController
 * @package console\controllers
 */
class DataScriptController extends Controller
{
    public function beforeAction($action)
    {
        Tool::setLogFile('data_script.log');

        return parent::beforeAction($action);
    }

    /**
     * redis相关相关信息入库
     */
    public function actionRedisToDb()
    {
        ini_set('memory_limit', '512M'); // 防止数据过大导致报错

        $lockKey = RedisKey::scriptExecuteLock('data-script/redis-to-db'); // 执行锁
        $redis = new RedisStore();
        if ($redis->scriptLockCheck($lockKey)) {
            Yii::warning('script is running');
            exit();
        }

        //视频观看次数
//        $this->_redisToDb(RedisKey::scriptSeriesViews(), 'videoSeries', 'total_views');
        //评论点赞数
//        $this->_redisToDb(RedisKey::scriptCommentLike(), 'comment', 'likes_num');
        // 广告pv
        $this->_redisToDb(RedisKey::scriptAdvertPv(), 'advert\Advert', 'pv');
        // 广告点击
        $this->_redisToDb(RedisKey::scriptAdvertClick(), 'advert\Advert', 'click');

        $redis->scriptLockRelease($lockKey); //释放锁
        Yii::warning('script finished');
    }

    /**
     * redis数据入库
     * @param $key redis的key,用于获取值
     * @param $modelClass 保存数据的model类
     * @param $field
     */
    private function _redisToDb($key, $modelClass, $field)
    {
        $redis = new RedisStore();

        $data = $redis->hGetAll($key);
        $modelClass = 'common\models\\' . $modelClass;

        foreach ($data as $id => $num) { //循环把redis数据落入库
            //格式化数据
            $id = intval($id);
            $num = intval($num);
            if ($num == 0) {
                //没有观看次数的需要清理redis,减小哈希大小
                $redis->hDel($key, $id);
                Yii::warning($modelClass . ' no data');
                continue;
            }

            //修改数据库
            $model = call_user_func([$modelClass, 'findOne'], $id);
            if (!$model) { //没有实例信息清理数据跳出
                $redis->hDel($key, $field);
                continue;
            }

            $model->$field += $num;
            if (!$model->save()) {
                Yii::warning($modelClass . ' ' . $id . ' update failed ' . json_encode($model->errors, JSON_UNESCAPED_UNICODE));
            } else {
                Yii::warning($modelClass . ' ' . $id . ' update success, total increase ' . $num);
            }
            $redis->hmIncrBy($key, $id, -$num);
        }
    }

    /**
     * 用户信息入库
     */
    public function actionUserInfo()
    {
        
    }
    
}
