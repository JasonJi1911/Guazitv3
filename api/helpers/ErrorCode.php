<?php
/**
 * 错误码类
 */
namespace api\helpers;

use phpDocumentor\Reflection\Types\Self_;

class ErrorCode
{
    //成功
    const SUCCESS_CODE = 0;

    //100~199 通用错误码
    //参数为空
    const EC_PARAM_EMPTY   = 100;
    //参数不合法
    const EC_PARAM_INVALID = 101;
    //未知错误
    const EC_UNKNOWN = 102;
    //签名过期
    const EC_SIGN_EXPIRE = 103;
    //签名无效
    const EC_SIGN_INVALID = 104;
    //短信验证码错误
    const EC_VERIFY_CODE_ERROR = 105;
    //系统异常
    const EC_SYSTEM_ERROR = 106;
    //并发操作
    const EC_SYSTEM_OPERATING = 107;
    // 注销失败，15天没不允许重复注销
    const EC_CANCEL_ACCOUNT = 108;

    //200~299 系统错误码
    //db error
    const EC_DB_ERROR = 200;
    //Redis异常
    const EC_REDIS_ERROR = 201;
    const EC_SEND_CODE_FAILED = 202;
    //阿里云上传图片失败
    const EC_ALI_UPLOAD_FAILED = 203;
    const EC_DATA_NOT_EXIST = 204;

    //300~399 用户错误
    const EC_USER_NOT_LOGIN        = 299;
    const EC_USER_NOT_EXIST        = 300;
    const EC_USER_TOKEN_EXPIRE     = 301;
    const EC_USER_FORBIDDEN        = 302;
    const EC_USER_REGISTER_FAIL    = 303;
    const EC_USER_ALREADY_SIGN     = 304;
    const EC_UDID_USER_LIMIT       = 305;
    const EC_WECHAT_LOGIN_FAILED   = 306;
    const EC_QQ_LOGIN_FAILED       = 307;
    const EC_SET_USERINFO_FAILED   = 308;
    const EC_USER_BINDED_MOBILE    = 309;
    const EC_USER_BINDED_WECHAT    = 310;
    const EC_MOBILE_ALREADY_BINDED = 311;
    const EC_WECHAT_ALREADY_BINDED = 312;
    const EC_MUST_BIND_MOBILE      = 313;
    const EC_MUST_BIND_WECHAT      = 314;
    const EC_EXTRACT_LIMIT_ONE     = 315;
    const EC_REMAIN_NOT_ENOUGH     = 316;
    const EC_WECHAT_LOGIN_BUSY     = 317;
    const EC_COMMENT_REVIEW        = 318;
    const EC_TUCAO_REVIEW          = 319;
    const EC_ALREADY_SING          = 320;
    const EC_QQ_ALREADY_BINDED     = 321;
    const EC_USER_SIGN_FAILED      = 322;
    const EC_CANCEL_SUCCESS        = 323;


    // 视频错误
    const EC_VIDEO_NOT_EXIST         = 500;
    const EC_VIDEO_CHAPTER_NOT_EXIST = 501;
    const EC_VIDEO_PLAY_URL_ERROR    = 502;
    const EC_CHAPTER_NOT_BUY         = 503;
    const EC_REMOVE_AD_FAIL          = 504;


    //800~899 充值错误
    const EC_INVALID_PAY_CHANNEL = 801; //不支持的充值渠道
    const EC_COUPON_NOT_ENOUGH = 802;   //卡券不足
    const EC_GOODS_INVALID = 803;       //购买商品无效
    const EC_SUB_REPEAT = 804;          //重复订阅
    const EC_PRODUCT_INVALID = 805;     //苹果商品id无效
    const EC_INVALID_RECEIPT = 806;     //无效的交易凭证
    const EC_PRODUCT_BUY_FAILED = 807;  //产品购买失败
    const EC_SUB_TEXT_FAILED = 808;     //订阅失败
    const EC_EXCEEDING_QUOTA = 809;     //超过购买限制
    const EC_INVALID_ACTIVITY = 810;    //无效活动
    const EC_SCORE_NOT_ENOUGH = 811;     //积分不足
    const EC_ORDER_NOT_COMPLETED = 812; //订单未完成

    /**
     * 错误码对应的错误信息数组
     * @var array
     */
    public static $errorDes = [
        self::SUCCESS_CODE => 'success',
        self::EC_PARAM_EMPTY => '参数[%s]为空',
        self::EC_PARAM_INVALID => '参数[%s]无效',
        self::EC_UNKNOWN => '未知错误',
        self::EC_SIGN_EXPIRE => '签名已过期',
        self::EC_SIGN_INVALID => '签名无效',
        self::EC_VERIFY_CODE_ERROR => '验证码错误',
        self::EC_SYSTEM_ERROR => '服务器开小差啦',
        self::EC_SYSTEM_OPERATING => '您的操作太过频繁,请稍后重试',
        self::EC_CANCEL_ACCOUNT => '注销失败，15天没不允许重复注销',
        self::EC_CANCEL_SUCCESS => '注销成功，等待审核',


        self::EC_DB_ERROR => 'DB异常',
        self::EC_REDIS_ERROR => 'Redis异常',
        self::EC_SEND_CODE_FAILED => '验证码发送失败',
        self::EC_ALI_UPLOAD_FAILED => '阿里云上传图片失败',
        self::EC_DATA_NOT_EXIST => '数据不存在',

        self::EC_USER_NOT_LOGIN => '用户未登录',
        self::EC_USER_NOT_EXIST => '用户不存在',
        self::EC_USER_TOKEN_EXPIRE => '登录过期，请重新登录',
        self::EC_USER_FORBIDDEN => '账号已被禁用，请联系管理员',
        self::EC_USER_REGISTER_FAIL => '注册失败',
        self::EC_USER_ALREADY_SIGN => '您今天已签到',
        self::EC_UDID_USER_LIMIT => '同一设备下最多只能注册两个用户',
        self::EC_WECHAT_LOGIN_FAILED => '登陆失败',
        self::EC_QQ_LOGIN_FAILED => 'QQ登陆失败',
        self::EC_WECHAT_LOGIN_BUSY => '正在登陆中,请稍后',
        self::EC_SET_USERINFO_FAILED => '用户信息设置失败',
        self::EC_USER_BINDED_MOBILE => '已经绑定过手机号',
        self::EC_USER_BINDED_WECHAT => '该用户已绑定微信号',
        self::EC_MOBILE_ALREADY_BINDED => '该手机号已被绑定',
        self::EC_WECHAT_ALREADY_BINDED => '该微信号已被绑定',
        self::EC_MUST_BIND_MOBILE => '提现必须绑定手机号',
        self::EC_MUST_BIND_WECHAT => '提现必须绑定微信',
        self::EC_EXTRACT_LIMIT_ONE => '您已提现过，不可再次提现',
        self::EC_REMAIN_NOT_ENOUGH => '您的余额不足',
        self::EC_COMMENT_REVIEW => '评论成功，请等待审核',
        self::EC_TUCAO_REVIEW => '吐槽成功，请等待审核',
        self::EC_ALREADY_SING => '今天已签到',
        self::EC_QQ_ALREADY_BINDED => 'qq已被绑定',

        self::EC_VIDEO_NOT_EXIST => '视频不存在',
        self::EC_VIDEO_CHAPTER_NOT_EXIST => '视频还未上映,敬请期待',
        self::EC_VIDEO_PLAY_URL_ERROR => '视频播放地址错误',
        self::EC_CHAPTER_NOT_BUY      => '视频未购买',
        
        self::EC_INVALID_PAY_CHANNEL => '不支持的充值渠道',
        self::EC_SCORE_NOT_ENOUGH => '积分不足',
        self::EC_COUPON_NOT_ENOUGH => '卡券不足',
        self::EC_GOODS_INVALID => '购买的商品不存在或已下架',
        self::EC_SUB_REPEAT => '重复订阅',
        self::EC_PRODUCT_INVALID => '购买的商品异常,请联系客服处理',
        self::EC_INVALID_RECEIPT => '无效的交易凭证',
        self::EC_PRODUCT_BUY_FAILED => '购买失败',
        self::EC_SUB_TEXT_FAILED => '订阅失败',
        self::EC_EXCEEDING_QUOTA => '超过购买次数限制',
        self::EC_INVALID_ACTIVITY => '无效的充值活动',
        self::EC_ORDER_NOT_COMPLETED => '订单未完成',

        self::EC_USER_SIGN_FAILED => '签到失败'

    ];

    /**
     * 根据错误码返回相应的错误信息
     * @param int $errCode
     * @return string
     */
    public static function errMsg($errCode)
    {
        if (isset(self::$errorDes[$errCode])) {
            return self::$errorDes[$errCode];
        } else {
            return self::$errorDes[self::EC_UNKNOWN];
        }
    }

}
