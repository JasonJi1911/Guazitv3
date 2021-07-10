<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-page',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'page\controllers',
    'components' => [
        'request' => [
            'class' => 'api\components\Request',
            'enableCsrfValidation' => false,
        ],
        'session' => [
            'name' => 'app-page',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@app/runtime/logs/page.log',
                    'logVars' => [], //关闭$_SERVER  info
                    'maxFileSize' => 1000000, //1GM
                    'maxLogFiles' => 3,
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
        'api' => function () {
            return new \page\services\ApiService;
        },
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //通用路由
                '<controller:[\w-]+>/<action:[\w-]+>' => '<controller>/<action>',
            ],
        ],
    ],
    
    'as access' => [  //所有权限,都需要强制登录
        'class'  => 'page\components\AccessControl',
        'user'   => false,
        'only'   => ['*'],
    ],
    
    'params' => $params,
];
