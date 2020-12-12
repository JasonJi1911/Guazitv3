<?php
namespace api\filters;

use api\exceptions\LoginException;
use api\helpers\ErrorCode;
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
        $route = Yii::$app->controller->route;
        $loginAccess = Yii::$app->params['login_access'];
        
        //查询用户
        $userUid = Yii::$app->user->id;
        
        if (!$userUid) { // 无效的token
            if (in_array($route, $loginAccess)) { // 强制登录
                throw new LoginException(ErrorCode::EC_USER_NOT_LOGIN);
            } else {
                throw new LoginException(ErrorCode::EC_USER_TOKEN_EXPIRE);
            }
        }

        return true;
    }
}
