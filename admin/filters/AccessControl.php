<?php
namespace admin\filters;

use Yii;

class AccessControl extends \yii\filters\AccessControl
{

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (!Yii::$app->user->identity->role->can(Yii::$app->requestedRoute, Yii::$app->request->queryParams)) {
            throw new ForbiddenHttpException('当前账号没有权限');
        }

        return true;
    }
}
