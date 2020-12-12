<?php

if (!defined('NUMBER_INPUT_MIN')) {
    define('NUMBER_INPUT_MIN', 0); //数字输入框默认最小值
}

if (!defined('NUMBER_INPUT_MAX')) {
    define('NUMBER_INPUT_MAX', 99999999); //数字输入框默认最大值
}

define('DISPLAY_ORDER_MIN', 0); // 排序默认最小
define('DISPLAY_ORDER_MAX', 255); // 排序默认最大

define('ADMIN_COMIC_VERTICAL_WIDTH', '75'); //漫画横封面宽
define('ADMIN_COMIC_VERTICAL_HEIGHT', '100'); //漫画横封面高
define('ADMIN_COMIC_HORIZONTAL_WIDTH', '150'); //漫画横封面宽
define('ADMIN_COMIC_HORIZONTAL_HEIGHT', '100'); //漫画横封面高

// 资源文件版本号
define('JS_FILE_VERSION', '1.0.1');
define('CSS_FILE_VERSION', '1.0.2');


return [
    'adminEmail' => 'admin@example.com',

    'offFilterRoute' => [
        'drp/generalize/index'
    ],

    'webuploader' => [
        // 后端处理图片的地址
        'uploadUrl' => 'upload/upload',
        // 多文件分隔符
        'delimiter' => ',',
        // 基本配置
        'baseConfig' => [
            'defaultImage' => '',    // 默认图
            'disableGlobalDnd' => true,
            'accept' => [
                'title' => '上传图片',
                'extensions' => 'jpg,jpeg,png,gif',
                'mimeTypes' => 'image/*',
            ],
        ],
    ],

    'setting' => [
        'system' => [
            [
                'label' => '基础配置',
                'route' => '/setting/system',
            ],
            [
                'label' => '签到设置',
                'route' => '/setting/update-sign',
            ],
            [
                'label' => '客服信息',
                'route' => '/setting/service-info',
            ],
            [
                'label' => '规则说明',
                'route' => '/setting/rule',
            ],
        ],

        'app' => [
            [
                'label' => 'APP配置管理',
                'route' => '/setting/app-info',
            ],
            [
                'label' => '支付宝设置',
                'route' => '/setting/alipay',
            ],
            [
                'label' => '微信支付设置',
                'route' => '/setting/wx-pay',
            ],
            [
                'label' => '短信服务设置',
                'route' => '/setting/message',
            ],
            [
                'label' => '阿里云基础设置',
                'route' => '/setting/aliyun',
            ],
            [
                'label' => '图片存储配置',
                'route' => '/setting/oss',
            ],
            [
                'label' => '第三方登录设置表',
                'route' => '/setting/app-tencent-info',
            ],
        ],
    ]
];
