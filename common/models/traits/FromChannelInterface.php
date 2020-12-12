<?php

namespace common\models\traits;

/**
 * 端类型接口
 */
interface FromChannelInterface
{
    // 终端来源常量
    const FROM_CHANNEL_UNKNOWN  = 0;
    const FROM_CHANNEL_ANDROID  = 1;
    const FROM_CHANNEL_IOS      = 2;
    const FROM_CHANNEL_MP       = 3;
    const FROM_CHANNEL_WAP      = 4;
    const FROM_CHANNEL_PC       = 5;

    /**
     * 获取渠道名
     * @return string
     */
    public function getFromChannelText();
}
