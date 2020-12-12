<?php

namespace common\models\pay;


use common\behaviors\UploadBehavior;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "bw_pay_channel".
 *
 * @property int $id id
 * @property string $channel_name 名称
 * @property string $channel_id 支付渠道id
 * @property int $channel_type 渠道类型 1原生 2三方web 3三方SDK
 * @property int $is_channel 是否支付通道 1是 0不是
 * @property int $min_price 支持的最小金额
 * @property int $max_price 支持的最大金额
 * @property int $pid 父级id
 * @property string $icon icon地址
 * @property int $status 状态 1开启 2关闭
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class PayChannel extends \xiang\db\ActiveRecord implements StatusToggleInterface
{
    use StatusToggleTrait;

    // 状态
    public static $statusMap = [
        self::STATUS_ENABLED => '开启',
        self::STATUS_DISABLED => '关闭'
    ];

    //渠道类型
    const CHANNEL_TYPE_NATIVE = 1; //原生支付
    const CHANNEL_TYPE_THIRD_WAP = 2; //三方wap 浏览器打开
    const CHANNEL_TYPE_THIRD_SDK = 3; //三方sdk
    const CHANNEL_TYPE_THIRD_WEBVIEW = 4; //三方wap webView打开

    //支付平台
    const CHANNEL_NAME_WECHAT = 'wechat';
    const CHANNEL_NAME_ALIPAY = 'alipay';
    const CHANNEL_NAME_CUSTOM = 'custom';

    //是否支付通道
    const IS_CHANNEL_YES = 1; //是支付通道
    const IS_CHANNEL_NO = 0; //不是支付通道

    //渠道支付的api地址
    public static $channelPayApi = [
        self::CHANNEL_NAME_CUSTOM => '/pay-support/custom',
    ];

    /**
     * 支付渠道类型
     * @var array
     */
    public static $channelTypeTexts = [
        self::CHANNEL_TYPE_NATIVE => '原生支付',
        self::CHANNEL_TYPE_THIRD_WAP => 'WAP支付(浏览器打开)',
        self::CHANNEL_TYPE_THIRD_SDK => '三方SDK',
        self::CHANNEL_TYPE_THIRD_WEBVIEW => 'WAP支付(APP内打开)',
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['upload'] = [
            'class'  => UploadBehavior::className(),
            'config' => [
                'icon' => [
                    'extensions' => UploadBehavior::$imageExtensions,
                    'maxSize'    => 1024 * 1024 , // 1M
                    'required'   => false,
                    'dir'        => 'pay/',
                ]
            ],
        ];

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pay_channel}}';
    }
}
