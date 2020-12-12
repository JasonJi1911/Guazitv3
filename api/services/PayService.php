<?php
/**
 * Created by PhpStorm.
 * Date: 18/7/9
 * Time: 下午5:22
 */

namespace api\services;


use api\dao\PayDao;
use api\exceptions\ApiException;
use api\helpers\ErrorCode;
use api\logic\TaskLogic;
use api\models\pay\AppleTrade;
use api\models\pay\Goods;
use api\models\pay\Order;
use api\models\pay\PayErrorLog;
use api\models\user\TaskInfo;
use api\models\user\User;
use api\models\user\UserAssets;
use api\models\user\UserCoupon;
use api\models\user\UserVip;
use common\helpers\Tool;
use Yii;

class PayService extends Service
{
    //支付的标题
    private $subject = '%s购买';
    //支付商品详情
    private $payBody = '%s充值';

    /**
     * 生成订单
     * @param array $arrGoodsInfo 商品信息
     * @param int $payChannel 支付类型 1-苹果 2-支付宝 3-微信 需要保证 pay_trade/pay_vip_buy表的 pay_type值字段一致
     * @param object $objUser 用户信息
     * @return bool
     * @throws ApiException
     */
    public function createOrder($arrGoodsInfo, $payChannel, $objUser)
    {
        $time = time();
        // 生产订单号
        $tradeNo = Tool::makeOrderNo($objUser->uid);
        // 检查是否到已达到限购次数
        $this->_checkUserLimit($arrGoodsInfo, $objUser->uid);

        // 用户vip状态
        $userService = new UserService();
        $vipStatus = $userService->isVip($objUser->uid);

        //购买操作
        try {
            $ip = Tool::getIp();

            // 根据商品类型下单操作不通
            $objOrder = new Order();
            $objOrder->trade_no     = $tradeNo;
            $objOrder->original_fee = $arrGoodsInfo['current_price'];
            $objOrder->total_fee    = $arrGoodsInfo['current_price'];
            $objOrder->pay_channel  = $payChannel;
            $objOrder->from_channel = Yii::$app->common->fromChannel;
            $objOrder->goods_id     = $arrGoodsInfo['goods_id'];
            // 充值卡券，判断用户是否为VIP，vip用户额外赠送卡券
            if ($arrGoodsInfo['type'] == Goods::TYPE_COUPON) {
                $objOrder->value    = $vipStatus ? ($arrGoodsInfo['content'] + $arrGoodsInfo['giving']) : $arrGoodsInfo['content'];
            } else {
                $objOrder->value    = $arrGoodsInfo['content'];
            }
            $objOrder->type         = $arrGoodsInfo['type'];
            $objOrder->uid          = $objUser->uid;
            $objOrder->from_uid     = $objUser->uid;
            $objOrder->status       = Order::STATUS_DEFAULT;
            $objOrder->note         = Order::$payChannels[$payChannel] . '购买'. $arrGoodsInfo['title'].'-GoodsId['. $arrGoodsInfo['goods_id'].']';
            $objOrder->ip           = $ip;
            $objOrder->created_at   = $time;

            if (!$objOrder->save()) {
                throw new \Exception(json_encode($objOrder->errors, JSON_UNESCAPED_UNICODE));
            }
            //生产订单描述
            $tradeBody = sprintf($this->payBody, $arrGoodsInfo['title']);

        } catch(\Exception $e) {
            \Yii::warning("uid:{$objUser->uid} create order failed - exception: " . $e->getMessage() ,'CREATE_ORDER_FAILED');
            throw new ApiException($e->getCode());
        }

        return [
            $tradeNo,
            $tradeBody,
        ];
    }

    /**
     * 检测用户订单状态
     * @param int $uid 用户uid
     * @param string $orderId
     * @return bool
     */
    public function checkOrderStatus($uid, $orderId='') {
        if (empty($orderId)) {
            $time = time() - 2*60;
            //取2分钟内
            $order = Order::find()
                ->andWhere(['uid' => $uid])
                ->andWhere(['>=', 'created_at', $time])
                ->orderBy('id desc')
                ->limit(1)
                ->one();
        } else {
            $order = Order::find()
                ->andWhere(['uid' => $uid, 'id' => $orderId])
                ->one();
        }
        //未查询到订单
        if (empty($order)) {
            return false;
        }

        if ($order->status == Order::STATUS_SUCCESS) {
            return true;
        }

        return false;
    }

    /**
     * 检测用户购买限制 超过限制 抛异常
     * @param $arrGoodsInfo
     * @param $uid
     * @return bool
     * @throws ApiException
     */
    private function _checkUserLimit($arrGoodsInfo, $uid) {
        if ($arrGoodsInfo['limit_num'] == 0) { // 没有限制
            return true;
        }

        $orderCount = Order::find()
            ->andWhere(['uid' => $uid, 'goods_id' => $arrGoodsInfo['id'], 'status' => Order::STATUS_SUCCESS])
            ->count();
        //商品限购次数
        if ($arrGoodsInfo['limit_num'] > 0) {
            if ($orderCount >= $arrGoodsInfo['limit_num']) {
                throw new ApiException(ErrorCode::EC_EXCEEDING_QUOTA);
            }
        }

        return true;
    }

    /**
     * 请求苹果支付接口验证支付信息
     * @param $receipt
     * @param bool|true $isSandbox
     * @return array|bool
     */
    public function validateReceipt($receipt, $isSandbox = true) {
        if ($isSandbox) {
            $endpoint = 'https://sandbox.itunes.apple.com/verifyReceipt';
        } else {
            $endpoint = 'https://buy.itunes.apple.com/verifyReceipt';
        }

        $postData = json_encode ( ['receipt-data' => $receipt] );

        $ch = curl_init ( $endpoint );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postData );

        $response = curl_exec ( $ch );
        $err_no = curl_errno ( $ch );
        $err_msg = curl_error ( $ch );
        curl_close ( $ch );

        if ($err_no != 0) {
            return false;
        }

        $data = json_decode ( $response );

        if (! is_object ( $data )) {
            return false;
        }

        //如果不是沙盒模式就尝试一次沙盒模式
        if ( $data->status == '21007' ) {
            if(!$isSandbox){
                $result = $this->validateReceipt($receipt, 1);
                return $result;
            }
        }

        if (! isset ( $data->status ) || $data->status != 0) {
            return false;
        }

        $order = $data->receipt->in_app; //所有的订单的信息

        //返回所有商品列表
        $receiptList = [];
        foreach ($order as $need) {
            $receiptList[] = [
                'quantity'          => $need->quantity,
                'product_id'        => $need->product_id,
                'transaction_id'    => $need->transaction_id,
                'purchase_date'     => $need->purchase_date,
                'app_item_id'       => $data->receipt->app_item_id,
                'original_transaction_id' => $need->original_transaction_id,
            ];
        }

        return $receiptList;

//        $k = count($order)-1;
        $need = $order[0]; //需要的那个订单

        return [
            'quantity' => $need->quantity,
            'product_id' => $need->product_id,
            'transaction_id' => $need->transaction_id,
            'purchase_date' => $need->purchase_date,
            'original_transaction_id' => $need->original_transaction_id,
            'app_item_id' => $data->receipt->app_item_id,
        ];
    }


    /**
     * 确认充值卡券订单
     * @param object $objOrderInfo 订单信息
     * @param string $outTradeNo 外部订单号
     * @return bool
     */
    public function confirmPayResult($objOrderInfo, $outTradeNo='' )
    {
        if (empty($objOrderInfo)) {
            return false;
        }
        if ($objOrderInfo->status == Order::STATUS_SUCCESS) {
            return true;
        }

        $time = time();
        //开启事务
        $transaction = Yii::$app->db->beginTransaction();
        $ip = Tool::getIp();

        $objUserInfo = User::findOne(['uid' => $objOrderInfo->uid]);
        if (empty($objUserInfo)) {
            Yii::warning("trade_no:{$objOrderInfo->trade_no} confirm pay - user not exist.",'CONFIRM_PAY_FAILED');
            return false;
        }
        try {
            // 给用户记录表里面添加对应记录
            $objUserAssets = UserAssets::getUserAssets($objOrderInfo->uid);
            $objUserAssets->coupon_remain = $objUserAssets->coupon_remain + $objOrderInfo->value;
            $objUserAssets->total_coupon += $objOrderInfo->value;
            if (!$objUserAssets->save()) {
                throw new \Exception(json_encode($objUserAssets->errors, JSON_UNESCAPED_UNICODE));
            }
            $userCoupon             = new UserCoupon();
            $userCoupon->uid        = $objOrderInfo->uid;
            $userCoupon->trade_no   = $objOrderInfo->trade_no;
            $userCoupon->num        = $objOrderInfo->value;
            $userCoupon->recv_time  = $time;
            $userCoupon->type       = UserCoupon::TYPE_GET;
            if (!$userCoupon->save()) {
                throw new \Exception(json_encode($userCoupon->errors, JSON_UNESCAPED_UNICODE));
            }

            if ($outTradeNo) {
                $objOrderInfo->out_trade_no = $outTradeNo;
            }
            $objOrderInfo->status = Order::STATUS_SUCCESS;
            $objOrderInfo->ip = $ip;
            $objOrderInfo->notify_time = $time;

            if (!$objOrderInfo->save() ) {
                throw new \Exception(json_encode($objOrderInfo->errors, JSON_UNESCAPED_UNICODE));
            }

            $transaction->commit();
        }catch(\Exception $e) {
            Yii::warning("trade_no:{$objOrderInfo->trade_no} confirm pay - exception: " . $e->getMessage(),'CONFIRM_PAY_FAILED');
            $transaction->rollback();
            return false;
        }

        // 首次充值
        $taskLogic = new TaskLogic();
        $taskLogic->finishTask(TaskInfo::TASK_ACTION_FIRST_RECHARGE, $objOrderInfo->uid);

        return true;
    }


    /**
     * 支付购买vip服务
     * @param object $objVipBuy
     * @param string $outTradeNo
     * @return bool
     */
    public function confirmBuyVip($objVipBuy, $outTradeNo='') {
        $time = time();
        $transaction = Yii::$app->db->beginTransaction();

        try {
            //查询用户vip状态
            $objUserVip = UserVip::getUserVip($objVipBuy->uid);

            //计算vip有效期
            $arrTimeRange = $this->_calVipRange($objUserVip, $objVipBuy->value);

            //更新用户vip状态记录
            $objUserVip->start_time = $arrTimeRange['start'];
            $objUserVip->end_time   = $arrTimeRange['end'];
            $objUserVip->continue_time = $arrTimeRange['continue'];

            if (!$objUserVip->save()) {
                throw new \Exception(json_encode($objUserVip->errors, JSON_UNESCAPED_UNICODE));
            }

            //更新pay_vip_buy的状态
            $objVipBuy->out_trade_no = $outTradeNo;
            $objVipBuy->notify_time = $time;
            $objVipBuy->status = Order::STATUS_SUCCESS;

            if (!$objVipBuy->save()) {
                throw new \Exception(json_encode($objVipBuy->errors, JSON_UNESCAPED_UNICODE));
            }

            $transaction->commit();

        } catch(\Exception $e) {
            Yii::warning("trade_no:{$objVipBuy->trade_no} confirm buy vip error- exception: " . $e->getMessage(),'CONFIRM_BUY_VIP_FAILED');
            $transaction->rollback();
            return false;
        }

        // 首次开通vip
        $taskLogic = new TaskLogic();
        $taskLogic->finishTask(TaskInfo::TASK_ACTION_RECHARGE_VIP, $objVipBuy->uid);

        return true;
    }


    /**
     * 支付错误日志
     * @param array $errData 日志信息
     * @return bool
     */
    public function recordPayError(array $errData) {
        $payError = new PayErrorLog();

        foreach ($errData as $field => $val) {
            //剔除掉null数据
            if ($val === null) {
                continue;
            }
            $payError->$field = $val;
        }

        return $payError->save();
    }


    /**
     * 计算vip时间区间
     * @param object $objVipStatus 用户vip状态 user_vip_status
     * @param int $durationDay 时间跨度,单位:天
     * @return array 开始时间/结束时间/断点时间
     */
    private function _calVipRange($objVipStatus, $durationDay) {
        //从当前时间起算
        $start = time();
        $end = $start + ($durationDay * 86400);

        $continue = 0;
        //计算时间段
        if ($objVipStatus && $objVipStatus->start_time) {
            $start = $objVipStatus->start_time;
            $lastEnd = $objVipStatus->end_time;
            //vip已断续 记录断点时间
            if($lastEnd < time()){
                $continue = $start;
            } else {
                $end = $lastEnd + ($durationDay * 86400);
            }
        }

        return [
            'start' => $start,
            'end'   => $end,
            'continue' => $continue,
        ];
    }

    /**
     * 微信支付回调流程
     * @param \api\helpers\Wxpay $objWxPay
     * @param                    $arrNotifyData
     * @return array
     * @throws \api\exceptions\ApiException
     */
    public function wxpayNotify($objWxPay, $arrNotifyData) {
        $flag = $objWxPay->checkSign($arrNotifyData);

        $time = time();
        $date = date('Ymd', $time);

        $tradeNo = isset($arrNotifyData['out_trade_no']) ? $arrNotifyData['out_trade_no'] : 0;
        $outTradeNo = isset($arrNotifyData['transaction_id']) ? $arrNotifyData['transaction_id'] : 0;

        $arrErrData = [
            'date'          => $date,
            'trade_no'      => $tradeNo,
            'out_trade_no'  => $outTradeNo,
            'created_at'    => $time,
        ];

        do {
            if (!$flag) {
                //验签失败
                $arrErrData['type'] = PayErrorLog::TYPE_VERIFY_FAILED;
                $arrErrData['note'] = PayErrorLog::$typeMap[PayErrorLog::TYPE_VERIFY_FAILED];

                $data['return_msg'] = '签名失败';
                Yii::warning("trade_no:{$tradeNo} out_trade_no:{$outTradeNo} wxpay - verify failed. req_json: " . json_encode($arrNotifyData),'WXPAY_NOTIFY_FAILED');
                break;
            }

            // 根据透传的商品id信息判断回调处理操作
            $arrAttachParams = json_decode($arrNotifyData['attach'], true);
            $payDao = new PayDao();
            $arrGoodsInfo = $payDao->goodsInfo($arrAttachParams['goods_id']);
            if (!$arrGoodsInfo) { // 商品无效
                throw new ApiException(ErrorCode::EC_GOODS_INVALID);
            }

            // 获取订单信息
            $objTradeInfo = Order::findOne(['trade_no' => $tradeNo]);
            if (! $objTradeInfo) {
                $arrErrData['type'] = PayErrorLog::TYPE_ORDER_NOT_EXIST;
                $arrErrData['note'] = PayErrorLog::$typeMap[PayErrorLog::TYPE_ORDER_NOT_EXIST];
                Yii::warning("trade_no:{$tradeNo} out_trade_no:{$outTradeNo} wxpay - order not find. req_json: " . json_encode($arrNotifyData),'WXPAY_NOTIFY_FAILED');
                $data['return_msg'] = '业务订单不存在';
                break;
            }

            $arrErrData['uid'] = $objTradeInfo->uid;

            if (($objTradeInfo->total_fee != $arrNotifyData['total_fee']) || ($objWxPay->getXmlConfig('appid') != $arrNotifyData['appid'])) {
                // 验证订单信息
                $arrErrData['type'] = PayErrorLog::TYPE_ORDER_INCORRECT;
                $arrErrData['note'] = PayErrorLog::$typeMap[PayErrorLog::TYPE_ORDER_INCORRECT];

                Yii::warning("trade_no:{$tradeNo} out_trade_no:{$outTradeNo} wxpay - order info incorrect. req_json: " . json_encode($arrNotifyData),'WXPAY_NOTIFY_FAILED');

                $data['return_msg'] = '订单信息不一致';
                break;
            }

            //查询订单是否已经处理
            if ($objTradeInfo->status == Order::STATUS_SUCCESS) {
                $data = [
                    'return_code' => 'SUCCESS',
                    'return_msg' => 'OK',
                ];
                break;
            }
            //未支付时不处理直接返回
            if ($arrNotifyData['return_code'] != 'SUCCESS' || $arrNotifyData['result_code'] != 'SUCCESS') {
                $data = [
                    'return_code' => 'SUCCESS',
                    'return_msg' => 'OK',
                ];
                break;
            }

            //开始处理订单信息
            if ($arrGoodsInfo['type'] == Goods::TYPE_VIP) {
                $result = $this->confirmBuyVip($objTradeInfo, $outTradeNo);
            } else {
                $result = $this->confirmPayResult($objTradeInfo, $outTradeNo);
            }

            if (!$result) {
                $arrErrData['type'] = PayErrorLog::TYPE_CONFIRM_TRADE_FAILED;
                $arrErrData['note'] = PayErrorLog::$typeMap[PayErrorLog::TYPE_CONFIRM_TRADE_FAILED];

                Yii::warning("trade_no:{$tradeNo} out_trade_no:{$outTradeNo} wxpay - order confirm failed. req_json: " . json_encode($arrNotifyData),'WXPAY_NOTIFY_FAILED');
                $data = [
                    'return_code' => 'FAIL',
                    'return_msg' => 'FAIL',
                ];
                return $data;
            }

            $data = [
                'return_code' => 'SUCCESS',
                'return_msg' => 'OK',
            ];

        } while(0);

        if (isset($arrErrData['type'])) {
            $this->recordPayError($arrErrData);
        }

        return $data;
    }



    /**
     * 苹果支付充值卡券处理
     * @param object $objAppleTrade 苹果交易记录 pay_apple_trade
     * @param array $arrGoodsInfo 商品信息(自有的商品信息 非苹果商品信息)
     * @param object $objUser 用户信息对象 userinfo
     * @param int $fromChannel 终端类型
     * @return bool
     */
    public function confirmAppleTrade($objAppleTrade, array $arrGoodsInfo, $objUser, $fromChannel=0){
        if (empty($arrGoodsInfo) || empty($objUser) || empty($objAppleTrade)) {
            return false;
        }
        /**
         * 根据商品信息计算金币
         * 更新user_assets表信息
         * pay_trade表记录
         * pay_apple_trade表更新凭证使用状态
         */

        $product = isset(Order::$channelProductMap[$fromChannel]) ? Order::$channelProductMap[$fromChannel] : 0;

        $transaction = Yii::$app->db->beginTransaction();
        $ip = Tool::getIp();
        $time = time();

        // 用户vip状态
        $userService = new UserService();
        $vipStatus = $userService->isVip($objUser->uid);

        // 判断用户是否为VIP，vip用户额外赠送卡券
        $goodContent = $vipStatus ? ($arrGoodsInfo['content'] + $arrGoodsInfo['giving']) : $arrGoodsInfo['content'];

        try {
            $objUserAssets = UserAssets::getUserAssets($objUser->uid);
            $objUserAssets->coupon_remain = $objUserAssets->coupon_remain + $goodContent;
            $objUserAssets->total_coupon += $goodContent;
            if (!$objUserAssets->save()) {
                throw new \Exception(json_encode($objUserAssets->errors, JSON_UNESCAPED_UNICODE));
            }

            //记录bw_order表记录
            $objOrder = new Order();
            $objOrder->trade_no         = $objAppleTrade->trade_no;
            $objOrder->out_trade_no     = $objAppleTrade->apple_trade_id;
            $objOrder->original_fee     = $arrGoodsInfo['current_price'];
            $objOrder->total_fee        = $arrGoodsInfo['current_price'];
            $objOrder->pay_channel      = $objOrder::PAY_CHANNEL_APPLEPAY;
            $objOrder->from_channel     = $fromChannel;
            $objOrder->goods_id         = $arrGoodsInfo['goods_id'];
            $objOrder->product          = $product;
            $objOrder->uid              = $objUser->uid;
            $objOrder->from_uid         = $objUser->uid;
            $objOrder->status           = $objOrder::STATUS_SUCCESS;
            $objOrder->value            = $goodContent;
            $objOrder->note             = '苹果支付购买'.'-GoodsId['.$arrGoodsInfo['goods_id'].']';
            $objOrder->ip               = $ip;
            $objOrder->notify_time      = $time;

            if (!$objOrder->save()) {
                throw new \Exception(json_encode($objOrder->errors, JSON_UNESCAPED_UNICODE));
            }

            //将凭证状态更新为已使用
            $objAppleTrade->is_used     = AppleTrade::IS_USED_YES;
            $objAppleTrade->updated_at  = $time;

            if (!$objAppleTrade->save()) {
                throw new \Exception(json_encode($objAppleTrade->errors, JSON_UNESCAPED_UNICODE));
            }

            $transaction->commit();

        } catch (\Exception $e) {
            Yii::warning("trade_no:{$objAppleTrade->trade_no} confirm apple pay error- exception: " . $e->getMessage(),'APPLE_PAY_FAILED');
            $transaction->rollback();
            return false;
        }

        return true;
    }

    /**
     * 苹果购买vip服务
     * @param object $objAppleTrade 苹果凭证记录
     * @param array $arrGoodsInfo 商品信息
     * @param object $objUser 用户信息
     * @param int $fromChannel 终端
     * @return bool
     * @throws \yii\db\Exception
     * @throws
     */
    public function confirmAppleBuyVip($objAppleTrade, array $arrGoodsInfo, $objUser, $fromChannel) {

        if ($arrGoodsInfo['type'] != Goods::TYPE_VIP) {
            throw new ApiException(ErrorCode::EC_GOODS_INVALID);
        }

        $time = time();
        $ip = Tool::getIp();
        $transaction = Yii::$app->db->beginTransaction();

        try {
            //查询用户vip状态
            $objUserVip = UserVip::getUserVip($objUser->uid);
            // 计算vip有效期,更新用户vip时间
            $arrTimeRange = $this->_calVipRange($objUserVip, $arrGoodsInfo['content']);
            $objUserVip->start_time = $arrTimeRange['start'];
            $objUserVip->end_time   = $arrTimeRange['end'];
            $objUserVip->continue_time = $arrTimeRange['continue'];
            if (!$objUserVip->save()) {
                throw new \Exception(json_encode($objUserVip->errors, JSON_UNESCAPED_UNICODE));
            }

            //记录vip苹果购买记录
            $objVipBuy                  = new Order();
            $objVipBuy->trade_no        = $objAppleTrade->trade_no;
            $objVipBuy->out_trade_no    = $objAppleTrade->apple_trade_id;
            $objVipBuy->original_fee    = $arrGoodsInfo['current_price'];
            $objVipBuy->total_fee       = $arrGoodsInfo['current_price'];
            $objVipBuy->pay_channel     = Order::PAY_CHANNEL_APPLEPAY;
            $objVipBuy->from_channel    = $fromChannel;
            $objVipBuy->uid             = $objUser->uid;
            $objVipBuy->status          = Order::STATUS_SUCCESS;
            $objVipBuy->goods_id        = $arrGoodsInfo['goods_id'];
            $objVipBuy->value           = $arrGoodsInfo['content'];
            $objVipBuy->note            = '苹果支付购买vip服务-GoodsId['.$arrGoodsInfo['goods_id'].']';
            $objVipBuy->ip              = $ip;
            $objVipBuy->notify_time     = $time;

            if (!$objVipBuy->save()) {
                throw new \Exception(json_encode($objVipBuy->errors, JSON_UNESCAPED_UNICODE));
            }

            //更新apple_trade的凭据使用状态
            $objAppleTrade->is_used = AppleTrade::IS_USED_YES;
            if (!$objAppleTrade->save()) {
                throw new \Exception(json_encode($objAppleTrade->errors, JSON_UNESCAPED_UNICODE));
            }

            $transaction->commit();

        } catch(\Exception $e) {
            Yii::warning("trade_no:{$objAppleTrade->trade_no} confirm apple buy vip error- exception: " . $e->getMessage(),'BY_VIP_FAILED');
            $transaction->rollback();
            return false;
        }

        // 首次开通vip
        $taskLogic = new TaskLogic();
        $taskLogic->finishTask(TaskInfo::TASK_ACTION_RECHARGE_VIP, $objVipBuy->uid);

        return true;
    }
}
