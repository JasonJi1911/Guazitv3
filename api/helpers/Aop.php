<?php

namespace api\helpers;
use Yii;

//加载alipay支付入口文件
require_once(dirname(dirname(__DIR__)) . '/common/helpers/alisdk/alipay/AopSdk.php');

class Aop
{
    //支付网关
    const GATE_WAY_URL = "https://openapi.alipay.com/gateway.do";
    // 支付回调api
    const NOTIFY_URL = API_HOST_PATH . "/pay/alipay-notify";

    // 配置参数
    const FORMAT = 'json';
    const CHARSET = 'UTF-8';
    const SIGN_TYPE = "RSA2";

    /**
     * app支付数据签名生产方法
     * @param string $trade_no 自有订单号
     * @param string $money 支付金额 单位:元
     * @param string $subject 商品名
     * @param string $body 商品描述
     * @param string $passback 透传的业务参数
     * @return string 订单支付调起串
     */
    public static function getOrderString($trade_no, $money, $subject, $body='', $passback='')
    {
        $alipayConfig = Yii::$app->apps->get('alipay', Yii::$app->common->appId);
        $aop = new \AopClient;
        $aop->gatewayUrl    = self::GATE_WAY_URL;
        $aop->appId         = $alipayConfig['alipay_app_id'];
        $aop->rsaPrivateKey = $alipayConfig['rsa_private_key'];
        $aop->format        = self::FORMAT;
        $aop->charset       = self::CHARSET;
        $aop->signType      = self::SIGN_TYPE;
        $aop->alipayrsaPublicKey = $alipayConfig['alipay_public_key'];
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new \AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $bizContent = "{\"body\":\"{$body}\","
            . "\"subject\": \"".$subject."\","
            . "\"out_trade_no\": \"".$trade_no."\","
            . "\"timeout_express\": \"30m\","
            . "\"total_amount\": \"".$money."\","
            . "\"product_code\":\"QUICK_MSECURITY_PAY\","
            . "\"passback_params\":\".$passback.\""
            . "}";
        $request->setNotifyUrl(self::NOTIFY_URL);
        $request->setBizContent($bizContent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
//        return htmlspecialchars($response); //就是orderString 可以直接给客户端请求，无需再做处理。
        return $response;
    }

    /**
     * 获取支付宝appid
     * @return string
     */
    public static function getAppId() {
        $alipayConfig = Yii::$app->apps->get('alipay', Yii::$app->common->appId);
        return $alipayConfig['alipay_app_id'];
    }

    /**
     * 支付宝回调数据校验
     * @param $data
     * @return bool
     */
    public static function checkNotify($data) {
        $alipayConfig = Yii::$app->apps->get('alipay', Yii::$app->common->appId);
        $aop = new \AopClient;
        $aop->alipayrsaPublicKey = $alipayConfig['alipay_public_key'];
        $flag = $aop->rsaCheckV1($data, NULL, self::SIGN_TYPE);

        return $flag;
    }
}
