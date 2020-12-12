<?php
namespace api\controllers;

use api\exceptions\LoginException;
use api\helpers\ErrorCode;
use common\helpers\Message;
use Yii;

class MessageController extends BaseController
{
    //发短信
    public function actionSend()
    {
        $mobile = $this->getParamOrFail('mobile');

        $message = new Message();
        $ret = $message->sendMobileCode($mobile, $this->appId);
        if (!$ret) {
            throw new LoginException(ErrorCode::EC_SEND_CODE_FAILED); //验证码发送失败
        }
        return [];
    }

    public function actionCheck()
    {
        $mobile = $this->getParamOrFail('mobile');
        $code = $this->getParamOrFail('code');

        $message = new Message();
        $ret = $message->checkCode($mobile, $code);
        if (!$ret) {
            throw new LoginException(ErrorCode::EC_VERIFY_CODE_ERROR);
        }
        return [];
    }

    //发送邮件
    public function actionSendEmail()
    {
        $email = $this->getParamOrFail('email');

        $message = new Message();
        $ret = $message->sendEmailCode($email);
        if ($ret['errno']) {
            throw new LoginException(ErrorCode::EC_SEND_CODE_FAILED); //验证码发送失败
        }
        return [];
    }

}
