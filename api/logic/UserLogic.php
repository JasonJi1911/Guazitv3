<?php
namespace api\logic;

use api\dao\AdvertDao;
use api\dao\PayDao;
use api\dao\UserDao;
use api\dao\VideoDao;
use api\data\ActiveDataProvider;
use api\exceptions\ApiException;
use api\exceptions\Exception;
use api\exceptions\LoginException;
use api\helpers\ErrorCode;
use api\models\advert\AdvertPosition;
use api\models\DeviceInfo;
use api\models\Feedback;
use api\models\pay\Expend;
use api\models\pay\Goods;
use api\models\pay\Order;
use api\models\user\Sign;
use api\models\user\SignLog;
use api\models\user\SignStatus;
use api\models\user\TaskInfo;
use api\models\user\User;
use api\models\user\UserAssets;
use api\models\user\UserAuthApp;
use api\models\user\UserMessage;
use api\models\user\UserVip;
use api\models\video\Comment;
use api\models\video\UserWatchLog;
use api\models\video\Video;
use api\models\video\VideoFavorite;
use common\helpers\Message;
use common\helpers\OssHelper;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\helpers\Tool;
use common\models\user\CancelAccountLog;
use common\services\PayService;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * 用户相关逻辑类
 * 非token查询用户,统一走私有的findOne方法
 * Class UserLogic
 * @package api\logic
 */
class UserLogic
{
    /**
     * 用户信息
     */
    public function userInfo()
    {
        $userDao = new UserDao();
        $userInfo = $userDao->userInfo();
        $userInfo['bind_list'] = $userDao->bindList();
        return $userInfo;
    }


    /**
     * 会员状态
     * @return int 是会员 1
     */
    public function vipStatus()
    {
        if (!Yii::$app->user->id) { // 非正常用户直接返回
            return 0;
        }

        $userDao = new UserDao();
        $vipInfo = $userDao->vipInfo();
        if (!$vipInfo) { // 没有会员信息
            return 0;
        }

        if ($vipInfo['end_time'] < time()) { // 已过期
            return 0;
        }

        return 1;
    }

    /**
     * 会员信息,包括用户基础信息
     */
    public function vipInfo()
    {
        if (!Yii::$app->user->id) { // 未登录
            return [
                'username'  => '立即注册/登录',
                'avatar'    => '',
                'vip_stats' => 0,
                'desc'      => '登录后查看您的权益'
            ];
        }
        
        $userDao = new UserDao();
        $vipInfo = $userDao->vipInfo();
        if ($vipInfo && ($vipInfo['end_time'] > time())) { // 有效会员
            $vipStatus = 1;
            $desc = '会员到期时间' . date('Y-m-d', $vipInfo['end_time']);
        } else {
            $vipStatus = 0;
            $desc = '您还不是vip用户';
        }

        $user = Yii::$app->user->toArray();
        return [
            'username'  => $user['nickname'],
            'avatar'    => $user['avatar'],
            'vip_stats' => $vipStatus,
            'desc'      => $desc  
        ];
    }
    
    /**
     * 用户手机号登录,返回用户信息
     * @param $mobile
     * @param $code
     * @return $this|User|bool|null
     * @throws ApiException
     * @throws \api\exceptions\LoginException
     */
    public function mobileLogin($mobile, $code)
    {
        $message = new Message();
        if (!$message->checkCode($mobile, $code)) { //检测code是否正确
            throw new ApiException(ErrorCode::EC_VERIFY_CODE_ERROR);
        }

        // 是否已有用户
        if ($user = $this->_findOne(['mobile' => $mobile])) {
            return $user;
        }

        // 新用户,走注册
        $data = ['mobile' => $mobile, 'reg_type' => User::REG_TYPE_MOBILE];
        $uid = $this->register($data);

        $taskLogic = new TaskLogic();
        $taskLogic->finishTask(TaskInfo::TASK_ACTION_BIND_MOBILE, $uid); // 完成任务

        return User::findOne(['uid' => $uid]);
    }

    /**
     * 绑定手机号
     * @param $mobile
     * @param $code
     * @return array
     * @throws \api\exceptions\ApiException
     */
    public function bindMobile($mobile, $code)
    {
        $userInfo = Yii::$app->user->model;
        if ($userInfo->mobile) { //已有手机号
            throw new ApiException(ErrorCode::EC_USER_BINDED_MOBILE);
        }

        // 检查手机号是否已经存在
        if ($this->_findOne(['mobile' => $mobile])) {
            throw new ApiException(ErrorCode::EC_MOBILE_ALREADY_BINDED);
        }

        $message = new Message();
        if (!$message->checkCode($mobile, $code)) { //检测code是否正确
            throw new ApiException(ErrorCode::EC_VERIFY_CODE_ERROR);
        }

        $userInfo->mobile = $mobile;
        $userInfo->save();

        $taskLogic = new TaskLogic();
        $taskLogic->finishTask(TaskInfo::TASK_ACTION_BIND_MOBILE); // 完成任务


        return $this->_findOne(['uid' => $userInfo->uid]);
    }

    /**
     * 微信登陆
     * @param $code
     * @return null|static
     * @throws \api\exceptions\ApiException
     */
    public function wechatLogin($code)
    {
        $userInfo = $this->_getWechatUser($code);  // 用户信息

        // 并发锁
        $key = RedisKey::getApiLockKey('user/login-wechat', ['openid' => $userInfo['openid']]);
        $redis = new RedisStore();
        if ($redis->checkLock($key)) {
            throw new ApiException(ErrorCode::EC_WECHAT_LOGIN_BUSY);
        }

        $userAuth = UserAuthApp::findOne(['app_id' => Yii::$app->common->appId, 'openid' => $userInfo['openid'], 'type' => UserAuthApp::TYPE_WECHAT]);
        if ($userAuth) { // 已有用户
            $redis->releaseLock($key);
            return $this->_login($userAuth->uid);
        }

        // 新用户注册
        $data = [
            'nickname'  => $userInfo['nickname'],
            'avatar'    => $userInfo['headimgurl'],
            'gender'    => Tool::transGender($userInfo['sex'])
        ];
        $uid = $this->register($data);

        // 授权信息
        $userAuthApp            = new UserAuthApp();
        $userAuthApp->uid       = $uid;
        $userAuthApp->openid    = $userInfo['openid'];
        $userAuthApp->unionid   = ArrayHelper::getValue($userInfo, 'unionid', '');
        $userAuthApp->name      = $userInfo['nickname'];
        $userAuthApp->avatar    = $userInfo['headimgurl'];
        $userAuthApp->type      = UserAuthApp::TYPE_WECHAT;
        $userAuthApp->app_id    = Yii::$app->common->appId;
        $userAuthApp->save();

        $taskLogic = new TaskLogic();
        $taskLogic->finishTask(TaskInfo::TASK_ACTION_BIND_WECHAT, $uid); // 完成任务

        $redis->releaseLock($key);
        return User::findOne(['uid' => $uid]);
    }

    /**
     * app绑定微信
     * @param $code
     * @return null|static
     * @throws \api\exceptions\ApiException
     */
    public function bindWechat($code)
    {
        $userInfo = $this->_getWechatUser($code);  //用户信息

        // 并发锁
        $key = RedisKey::getApiLockKey('user/bind-wechat', ['openid' => $userInfo['openid']]);
        $redis = new RedisStore();
        if ($redis->checkLock($key)) {
            throw new ApiException(ErrorCode::EC_WECHAT_LOGIN_BUSY);
        }

        $userAuth = UserAuthApp::findOne(['app_id' => Yii::$app->common->appId, 'openid' => $userInfo['openid'], 'type' => UserAuthApp::TYPE_WECHAT]);
        if ($userAuth) { // 微信已被绑定,直接返回
            $redis->releaseLock($key);
            throw new ApiException(ErrorCode::EC_WECHAT_ALREADY_BINDED);
        }

        // 授权信息
        $userAuthApp            = new UserAuthApp();
        $userAuthApp->uid       = Yii::$app->user->id;
        $userAuthApp->openid    = $userInfo['openid'];
        $userAuthApp->unionid   = ArrayHelper::getValue($userInfo, 'unionid','');
        $userAuthApp->name      = $userInfo['nickname'];
        $userAuthApp->avatar    = $userInfo['headimgurl'];
        $userAuthApp->type      = UserAuthApp::TYPE_WECHAT;
        $userAuthApp->app_id    = Yii::$app->common->appId;
        $userAuthApp->save();

        // 如果有头像,更新用户信息
        $userModel = Yii::$app->user->model;
        if (!$userModel->avatar->toUrl()) {
            $userModel->avatar = $userInfo['headimgurl'];
            $userModel->save();
        }

        $redis->releaseLock($key);

        $taskLogic = new TaskLogic();
        $taskLogic->finishTask(TaskInfo::TASK_ACTION_BIND_WECHAT); // 完成任务


        return $this->_findOne(['uid' => $userInfo->uid]);
    }

    /**
     * qq登录
     * @param $accessToken
     * @return null|static
     * @throws \api\exceptions\ApiException
     * @throws \api\exceptions\LoginException
     */
    public function qqLogin($accessToken)
    {
        $openIdData = $this->_getQqUser($accessToken); // open id信息

        // 并发锁
        $key = RedisKey::getApiLockKey('user/login-qq', ['openid' => $openIdData['openid']]);
        $redis = new RedisStore();
        if ($redis->checkLock($key)) {
            throw new ApiException(ErrorCode::EC_WECHAT_LOGIN_BUSY);
        }
        // 如果已有对应的openid的QQ信息，不需要再次获取，否则获取用户信息
        $userAuth = UserAuthApp::findOne(['app_id' => Yii::$app->common->appId, 'openid' => $openIdData['openid'], 'type' => UserAuthApp::TYPE_QQ]);
        if ($userAuth) { // 已有用户
            $redis->releaseLock($key);
            return $this->_login($userAuth->uid);
        }

        $appWechat = Yii::$app->apps->get('tencentInfo', Yii::$app->common->appId);
        //获取用户信息
        $params = [
            'access_token'       => $accessToken,
            'oauth_consumer_key' => $appWechat['qq_app_id'],
            'openid'             => $openIdData['openid']
        ];
        $userInfo = Tool::httpGet(QQ_USERINFO, $params); // 用户信息
        Yii::warning('app get user info ' . $userInfo['data']);
        if ($userInfo['errno']) {
            Yii::warning($openIdData['error']);
            $redis->releaseLock($key);
            throw new ApiException(ErrorCode::EC_WECHAT_LOGIN_BUSY);
        }

        // 新用户注册
        $userInfo   = json_decode($userInfo['data'], true);
        $data = [
            'nickname'  => $userInfo['nickname'],
            'avatar'    => $userInfo['figureurl_qq'],
            'gender'    => Tool::transGender($userInfo['gender_type']) // 微信性别1-男，2-女
        ];
        $uid = $this->register($data);

        // 授权信息
        $userAuthApp            = new UserAuthApp();
        $userAuthApp->uid       = $uid;
        $userAuthApp->openid    = $openIdData['openid'];
        $userAuthApp->name      = $userInfo['nickname'];
        $userAuthApp->avatar    = $userInfo['figureurl_qq'];
        $userAuthApp->type      = UserAuthApp::TYPE_QQ;
        $userAuthApp->app_id    = Yii::$app->common->appId;
        $userAuthApp->save();

        $redis->releaseLock($key);
        return User::findOne($uid);
    }

    public function bindQq($accessToken)
    {
        $openIdData = $this->_getQqUser($accessToken); // open id信息

        // 并发锁
        $key = RedisKey::getApiLockKey('user/bind-qq', ['openid' => $openIdData['openid']]);
        $redis = new RedisStore();
        if ($redis->checkLock($key)) {
            throw new ApiException(ErrorCode::EC_WECHAT_LOGIN_BUSY);
        }
        // 如果已有对应的openid的QQ信息，不需要再次获取，否则获取用户信息
        $userAuth = UserAuthApp::findOne(['app_id' => Yii::$app->common->appId, 'openid' => $openIdData['openid'], 'type' => UserAuthApp::TYPE_QQ]);
        if ($userAuth) { // 已有用户
            throw new ApiException(ErrorCode::EC_QQ_ALREADY_BINDED);
        }

        $appWechat = Yii::$app->apps->get('tencentInfo', Yii::$app->common->appId);
        //获取用户信息
        $params = [
            'access_token'       => $accessToken,
            'oauth_consumer_key' => $appWechat['qq_app_id'],
            'openid'             => $openIdData['openid']
        ];
        $userData = Tool::httpGet(QQ_USERINFO, $params); // 用户信息
        Yii::warning('app get user info' . $userData['data']);
        $userInfo   = json_decode($userData['data'], true);
        // 授权信息
        $userAuthApp            = new UserAuthApp();
        $userAuthApp->uid       = Yii::$app->user->id;
        $userAuthApp->openid    = $openIdData['openid'];
        $userAuthApp->name      = $userInfo['nickname'];
        $userAuthApp->avatar    = $userInfo['figureurl_qq'];
        $userAuthApp->type      = UserAuthApp::TYPE_QQ;
        $userAuthApp->app_id    = Yii::$app->common->appId;
        $userAuthApp->save();

        // 如果有头像,更新用户信息
        $userModel = Yii::$app->user->model;
        if (!$userModel->avatar->toUrl()) {
            $userModel->avatar = $userInfo['figureurl_qq'];
            $userModel->save();
        }

        $redis->releaseLock($key);
        return $this->_findOne(['uid' => $userInfo->uid]);
    }

    /**
     * qq open id信息
     * @param $accessToken
     * @return mixed
     * @throws \api\exceptions\LoginException
     */
    private function _getQqUser($accessToken)
    {
        // 获取用户openid
        $openIdData = Tool::httpGet(QQ_OAUTH2_ME, ['access_token' => $accessToken]);
        Yii::warning('app get user openid ' . $openIdData['data']);
        if ($openIdData['errno']) { // 获取信息失败
            Yii::warning($openIdData['error']);
            throw new LoginException(ErrorCode::EC_QQ_LOGIN_FAILED);
        }

        // QQ返回参数格式：callback( {"client_id":"YOUR_APPID","openid":"YOUR_OPENID"} )，需要做解析
        if (strpos($openIdData['data'], "callback") !== false) {
            $lpos = strpos($openIdData['data'], "(");//判断(出现的下标
            $rpos = strrpos($openIdData['data'], ")");//判断)出现的下标，加上r从右边开始查找
            $openIdData['data'] = substr($openIdData['data'], $lpos + 1, $rpos - $lpos -1);//截取字符串
        }
        // 解析后格式：{"client_id":"YOUR_APPID","openid":"YOUR_OPENID"}，错误时会返回code和msg
        return json_decode($openIdData['data'], true);
    }


    /**
     * 设备号登录 只支持设备号注册的用户登录
     * @param $udid
     * @return $this|User|bool|null
     * @throws ApiException
     */
    public function deviceLogin($udid)
    {
        // 是否已有用户
        if ($user = $this->_findOne(['udid' => $udid, 'reg_type' => User::REG_TYPE_DEVICE])) {
            return $user;
        }
        $uid = $this->register(['udid' => $udid, 'reg_type' => User::REG_TYPE_DEVICE]);
        return User::findOne(['uid' => $uid]);
    }

    /**
     * 查询用户,根据状态返回
     * @param $condition
     * @return bool|null|static
     * @throws \api\exceptions\ApiException
     */
    private function _findOne($condition)
    {
        $user = User::findOne($condition);
        if (!$user) {
            return false;
        }

        if ($user->status != User::STATUS_ENABLED) {
            throw new ApiException(ErrorCode::EC_USER_FORBIDDEN);
        }

        return $user;
    }

    /**
     * 用户注册,所有用户注册都走这个方法
     * @param $data 包括 from_channel reg_type等其他参数
     * @return bool
     * @throws \api\exceptions\ApiException
     */
    public function register($data)
    {
        $user = new User();
        // 默认注册参数
        $user->user_token   = Tool::getRandKey();
        $user->reg_ip       = Tool::getIp();
        $user->source       = Yii::$app->common->source;
        $user->from_channel = Yii::$app->common->fromChannel;
        $user->product      = Yii::$app->common->product;
        $user->from_market  = Yii::$app->common->marketChannel;
        $user->reg_ip       = Tool::getIp();

        foreach ($data as $attribute => $value) {  // 循环遍历赋值
            $user->$attribute = $value;
        }

        if (!$user->nickname) { // 如果没有设置昵称,则默认设置一个
            $user->nickname = USER_NICKNAME_PREFIX . time();
        }

        if (!$user->save()) {
            Yii::warning($user->errors);
            throw new ApiException(ErrorCode::EC_USER_REGISTER_FAIL);
        }

        // 完成新手任务
        $taskLogic = new TaskLogic();
        $taskLogic->finishTask(TaskInfo::TASK_ACTION_GIFT, $user->uid); // 完成任务

        return $user->uid;
    }

    /**
     * 同步推送设备号
     * @param $deviceId
     * @return bool
     */
    public function syncDevice($deviceId)
    {
        if (!$deviceId) { // 空的设备号
            return [];
        }

        $uid = 0;
        if (Yii::$app->user->id) { // 如果登录了使用登录的uid
            $uid = Yii::$app->user->id;
        }
        
        $objDevice = DeviceInfo::findOne(['uid' => $uid, 'udid' => Yii::$app->common->udid]);
        if (!$objDevice) { // 不存在 写入
            $objDevice = new DeviceInfo();
            $objDevice->udid = Yii::$app->common->udid;
        }
        $objDevice->os_type         = Yii::$app->common->osType;
        $objDevice->sysver          = Yii::$app->common->sysVer;
        $objDevice->uid             = $uid;
        $objDevice->ver             = Yii::$app->common->ver;
        $objDevice->last_visit_time = time();
        $objDevice->ali_device_id   = $deviceId;
        $objDevice->save();

        if ($uid) {
            //更新用户设备信息
            Yii::$app->user->model->last_device_id = $objDevice->device_id;
            Yii::$app->user->model->save();
        }

        return true;
    }

    /**
     * 设置用户头像信息
     * @param $avatar
     * @return array
     * @throws ApiException
     * @throws \api\exceptions\LoginException
     */
    public function setAvatar($avatar)
    {
        $ossHelper = new OssHelper();
        $dir = 'avatar/' . date('Ym');  //目录
        $ret = $ossHelper->uploadFileBaseToOss($avatar, $dir);
        if (!$ret) {
            throw new ApiException(ErrorCode::EC_ALI_UPLOAD_FAILED);
        }

        $userInfo = Yii::$app->user->model;
        $userInfo->avatar = $ret;
        $userInfo->save();

        return [];
    }

    /**
     * 设置昵称
     * @param $nickname
     * @return array
     * @throws ApiException
     * @throws \api\exceptions\LoginException
     */
    public function setNickname($nickname)
    {
        if (mb_strlen($nickname) < 1 || mb_strlen($nickname) > 12) { //昵称长度限制
            throw new ApiException(ErrorCode::EC_SET_USERINFO_FAILED, '请填写1-12个字符！');
        }

        $userInfo = Yii::$app->user->model;
        $userInfo->nickname = $nickname;
        $userInfo->save();

        return [];
    }

    /**
     * 设置性别
     * @param $gender
     * @return array
     * @throws ApiException
     */
    public function setGender($gender)
    {
        if (!in_array($gender, array_keys(User::$genderMap))) { //非法的gender
            $gender = 0;
        }

        $userInfo =Yii::$app->user->model;
        $userInfo->gender = $gender;
        $userInfo->save();

        return [];
    }


    /**
     * 登录操作,更新各项信息
     */
    private function _login($uid)
    {
        return User::findOne($uid);
    }

    /**
     * 获取微信用户信息
     * @param $code 登录code,根据code获取用户信息
     * @return mixed
     * @throws \api\exceptions\ApiException
     */
    private function _getWechatUser($code)
    {
        // 获取配置
        $appWechat = Yii::$app->apps->get('tencentInfo', Yii::$app->common->appId);

        $params = [
            'appid'     => $appWechat['wechat_app_id'],
            'secret'    => $appWechat['wechat_app_secret'],
            'code'      => $code,
            'grant_type' => 'authorization_code'
        ];

        $data = Tool::httpGet(WECHAT_OAUTH2, $params);
        if ($data['errno']) {
            Yii::warning('request filed' . json_encode($data));
            throw new ApiException(ErrorCode::EC_WECHAT_LOGIN_FAILED);
        }

        $accessTokenInfo = json_decode($data['data'], true);
        if (isset($accessTokenInfo['errcode'])) { // 获取access token失败
            Yii::warning('get access token failed' . json_encode($data['data']));
            throw new ApiException(ErrorCode::EC_WECHAT_LOGIN_FAILED);
        }

        //获取用户信息
        $data = Tool::httpGet(WECHAT_USERINFO, [
            'access_token' => $accessTokenInfo['access_token'],
            'openid'       => $accessTokenInfo['openid'],
        ]);
        if ($data['errno']) {
            Yii::warning('request filed' . json_encode($data));
            throw new ApiException(ErrorCode::EC_WECHAT_LOGIN_FAILED);
        }
        Yii::warning($data['data']);
        return json_decode($data['data'], true);  //用户信息
    }
    
    


    /**
     * 获取用户id或者失败,用于强制登录时处理
     */
    private function _getUidOrFail()
    {
        $uid = Yii::$app->user->id;;
        if (!$uid) {
            throw new ApiException(ErrorCode::EC_USER_TOKEN_EXPIRE);
        }

        return $uid;
    }

    /**
     * 分享奖励展示
     */
    public function shareReward()
    {
        $data = ['tip' => '分享成功']; // 最终返回数据
        $taskLogic = new TaskLogic();
        $ret = $taskLogic->finishTask(TaskInfo::TASK_ACTION_SHARE_APP);
        if (!$ret) {
            return $data;
        }

        //取货币单位
        $unit = Yii::$app->setting->get('system.subUnit');
        $data['tip'] = '分享成功+' . $ret . $unit;

        return $data;
    }

    /**
     * 签到
     */
    public function sign()
    {
        $uid = Yii::$app->user->id;
        $time = time();
        //判断今天是否已签到过
        $date = date('Ymd', $time);
        $objSignLog = SignLog::findOne(['uid' => $uid, 'date' => $date]);
        if ($objSignLog) {
            //已经签到过直接返回已签到过
            throw new ApiException(ErrorCode::EC_ALREADY_SING);
        }
        // 事务
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $objSignStatus = SignStatus::findOne(['uid' => $uid]);

            if (empty($objSignStatus)) {
                $objSignStatus = new SignStatus();
                $objSignStatus->uid       = $uid;
                $objSignStatus->sign_days = 0;
            }

            //判断是否断签 断签连续签到从0开始计算
            $objYtdSignLog = SignLog::findOne(['uid' => $uid, 'date' => date('Ymd', strtotime('-1 day'))]);
            if (empty($objYtdSignLog)) {
                $objSignStatus->sign_days = 1;
            } else {
                $objSignStatus->sign_days += 1;
            }
            //连续签到超过7天重置签到天数
            if ($objSignStatus->sign_days > Yii::$app->params['max_valid_sign_days']) {
                $objSignStatus->sign_days = 1;
            }
            if (!$objSignStatus->save()) {
                throw new \Exception(json_encode($objSignStatus->errors, JSON_UNESCAPED_UNICODE));
            }

            $sign_days = $objSignStatus->sign_days;
            $scoreNum = $this->_calSignScoreNum($sign_days);

            $objPayService = new PayService();
            //赠送金币
            list($trade_no, $scoreNum) = $objPayService->interfacePay($uid, Expend::TYPE_SIGN_IN, $scoreNum);

            //记录每日签到记录
            $objSignLog = new SignLog();
            $objSignLog->uid        = $uid;
            $objSignLog->trade_no   = $trade_no;
            $objSignLog->date       = $date;
            $objSignLog->year_month = date('Ym', $time);
            $objSignLog->sign_days  = $sign_days;
            if (!$objSignLog->save()) {
                throw new \Exception(json_encode($objSignLog->errors, JSON_UNESCAPED_UNICODE));
            }
            
            //取货币单位
            $unit = Yii::$app->setting->get('system.currency_unit');
            $data = [
                "award" => '+' . intval($scoreNum) . $unit, // 元宝icon +20
            ];
            $transaction->commit();
        }catch (\Exception $e){
            $transaction->rollback();
            Yii::warning("uid:{" . $uid . "} user sign failed - exception: " . $e->getMessage(), 'USER_SIGN_FAILED');
            throw new ApiException(ErrorCode::EC_DB_ERROR);
        }

        return $data;
    }

    /**
     * 签到状态
     * @return int
     */
    public function signStatus()
    {
        $uid = Yii::$app->user->id;
        if (!$uid) { // 没有用户
            return 0;
        }
        if (SignLog::findOne(['uid' => $uid, 'date' => date('Ymd')])) { // 今天已签到
            return 1;
        }
        return 0;
    }

    /**
     * 用户中心
     */
    public function userCenter()
    {
        $uid = Yii::$app->user->id;
        $assets = $this->assets();
        // 初始化数据
        $favNum = VideoFavorite::find()->where(['uid' => $uid, 'status' => VideoFavorite::STATUS_YES])->count();
        $msgNUm = UserMessage::find()->where(['uid' => $uid, 'status' => UserMessage::STATUS_NO])->count();
        $tabBar = [
            ['title' => Yii::$app->setting->get('system.currency_coupon'), 'num' => ($assets && $assets->coupon_remain) ? strval($assets->coupon_remain) : '0', 'action' => 'coupon'],
            ['title' => Yii::$app->setting->get('system.currency_unit'), 'num'   => ($assets && $assets->score_remain) ? strval($assets->score_remain) : '0', 'action' => 'score'],
            ['title' => '收藏', 'num' => $favNum ? strval($favNum) : '0', 'action' => 'collect'],
            ['title' => '消息', 'num' => $msgNUm ? strval($msgNUm) : '0', 'action' => 'message'],
        ];
        if (!COUPON_SWITCH) { // 没有观影券则隐藏
            unset($tabBar[0]);
            $tabBar = array_values($tabBar);
        }

        // 任务模块
        $taskCenter = [];
        $taskLogic = new TaskLogic();
        $tasks = array_slice(ArrayHelper::getValue($taskLogic->taskInfo(), 'dailyTasks', []), 0, 2);
        if ($tasks) {
            $list = [];
            foreach ($tasks as $task) {
                $list[] = [
                    'title' => $task['task_label'],
                    'desc'  => $task['task_desc'],
                    'icon'  => $task['task_icon'],
                    'action' => $task['task_action'],
                ];
            }
            $taskCenter = [
                'title' => '任务中心',
                'desc'  => '赚取更多' . Yii::$app->setting->get('system.currency_unit'),
                'action' => 'task',
                'list'   => $list
            ];
        }
        $vipInfo = [  // 会员
            'title' => '开通会员',
            'desc'  => '尊享广告等8大权益'
        ];

        $sign = ['status' => 0, 'desc' => '签到'];
        $isVip = 0; // 会员状态,默认0

        if ($uid) { // 登录需要更新信息
            $sign['status'] = $this->signStatus();
            if ( $sign['status']) { // 已签到
                $sign['desc'] = '签到';
            } else {
                $sign['desc'] = '赢更多积分';
            }

            // 会员信息
            $userDao = new UserDao();
            $vip = $userDao->vipInfo();
            if ($vip && ($vip['end_time'] > time())) { // 有会员
                $vipInfo = [
                    'title' => '我的会员',
                    'desc'  => '到期时间' . date('Y-m-d', $vip['end_time'])
                ];
                $isVip = 1; // 更新会员状态
            }
        }

        if (!VIP_SWITCH) {
            $vipInfo = [
                'title' => '',
                'desc' => '',
            ];
        }

        $userDao = new UserDao();
        $user = $userDao->userInfo();

        $advertLogic = new AdvertLogic();
        return array_merge($user, [
            'order_switch'  => (!VIP_SWITCH && !COUPON_SWITCH) ? 2 : 1, // 会员和卡券都没有的情况
            'currency_unit'    => Yii::$app->setting->get('system.currency_unit'),
            'currency_coupon'  => Yii::$app->setting->get('system.currency_coupon'),
            'vip_info'      => $vipInfo,
            'tab_bar'       => $tabBar,
            'task_center'   => $taskCenter,
            'sign'          => $sign,
            'is_vip'        => $isVip,
            'advert'        => (object)$advertLogic->advertByPosition(AdvertPosition::POSITION_ORDER_LIST)
        ]);
    }

    /**
     * 用户余额,没用用户余额或者未登录时,返回余额为0
     */
    public function assets()
    {
        $uid = Yii::$app->user->id;
        if (!$uid) {
            return false;
        }
        return UserAssets::getUserAssets(['uid' => $uid]);
    }

    /**
     * 计算签到获取的奖励
     * @param int $signDays 签到天数
     * @return int $silver_num 银币数
     */
    private function _calSignScoreNum($signDays) {
        // 签到奖励数组
        $signAward = ArrayHelper::map(Sign::find()->asArray()->all(), 'day', 'score');
        
        return ArrayHelper::getValue($signAward, $signDays, 0);
    }

    /**
     * 添加播放记录
     * @param $videoId
     * @param $chapterId
     * @param $watchTime
     * @return bool
     * @throws ApiException
     */
    public function addWatchLog($videoId, $chapterId, $watchTime)
    {
        $uid = Yii::$app->user->id;
        if (!$uid) {
            return false;
        }
        $videoLogic = new VideoLogic();
        $chapterId = $videoLogic->getFirstChapter($videoId, $chapterId);

        //并发锁检测
        $key = RedisKey::getApiLockKey('user/add-watch-log', ['chapter_id' => $chapterId, 'uid' => $uid]);
        $redis = new RedisStore();
        if ($redis->checkLock($key)) {
            throw new ApiException(ErrorCode::EC_SYSTEM_OPERATING);
        }

        $videoDao = new VideoDao();
        $videoChapter = $videoDao->videoChapter($videoId, ['chapter_id'], true);

        if (!isset($videoChapter[$chapterId])) {  //如果视频不存在直接返回
            $redis->releaseLock($key);
            throw new ApiException(ErrorCode::EC_VIDEO_NOT_EXIST);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            //是否已有观看记录,每个系列视频只存一条记录
            $videoLog = UserWatchLog::findOne(['video_id' => $videoId, 'uid' => $uid]);
            if (!$videoLog) {
                $videoLog = new UserWatchLog();
                $videoLog->uid       = $uid;
                $videoLog->video_id  = $videoId;
                $videoLog->time = $watchTime;
            } else {
                $videoLog->time = $watchTime ? $watchTime : $videoLog->time;
            }
            $videoLog->chapter_id = $chapterId;


            $videoLog->save();

            // 完成任务
            if ($watchTime > 60) {
                // 完成任务
                $taskLogic = new TaskLogic();
                $taskLogic->finishTask(TaskInfo::TASK_ACTION_PLAY_VIDEO);
            }

            $transaction->commit();
        } catch (\Exception $e){
            $transaction->rollBack();
            $redis->releaseLock($key);
            return false;
        }

        $redis->releaseLock($key);
        return true;
    }

    /**
     * 是否收藏视频
     * @param $videoId
     * @return bool 收藏返回true
     */
    public function isFav($videoId)
    {
        $userDao = new UserDao();
        $userFavorite = $userDao->favoriteId(Yii::$app->user->id);
        if (in_array($videoId, $userFavorite)) {
            return true;
        }
        
        return false;
    }

    /**
     * 删除观看记录
     * @param $logId
     * @return int
     */
    public function delWatchLog($logId)
    {
        $uid = Yii::$app->user->id;
        if ($logId === 'all') {
            $where = ['uid' => $uid];
        } else {
            $logId = explode(',', $logId);
            $where = ['id' => $logId, 'uid' => $uid];
        }
        return UserWatchLog::deleteAll($where);
    }

    /**
     * 观影记录
     * @return array
     * @throws ApiException
     */
    public function watchLogList()
    {
        $uid = Yii::$app->user->id;
        $dataProvider = new ActiveDataProvider([
            'query' => UserWatchLog::find()
                ->where(['uid' => $uid])
        ]);
        $data = $dataProvider->setPagination()->toArray(['log_id', 'video_id', 'chapter_id', 'play_time', 'time', 'play_date', 'created_at']);
        if ($data['list']) {
            $videoId = array_column($data['list'], 'video_id');
            $videoDao = new VideoDao();
            $videoInfo = $videoDao->batchGetVideo($videoId, ['video_id', 'video_name', 'horizontal_cover'], true);
            $list = [];
            foreach ($data['list'] as &$info) {
                $info['title']      = $videoInfo[$info['video_id']]['video_name'];
                $info['cover']      = $videoInfo[$info['video_id']]['horizontal_cover'];
                $info['watch_time'] = '观看至 ' . $info['play_time'];
                if ($info['play_date'] == date('Y-m-d')) {
                    $dateKey = '今天';
                } else if ($info['play_date'] == date('Y-m-d', strtotime('-1 day'))) {
                    $dateKey = '昨天';
                } else {
                    $dateKey = '更早';
                }
                $list[$info['play_date']]['date']   = $dateKey;
                $list[$info['play_date']]['list'][] = $info;
            }

            $data['list'] = array_values($list);
        }
        return $data;
    }

    /**
     * 用户视频收藏列表
     * @return array
     * @throws ApiException
     */
    public function favVideoList()
    {
        $uid = $this->_getUidOrFail();
        $dataProvider = new ActiveDataProvider([
            'query' => VideoFavorite::find()->where(['uid' => $uid, 'status' => VideoFavorite::STATUS_YES])
        ]);
        $data = $dataProvider->setPagination()->toArray(['video_id']);
        if ($data['list']) {
            $videoId = array_column($data['list'], 'video_id');
            $videoDao = new VideoDao();
            $videoInfo = $videoDao->batchGetVideo($videoId, ['video_id', 'video_name', 'cover', 'horizontal_cover', 'flag', 'tag'], true);

            // 查询观看记录
            $watchLog = ArrayHelper::index(UserWatchLog::find()->where(['uid' => $uid, 'video_id' => $videoId])->asArray()->all(), 'video_id');

            foreach ($data['list'] as &$info) {
                $info['video_name']       = $videoInfo[$info['video_id']]['video_name'];
                $info['cover']            = $videoInfo[$info['video_id']]['horizontal_cover'];
                $info['flag']             = $videoInfo[$info['video_id']]['flag'];
                $info['tag']              = $videoInfo[$info['video_id']]['tag'];
                $info['chapter_id']       = isset($watchLog[$info['video_id']]) ? $watchLog[$info['video_id']]['chapter_id'] : 0;
                $info['watch_time']       = '观看至 ' . (isset($watchLog[$info['video_id']]) ? Tool::timeToLong($watchLog[$info['video_id']]['time']) : '00:00');
            }
        }
        return $data;
    }
    
    /**
     * 视频收藏
     * @param $videoId
     * @return array
     * @throws ApiException
     */
    public function favVideo($videoId)
    {
        $uid = $this->_getUidOrFail();

        if ($videoId === 'all') {
            $favList = VideoFavorite::find()->where(['uid' => $uid, 'status' => VideoFavorite::STATUS_YES])->asArray()->all();
            $videoIdArr = array_column($favList, 'video_id');
        } else {
            $videoIdArr = explode(',', $videoId);
        }

        foreach ($videoIdArr as $id) {
            //查询收藏状态，并保存
            $objVideoFav = VideoFavorite::findOne(['uid' => $uid, 'video_id' => $id]);
            if ($objVideoFav){
                if ($objVideoFav->status == VideoFavorite::STATUS_YES){
                    $objVideoFav->status = VideoFavorite::STATUS_NO;
                    Video::updateAllCounters(['total_favors' => -1],
                        ['id' => $objVideoFav->video_id]);
                    $status = 0;
                }else{
                    $objVideoFav->status = VideoFavorite::STATUS_YES;
                    Video::updateAllCounters(['total_favors' => +1],
                        ['id' => $objVideoFav->video_id]);
                    $status = 1;
                }
                $objVideoFav->save();
            } else {
                $objVideoFav = new VideoFavorite();
                $objVideoFav->uid        = $uid;
                $objVideoFav->video_id   = $id;
                $objVideoFav->status     = VideoFavorite::STATUS_YES;
                $objVideoFav->created_at = time();
                $objVideoFav->save();
                Video::updateAllCounters(['total_favors' => +1],
                    ['id' => $videoId]);
                $status = 1;
            }
        }

        // 删除收藏缓存
        $key = RedisKey::videoUserFavorite($uid);
        $redis = new RedisStore();
        $redis->del($key);

        return [
            'status' => $status
        ];
    }

    /**
     * 评论列表
     * @return array
     */
    public function commentList()
    {
        $uid      = Yii::$app->user->id;
        $avatar   = Yii::$app->user->avatar->toUrl();
        $username = Yii::$app->user->nickname;

        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()->andWhere(['uid' => $uid])
        ]);
        $data = $dataProvider->setPagination()->toArray(['uid', 'content', 'video_id', 'created_at']);
        if ($data['list']) {
            $videoId = array_column($data['list'], 'video_id');
            $videoDao = new VideoDao();
            $videoInfo = $videoDao->batchGetVideo($videoId, ['video_id', 'video_name', 'cover', 'flag'], true);
            foreach ($data['list'] as &$comment) {
                $comment['avatar']    = $avatar;
                $comment['username']  = $username;
                $comment['film_name'] = $videoInfo[$comment['video_id']]['video_name'];
                $comment['date']      = date('Y-m-d', $comment['created_at']);
                unset($comment['created_at']);
            }
        }
        return $data;
    }

    /**
     * 订单列表
     * @return array
     */
    public function orderList()
    {
        $uid = Yii::$app->user->id;
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()
                ->where(['uid' => $uid, 'status' => Order::STATUS_SUCCESS])
        ]);

        $field = ['trade_no', 'original_fee', 'total_fee', 'pay_channel', 'goods_id', 'value', 'type', 'created_at'];
        $data = $dataProvider->setPagination()->toArray($field);

        $payDao = new PayDao();
        $goods = ArrayHelper::index($payDao->goodsList(array_keys(Goods::$goodsTypeMap)), 'goods_id');

        if ($data['list']) {  
            foreach ($data['list'] as &$order) {
                $order['title']          = '订单号：' . $order['trade_no'];
                $order['content']        = isset( $goods[$order['goods_id']]) ? $goods[$order['goods_id']]['title'] : '--';
                $order['original_price'] = MONEY_UNIT . bcdiv($order['original_fee'], 100, 2);
                $order['current_price']  = MONEY_UNIT . bcdiv($order['total_fee'], 100, 2);
                $order['date']           = date('Y-m-d', $order['created_at']);
                $order['status_label']   = ArrayHelper::getValue(Order::$payChannels, $order['pay_channel'], '--');
            }
        }

        // 获取广告
        $advertLogic = new AdvertLogic();
        $advert = $advertLogic->advertByPosition(AdvertPosition::POSITION_ORDER_LIST);
        $data['advert'] = !empty($advert) ? $advert : (object)$advert;

        return $data;
    }

    /**
     * 用户当前获取的积分
     * @return mixed
     */
    public function todayScore()
    {
        $uid = Yii::$app->user->id;

        $time = strtotime(date('Y-m-d'));
        $score  = Expend::find()->where(['uid' => $uid])
            ->andWhere(['<', 'type', Expend::TYPE_REMOVE_AD])
            ->andWhere(['between', 'created_at', $time, $time+86400])
            ->sum('score');
        return intval($score);
    }

    /**
     * 积分明细列表
     * @return array
     * @throws ApiException
     */
    public function scoreList()
    {
        $uid = $this->_getUidOrFail();
        $dataProvider = new ActiveDataProvider([
            'query' => Expend::find()
                ->where(['uid' => $uid])
                ->orderBy(['created_at' => SORT_DESC])
        ]);

        return $dataProvider->setPagination()->toArray(['title', 'desc', 'date']);
    }


    /**
     * 消息
     * @return array
     * @throws \api\exceptions\LoginException
     */
    public function message()
    {
        $uid = Yii::$app->user->id;

        if (!$uid) {
            throw new LoginException(ErrorCode::EC_USER_TOKEN_EXPIRE);
        }
        // 所有消息置位已读
        UserMessage::updateAll(['status' => UserMessage::STATUS_YES], ['uid' => $uid]);

        $dataProvider = new ActiveDataProvider([
            'query' => UserMessage::find()
                ->where(['uid' => $uid])
                ->orderBy(['created_at' => SORT_DESC])
        ]);
        $data = $dataProvider->setPagination()->toArray();

        foreach ($data['list'] as &$v) {
            $v['title']   = UserMessage::$messageMap[$v['type']];
            $v['content'] = $v['type'] ==  UserMessage::TYPE_MESSAGE ? $v['content'] : '回复内容：' . $v['content'];
            $v['data']    = $v['created_at'];
            unset($v['created_at']);
            unset($v['type']);
        }
        Yii::warning($data['list']);
        return $data;
    }

    /**
     * 注销帐号
     * @throws \yii\db\Exception
     */
    public function cancelAccount()
    {
        $user = Yii::$app->user;
        // 检测用户之前是否注册过
        $redis = new RedisStore();
        $lockKey = RedisKey::getCancelAccountLock($user->udid);
        if ($redis->exists($lockKey) && $redis->get($lockKey)) {
            throw new ApiException(ErrorCode::EC_CANCEL_ACCOUNT);
        }

        $log = new CancelAccountLog();
        $log->uid = $user->uid;
        if (!$log->save()) {
            throw new ApiException(ErrorCode::EC_SYSTEM_ERROR);
        }
        $redis->setEx($lockKey, 1, 1296000); // 15天
        throw new ApiException(ErrorCode::EC_CANCEL_SUCCESS);
    }
}
