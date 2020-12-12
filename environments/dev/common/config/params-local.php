<?php
define('USER_NICKNAME_PREFIX', '用户'); // 用户昵称前缀
define('MESSAGE_LIMIT_NUM', 10000); // 短信次数限制

//API
define('API_HOST_NAME', 'api.guazitv.tv');
define('API_HOST_PATH', 'http://' . API_HOST_NAME);

//PC
define('PC_HOST_NAME', 'guazitv.tv');
define('PC_HOST_PATH', 'http://' . PC_HOST_NAME);

//WAP
define('WAP_HOST_NAME', 'm.guazitv.tv');
define('WAP_HOST_PATH', 'http://' . WAP_HOST_NAME);

// 付费相关开关,根据具体运营需求来确认
define('VIP_SWITCH', true); // 会员开关
define('COUPON_SWITCH', true); // 卡券开关

return [
    'sign_secret_key' => [ //签名key
        'product_app' => [  //app
            'os_ios' => [
                'sign_key'   => 'jI7POOBbmiUZ0lmi',
                'secret_key' => 'D9ShYdN51ksWptpkTu11yenAJu7Zu3cR',
            ],
            'os_android' => [
                'sign_key'   => 'jI7POOBbmiUZ0lmi',
                'secret_key' => 'D9ShYdN51ksWptpkTu11yenAJu7Zu3cR',
            ]
        ],
        'product_mp' => [
            'os_ios' => [
                'sign_key'   => 'jI7POOBbmiUZ0lmi',
                'secret_key' => 'D9ShYdN51ksWptpkTu11yenAJu7Zu3cR',
            ],
            'os_android' => [
                'sign_key'   => 'jI7POOBbmiUZ0lmi',
                'secret_key' => 'D9ShYdN51ksWptpkTu11yenAJu7Zu3cR',
            ],
            'os_other' => [
                'sign_key'   => 'jI7POOBbmiUZ0lmi',
                'secret_key' => 'D9ShYdN51ksWptpkTu11yenAJu7Zu3cR',
            ]
        ],
    ],
];
