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

//视频网站名称
define('LOGONAME','吉祥');
//广告图片链接前缀(当前域名)
define('ADVERTURL','https://img.kantv9.com/');
//邮箱
define('EMAIL_NAME','jxsptv');
//客服二维码
define('KFQRCODE','ryewm.png');
//qq.com(视频url转换)
define('QQURL','https://cache4.jhdyw.vip:8091/jhcs.php?url=');
//iqiyi.com(视频url转换)
define('IQIYIURL','https://cache4.jhdyw.vip:8091/jhcs.php?url=');
//其他(视频url转换)
define('OTHERURL','https://cache4.jhdyw.vip:8091/jhcs.php?url=');
//短信验证码长度
define('SMSCODE_LENGTH',6);
//短信密钥
define('SMS_ACCESS_KEY','0qZxe0AMh7wlMI2RBfD3sTbul');
//广告播放平台
define('PLATFORM','GZ');

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
                'sign_key'   => '1MAVhF4O8OabONLLmTw8dw==',
                'secret_key' => 'D9ShYdN51ksWptpkTu11yenAJu7Zu3cR',
            ]
        ],
    ],
];
