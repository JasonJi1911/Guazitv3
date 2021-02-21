<?php
namespace pc\controllers;

use common\helpers\Tool;
use Yii;
use yii\web\Cookie;
use api\models\User;
use yii\helpers\Url;

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
        return $this->render('sharedown');
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

                $video = [];
                $video['loc'] = PC_HOST_PATH.Url::to(['site/map', 'channel_id' =>  $channel['channel_id']]);
                $video['channel'] = $channel['channel_name'];
                array_push($xml['data'], $video);
            }
        }


        $ss= \Yii::createObject($xml);
        $doc = new DOMDocument();
        $doc->load('example.xml');
        $ss->getElementsByTagName("");

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
                    'rootTag' => 'sitemapindex', //根节点
                    'itemTag' => 'sitemap', //单元
                ],
            ],
            'data' => [ //要输出的数据

            ],
        ];

        if (!empty($data['label']))
        {
            foreach ($data['label'] as $k => $labels)
            {
                if (empty($labels['list']))
                    continue;

                foreach ($labels['list'] as $key => $list)
                {
                    $video = [];
                    $video['loc'] = PC_HOST_PATH.Url::to(['detail', 'video_id' => $list['video_id']]);
                    $video['score'] = $list['score'];
                    $video['title'] = '瓜子TV_'.$list['video_name'];
                    $video['year'] = $list['year'];
                    array_push($xml['data'], $video);
                }
            }
        }

        return \Yii::createObject($xml);
    }
}
