<?php
namespace api\logic;

use api\dao\CommonDao;
use api\dao\TaskDao;
use api\dao\UserDao;
use api\exceptions\LoginException;
use api\helpers\ErrorCode;
use api\models\advert\AdvertPosition;
use api\models\pay\Expend;
use api\models\user\Sign;
use api\models\user\SignLog;
use api\models\user\SignStatus;
use api\models\user\TaskInfo;
use api\models\user\UserAssets;
use api\models\user\UserTask;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\helpers\Tool;
use common\models\traits\ProductInterface;
use common\models\user\User;
use common\models\user\UserCoupon;
use common\services\PayService;
use Yii;

/**
 * 任务和签到相关逻辑层
 * Class TaskLogic
 * @package api\logic
 */
class TaskLogic
{
    /**
     * 完成任务情况
     * @param $uid
     * @return array
     */
    public function finishStatus($uid)
    {
        $commonDao  = new CommonDao();
        $taskList   = $commonDao->getTaskList();

        if (!$uid) { // 没有用户时候,任务完成数0
            return [
                'finish_num'    => 0,
                'mission_num'   => count($taskList),
            ];
        }

        $userDao    = new UserDao();
        $finishTask = $userDao->finishTask($uid);

        return [
            'finish_num'    => count($finishTask),
            'mission_num'   => count($taskList),
        ];
    }

    /**
     * 完成任务
     * @param int $taskId
     * @param int $uid 传入uid
     * @return bool
     * @throws \api\exceptions\LoginException
     */
    public function finishTask($taskId, $uid = 0)
    {
        if (!$uid) { // 没有传入uid,则以登录uid为准
            $uid = Yii::$app->user->id;
        }
        if (!$uid) { // 未登录提示
            throw new LoginException(ErrorCode::EC_USER_TOKEN_EXPIRE);
        }

        if (!TASK_AWARD_SWITCH) { //任务奖励开关
            return true;
        }
        // 判断是否是APP
        if (Yii::$app->common->product != ProductInterface::PRODUCT_APP
            && !(in_array($taskId, [TaskInfo::TASK_ACTION_RECHARGE_VIP, TaskInfo::TASK_ACTION_FIRST_RECHARGE]))) { //不是APP直接返回true
            return true;
        }

        //锁判断
        $redis = new RedisStore();
        $lockKey = RedisKey::getApiLockKey('task/finish', [
            'uid'     => $uid,
            'task_id' => $taskId
        ]);
        if ($redis->checkLock($lockKey)) {
            $redis->releaseLock($lockKey);
            return false;
        }

        $taskInfo = TaskInfo::findOne($taskId);
        //如果任务下线直接返回
        if ($taskInfo->status != TaskInfo::STATUS_ENABLED) {
            return true;
        }

        //查询条件
        $condition = ['uid' => $uid, 'task_id' => $taskId];
        if ($taskInfo->task_type == TaskInfo::TASK_TYPE_DAILY) { //每日任务
            $condition['date'] = date('Ymd');
        }
        // 判断是否达到完成次数
        $count = UserTask::find()
             ->where($condition)
             ->count();
        if ($count >= $taskInfo->limit_num) {
            $redis->releaseLock($lockKey);
            return false;
        }

        // 奖励
        $payService = new PayService();
        if ($taskInfo->award_type == TaskInfo::AWARD_TYPE_VIP) { // 奖励会员
            $payService->givingVip($uid, $taskInfo->award_num * 86400); // 赠送vip天数
            $silver_num = $taskInfo->award_num;
            $trade_no = Tool::makeOrderNo($uid);
        } else if ($taskInfo->award_type == TaskInfo::AWARD_TYPE_COUPON) { // 卡券
            // 增加卡券
            list($trade_no, $silver_num) = $payService->interfaceCoupon($uid, UserCoupon::TYPE_GET, $taskInfo->award_num);
        } else { // 积分
            //赠送金币
            list($trade_no, $silver_num) = $payService->interfacePay($uid, Expend::TYPE_TASK, $taskInfo->award_num, $taskInfo->desc);
        }
        if (empty($trade_no)) {
            $redis->releaseLock($lockKey);
            return false;
        }

        $userTask = new UserTask();
        $userTask->uid       = $uid;
        $userTask->date      = date('Ymd');
        $userTask->task_type = $taskInfo->task_type;
        $userTask->award     = $silver_num;
        $userTask->expend_no = $trade_no;
        $userTask->task_id   = $taskId;
        $userTask->save();

        $redis->releaseLock($lockKey);
        return true;
    }



    /**
     * 任务中心
     */
    public function taskCenter()
    {
        $user = Yii::$app->user;
        $signDays   = 0; //连续签到天数
        $signStatus = 0; //今天是否签到
        //获取签到信息
        if ($user->id && $objSignStatus = SignStatus::findOne(['uid' => $user->id])) {
            $signDays = $objSignStatus->sign_days;
            //查询当天签到状态
            $objSignLog = SignLog::findOne(['uid' => $user->id, 'date' => date('Ymd')]);
            if ($objSignLog) {
                $signStatus = 1;
            } else {
                $signStatus = 0;
            }
        }

        $signInfo = Sign::find()->all();
        $signList = [];
        foreach ($signInfo as $sign) {
            $signList[] = [
                "label"  => $sign->day . "天",
                "award"  => $sign->score, // 奖励
                "status" => $sign->day > $signDays ? 0 : 1, // 当前天数大于连续签到天数即为未签到
            ];
        }
        // 任务信息
        $taskInfo = $this->taskInfo();

        $userLogic = new UserLogic();
        $assets = $userLogic->assets();

        // 获取广告
        $advertLogic = new AdvertLogic();
        $advert = $advertLogic->advertByPosition(AdvertPosition::POSITION_SIGN);

        return [
            'info' => [
                'score' => !empty($assets) ? $assets->score_remain : 0,
                'rules' => Yii::$app->setting->get('rules.task_intro'),
            ],
            'advert' => !empty($advert) ? $advert : (object)$advert,
            'task_menu' => [
                [
                    'task_title' => '日常任务',
                    'task_list'  => $taskInfo['dailyTasks']
                ],
                [
                    'task_title' => '新手任务',
                    'task_list' => $taskInfo['newTasks']
                ],
            ],
            'sign_info' => [
                'sign_status' => $signStatus,
                'sign_days'   => $signDays,
                'sign_list'   => $signList,
            ],
        ];
    }

    /**
     * 任务详情
     * @return array
     */
    public function taskInfo()
    {
        $user = Yii::$app->user;
        // 积分(单位)
        $unit = Yii::$app->setting->get('system.currency_unit');

        $newTasks = $dailyTasks = [];
        $finishedNum = 0;
        // 获取任务详情
        $taskDao = new TaskDao();
        $tasks = $taskDao->taskInfo();
        foreach ($tasks as $task) {
            $taskState = 0;
            // 任务完成个数
            $finishTaskNum = intval($this->finishTaskNum($user->id, $task['task_id']));
            if ($user && ($finishTaskNum >= $task['limit_num'])) {  //已登录状态判断完成任务情况
                $taskState = 1;
                $finishedNum++;
            }
            $data = [
                'task_id'     => $task['task_id'],
                'task_label'  => $task['title'] . '（'  . STYLE_SIGN . $finishTaskNum . STYLE_SIGN .  '/' . $task['limit_num'] . '）',
                'task_award'  => '+' . $task['award_num'] . $unit,
                'task_desc'   => $task['desc'],
                'task_icon'   => $task['icon'],
                'task_action' => isset(TaskInfo::$taskActionMap[$task['task_id']]) ? TaskInfo::$taskActionMap[$task['task_id']] : '',
                'task_state'  => $taskState,
            ];
            if ($task['task_type'] == TaskInfo::TASK_TYPE_NEW) {
                $newTasks[] = $data;
            } else {
                $dailyTasks[] = $data;
            }
        }

        return ['dailyTasks' => $dailyTasks, 'newTasks' => $newTasks];
    }


    /**
     * 用户任务完成次数
     * @param $uid
     * @param $taskId
     * @return bool
     */
    public function finishTaskNum($uid, $taskId)
    {
        // 查询任务
        $task = TaskInfo::findOne(['id' => $taskId]);
        $condition = ['uid' => $uid, 'task_id' => $taskId];
        if ($task->task_type == TaskInfo::TASK_TYPE_DAILY) {
            $condition['date'] = date('Ymd');
        }
        return UserTask::find()->where($condition)->count();
    }

    /**
     * 用户任务完成任务状态
     * @param $uid
     * @param $taskId
     * @return bool
     */
    public function taskStatus($uid, $taskId)
    {
        // 查询任务
        $task = TaskInfo::findOne(['id' => $taskId]);
        $condition = ['uid' => $uid, 'task_id' => $taskId];
        if ($task->task_type == TaskInfo::TASK_TYPE_DAILY) {
            $condition['date'] = date('Ymd');
        }
        $num = UserTask::find()->where($condition)->count();
        
        return $num >= $task->limit_num ? true : false;
    }
}
