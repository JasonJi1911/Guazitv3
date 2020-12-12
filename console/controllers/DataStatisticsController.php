<?php
namespace console\controllers;

use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\helpers\Tool;
use console\models\AnalyzeApiLog;
use Yii;
use yii\console\Controller;

/**
 * 数据统计信息
 * Class DataStatisticsController
 * @package console\controllers
 */
class DataStatisticsController extends Controller
{
    const LIST_BATCH_NUM = 100; // 列表每次操作数据长度

    public function beforeAction($action)
    {
        /*if (!API_STATISTICS_SWITCH) { // 没有启用统计脚本
            exit();
        }*/

        //设置日志位置
        Tool::setLogFile('api_request.log');

        return parent::beforeAction($action);
    }

    /**
     * 接口请求统计
     */
    public function actionApiRequest()
    {
        $lockKey = RedisKey::scriptExecuteLock('data-script/api-request'); // 执行锁
        $redis = new RedisStore();
        if ($redis->scriptLockCheck($lockKey)) {
            Yii::warning('script is running');
            exit();
        }

        $requestKey = RedisKey::listApiRequest();
        $redis = new RedisStore();
        $len = $redis->lLen($requestKey); // 队列长度
        if (!$len) { //没有数据
            $redis->scriptLockRelease($lockKey); // 释放锁
            Yii::warning('no api request');
            exit();
        }

        // 开始入库
        Yii::warning('api request count ' . $len);
        $times = ceil($len / self::LIST_BATCH_NUM); // 需要循环的次数
        
        for ($i = 0; $i < $times; $i ++) {
            $logs = $redis->lRange($requestKey, 0, self::LIST_BATCH_NUM - 1); // 获取要处理的数据
            $redis->lTrim($requestKey, self::LIST_BATCH_NUM, -1); // 去掉取出来的数据

            $data = []; // 最终要写入的数据
            foreach ($logs as $log) {
                $info = json_decode($log, true); // 解析数据
                $data[]  = [
                    'url' => $info['url'],
                    'body' => $info['body'],
                    'cost' => $info['cost'],
                    'time' => $info['time']
                ];
            }

            // 批量入库
            $db = Yii::$app->db->createCommand()->batchInsert(AnalyzeApiLog::tableName(), ['url', 'body', 'cost', 'created_at'], $data)->execute();
            Yii::warning('save to database ' . $db);
        }

        $redis->scriptLockRelease($lockKey); // 释放锁
    }
}
