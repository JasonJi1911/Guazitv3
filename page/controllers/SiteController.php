<?php
namespace page\controllers;

use common\models\apps\AppsCheckSwitch;
use common\models\UserMessageTime;
use Yii;
use common\models\LoginForm;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class'  => 'yii\web\ErrorAction',
                'layout' => false,
            ],
        ];
    }

    //会员服务协议
    public function actionMembershipService() 
    {
        $this->layout = true;
        $appId = Yii::$app->request->get('id', 1);
        $appInfo = Yii::$app->apps->get('info', $appId);
        
        return $this->render('membership_service', [
            'appName' => $appInfo['name'],
        ]);
    }

    public function actionSite()
    {
        $this->layout = true;
        return $this->render('site');
    }

    /**
     * 投屏助手
     */
    public function actionScreenHelper()
    {
        return $this->render('screen_helper');
    }

    /**
     * 分享落地页
     */
    public function actionShareDown()
    {
        $androidApps = AppsCheckSwitch::find()->where(['and', ['!=', 'file_path', ''], ['!=', 'channel', 'ios']])->orderBy('version_id desc')->one();
        return $this->render('share_down', ['androidFilePath' => $androidApps ? $androidApps->file_path : '']);
    }

    /**
     * 软件许可及服务协议
     * @return string
     */
    public function actionNotify()
    {
        $this->layout = true;
        $appId = Yii::$app->request->get('id', 1);
        $appInfo = Yii::$app->apps->get('info', $appId);

        return $this->render('notify', [
            'appName' => $appInfo['name'],
        ]);
    }

    /**
     * 隐私协议
     * @return string
     */
    public function actionPrivacyPolicy() {
        $this->layout = true;
        $appId = Yii::$app->request->get('id', 1);
        $appInfo = Yii::$app->apps->get('info', $appId);

        return $this->render('privacy_policy', [
            'appName' => $appInfo['name'],
        ]);
    }

    /**
     * 会员协议
     */
    public function actionVipPolicy()
    {
        $this->layout = true;
        $appId   = Yii::$app->request->get('id', 1);
        $appInfo = Yii::$app->apps->get('info', $appId);

        return $this->render('vip_policy', [
            'appName' => $appInfo['name'],
        ]);
    }

    //用户协议
    public function actionUserAgreement() {
        $this->layout = true;
        $appName = Yii::$app->apps->get('info');
        return $this->render('user_agreement', [
            'appName' => $appName['name'],
        ]);
    }
    //注销协议
    public function actionLogoffProtocol() {
        $this->layout = true;
        $appName = Yii::$app->apps->get('info');
        return $this->render('logoff_protocol', [
            'appName' => $appName['name'],
        ]);
    }
}
