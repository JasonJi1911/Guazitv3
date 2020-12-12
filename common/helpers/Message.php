<?php
namespace common\helpers;

use app\helpers\Dysmsapi\Request\V20170525\SendSmsRequest;
use common\models\apps\AppsMessage;
use common\models\setting\SettingAliyun;
use DefaultAcsClient;
use DefaultProfile;
use Yii;

include_once ROOT_PATH . '/common/helpers/alisdk/aliyun-php-sdk-core/Config.php';
include_once ROOT_PATH . '/common/helpers/alisdk/Dysmsapi/Request/V20170525/SendSmsRequest.php';
include_once ROOT_PATH . '/common/helpers/alisdk/Dysmsapi/Request/V20170525/QuerySendDetailsRequest.php';

/**
 * 短信服务类
 * Class Message
 * @package common\helpers
 */
class Message
{
    const MOBILE_CODE_EXPIRE = 600; //短信过期时间

    /**
     * 发送短信验证码
     * @param $mobile
     * @param $appId
     * @return array
     */
    public function sendMobileCode($mobile, $appId)
    {
        if (!Tool::isMobile($mobile)) {
            Yii::warning($mobile . '不是一个正确的电话号码');
            return false;
        }

        // 请求次数判断
        $requestKey = RedisKey::messageLimit(Tool::getIp());
        $redis = new RedisStore();
        $num = $redis->get($requestKey);
        if (!$num) { // 没有次数
            $redis->setEx($requestKey, 1);
        }
        if ($num > MESSAGE_LIMIT_NUM) {
            Yii::warning('超过发送短信次数');
            return false;
        }

        $code = Tool::getRandNumFour();
        $config = Yii::$app->apps->get('message', $appId);
        if ($config['message_type'] == AppsMessage::MESSAGE_ALIYUN) { // 阿里云
            // 阿里云发送短信
            $res = $this->aliyunSms($mobile, $code, $config);
            if (!$res) { // 发送失败
                Yii::warning('send message failed mobile ' . $mobile . ' code ' . $code);
                return false;
            }
        } else { // 云之讯
            $res = $this->sendSmsYun($mobile, $code, $config);
            if (!$res) {
                Yii::warning('send message failed mobile ' . $mobile . ' code ' . $code);
                return false;
            }
        }

        $redis = new RedisStore();
        $codeKey = RedisKey::messageCode($mobile);
        $redis->setEx($codeKey, $code, self::MOBILE_CODE_EXPIRE);
        Yii::warning('send to mobile:' . $mobile. '  code:' . $code);
        $redis->set($requestKey, $num + 1); // 更新发送短信次数
        return true;
    }


    /**
     * 阿里云发送验证码代码
     * @param        $mobile
     * @param        $code
     * @param        $config
     * @return mixed|\SimpleXMLElement
     */
    public function aliyunSms($mobile, $code, $config)
    {
        // 获取短信服务的阿里云配置
        $accessKeyId = Yii::$app->setting->get('aliyun.access_key', ['type' => SettingAliyun::TYPE_MESSAGE]);
        $accessKeySecret = Yii::$app->setting->get('aliyun.access_secret', ['type' => SettingAliyun::TYPE_MESSAGE]);

        //短信API产品名
        $product = "Dysmsapi";
        //短信API产品域名
        $domain = "dysmsapi.aliyuncs.com";
        //暂时不支持多Region
        $region = 'cn-hangzhou';

        //初始化访问的acsCleint
        $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
        DefaultProfile::addEndpoint($region, $region, $product, $domain);
        $acsClient = new DefaultAcsClient($profile);

        $request = new SendSmsRequest();
        //必填-短信接收号码
        $request->setPhoneNumbers($mobile);
        //必填-短信签名
        $request->setSignName($config['ali_sign_name']);
        //必填-短信模板Code
        $request->setTemplateCode($config['ali_verify_code']);
        //选填-假如模板中存在变量需要替换则为必填(JSON格式)
        $request->setTemplateParam("{\"code\":\"" . $code . "\"}");

        //发起访问请求
        $acsResponse = $acsClient->getAcsResponse($request);
        if ($acsResponse->Code != 'OK') {
            Yii::warning($acsResponse);
            return false;
        }
        return true;
    }
    
    /**
     * 检验验证码是否正确,过滤白名单
     * @param        $mobile
     * @param        $code
     * @return bool
     */
    public function checkCode($mobile, $code)
    {
        $mobileWhiteList = Yii::$app->params['mobileWhiteList']; //白名单
        if (in_array($mobile, $mobileWhiteList)) { //白名单不验证
            return true;
        }

        $key = RedisKey::messageCode($mobile);
        $redis = new RedisStore();
        $res = $redis->get($key);
        if ($res == $code) {
            return true;
        } else {
            return false;
        }
    }

    // 发送短信（云之讯平台）
    public function sendSmsYun($mobile, $code, $config)
    {
        // 准备发送
        require_once(ROOT_PATH . '/common/helpers/yunzhixun/Ucpaas.php');
        //填写在开发者控制台首页上的Account Sid
        $options['accountsid'] = $config['yun_account_id'];
        //填写在开发者控制台首页上的Auth Token
        $options['token'] = $config['yun_token'];

        $appid = $config['yun_app_id'];    // appid
        $templateid = $config['yun_template_id'];     // 模板ID

        $ucpass = new \Ucpaas($options);

        $res = $ucpass->SendSms($appid, $templateid, $code, $mobile, 0);
        $res = json_decode($res, true);
        if ($res['code'] != '000000') { // 发送失败
            Yii::warning($res['msg']);
            return false;
        }
        return true;
    }

    /**
     * 发送邮箱验证码
     * @param        $email
     * @return array
     */
    public function sendEmailCode($email)
    {
        $ret = [
            'errno' => 0,
            'error' => ''
        ];
        $is_mobile = Tool::isEmail($email);
        if (!$is_mobile) {
            $ret['errno'] = 1;
            $ret['error'] = '不是一个正确的邮箱地址';
            return $ret;
        }
        $code = Tool::getRandNumFour();

        // 开始发送
        $mail= Yii::$app->mailer->compose();
        $mail->setTo($email);
        $mail->setSubject("邮件验证码");
        //$mail->setTextBody('zheshisha ');   //发布纯文字文本
        $mail->setHtmlBody("【】您的邮箱验证码是：".$code);    //发布可以带html标签的文本
        $res = $mail->send();
        if(!$res) {
            $ret['errno'] = 1;
            $ret['error'] = '发送失败';
            Yii::warning('send message failed ' . $res->Code);
            return $ret;
        }

        $redis = new RedisStore();
        $key = RedisKey::getMessageCodeKey($email);
        $redis->setEx($key, $code, self::MOBILE_CODE_EXPIRE);
        Yii::warning('send to mobile:' . $email. '  code:' . $code);
        return $ret;
    }

}
