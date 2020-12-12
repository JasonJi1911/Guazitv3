<?php

namespace common\models\user;

use common\behaviors\UploadBehavior;
use common\models\traits\ChannelInterface;
use common\models\traits\ChannelTrait;
use common\models\traits\FromChannelInterface;
use common\models\traits\FromChannelTrait;
use common\models\traits\SourceInterface;
use common\models\traits\SourceTrait;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use phpDocumentor\Reflection\Types\Self_;
use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $uid
 * @property string $mobile 手机号
 * @property string $nickname 昵称
 * @property string $udid 注册设备号 iOS:UDID,Android:IMEI
 * @property string $user_token token
 * @property string $password_hash password哈希
 * @property int $from_channel 端来源 1iOS 2Android 3wap 4PC
 * @property int $product 产品线 1App 2wap 3PC
 * @property int $from_market 市场渠道 0未知 1Apple
 * @property int $source 用户来源 1-pc 2-wap 3-app 4-wechat
 * @property int $gender 性别 1女 2男
 * @property string $avatar 头像
 * @property string $intro 个人简介
 * @property int $reg_type 1正常注册 2设备号注册
 * @property string $reg_ip 注册ip
 * @property int $reg_time 注册时间
 * @property string $last_login_ip 最后登录ip
 * @property int $last_login_time 最后登录时间
 * @property int $status 1正常 2封禁
 * @property string $salt 盐值
 * @property string $device_id 推送设备device_id
 * @property int $user_type 用户类型 1注册用户 2内置用户
 * @property string $last_device_id 最后登录设备id
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class User extends \xiang\db\ActiveRecord implements StatusToggleInterface, SourceInterface,FromChannelInterface
{
    use SourceTrait;
    use StatusToggleTrait;
    use FromChannelTrait;

    // 性别常量
    const GENDER_MALE   = 2;
    const GENDER_FEMALE = 1;
//    const GENDER_UNKNOWN = 0;
    
    //微信绑定状态
    const BIND_STATUS_NO = 0; //未绑定
    const BIND_STATUS_YES = 1; //绑定

    //注册类型
    const REG_TYPE_COMMON = 1;
    const REG_TYPE_DEVICE = 2; //设备登录
    const REG_TYPE_MOBILE = 3; // 手机号
    const REG_TYPE_WECHAT = 4; // 微信
    const REG_TYPE_QQ     = 5; // QQ

    //是否机器人
    const IS_ROBOT_NO  = 0; //否
    const IS_ROBOT_YES = 1; //是
    
    //市场渠道
    const FROM_MARKET_NO = 0;
    const FROM_MARKET_APP = 1;

    /**
     * @var array 状态
     */
    public static $statusMap = [
        self::STATUS_ENABLED  => '正常',
        self::STATUS_DISABLED => '封禁',
    ];

    /**
     * @var array 市场渠道
     */
    public static $marketMap = [
        self::FROM_MARKET_NO => '未知',
        self::FROM_MARKET_APP => 'app'
    ];

    /**
     * @var array 性别
     */
    public static $genderMap = [
        self::GENDER_MALE   => '男',
        self::GENDER_FEMALE => '女',
//        self::GENDER_UNKNOWN => '未知'
    ];

    public static $robotMap = [
        self::IS_ROBOT_NO => '否',
        self::IS_ROBOT_YES => '是'
    ];

    public static $regTypeMap = [
        self::REG_TYPE_COMMON => '正常注册',
        self::REG_TYPE_DEVICE => '设备注册',
    ];

    public static $sourceMap = [
        self::SOURCE_ANDROID_APP => '安卓',
        self::SOURCE_IOS_APP => 'ios'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
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
                'avatar' => [
                    'extensions' => UploadBehavior::$imageExtensions,
                    'maxSize'    => 1024 * 1024 , // 1M
                    'required'   => false,
                    'dir'        => 'video/avatar/' . date('Ymd'),
                ]
            ],
        ];

        return $behaviors;
    }
}
