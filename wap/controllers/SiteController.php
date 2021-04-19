<?php
namespace wap\controllers;

use common\helpers\Tool;
use Yii;
use api\models\User;

/**
 * Site controller
 */
class SiteController extends BaseController
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

            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 4,
                'minLength' => 4,
            ],
        ];
    }

    /*
     * 增加广告点击量
     */
    public function actionAdvertClick()
    {
        $advertId = Yii::$app->request->get('advert_id');
        Yii::$app->api->get('/advert/click',['advert_id' => $advertId]);
        return Tool::responseJson(0, 'success');
    }

    public function actionClearCookies()
    {
        Yii::$app->response->cookies->remove('gid');
        Yii::$app->response->cookies->remove('lid');
        Yii::$app->response->cookies->remove('user_token');
    }
    
    public function actionShareDown()
    {
        $useragent = Yii::$app->request->getUserAgent();
        $iswechat = false;
        if (strpos($useragent, 'MicroMessenger')) {
            $iswechat = true;
        }
        $data = Yii::$app->api->get('/search/app-version');
        return $this->render('sharedown', [
            'iswechat'  =>  $iswechat,
            "data"      =>  $data,
        ]);
    }
}
