<?php

namespace api\components;

use common\helpers\Encrypt;
use Yii;
use api\helpers\ErrorCode;

/**
 * 响应类
 */
class Response extends \yii\web\Response
{
    /**
     * @inheritdoc
     */
    public $format = self::FORMAT_JSON;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->on(static::EVENT_BEFORE_SEND, [static::className(), 'beforeSend']);
    }

    /**
     * 发送前格式化响应结果
     * @param object $event
     */
    public static function beforeSend($event)
    {
        $response = $event->sender;

        if ($response->isSuccessful) {
            // 响应成功
            $code    = ErrorCode::SUCCESS_CODE;
            $message = ErrorCode::errMsg($code);
            $data    = $response->data;
        } else {
            // 响应失败
            $code = $response->data['code'] ?? ErrorCode::EC_UNKNOWN;
            
            //失败时候code为0时重置为系统错误
            if ($code == 0) {
                $code = ErrorCode::EC_SYSTEM_ERROR;
            }

            $message = $response->data['message'] ?? ErrorCode::errMsg($code);

            $data = null;
        }

        //无数据响应时
//        if (empty($data)) {
//            $data = (object)[];
//        }

        // 状态码重置为200
        $response->statusCode = 200;

        if ($response->format == 'json') {
            //没有code或msg时重新定义code
            if (!isset($response->data['code']) || !isset($response->data['msg'])) {
                // 重新格式化响应结果
                $response->data = [
                    'code' => $code,
                    'msg'  => $message,
                    'data' => $data,
                ];
            }
        } else {
            $response->data = $data;
        }
    }

    /**
     * 发送加密数据
     */
    protected function sendContent()
    {
        $apiUri = Yii::$app->request->getUrl();
        $apiArr = explode('?', $apiUri);
        $apiRoute = $apiArr[0];
        $apiWhiteList = Yii::$app->params['apiWhiteList'];
        // 判断是否开启 debug 或者 白名单接口
        if (Yii::$app->request->post('debug') || in_array($apiRoute, $apiWhiteList)) {
            return parent::sendContent();
        }
        $encrypt = new Encrypt();
        $this->content = $encrypt->encrypt($this->content);
        return parent::sendContent();
    }
}
