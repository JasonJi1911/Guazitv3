<?php
namespace console\controllers;

use admin\models\Admin;
use common\models\User;
use Yii;
use yii\console\Controller;

/**
 * 格式化数据脚本
 * Class DataFormatController
 * @package console\controllers
 */
class DataFormatController extends Controller
{
    // todo 书籍相关数据准确性校正
    public function actionBook()
    {
        
    }

    /**
     * 重置密码
     * @throws \yii\base\Exception
     */
    public function actionResetPassword()
    {
        $passwordHash = Yii::$app->security->generatePasswordHash('123456');

        $admin = Admin::findOne(1);
        $admin->password_hash = $passwordHash;
        if (!$admin->save()) {
            Yii::warning($admin->errors);
        }
    }
    
    /**
     * 清理测试数据
     */
    public function actionClearTestData()
    {
        // 清理用户数据
//        User::deleteAll(['i'])
    }

}
