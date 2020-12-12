<?php
namespace admin\controllers;

use admin\models\pay\Expend;
use admin\models\user\User;
use admin\models\user\UserAssets;
use admin\models\user\UserCoupon;
use admin\models\user\UserVip;
use common\services\PayService;
use Yii;
use common\helpers\Tool;

class UserController extends BaseController
{
    public $name = '用户';

    public $modelClass = 'admin\models\user\User';
    public $searchModelClass = 'admin\models\user\search\UserSearch';


    /*
   * 赠送金币
   * */
    public function actionGold()
    {
        $uid = Yii::$app->request->get('uid');
        $money = Yii::$app->request->get('money');
        if (!is_numeric($money)) {
            return Tool::responseJson(1, '不是一个正确的数字');
        }
        $payService = new PayService();
        if ($money > 0) { //赠送积分
            $result = $payService->interfacePay($uid, Expend::TYPE_SYSTEM, $money);
        } else { //扣除积分
            $result = $payService->interfacePay($uid, Expend::TYPE_SYSTEM_REDUCE, abs($money));
        }

        if ($result) {
            return Tool::responseJson(0, '');
        }

        return Tool::responseJson(1, '扣除数不能超过当前总数');
    }

    /**
     * 开通会员
     */
    public function actionVipBuy()
    {
        $uid = Yii::$app->request->get('uid');
        $days = Yii::$app->request->get('days');
        if (!is_numeric($days)) {
            return Tool::responseJson(1, '天数必须为整数');
        }
        $model = UserVip::findOne(['uid' => $uid]);
        if (!$model) {
            if ($days <= 0) { //如果天数小于等于0直接返回
                return Tool::responseJson(0, '');
            }
            $model = new UserVip();
            $model->uid = $uid;
        }

        //如果会员已经过期
        if ($model->end_time < time()) {
            $model->end_time = time();
        }
        $model->continue_time = $days * 86400;
        if ($model->continue_time < 0) {
            $model->continue_time = 0;
        }
        $model->start_time = $model->start_time ? $model->start_time : time();
        $model->end_time = ($model->end_time ? $model->end_time : time()) + 86400 * $days;
        if (!$model->save()) {
            Yii::warning($model->errors);
        }

        return Tool::responseJson(0, '');
    }

    /**
     * 充值、扣除卡券
     */
    public function actionCoupon()
    {
        $uid = Yii::$app->request->get('uid');
        $num = Yii::$app->request->get('num');

        if (!is_numeric($num)) {
            return Tool::responseJson(1, '不是一个正确的数字');
        }

        $payService = new PayService();
        if ($num > 0) { //赠送卡券
            $result = $payService->interfaceCoupon($uid, UserCoupon::TYPE_GET, $num);
        } else { //扣除卡券
            $result = $payService->interfaceCoupon($uid, UserCoupon::TYPE_SYSTEM_REDUCE, abs($num));
        }

        if ($result) {
            return Tool::responseJson(0, '');
        }

        return Tool::responseJson(1, '系统错误,稍后重试');
    }

}
