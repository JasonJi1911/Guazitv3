<?php
namespace page\components;

use common\helpers\Tool;
use Yii;

/**
 * 访问控制
 */
class AccessControl extends \yii\filters\AccessControl
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        return true;
        $token = Yii::$app->request->get('token');
        $uid = Yii::$app->api->get('/user/uid', ['token' => $token]);
        if (!$uid) { //没有用户id表示登录过期,重新登录
            Tool::goLogin();
        }
        
        return true;
    }
}
