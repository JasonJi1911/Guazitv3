<?php
namespace appapi\controllers;

use appapi\exceptions\Exception;
use appapi\helpers\ErrorCode;
use appapi\logic\TaskLogic;
use appapi\models\user\TaskInfo;
use appapi\models\user\User;
use appapi\models\user\UserAssets;
use appapi\models\user\UserAuthApp;
use appapi\models\user\UserVip;
use common\helpers\RedisStore;
use Yii;
use appapi\exceptions\ApiException;
use appapi\logic\UserLogic;

class UserController extends BaseController
{
    public function actionCenter()
    {
        $userLogic = new UserLogic();
        return $userLogic->userCenter();
    }
    
    /**
     * 用户信息
     */
    public function actionInfo()
    {
        $userLogic = new UserLogic();
        return $userLogic->userInfo();
    }
    
    /**
     * 手机登录
     */
    public function actionMobileLogin()
    {
        $mobile = $this->getParamOrFail('mobile');
        $code = $this->getParamOrFail('code');

        $userLogic = new UserLogic();
        return $userLogic->mobileLogin($mobile, $code);
    }

    /**
     * 绑定手机号
     */
    public function actionBindMobile()
    {
        $mobile = $this->getParamOrFail('mobile');
        $code = $this->getParamOrFail('code');

        $userLogic = new UserLogic();
        return $userLogic->bindMobile($mobile, $code);
    }

    /**
     * 微信登陆
     */
    public function actionWechatLogin()
    {
        $code = $this->getParamOrFail('code');
        $userLogic = new UserLogic();
        
        return $userLogic->wechatLogin($code);
    }

    /**
     * 微信绑定
     */
    public function actionBindWechat()
    {
        $code = $this->getParamOrFail('code');
        $userLogic = new UserLogic();

        return $userLogic->bindWechat($code);
    }

    /**
     * qq登录
     */
    public function actionQqLogin()
    {
        $accessToken = $this->getParamOrFail('access_token');
        
        $userLogic = new UserLogic();
        return $userLogic->qqLogin($accessToken);
    }

    /**
     * qq绑定
     */
    public function actionBindQq()
    {
        $accessToken = $this->getParamOrFail('access_token');

        $userLogic = new UserLogic();
        return $userLogic->bindQq($accessToken);
    }

    /**
     * 添加播放记录
     */
    public function actionAddWatchLog()
    {
        $videoId   = $this->getParamOrFail('video_id');
        $chapterId = $this->getParam('chapter_id');
        $watchTime = $this->getParamOrFail('watch_time'); //观看的时间

        $userLogic = new UserLogic();
        return $userLogic->addWatchLog($videoId, $chapterId, $watchTime);
    }

    /**
     * 观影记录
     * @return array
     * @throws ApiException
     */
    public function actionWatchLog()
    {
        $userLogic = new UserLogic();
        return $userLogic->watchLogList();
    }

    /**
     * 设备号登录 只支持设备号注册的用户登录
     */
    public function actionDeviceLogin()
    {
        $udid = $this->getParamOrFail('udid');
        $userLogic = new UserLogic();
        return $userLogic->deviceLogin($udid);
    }


    /**
     * 同步设备
     * @return int
     * @throws ApiException
     * @throws \appapi\exceptions\InvalidParamException
     */
    public function actionSyncDevice()
    {
        $deviceId = $this->getParamOrFail('device_id');
        $userLogic = new UserLogic();
        return $userLogic->syncDevice($deviceId);
    }

    /**
     * 删除观影记录
     * @return int
     * @throws \appapi\exceptions\InvalidParamException
     */
    public function actionDelWatchLog()
    {
        $logId = $this->getParamOrFail('log_id');
        $userLogic = new UserLogic();
        return $userLogic->delWatchLog($logId);
    }

    /**
     * 消息
     * @return array
     */
    public function actionMessage()
    {
        $message = new UserLogic();
        return $message->message();
    }

    /**
     * 积分列表
     * @return array
     * @throws ApiException
     */
    public function actionScore()
    {
        $userLogic = new UserLogic();

        $assets = $userLogic->assets();

        // 积分明细列表
        $data = $userLogic->scoreList();

        $data["current_score"] = $assets ? $assets->score_remain : 0; // 当前积分
        $data["today_score"]   = $userLogic->todayScore(); //  今日积分
        $data["total_score"]   = $assets ? $assets->total_score : 0; // 累计积分
        $data["score_rule"]    = Yii::$app->setting->get('rules.score_intro');

        return $data;
    }

    /**
     * 评论
     * @return array
     */
    public function actionComment()
    {
        $userLogic = new UserLogic();
        return $userLogic->commentList();
    }

    /**
     * 用户视频收藏列表
     * @return array
     * @throws ApiException
     */
    public function actionFavList()
    {
        $userLogic = new UserLogic();
        return $userLogic->favVideoList();
    }

    /**
     * 视频收藏
     */
    public function actionFav()
    {
        $videoId = $this->getParamOrFail('video_id');

        $userLogic = new UserLogic();
        return $userLogic->favVideo($videoId);
    }

    /**
     * 签到接口
     * @return array
     * @throws ApiException
     * @throws \yii\db\Exception
     */
    public function actionSign()
    {
        $userLogic = new UserLogic();
        return $userLogic->sign();
    }

    /**
     * 订单列表
     * @return array
     */
    public function actionOrderList()
    {
        $userLogic = new UserLogic();
        return $userLogic->orderList();
    }

    /**
     * 上传头像
     */
    public function actionSetAvatar()
    {
        $avatar = $this->getParamOrFail('avatar');

        $userLogic = new UserLogic();
        return $userLogic->setAvatar($avatar);
    }
    
    /**
     * 修改个人信息
     */
    public function actionSetNickname()
    {
        $nickname = $this->getParamOrFail('nickname');

        $userLogic = new UserLogic();
        return $userLogic->setNickname($nickname);
    }

    /**
     * 修改性别
     */
    public function actionSetGender()
    {
        $gender = $this->getParamOrFail('gender');

        $userLogic = new UserLogic();
        return $userLogic->setGender($gender);
    }

    /**
     * 注销账号
     * @throws \yii\db\Exception
     */
    public function actionCancelAccount()
    {
        $userLogic = new UserLogic();
        return $userLogic->cancelAccount();
    }
    /**
     * 观看视频1分钟任务
     * @throws \appapi\exceptions\LoginException
     */
    public function actionOneMinuteTask()
    {
        // 完成任务
        $taskLogic = new TaskLogic();
        return $taskLogic->finishTask(TaskInfo::TASK_ACTION_PLAY_VIDEO);
    }
    /*
     * 20220615 尹 app发送验证码
     */
    public function actionSendCode(){
        $mobile_areacode = '+'.$this->getParam('mobile_areacode', "");
        $mobile = $this->getParam('mobile', "");//手机
        $userlogic = new UserLogic();
        $result = $userlogic->createSMScode($mobile_areacode.$mobile);
        if($result['errno']==0){
            return true;
        }else{
            return false;
        }
    }
    /*
     * 20220615 尹 app短信登录
     */
    public function actionSmsLogin()
    {
        $mobile = $this->getParamOrFail('mobile');
        $mobile_areacode = '+'.$this->getParamOrFail('mobile_areacode');
        $code = $this->getParamOrFail('code');

        $user = [];

        $redis = new RedisStore();
        $key = 'appSMScode'.$mobile_areacode.$mobile;
        if($redis->get($key) && $redis->get($key)==$code){
            $userLogic = new UserLogic();
            $user = $userLogic->messageRegister(['mobile_areacode'=> $mobile_areacode,'mobile'=>$mobile]);
        }

        return $user;
    }
    /**
     * 绑定手机号
     */
    public function actionBindNewMobile()
    {
        $mobile = $this->getParamOrFail('mobile');
        $mobile_areacode = '+'.$this->getParamOrFail('mobile_areacode');
        $code = $this->getParamOrFail('code');

        $data = [];

        $redis = new RedisStore();
        $key = 'appSMScode'.$mobile_areacode.$mobile;
        if($redis->get($key) && $redis->get($key)==$code){
            $userLogic = new UserLogic();
            $data = $userLogic->bindnewMobile($mobile, $mobile_areacode);
        }


        return $data;
    }
}
