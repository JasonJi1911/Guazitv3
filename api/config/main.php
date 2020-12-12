<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'class' => 'api\components\Request',
            'enableCsrfValidation' => false,
        ],
        // 用户
        'user' => [
            'class'  => 'api\services\UserService',
            'params' => ['token'],
        ],
        'api' => function () {
            return new \api\services\ApiService;
        },
        'common' => [
            'class'  => 'api\services\CommonService',
        ],
        'response' => [
            'class' => 'api\components\Response',
        ],
        'session' => [
            'name' => 'app-api',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@app/runtime/logs/api.log',
                    'logVars' => [], //关闭$_SERVER  info
                    'maxFileSize' => 1000000, //1GM
                    'maxLogFiles' => 3,
                    'prefix' => function ($message) {
                        $uri = Yii::$app->request->url;
                        return "[$uri]";
                    }
                ],
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['info'],
//                    'logFile' => '@app/runtime/logs/info.log',
//                ]
            ],
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //通用路由
                '<controller:[\w-]+>/<action:[\w-]+>' => '<controller>/<action>',
            ],
        ],
    ],

    //强制登录预操作
    'as access' => [
        'class'  => 'api\filters\AccessControl',
        'user'   => false,
        'only' => ['answer/feedback-list', 'user/info', 'user/bind-*', 'user/set-*', 'advert/remove-ad', 'comment/*', 'user/order-list', 'user/watch-log', 'pay/*'],
        'except' => ['comment/list', 'user/mobile-login',
            'pay/vip-center', 'pay/coupon-center', 'pay/alipay-notify', 'pay/wxpay-notify',]
    ],


    'params' => $params,
];
