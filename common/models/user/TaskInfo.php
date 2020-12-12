<?php

namespace common\models\user;

use common\behaviors\UploadBehavior;
use common\models\traits\SchemeTrait;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%task_info}}".
 *
 * @property int $id
 * @property string $title 任务标题
 * @property string $icon 任务icon
 * @property string $desc 任务描述
 * @property int $award_num 奖励
 * @property int $award_type 奖励类型，1：金币，2会员
 * @property int $task_type 任务类型，0：新手任务,1：每日任务
 * @property string $task_action 任务动作
 * @property int $limit_num 限制次数
 * @property int $status 状态，1显示 2隐藏
 * @property int $display_order 排序
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class TaskInfo extends \xiang\db\ActiveRecord implements StatusToggleInterface
{
    use StatusToggleTrait,SchemeTrait;

    /**
     * @var array 状态
     */
    /**
     * 状态数组
     */
    public static $statusMap = [
        self::STATUS_ENABLED  => '开启',
        self::STATUS_DISABLED => '关闭',
    ];

    const TASK_TYPE_NEW   = 0;  //新手任务
    const TASK_TYPE_DAILY = 1;  //每日任务

    //任务类型
    public static $typeMap = [
        self::TASK_TYPE_DAILY => '每日任务',
        self::TASK_TYPE_NEW   => '新手任务'
    ];
    // 新手任务
    const TASK_ACTION_GIFT           = 1; //新手礼包
    const TASK_ACTION_RECHARGE_VIP   = 2; //首次开通会员
    const TASK_ACTION_FIRST_RECHARGE = 3; //首次充值观影券
    const TASK_ACTION_BIND_WECHAT    = 4; //绑定微信
    const TASK_ACTION_BIND_MOBILE    = 5; //绑定手机
    // 每日任务
    const TASK_ACTION_SHARE_APP    = 6; //分享得积分
    const TASK_ACTION_READ_ADVERT  = 7; //看一看，赢积分
    const TASK_ACTION_COMMENT_ONCE = 8; //评论视频
    const TASK_ACTION_PLAY_VIDEO   = 9; //观看视频一分钟

    // 点击任务跳转
    public static $taskActionMap = [
        self::TASK_ACTION_GIFT           => 'login',       // 登录
        self::TASK_ACTION_RECHARGE_VIP   => 'vip_center',  // 购买vip
        self::TASK_ACTION_FIRST_RECHARGE => 'recharge',    // 购买券
        self::TASK_ACTION_BIND_WECHAT    => 'user_info',   // 绑定微信
        self::TASK_ACTION_BIND_MOBILE    => 'user_info',   // 绑定手机

        self::TASK_ACTION_SHARE_APP    => 'share_app', // 分享APP
        self::TASK_ACTION_READ_ADVERT  => 'index',     // 首页
        self::TASK_ACTION_COMMENT_ONCE => 'index',     // 首页
        self::TASK_ACTION_PLAY_VIDEO   => 'index',     // 首页
    ];


    const AWARD_TYPE_SCORE = 1; // 积分
    const AWARD_TYPE_VIP  = 2; // 会员
    const AWARD_TYPE_COUPON  = 3; // 卡券

    public static $awardTypeMap = [
        self::AWARD_TYPE_SCORE  => '积分',
        self::AWARD_TYPE_VIP    => '会员',
        self::AWARD_TYPE_COUPON => '卡券'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%task_info}}';
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['upload'] = [
            'class'  => UploadBehavior::className(),
            'config' => [
                'icon' => [ //竖封面
                    'extensions' => UploadBehavior::$imageExtensions,
                    'maxSize'    => 1024 * 1024 , // 100K
                    'required'   => false,
                    'dir'        => 'task_icon/'. date('Ym'),
                ]
            ],
        ];

        return $behaviors;
    }
}
