<?php

namespace common\models\traits;

/**
 * 切换接口
 */
interface StatusToggleInterface
{
    // 状态常量
    const STATUS_ENABLED  = 1;
    const STATUS_DISABLED = 2;

    /**
     * 启用
     * @return boolean
     */
    public function enable();

    /**
     * 禁用
     * @return boolean
     */
    public function disable();

    /**
     * 切换状态
     * @return boolean
     */
    public function toggle();

    /**
     * 是否已启用
     * @return boolean
     */
    public function getIsEnabled();

    /**
     * 是否已禁用
     * @return boolean
     */
    public function getIsDisabled();
}
