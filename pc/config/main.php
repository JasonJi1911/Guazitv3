<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-pc',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'pc\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-pc',
            'cookieValidationKey' => 'T0ZK5NohbEgclUuLjBfgvlZXQmVKhZUx',
        ],
        'user' => [
            'identityClass' => 'pc\models\UserInfo',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-pc', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the admin
            'name' => 'soushu-pc',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logVars' => [], //关闭$_SERVER  info
                    'prefix' => function ($message) {
                        $uri = Yii::$app->request->url;
                        return "[$uri]";
                    },
                    'logFile' => '@app/runtime/logs/pc.log',
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,

//            'suffix' => '.html',

            'rules' => [

                // 视频首页
                [
                    'pattern'   => '/',
                    'route'     => 'video/index',
                ],

                'news/<id:\d+>/detail' => 'news/detail',

                // 通用路由配置
                '<controller:[\w-]+>/<action:[\w-]+>' => '<controller>/<action>',
                '<verify:[\w-]+>.txt' => 'site/txt' //验证文件
            ],
        ],
        'api' => function () {
            return new \pc\services\ApiService;
        },
        'setting' => 'common\services\Setting',
    ],

    //权限

    'params' => $params,
];
