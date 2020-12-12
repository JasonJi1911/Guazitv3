<?php
namespace common\models\traits;

/**
 * 来源接口
 */
interface SourceInterface
{
    // 来源常量
    const SOURCE_PC          = 1; // pc站
    const SOURCE_WAP         = 2; // wap站
    const SOURCE_ANDROID_APP = 3; // 安卓app
    const SOURCE_IOS_APP     = 4; // ios app
    const SOURCE_MP          = 5; // 公众号
    const SOURCE_MINI_APP    = 6; // 小程序
    const SOURCE_SYSTEM      = 7; // 系统

    /**
     * 获取来源名称
     * @return string
     */
    public function getSourceText();
}
