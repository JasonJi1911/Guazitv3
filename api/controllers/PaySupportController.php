<?php
/**
 * Created by PhpStorm.
 * Date: 18/6/23
 * Time: 下午8:30
 */

namespace api\controllers;

use api\helpers\ErrorCode;
use api\models\pay\PayChannel;
use api\models\User;
use common\helpers\Tool;
use Yii;
use yii\web\Controller;


class PaySupportController extends Controller
{
    /**
     * 自定义支付
     */
    public function actionCustom() {
        $goodsId = Yii::$app->request->get('goods_id');
        $token = Yii::$app->request->get('token', '');
        $payId = Yii::$app->request->get('pal_id');

        do {
            if (empty($token)) {
                //未登录页面
                $msg = '未登录，请先登录';
                break;
            }

            $objPayChannel = PayChannel::find()->andWhere(['id' => $payId])->one();
            if (empty($objPayChannel)) {
                $msg = '参数异常！';
                break;
            }

            $payChannel = $objPayChannel->channel_id;
            if (empty($payChannel) || empty($goodsId)) {
                $msg = '参数缺失！';
                break;
            }
            //调用下单接口
            $data = Yii::$app->api->get('/pay/create-order', [
                'goods_id' => $goodsId,
                'token' => $token,
                'ip' => Tool::getIp(),
            ], true);

            if (isset($data['code'])) {
                if ($data['code'] == ErrorCode::EC_USER_TOKEN_EXPIRE) {
                    //未登录页
                    $msg = '未登录，请先登录';
                    break;
                }
                if ($data['code'] != ErrorCode::SUCCESS_CODE) {
                    //错误页
                    $msg = '支付出错啦！';
                    break;
                }
            }

            $masterChannel = PayChannel::find()->andWhere(['id' => $objPayChannel->pid])->one();
            $params = [
                'uid' => $data['userId'],
                'orderId' => $data['orderId'],
                'price' => $data['amount'],
                'title' => $data['orderName'],
                'type' => $payChannel,
            ];
            $query = http_build_query($params);

            $url = $masterChannel->gateway.'?'.$query;
            //跳转支付
            header("Location: {$url}");
            exit;
        } while(false);

        echo $msg;
        exit;
    }

}
