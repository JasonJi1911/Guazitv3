<?php

namespace common\models\traits;

/**
 * 位置接口
 */
interface PositionInterface
{
    // 产品类型常量
    const POSITION_MAN_INDEX    = 1;
    const POSITION_FEMALE_INDEX = 2;
    const POSITION_DISCOVER     = 3;
  
    /**
     * 获取全部位置名称
     * @return array
     */
    public static function positionTexts();

    /**
     * 获取当前产品线名称
     * @return string
     */
    public function getPositionText();
}
