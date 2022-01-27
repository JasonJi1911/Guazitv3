<?php
namespace pc\controllers;

use common\helpers\RedisStore;
use common\helpers\Tool;
use Yii;
use yii\web\Cookie;
use api\models\User;
use yii\helpers\Url;
use pc\models\LoginForm;

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
        $data = Yii::$app->api->get('/search/app-version');
        return $this->render('sharedown',[
            'data'          => $data,
        ]);
    }
    
    public function actionAllMap()
    {
        $xml =  [
            'class' => 'yii\web\Response',
            'format' => \yii\web\Response::FORMAT_XML, //设置输出的格式为 XML
            'formatters' => [
                \yii\web\Response::FORMAT_XML => [
                    'class' => 'yii\web\XmlResponseFormatter',
                    'rootTag' => 'sitemapindex', //根节点
                    'itemTag' => 'sitemap', //单元
                ],
            ],
            'data' => [ //要输出的数据

            ],
        ];
        $channels = Yii::$app->api->get('/video/channels');
        if (!empty($channels))
        {
            foreach ($channels['list'] as $channel)
            {
                if (empty($channel))
                    continue;

                if ($channel['channel_id'] == 0) {
                    continue;
                }
                $video = [];
                // $video['loc'] = PC_HOST_PATH.Url::to(['site/map', 'channel_id' =>  $channel['channel_id']]);
                $video['loc'] = PC_HOST_PATH.Url::to(['video/channel', 'channel_id' =>  $channel['channel_id']]);
                // $video['channel'] = $channel['channel_name'];
                array_push($xml['data'], $video);
            }
        }

        return \Yii::createObject($xml);
    }
    
    public function actionMap()
    {
        $channel_id = Yii::$app->request->get('channel_id', 0);
        //请求首页信息
        $data = Yii::$app->api->get('/video/index', ['channel_id' => $channel_id]);

        $xml =  [
            'class' => 'yii\web\Response',
            'format' => \yii\web\Response::FORMAT_XML, //设置输出的格式为 XML
            'formatters' => [
                \yii\web\Response::FORMAT_XML => [
                    'class' => 'yii\web\XmlResponseFormatter',
                    'rootTag' => 'urlset', //根节点
                    'itemTag' => 'url', //单元
                ],
            ],
            'data' => [ //要输出的数据
            ],
        ];

        if (!empty($data['label']))
        {
            foreach ($data['label'] as  $labels)
            {
                if (empty($labels['list']))
                    continue;
                    
                foreach ($labels['list'] as $key => $list)
                {
                    $video = [];
                    $video['loc'] = PC_HOST_PATH.Url::to(['detail', 'video_id' => $list['video_id']]);
                    $video['score'] = $list['score'];
                    $video['title'] = LOGONAME.'TV|'.$list['video_name'];
                    $video['year'] = $list['year'];
                    array_push($xml['data'], $video);
                }
            }
        }

        $this->XmlFile($data['label'],$channel_id);
        return \Yii::createObject($xml);
    }
    public function XmlFile($data,$channel_id=0){
        //  创建一个XML文档并设置XML版本和编码。。
        $dom=new \DomDocument('1.0', 'utf-8');
        //  创建根节点
        $urlset = $dom->createElement('urlset');
        $dom->appendchild($urlset);
        if (!empty($data)){
            foreach ($data as  $labels){
                if (empty($labels['list']))
                    continue;

                foreach ($labels['list'] as $key => $list){
                    $item = $dom->createElement('url');
                    $urlset->appendchild($item);
                    //  loc
                    $node = $dom->createElement('loc');//创建元素
                    $item->appendchild($node);
                    $text = $dom->createTextNode(PC_HOST_PATH.Url::to(['detail', 'video_id' => $list['video_id']]));//创建元素值
                    $node->appendchild($text);
                    //  score
                    $node = $dom->createElement('score');
                    $item->appendchild($node);
                    $text = $dom->createTextNode($list['score']);
                    $node->appendchild($text);
                    //  title
                    $node = $dom->createElement('title');
                    $item->appendchild($node);
                    $text = $dom->createTextNode(LOGONAME.'TV|'.$list['video_name']);
                    $node->appendchild($text);
                    //  year
                    $node = $dom->createElement('year');
                    $item->appendchild($node);
                    $text = $dom->createTextNode($list['year']);
                    $node->appendchild($text);
                }
            }
        }
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($dom->saveXML(),LIBXML_NOERROR);

        $filename = "sitemap";
        if($channel_id != 0){
            $filename = $filename.$channel_id;
        }

        $res = file_put_contents($filename.'.xml',$dom->saveXML());
//        return $dom->saveXML();
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $account = Yii::$app->request->get('account', "");//手机或邮箱
        $password = Yii::$app->request->get('password', "");
        $is_email = Tool::isEmail($account);//验证邮箱格式
        if (!Yii::$app->user->isGuest) {
            $uid = Yii::$app->user->id;
            $this->setCookie($uid);
            return Tool::responseJson(0, '登录成功', $uid);
        }

        $model = new LoginForm();
        if($is_email){
            $model->mobile = '';
            $model->email = $account;
        }else{
            $model->mobile = $account;
            $model->email = '';
        }
        $model->password = $password;
        if ( $model->login()) {
            Yii::$app->cache->set('login_flag', '1');
            $uid = Yii::$app->user->id;
            $this->setCookie($uid);
            return Tool::responseJson(0, '登录成功', $uid);
        } else {
            return Tool::responseJson(-1, '登录失败', '');
        }
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
                $msg = '登录失败';
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
                    $result['uid'] = $uid;
                    $cookie1 = \Yii::$app->request->cookies;
                    $uid1=$cookie1->get("uid");
                    if(!$uid1){
                        $cookie = new \yii\web\Cookie();
                        $cookie -> name = 'uid';        //cookie的名称
                        $cookie -> expire = time() + 3600*24;	   //存活的时间
                        $cookie -> httpOnly = false;		   //无法通过js读取cookie
                        $cookie -> value = $uid;   //cookie的值
                        $cookie -> secure = false; //不加密
                        \Yii::$app->response->getCookies()->add($cookie);
                    }
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
//        return Tool::responseJson(0, '登录成功', $result);
    }

    private function setCookie($uid){
        $cookie1 = \Yii::$app->request->cookies;
        $uid1=$cookie1->get("uid");
        if(!$uid1){
            $cookie = new \yii\web\Cookie();
            $cookie -> name = 'uid';        //cookie的名称
            $cookie -> expire = time() + 3600*24;	   //存活的时间
            $cookie -> httpOnly = false;		   //无法通过js读取cookie
            $cookie -> value = $uid;   //cookie的值
            $cookie -> secure = false; //不加密
            \Yii::$app->response->getCookies()->add($cookie);
        }
    }


    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

//        $cookie1 = \Yii::$app->request->cookies;
//        Yii::$app->request->enableCookieValidation = false;
//        $cookie1->remove('uid');

        return Tool::responseJson(0, '退出登录', '');
    }
}
