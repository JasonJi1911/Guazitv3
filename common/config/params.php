<?php

// 微信接口
define('WECHAT_OAUTH2', 'https://api.weixin.qq.com/sns/oauth2/access_token'); // 获取access token
define('WECHAT_USERINFO', 'https://api.weixin.qq.com/sns/userinfo'); // app获取用户信息

//QQ登录请求地址
define('QQ_OAUTH2_ME', 'https://graph.qq.com/oauth2.0/me');
define('QQ_USERINFO', 'https://graph.qq.com/user/get_user_info');

// 广告位置,用于在列表显示是,插入广告相对于数据的序位
define('ADVERT_POSITION', '6');

//定义路由常量
define('ROOT_DIR', __DIR__.'/../../');

//admin
define('ADMIN_HOST_NAME', 'xmind.guazitv8.com');
define('ADMIN_HOST_PATH', 'http://' . ADMIN_HOST_NAME);

//支付金额单位
define('MONEY_UNIT', '¥');
//客户端样式定界符
define('STYLE_SIGN', '###');
//任务奖励开关
define('TASK_AWARD_SWITCH', 1);

//解析api地址
define('VIDEO_JIXI_URL',     'http://360apitv.com/jiexi/jianghu.php'); //播放器
define('VIDEO_JIXI_URL_WAP' ,'http://360apitv.com/jiexi/jianghu.php');
define('VIDEO_JSON_URL', 'http://360apitv.com/json/'); //云解析

if (!defined('NUMBER_INPUT_MIN')) {
    define('NUMBER_INPUT_MIN', 0); //数字输入框默认最小值
}
if (!defined('NUMBER_INPUT_MAX')) {
    define('NUMBER_INPUT_MAX', 99999999); //数字输入框默认最大值
}

return [

];
