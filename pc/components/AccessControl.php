<?php
namespace pc\components;

use Yii;
use yii\web\ForbiddenHttpException;

class AccessControl extends \yii\filters\AccessControl
{

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (!Yii::$app->user) {
            throw new ForbiddenHttpException('当前账号没有权限');
        }

        return true;
    }
}
