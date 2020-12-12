<?php
/**
 * Created by PhpStorm.
 * Date: 18/7/9
 * Time: 下午5:22
 */

namespace common\services;


use admin\models\user\UserCoupon;
use api\exceptions\ApiException;
use api\helpers\ErrorCode;
use common\helpers\Tool;
use common\models\pay\Expend;
use common\models\user\User;
use common\models\user\UserAssets;
use common\models\user\UserVip;
use Yii;

class PayService
{
    /**
     * 赠送积分入口
     * @param int $uid 用户uid
     * @param int $type 获取类型 2-分享获取 4-任务获取
     * @param int $num 赠送积分数 可不传 (type为4时必传)
     * @param string $note 备注信息 可不填(type为4时必传)
     * @return bool
     */
    public function interfacePay($uid, $type, $num = null, $note = '')
    {
        if (empty($uid) || empty($type)) {
            return false;
        }

        $objUser = User::findOne(['uid' => $uid]);
        if (empty($objUser) || empty($num)) {
            return false;
        }

        if (empty($note)) {
            $note = isset(Expend::$expendMap[$type]) ? Expend::$expendMap[$type] : '';
        }

        //生产订单号
        $tradeNo = Tool::makeOrderNo($uid);

        //开启事务
        $transaction = Yii::$app->db->beginTransaction();
        $ip = Tool::getIp();

        try {
            $objUserAssets = UserAssets::findOne(['uid' => $uid]);
            if (empty($objUserAssets)) {
                $objUserAssets = new UserAssets();
                $objUserAssets->uid = $uid;
            }

            if ($type < Expend::INCOME_EXPEND_FLAG) {
                $objUserAssets->score_remain += $num;
                $objUserAssets->total_score  += $num;
            } else {
                $objUserAssets->score_remain -= $num;
                // 积分小于0时，直接抛错, 后台扣除可扣除负数
                if ($objUserAssets->score_remain < 0 && $type == Expend::TYPE_SYSTEM_REDUCE) {
                    throw new ApiException(ErrorCode::EC_SCORE_NOT_ENOUGH);
                }
            }

            if (!$objUserAssets->save()) {

                Yii::warning($objUserAssets->errors);
                throw new \Exception(json_encode($objUserAssets->errors, JSON_UNESCAPED_UNICODE));
            }

            //用户金币变化记录
            $objExpend = new Expend();
            $objExpend->expend_no    = $tradeNo;
            $objExpend->uid          = $uid;
            $objExpend->type         = $type;
            $objExpend->score        = $num;
//            $objExpend->from_channel = Yii::$app->common->fromChannel;
//            $objExpend->product      = Yii::$app->common->product;
            $objExpend->score_remain = $objUserAssets->score_remain;
            $objExpend->note         = $note;
            $objExpend->ip           = $ip;

            if (!$objExpend->save() ) {
                throw new \Exception(json_encode($objExpend->errors, JSON_UNESCAPED_UNICODE));
            }

            $transaction->commit();
        }catch(\Exception $e) {
            $transaction->rollback();
            Yii::warning('interfacePay error, Exception['.$e->getMessage().']', 'INTERFACE_PAY');
            return false;
        }

        return [$tradeNo, $num];
    }

    /**
     * 赠送vip的方法
     * @param $uid
     * @param $timeRange
     * @return bool
     */
    public function givingVip($uid, $timeRange)
    {
        if (empty($uid) || empty($timeRange)) {
            return false;
        }
        //查询用户vip状态
        $objUserVip = UserVip::getUserVip($uid);

        //计算vip有效期
        $arrTimeRange = $this->_calVipRange($objUserVip, $timeRange);

        //更新用户vip状态记录
        $objUserVip->start_time    = $arrTimeRange['start'];
        $objUserVip->end_time      = $arrTimeRange['end'];
        $objUserVip->continue_time = $arrTimeRange['continue'];
        $objUserVip->status        = UserVip::STATUS_NORMAL;

        if (!$objUserVip->save()) {
            return false;
        }

        return true;
    }

    /**
     * 计算vip时间区间
     * @param object $objVipStatus 用户vip状态 user_vip_status
     * @param int $durationTime 时间跨度,单位:秒
     * @return array 开始时间/结束时间/断点时间
     */
    private function _calVipRange($objVipStatus, $durationTime) {

        //从当前时间起算
        $start = time();
        $end = $start + $durationTime;

        $continue = 0;
        //计算时间段
        if( $objVipStatus && $objVipStatus->start_time){
            $start = $objVipStatus->start_time;
            $lastEnd = $objVipStatus->end_time;
            //vip已断续 记录断点时间
            if( $lastEnd < time()){
                $continue = $start;
            }else {
                $end = $lastEnd + $durationTime;
            }
        }

        return [
            'start' => $start,
            'end' => $end,
            'continue' => $continue,
        ];
    }

    /**
     * 赠送/扣除 卡券入口
     * @param int $uid 用户uid
     * @param int $type 获取类型 1 使用  2 获取
     * @param int $num 赠送卡券数 必传
     * @return bool
     */
    public function interfaceCoupon($uid, $type, $num = 0)
    {
        if (empty($uid) || empty($type)) {
            return false;
        }

        $objUser = User::findOne(['uid' => $uid]);
        if (empty($objUser) || empty($num)) {
            return false;
        }

        //生产订单号
        $tradeNo = Tool::makeOrderNo($uid);
        //开启事务
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $objUserAssets = UserAssets::findOne(['uid' => $uid]);
            if (empty($objUserAssets)) {
                $objUserAssets = new UserAssets();
                $objUserAssets->uid = $uid;
            }

            if ($type == UserCoupon::TYPE_GET) {
                $objUserAssets->coupon_remain += $num;
                $objUserAssets->total_coupon  += $num;
            } else {
                $objUserAssets->coupon_remain -= $num;
                // 积分小于0时，直接抛错，后台扣除可直接扣为负数
                if ($objUserAssets->coupon_remain < 0 && $type != UserCoupon::TYPE_SYSTEM_REDUCE) {
                    throw new ApiException(ErrorCode::EC_SCORE_NOT_ENOUGH);
                }
            }

            if (!$objUserAssets->save()) {
                Yii::warning($objUserAssets->errors);
                throw new \Exception(json_encode($objUserAssets->errors, JSON_UNESCAPED_UNICODE));
            }

            //用户卡券变化记录
            $objUserCoupon = new UserCoupon();
            $objUserCoupon->uid       = $uid;
            $objUserCoupon->trade_no  = $tradeNo;
            $objUserCoupon->num       = $num;
            $objUserCoupon->recv_time = time();
            $objUserCoupon->type      = $type;

            if (!$objUserCoupon->save() ) {
                throw new \Exception(json_encode($objUserCoupon->errors, JSON_UNESCAPED_UNICODE));
            }

            $transaction->commit();
        }catch(\Exception $e) {
            $transaction->rollback();
            Yii::warning('interfacePay error, Exception['.$e->getMessage().']', 'INTERFACE_PAY');
            return false;
        }

        return [$tradeNo, $num];
    }

}
