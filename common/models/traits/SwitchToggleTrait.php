<?php

namespace common\models\traits;

trait SwitchToggleTrait
{
    public static $itemsMap = [
        self::SWITCH_OPEN => '开启',
        self::SWITCH_CLOSE => '关闭',
    ];

    /**
     * 启用
     * @param $attribute
     * @return bool
     */
    public function turnOn($attribute)
    {
        $this->$attribute = self::SWITCH_OPEN;
        return $this->save(false);
    }

    /**
     * 禁用
     * @param $attribute
     * @return bool
     */
    public function turnOff($attribute)
    {
        $this->$attribute = self::SWITCH_CLOSE;
        return $this->save(false);
    }

    /**
     * 切换状态
     * @param $attribute
     * @return bool
     */
    public function toggle($attribute)
    {
        if ($this->isOn) {
            return $this->turnOff($attribute);
        } else {
            return $this->turnOn($attribute);
        }
    }

    /**
     * 是否已启用
     * @param $attribute
     * @return bool
     */
    public function getIsOn($attribute)
    {
        return $this->$attribute == self::SWITCH_OPEN;
    }

    /**
     * 是否已禁用
     * @param $attribute
     * @return bool
     */
    public function getIsOff($attribute)
    {
        return $this->$attribute == self::SWITCH_CLOSE;
    }
}
