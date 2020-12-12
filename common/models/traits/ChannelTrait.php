<?php
namespace common\models\traits;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * 频道Trait
 */
trait ChannelTrait
{
    /**
     * @var array 频道
     */
    public static $channels = [
        self::CHANNEL_MALE   => '男频',
        self::CHANNEL_FEMALE => '女频',
    ];

    /**
     * 获取频道名称
     * @return string
     */
    public function getChannelName()
    {
        return ArrayHelper::getValue(static::$channels, $this->channel_id);
    }
}
