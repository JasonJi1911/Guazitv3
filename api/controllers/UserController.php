<?php
namespace api\controllers;

use api\exceptions\Exception;
use api\helpers\ErrorCode;
use api\logic\TaskLogic;
use api\models\user\TaskInfo;
use api\models\user\User;
use api\models\user\UserAssets;
use api\models\user\UserAuthApp;
use api\models\user\UserRelations;
use api\models\user\UserVip;
use Yii;
use api\exceptions\ApiException;
use api\logic\UserLogic;
use api\dao\UserDao;

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

    /*
     * 邮箱密码登录
     */
    public function actionEmailWeblogin(){
        $email = $this->getParam('email', '');
        $password = $this->getParam('password', '');
        // $password = Yii::$app->security->generatePasswordHash($password);

        $userDao = new UserDao();
        $param['email'] = $email;
        $param['password_hash'] = $password;
        $user = $userDao->finduserInfo($param);
        return $user;
    }
    /*
     * 手机密码登录
     */
    public function actionMobileWeblogin(){
        $mobile = $this->getParam('mobile', '');
        $password = $this->getParam('password', '');
        // $password = Yii::$app->security->generatePasswordHash($password);

        $userDao = new UserDao();
        $param['mobile'] = $mobile;
        $param['email'] = '';
        $param['password_hash'] = $password;
        $user = $userDao->finduserInfo($param);

        // $result['user'] = $user;
        // $result['ss'] = $param;
        return $user;
    }

    /*
     * web用户注册（手机邮箱+密码，密保）
     */
    public function actionWebregister(){
        $email = $this->getParam('email', '');
        $mobile_areacode = $this->getParam('mobile_areacode', '');
        $mobile = $this->getParam('mobile', '');
        $question = $this->getParam('question', 0);
        $answer = $this->getParam('answer', '');

        $password = $this->getParam('password', '');
        $password = Yii::$app->security->generatePasswordHash($password);

        $userLogic = new UserLogic();
        $user = $userLogic->webRegister(['email'=>$email, 'mobile_areacode'=>$mobile_areacode, 'mobile'=>$mobile,
            'security_question'=>$question, 'security_answer'=>$answer, 'password_hash'=>$password]);

        return $user;
    }

    /*
     * PC端手机短信验证码注册
     */
    public function actionMessageRegister(){
        $mobile_areacode = $this->getParam('mobile_areacode', '');
        $mobile = $this->getParam('mobile', '');
        $password = $this->getParam('password', '');
        $password = Yii::$app->security->generatePasswordHash($password);

        $userLogic = new UserLogic();
        $user = $userLogic->messageRegister(['mobile_areacode'=>$mobile_areacode,'mobile'=>$mobile,'password_hash'=>$password]);

        return $user;
    }

    /*
     * PC端用户修改密码
     */
    public function actionModifyPassword(){
        $account = $this->getParam('account', '');
        $question = $this->getParam('question', 0);
        $answer = $this->getParam('answer', '');
        $password = $this->getParam('password', '');
        $password = Yii::$app->security->generatePasswordHash($password);
        $is_email = $this->getParam('is_email', false);
        if($is_email){
            $param['email'] = $account;
        }else{
            $param['mobile'] = $account;
        }
        $param['security_question'] = $question;
        $param['security_answer'] = $answer;
        $userDao = new UserDao();
        $data = $userDao->finduserInfoToReason($param);
        $rows = 0;
        if($data && $data['errno']==0){
            $rows = $userDao->modifypassword($data['uid'],$password);
        }
        $data['row'] = $rows;
        return $data;
    }
    /*
     * PC端用户修改密码
     */
    public function actionNewModifyPassword(){
        $mobile = $this->getParam('mobile', '');
        $password = $this->getParam('password', '');
        $password = Yii::$app->security->generatePasswordHash($password);

        $userDao = new UserDao();
        $data = [];

        $rows = $userDao->modifypasswordByMobile($mobile,$password);
        $data['row'] = $rows;
        if($rows>0){
            $data['error'] = 0;
            $data['msg'] = '密码修改成功';
        }else{
            $data['error'] = -1;
            $data['msg'] = '密码修改失败';
        }
        return $data;
    }

    /*
     * PC端用户修改邮箱
     */
    public function actionModifyEmail(){
        $email = $this->getParam('email', '');
        $mobile = $this->getParam('mobile', '');

        $param['mobile'] = $mobile;
        $param['email'] = $email;
        $userDao = new UserDao();
        $data = [];
        $rows = $userDao->modifyemail($param);
        $data['row'] = $rows;
        if($rows>0){
            $data['error'] = 0;
            $data['msg'] = '邮箱修改成功';
        }else{
            $data['error'] = -1;
            $data['msg'] = '邮箱修改失败';
        }
        return $data;
    }

    /*
     * PC端查vip是否有效
     */
    public function actionUservip(){
        $uid = $this->getParam('uid', '');
        $userdao = new UserDao();
        $vip = $userdao->validuservipPC($uid);
        return $vip;
    }

    /*
     * 主页查询用户信息及相关视频信息
     */
    public function actionOtherHome(){
        $uid = $this->getParam('uid', 0);
        $other_uid = $this->getParam('other_uid', 0);
        //加载用户信息
        $userdao = new UserDao();
        $result = $userdao->finduserById($uid,$other_uid,UserRelations::TYPE_FOLLOW);
        //用户上传的视频

        return $result;
    }
    /*
     * 关注/拉黑 或取消
     */
    public function actionChangeRelations(){
        $uid  = $this->getParam('uid', 0);
        $other_uid  = $this->getParam('other_uid', 0);
        $type  = $this->getParam('type', 1);
        $userdao = new UserDao();
        $result = $userdao->addRelations($uid,$other_uid,$type);
        return $result;
    }

    /*
     * 我的消息
     */
    public function actionCommentPc(){
        $uid = $this->getParam('uid', "");
        $userdao = new UserDao();

        //消息-我发表的（包括我回复的）
        $data['comment'] = $userdao->commentListPC($uid);
        //消息-回复我的（pid==uid）
        $data['reply'] = $userdao->replyListPC($uid);
        //消息-系统信息
        $data['system_message'] = $userdao->messagePC($uid);
        return $data;
    }

    /*
     * 系统消息
     */
    public function actionMessagePc(){
        $uid = $this->getParam('uid', "");
        $userdao = new UserDao();
        //消息-系统信息
        $data = $userdao->messagePC($uid);
        return $data;
    }

    /*
     * 消息加载更多
     */
    public function actionSearchComment(){
        $uid = $this->getParam('uid', "");
        $page_num = $this->getParam('page_num', 1);
        $type = $this->getParam('type', 'comment');
        $userdao = new UserDao();
        if($type=="reply"){
            //消息-回复我的（pid==uid）
            $data = $userdao->replyListPC($uid,$page_num);
        }else if($type=="system_message"){
            //消息-系统信息
            $data = $userdao->messagePC($uid,$page_num);
        }else{
            //消息-我发表的（包括我回复的）- comment
            $data = $userdao->commentListPC($uid,$page_num);
        }
        return $data;
    }

    /*
     * 我的关注
     */
    public function actionRelationsPc(){
        $uid = $this->getParam('uid', "");
        $userdao = new UserDao();
        //关注
        $data['follow'] = $userdao->findRelationsByCondition($uid,UserRelations::TYPE_FOLLOW,'time','');
        //黑名单
        $data['blacklist'] = $userdao->findRelationsByCondition($uid,UserRelations::TYPE_BLACKLIST,'time','');
        //粉丝
        $data['fans'] = $userdao->findFansByCondition($uid,'time','');
        return $data;
    }

    /*
     * 点赞
     */
    public function actionAddLikes(){
        $comment_id  = $this->getParam('comment_id', 0);
        $cal  = $this->getParam('cal', 'plus');
        $userdao = new UserDao();
        $result = $userdao->addlikesNumPC($comment_id,$cal);
        return $result;
    }
    /*
     * 删除系统消息
     */
    public function actionRemoveMessage(){
        $uid  = $this->getParam('uid', 0);
        $comment_id  = $this->getParam('comment_id', 0);
        $userdao = new UserDao();
        $result = $userdao->removeMessagePC($comment_id,$uid);
        return $result;
    }
    /*
     * 删除评论
     */
    public function actionRemoveComment(){
        $comment_id  = $this->getParam('comment_id', 0);
        $userdao = new UserDao();
        $result = $userdao->removeCommentPC($comment_id);
        return $result;
    }

    /*
     * 根据条件重新查消息
     */
    public function actionSearchRelation(){
        $uid = $this->getParam('uid', 0);
        $type  = $this->getParam('type', 1);
        $order = $this->getParam('order', 'time');
        $searchword  = $this->getParam('searchword', '');
        $page_num = $this->getParam('page_num', 1);

        $userdao = new UserDao();
        if($type==3){
            $result = $userdao->findFansByCondition($uid,$order,$searchword,$page_num);
        }else{
            $result = $userdao->findRelationsByCondition($uid,$type,$order,$searchword,$page_num);
        }
        return $result;
    }

    /*
     * 查用户信息
     */
    public function actionUserinfo(){
        $uid = $this->getParam('uid', 0);
        $userdao = new UserDao();
        $return  = [];
        $result = $userdao->finduserByuid($uid);
        $return['user'] = $result;
        $vip = $userdao->validuservipPC($uid);
        if($vip){
            $return['vip'] = $vip;
            $return['isvip'] = 1;
        }
        return $return;
    }
    /*
     * 发送验证码
     */
    public function actionSendCode(){
        $mobile_areacode = $this->getParam('mobile_areacode', "");
        $mobile = $this->getParam('mobile', "");//手机
        $userlogic = new UserLogic();
        $result = $userlogic->createSMScode($mobile_areacode.$mobile);
        return $result;
    }
}
