<?php

namespace common\models\traits;

/**
 * 开关接口
 */
interface SwitchToggleInterface
{
    // 状态常量
    const SWITCH_OPEN   = 1;
    const SWITCH_CLOSE  = 2;

    /**
     * 开启
     * @param $attribute
     * @return bool
     */
    public function turnOn($attribute);

    /**
     * 关闭
     * @param $attribute
     * @return bool
     */
    public function turnOff($attribute);

    /**
     * 切换状态
     * @param $attribute
     * @return bool
     */
    public function toggle($attribute);

    /**
     * 是否已启用
     * @param $attribute
     * @return bool
     */
    public function getIsOn($attribute);

    /**
     * 是否已关闭
     * @param $attribute
     * @return bool
     */
    public function getIsOff($attribute);
}
