<?php
namespace common\models\traits;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * 来源渠道Trait
 */
trait FromChannelTrait
{
    /**
     * @var array 来源渠道
     */
    public static $fromChannelTexts = [
        //self::FROM_CHANNEL_UNKNOWN  => '未知',
        self::FROM_CHANNEL_ANDROID  => 'Android',
        self::FROM_CHANNEL_IOS      => 'iOS',
        self::FROM_CHANNEL_MP       => '公众号',
        self::FROM_CHANNEL_WAP      => 'WAP',
        self::FROM_CHANNEL_PC       => 'PC',
    ];

    /**
     * 获取终端来源文本
     * @return string
     */
    public function getFromChannelText()
    {
        return ArrayHelper::getValue(self::$fromChannelTexts, $this->from_channel);
    }
}
