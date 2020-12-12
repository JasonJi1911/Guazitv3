<?php

namespace page\services;

use api\helpers\Common;
use common\helpers\Tool;
use Yii;

/**
 * 接口服务
 */
class ApiService
{
    /**
     * @var integer 超时时间
     */
    public $timeout = 30;
    /**
     * @var integer 最大重试次数
     */
    public $maxRetryTimes = 3;
    

    /**
     * @param       $path
     * @param array $params
     * @param bool  $return_code 当返回值错误时,返回错误信息
     * @param int   $timeout
     * @return bool
     */
    public function get($path, array $params = [], $return_code = false, $timeout = 30)
    {
        if (stripos(Yii::$app->request->userAgent, 'ios') !== false) {
            $osType = 1;
        } else {
            $osType = 2;
        }

        //设置page页码
        $page = Yii::$app->request->get('page');
        if ($page) {
            $params['page_num'] = $page;
        }

        //传了token使用传入的token,为解决token刷新的问题
        if (!isset($params['token'])) {
            $params['token'] = Yii::$app->request->cookies->getValue('user_token');
        }

        // 合并默认参数
        $params = array_merge([
            'ver'    => '1.0',
            'osType' => $osType,
            'time'   => time(),
            'product'=> Common::PRODUCT_APP,
        ], $params);

        // 签名
        $config = Common::getSecretKey($params['product'], $params['osType']);
        list($appKey, $secret) = array_values($config);
        $sign = Tool::getSign($appKey, $params, $secret);
        $params['sign'] = $sign[0];

        // 发送请求
        $url = PAGE_HOST_PATH . $path;

        $result = null;

        $times = 0;
        while ($times++ < $this->maxRetryTimes) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout ?: $this->timeout);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            $result = curl_exec($ch);
            curl_close($ch);
// var_dump($result); exit;
            // 请求成功，跳过循环
            if ($result) {
                break;
            }
        }

        // 接口请求失败
        $result = json_decode($result, true);
        if (!$result) {
            return false;
        }

        if ($return_code) {
            return [
                'code' => $result['code'],
                'msg' => $result['msg'],
                'data' => $result['data']
            ];
        }

        if ($result['code'] == 0) {
            // 接口响应成功
            return $result['data'];
        }
    }
}
