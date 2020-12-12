<?php

namespace api\helpers;

use common\helpers\Tool;
use common\models\WechatPaySetting;
use Yii;

class Wxpay
{
    // 微信下单接口
    const WEIXIN_PAY_API = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    const SIGN_TYPE = 'MD5';

    //支付方式
    const TRADE_TYPE_APP    = 'APP';
    const TRADE_TYPE_MWEB   = 'MWEB';
    const TRADE_TYPE_MINI   = 'MINI';
    const TRADE_TYPE_MP     = 'MP';

    //api sk
    private $apiSecKey = '';

    private $xml_arr = [];

    /**
     * Wxpay constructor.
     */
    public function __construct()
    {
        // 初始化支付配置
        $payConfig = Yii::$app->apps->get('wechatPay', Yii::$app->common->appId);
        $appConfig = Yii::$app->apps->get('tencentInfo', Yii::$app->common->appId);

        $this->xml_arr['appid']      = $appConfig['wechat_app_id'];
        $this->xml_arr['mch_id']     = $payConfig['mch_id'];
        $this->xml_arr['sign_type']  = self::SIGN_TYPE;
        $this->xml_arr['trade_type'] = self::TRADE_TYPE_APP;
        $this->xml_arr['notify_url'] = API_HOST_PATH . '/pay/wxpay-notify';

      /*  if ($openid) {
            $this->xml_arr['openid'] = $openid;
        }*/

        $this->apiSecKey = $payConfig['api_sec_key'];
    }

    /**
     * 生产订单string
     * @param string $trade_no 业务订单号
     * @param float $total_fee 支付金额 单位:元
     * @param string $body 商品描述
     * @param string $spbill_create_ip 创建订单端ip
     * @param string $attach 业务透传参数
     * @return mixed
     */
    public function createOrder($trade_no, $total_fee, $body, $spbill_create_ip, $attach='')
    {
        $this->xml_arr['nonce_str'] = Tool::getRandKey();
        $this->xml_arr['body'] = $body;
        $this->xml_arr['attach'] = $attach;
        $this->xml_arr['out_trade_no'] = $trade_no;
        $this->xml_arr['total_fee'] = $total_fee;
        $this->xml_arr['spbill_create_ip'] = $spbill_create_ip;

        $sign = $this->_makeSign($this->xml_arr);
        $arr = $this->xml_arr;
        $arr['sign'] = $sign;
        $xml = $this->_arrayToXml($arr);
        $ch = curl_init();
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 10);
        curl_setopt ( $ch, CURLOPT_URL, self::WEIXIN_PAY_API);
        curl_setopt ( $ch, CURLOPT_POST, 1);
        curl_setopt ( $ch, CURLOPT_HEADER, 0);
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Content-Length: ' . strlen($xml)));
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $xml);

        $data = curl_exec($ch);
        $xml_obj = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($xml_obj->return_code != 'SUCCESS' || $xml_obj->result_code != 'SUCCESS') {
//            return  json_encode($xml_obj);
            //生产订单失败 记录日志
            \Yii::warning("wxpay - order create failed. req_json: " . json_encode($arr) . " resp_json: " . json_encode($xml_obj), 'WXPAY_CREATE_ORDER_FAILED');
            return false;
        }
        \Yii::warning("wxpay - order create suc. req_json: " . json_encode($arr) . " resp_json: " . json_encode($xml_obj), 'WXPAY_CREATE_ORDER_SUC');
        $ret = json_decode(json_encode($xml_obj), true);
        return $ret;
    }

    /**
     * 取config信息
     * @param $field
     * @return mixed
     */
    public function getXmlConfig($field) {
        return $this->xml_arr[$field];
    }

    /**
     * 生产数据签名
     * @param array $args
     * @return string
     */
    private function _makeSign($args) {

        $args = $this->_arg_sort($args);

        $args = $this->_param_filter($args);

        $sign_str = $this->_create_linkstring($args);

        $sign_str .= '&key='. $this->apiSecKey;

        $sign = strtoupper(md5($sign_str));

        return $sign;
    }


    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * @param array $array 需要拼接的数组
     * @return string $arg 拼接完成以后的字符串
     */
    private function _create_linkstring($array) {
        $arg  = "";

        foreach ($array as $key => $val) {
            $arg .= $key."=".$val."&";
        }

        //去掉最后一个&字符
        $arg = rtrim($arg, '&');
        return $arg;
    }
    /**
     * 对数组排序
     * @param array $array 排序前的数组
     * @return array $array 排序后的数组
     */
    private function _arg_sort($array) {
        ksort($array);
        reset($array);
        return $array;
    }
    /**
     * 除去数组中的空值和签名参数
     * @param array $parameter 签名参数组
     * @return array 去掉空值与签名参数后的新签名参数组
     */
    private function _param_filter($parameter){
        $param = [];
        foreach( $parameter as $key => $val){
            if($key == "sign" || $val == "") {
                continue;
            }
            $param[$key] = $parameter[$key];
        }
        return $param;
    }


    private function _arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            $xml.="<".$key.">".$val."</".$key.">";
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     * 校验签名
     * @param array $input
     * @return bool
     */
    public function checkSign($input)
    {
        if (!isset($input['sign'])) {
            return false;
        }

        $cal_sign = $this->_makeSign($input);

        if (strtoupper($input['sign']) == $cal_sign) {
            return true;
        }

        return false;
    }

    /**
     * 获取数据签名
     * @param $input
     * @return string
     */
    public function getSign($input) {
        unset($input['sign']);

        return $this->_makeSign($input);
    }

    /**
     * 接收http传过来的xml,并解析为数组返回
     * @return mixed
     */
    public static function post_xml_receive()
    {
        $file_in = file_get_contents("php://input"); //接收post数据

        try {
            $xml_string = simplexml_load_string($file_in, 'SimpleXMLElement', LIBXML_NOCDATA);
            $ret = json_decode(json_encode($xml_string),true);
            return $ret;
        } catch(\Exception $e) {
            \Yii::warning("input: ".$file_in." error: post_xml_receive failed - exception: " . $e->getMessage() ,'WXPAY_NOTIFY_FAILED');
            return false;
        }
    }
}
