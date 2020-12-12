<?php
namespace common\models\traits;

/**
 * 频道接口
 */
interface ChannelInterface
{
    // 频道常量
    const CHANNEL_MALE   = 1;
    const CHANNEL_FEMALE = 2;

    /**
     * 获取频道名称
     * @return string
     */
    public function getChannelName();
}
