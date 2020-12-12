<?php
namespace api\controllers;

use api\exceptions\Exception;
use api\helpers\ErrorCode;
use api\logic\TaskLogic;
use api\models\user\TaskInfo;
use api\models\user\User;
use api\models\user\UserAssets;
use api\models\user\UserAuthApp;
use api\models\user\UserVip;
use Yii;
use api\exceptions\ApiException;
use api\logic\UserLogic;

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
     * @throws \api\exceptions\InvalidParamException
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
     * @throws \api\exceptions\InvalidParamException
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
     * @throws \api\exceptions\LoginException
     */
    public function actionOneMinuteTask()
    {
        // 完成任务
        $taskLogic = new TaskLogic();
        return $taskLogic->finishTask(TaskInfo::TASK_ACTION_PLAY_VIDEO);
    }
}
