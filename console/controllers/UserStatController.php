<?php
namespace console\controllers;

use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\models\pay\Order;
use common\models\stat\UserStat;
use common\models\user\User;
use yii\web\Controller;

class UserStatController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionRun()
    {
        $date = date('Ymd');
        $userStat = UserStat::findOne(['date' => $date]);
        if (!$userStat) {
            $userStat = new UserStat();
            $userStat->date = $date;
        }

        //时间
        $start_time = strtotime($date);
        $end_time = $start_time + 86400;

        //日活
        $key = RedisKey::userStat(date('Ymd'));
        $redis = new RedisStore();
        $dayActive = $redis->scard($key);

        //用户
        $users = User::find()
            ->where(['and', ['>=', 'created_at', $start_time], ['<', 'created_at', $end_time]])
            ->asArray()
            ->all();

        $android_incr = $apple_incr = $total_incr = $recharge_total = $recharge_incr = $vip_incr = $vip_total = 0;

        // 统计来源
        foreach ($users as $user) {
            switch ($user['source']) {
                case User::SOURCE_ANDROID_APP:
                    $android_incr++;
                    $total_incr++;
                    break;
                case User::SOURCE_IOS_APP:
                    $apple_incr++;
                    $total_incr++;
                    break;
            }
        }


        //充值新增
        $recharge_incr = Order::find()
            ->where(['status' => Order::STATUS_SUCCESS, 'type' => Order::TYPE_COUPON])
            ->andWhere(['and', ['>=', 'created_at', $start_time], ['<', 'created_at', $end_time]])
            ->groupBy('uid')
            ->count();
        // 总充值
        $recharge_total = Order::find()
            ->where(['status' => Order::STATUS_SUCCESS, 'type' => Order::TYPE_COUPON])
            ->groupBy('uid')
            ->count();
        // 新增vip
        $vip_incr = Order::find()
            ->where(['status' => Order::STATUS_SUCCESS, 'type' => Order::TYPE_VIP])
            ->andWhere(['and', ['>=', 'created_at', $start_time], ['<', 'created_at', $end_time]])
            ->groupBy('uid')
            ->count();
        // 总vip
        $vip_total = Order::find()
            ->where(['status' => Order::STATUS_SUCCESS, 'type' => Order::TYPE_VIP])
            ->groupBy('uid')
            ->count();

        $userStat->android_incr   = $android_incr;
        $userStat->apple_incr     = $apple_incr;
        $userStat->total_incr     = $total_incr;
        $userStat->day_active     = $dayActive;
        $userStat->recharge_incr  = $recharge_incr;
        $userStat->recharge_total = $recharge_total;
        $userStat->vip_incr       = $vip_incr;
        $userStat->vip_total      = $vip_total;

        $userStat->save();
    }
}