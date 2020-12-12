<?php
define('DEFAULT_PAGE_NUM', 1); //默认页码
define('DEFAULT_PAGE_SIZE', 10); // 接口分页默认数据大小

return [
    'apiWhiteList' => [ // 免验签名接口
        '/pay/alipay-notify',
        '/pay/wxpay-notify',
        '/pay-support/custom',
    ],

    'mobileWhiteList' => [ // 测试白名单
        '13800000001',
        '13800000002',
        '13800000003',
        '13800000004',
        '13800000005',
        '13800000006',
        '13800000007',
        '13800000008',
        '13800000009',
        '13800000010',
    ],

    // 强制登录
    'login_access' => [
        'chapter/buy',
        'comic/post',
        'comic/tucao',
        'comic-chapter/buy',
        'comment/post',
    ],
    //最大签到的天数
    'max_valid_sign_days' => 7,

    //缓存接口
    'cache_route' => [
        'video/index', //影视首页
        'video/filter', //分类影视筛选
        'video/vip', //会员作品
    ],
];
