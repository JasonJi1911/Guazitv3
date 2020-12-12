<?php
namespace common\models\traits;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * 支付渠道Trait
 */
trait PayChannelTrait
{
    /**
     * @var array 支付渠道
     */
    public static $payChannels = [
        self::PAY_CHANNEL_APPLEPAY  => '苹果支付',
        self::PAY_CHANNEL_ALIPAY    => '支付宝',
        self::PAY_CHANNEL_WXPAY     => '微信',
        self::PAY_CHANNEL_UNKNOWN   => '未知',
        self::PAY_CHANNEL_GOOGLE    => '谷歌支付',
        self::PAY_CHANNEL_THIRD     => '三方支付',
        self::PAT_SIGN              => '签到获取',
        self::PAY_SYSTEM_GIVE       => '系统赠送',
    ];

    /**
     * 获取支付渠道
     * @return mixed
     */
    public function getPayChannelName() {
        return ArrayHelper::getValue(static::$payChannels, $this->pay_channel);
    }

}
