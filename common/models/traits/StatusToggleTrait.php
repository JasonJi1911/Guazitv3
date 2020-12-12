<?php

namespace common\models\traits;

trait StatusToggleTrait
{
    /**
     * 启用
     * @return boolean
     */
    public function enable()
    {
        $this->status = static::STATUS_ENABLED;
        return $this->save(false);
    }

    /**
     * 禁用
     * @return boolean
     */
    public function disable()
    {
        $this->status = static::STATUS_DISABLED;
        return $this->save(false);
    }

    /**
     * 切换状态
     * @return boolean
     */
    public function toggle()
    {
        if ($this->isEnabled) {
            return $this->disable();
        } else {
            return $this->enable();
        }
    }

    /**
     * 是否已启用
     * @return boolean
     */
    public function getIsEnabled()
    {
        return $this->status == static::STATUS_ENABLED;
    }

    /**
     * 是否已禁用
     * @return boolean
     */
    public function getIsDisabled()
    {
        return $this->status == static::STATUS_DISABLED;
    }
}
