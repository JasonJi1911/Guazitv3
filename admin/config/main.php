<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'admin\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-admin',
            'enableCsrfValidation' => false
        ],
        'user' => [
            'identityClass' => 'admin\models\Admin',
            'enableAutoLogin' => true,
            'authTimeout' => 60 * 360,
            'identityCookie' => ['name' => '_identity-admin', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'app-admin',
            'class' => 'yii\redis\Session',
            'keyPrefix'=>'app-admin',
            'redis' => 'redis',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@app/runtime/logs/admin.log',
                    'logVars' => [], //关闭$_SERVER  info
                    'maxFileSize' => 1000000, //1GM
                    'prefix' => function ($message) {
                        $uri = Yii::$app->request->url;
                        return "[$uri]";
                    }
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [
            'class' => 'admin\components\Formatter',
            'dateFormat' => 'Y-M-d',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => '￥',
            'sizeFormatBase' => 1000,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // 配置管理
//                '<module:[\w-]+>/setting/<group:\w+>' => '<module>/setting/update',
//                'setting/<group:\w+>'                 => 'setting/update',

                // 订单管理
                'order/<type:\w+>' => 'order/index',

                //充值商品管理
                'goods/<type:\w+>'                  => 'goods/index',
                'goods/<type:\w+>/create'           => 'goods/create',
                'goods/<type:\w+>/<id:\d+>/update'  => 'goods/update',
                'goods/<type:\w+>/<id:\d+>/delete'  => 'goods/delete',

                //通用路由
                '<controller:[\w-]+>/<id:\d+>/<action:[\w-]+>' => '<controller>/<action>',

                '<module:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>' => '<module>/<controller>/<action>',
                '<module:[\w-]+>/<controller:[\w-]+>/<id:\d+>/<action:[\w-]+>' => '<module>/<controller>/<action>',
                '<controller:[\w-]+>/<action:[\w-]+>' => '<controller>/<action>',
            ],
        ],
    ],
    
    'modules' => [
        'manager' => [
            'class' => 'admin\modules\manager\Module',
        ],
        'api' => [
            'class' => 'admin\modules\api\Module'
        ]
    ],
    
    'as access' => [
        'class'  => 'admin\filters\AccessControl',
        'except' => ['site/captcha', 'site/login', 'site/error', 'drp/wechat/index', 'site/login-key', 'api/*'],
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
    
    'params' => $params,
];
