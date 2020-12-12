<?php
namespace api\controllers;

use api\exceptions\ApiException;
use api\helpers\ErrorCode;
use api\logic\PayLogic;
use api\models\pay\Goods;
use api\models\pay\Order;
use api\services\PayService;
use Yii;
use yii\web\Response;

class PayController extends BaseController
{
    /**
     * 会员中心
     * @return array
     */
    public function actionVipCenter()
    {
        $payLogic = new PayLogic();
        return $payLogic->vipCenter();
    }

    /**
     * 卡券中心
     * @return array
     */
    public function actionCouponCenter()
    {
        $payLogic = new PayLogic();
        return $payLogic->couponCenter();
    }

    /**
     * 支付宝充值下单接口
     * @return string
     * @throws ApiException
     */
    public function actionAlipay()
    {
        $goodsId    = $this->getParamOrFail('goods_id');
        $payLogic   = new PayLogic();
        return $payLogic->alipay($goodsId);
    }

    /**
     * 支付宝支付回调
     * @return string
     */
    public function actionAlipayNotify()
    {
        $input = $_POST;

        $payLogic = new PayLogic();
        $result = $payLogic->alipayNotify($input);

        echo $result;
        exit;
    }

    /**
     * 微信支付下单
     * @return array $data
     * @throws ApiException
     */
    public function actionWxpay()
    {
        $goodsId = $this->getParamOrFail('goods_id');
        $payLogic   = new PayLogic();
        return $payLogic->wxpay($goodsId);
    }

    /**
     * 微信支付回调
     * @return array
     */
    public function actionWxpayNotify()
    {
        Yii::$app->response->format = Response::FORMAT_XML;
        $payLogic   = new PayLogic();
        return $payLogic->wxpayNotify();
    }

    /**
     * 苹果支付确认接口
     */
    public function actionApplepay()
    {
        $receipt = $this->getParamOrFail('receipt');
        
        $payLogic   = new PayLogic();
        return $payLogic->applepay($receipt);
    }

    /**
     * 下单接口, 为外部提供统一的下单接口
     * @return array
     * @throws ApiException
     */
    public function actionCreateOrder() {
        $goodsId = $this->getParamOrFail('goods_id');
        /**
         * 查询商品信息
         */
        $objGoods = Goods::findOne($goodsId);
        if (empty($objGoods)) {
            throw new ApiException(ErrorCode::EC_GOODS_INVALID);
        }
        $arrGoodsInfo = $objGoods->toArray();

        $objPayService = new PayService();

        //购买商品下单
        list($tradeNo, $tradeBody) = $objPayService->createOrder($arrGoodsInfo, Order::PAY_CHANNEL_ALIPAY,
            Yii::$app->user);


        //将商品ID和渠道透传过去
        $extension = $this->fromChannel.'-'.$goodsId;
        $data = [
            'orderId' => $tradeNo,
            'orderName' => $arrGoodsInfo['title'],
            'userId' => Yii::$app->user->uid,
            'extension' => $extension,
            'amount' => $arrGoodsInfo['current_price'],
        ];

        return $data;
    }

    /**
     * 订单检测接口
     * @return array
     * @throws ApiException
     */
    public function actionCheckOrder() {

        $payService = new PayService();
        $result = $payService->checkOrderStatus(Yii::$app->user->uid);

        if ($result) {
            return [];
        }

        throw new ApiException(ErrorCode::EC_ORDER_NOT_COMPLETED);
    }

}
