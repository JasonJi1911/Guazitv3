<?php
namespace wap\controllers;

use common\helpers\RedisStore;
use common\helpers\Tool;
use wap\models\LoginForm;
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
    /**
     * 手机密码 / 短信验证码登录
     */
    public function actionNewLogin()
    {
        $mobile_areacode = Yii::$app->request->get('mobile_areacode', "");
        $mobile = Yii::$app->request->get('mobile', "");//手机
        $password = Yii::$app->request->get('password', "");
        $flag = Yii::$app->request->get('flag',0);//0-密码；1-短信验证码
        $code = Yii::$app->request->get('code', "");
        if($flag==0){//密码登录
            $model = new LoginForm();
            $model->mobile = $mobile;
            $model->mobile_areacode = $mobile_areacode;
            $model->password = $password;
            $model->flag = 0;
            if ( $model->login()) {
                Yii::$app->cache->set('login_flag', '1');
                $uid = Yii::$app->user->id;
                $this->setCookie($uid);
                $errno = 0;
                $msg = '登录成功';
            } else {
                $errno = -1;
                $msg = '账号或密码输入错误';
                $uid = '';
            }
        }else{//短信验证码登录
            $redis = new RedisStore();
            $key = 'SMScode'.$mobile_areacode.$mobile;
            if($redis->get($key) && $redis->get($key)==$code){
                $password = '111111';
                $result = Yii::$app->api->get('/user/message-register',['mobile' => $mobile,'mobile_areacode'=>$mobile_areacode,'password'=>$password]);
                if($result['errno']==0){
                    $model = new LoginForm();
                    $model->mobile = $mobile;
                    $model->password = $password;
                    $model->flag = 1;
                    if ( $model->login()) {
                        Yii::$app->cache->set('login_flag', '1');
                    }
                    $uid = Yii::$app->user->id;
                    $errno = 0;
                    $msg = '操作成功';
                }else{
                    $errno = -1;
                    $msg = '注册失败';
                    $uid = '';
                }
            }else{
                $errno = -1;
                $msg = '短信验证码输入错误';
                $uid = '';
            }
        }
        return Tool::responseJson($errno, $msg, $uid);
    }

    private function setCookie($uid){
        $cookie1 = \Yii::$app->request->cookies;
        $uid1=$cookie1->get("uid");
        if(!$uid1){
            $cookie = new \yii\web\Cookie();
            $cookie -> name = 'uid';        //cookie的名称
            $cookie -> expire = time() + 3600*24*30;	   //存活的时间
            $cookie -> httpOnly = false;		   //无法通过js读取cookie
            $cookie -> value = $uid;   //cookie的值
            $cookie -> secure = false; //不加密
            \Yii::$app->response->getCookies()->add($cookie);
        }
    }
    /*
     * 退出登录
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return Tool::responseJson(0, '退出登录', '');
    }
}
