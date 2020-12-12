<?php

namespace console\controllers;

use common\helpers\Tool;
use Yii;
use yii\console\Controller;
use api\helpers\Common;

/**
 * 接口测试
 *
 * @since 1.0
 */
class ApiTestController extends Controller
{
    /**
     * @var string 系统: ios|android
     */
    public $os = 'ios';
    /**
     * @var string 产品线: 1:APP, 2:公众号
     */
    public $product = 1;
    /**
     * @var boolean 调试模式
     */
    public $debug = false;
    /**
     * @var string 接口地址
     */
    public $path;
    /**
     * @var string 请求参数
     */
    public $params;

    /**
     * {@inheritdoc}
     */
    public function options($actionID)
    {
        return ['os', 'product', 'debug', 'path', 'params'];
    }

    /**
     * Usage: ./yii api-test [options] <path>
     */
    public function actionIndex()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->jsonParams);
        if ($this->debug) {
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
        }

        $result = curl_exec($ch);
        
        if ($this->debug) {
            echo "--------------------------- request  --------------------------- \n";
            echo curl_getinfo($ch)['request_header'] . $this->jsonParams . "\n\n";
            echo "--------------------------- response --------------------------- \n";
            echo $result . "\n";
            exit;
        }

        curl_close($ch);

        print_r(json_decode($result, 1));
    }

    /**
     * 获取接口地址
     * @return string
     */
    protected function getUrl()
    {
        return API_HOST_PATH . $this->path;
    }

    /**
     * 获取json_encode后的请求参数
     * @return string
     */
    protected function getJsonParams()
    {
        // 默认参数
        $params = [];
        $params['ver']     = '0.1';
        $params['osType']  = ['ios' => 1, 'android' => 2][$this->os];
        $params['product'] = $this->product;
        $params['time']    = time();

        // 传递的参数
        if ($this->params) {
            foreach (explode('&', $this->params) as $param) {
                list($key, $val) = explode('=', $param);
                $params[$key] = $val;
            }
        }

        // 排序
        ksort($params);

        // appKey & secret
        $config = Common::getSecretKey($params['product'], $params['osType']);
        
        list($appKey, $secret) = array_values($config);

        // 签名
        $params['sign'] = Tool::getSign($appKey, $params, $secret)[0];

        return json_encode($params);
    }
}
