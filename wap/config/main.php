<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-mp',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'wap\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logVars' => [], //关闭$_SERVER  info
                    'maxFileSize' => 4000000, //1GM
                    'maxLogFiles' => 10,
                    'prefix' => function ($message) {
                        $uri = Yii::$app->request->url;
                        return "[$uri]";
                    },
                    'logFile' => '@app/runtime/logs/wap.log',
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-mp',
            'cookieValidationKey' => 'IO_en1cN-nkqsobLLf6lm-j43dFxGdIa',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-wap', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the mp
            'name' => 'advanced-wap',
            'cookieParams' => ['lifetime' => 3650 * 24 * 60 * 60]
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

                // 通用路由配置
//                '<controller:[\w-]+>/<id:\d+>/<action:[\w-]+>' => '<controller>/<action>',
                '<controller:[\w-]+>/<action:[\w-]+>' => '<controller>/<action>',
                '<verify:[\w-]+>.txt' => 'site/txt' //验证文件
            ],
        ],
        'api' => function () {
            return new \wap\services\ApiService;
        },
        'agent' => function () { //代理
            return new \wap\services\AgentService;
        },
        'users' => function () { //用户
            return new \wap\services\UsersService;
        },
        'setting' => 'common\services\Setting',
        'as access' => [
            'class'  => 'common\filters\AccessControl',
            'only' => ['comment/ajax-create'],
            'rules'  => [
                [
                    'allow' => false,
                    'roles' => ['?'],
                ],
                [
                    'allow' => true,
                    'roles' => ['@'],
                ]
            ]
        ],
    ],
    'params' => $params,
];
