<?php
namespace common\models\traits;

/**
 * 频道接口
 */
interface GoodsTypeInterface
{
    // 频道常量
    const TYPE_COUPON   = 1;
    const TYPE_VIP      = 2;

    /**
     * 获取频道名称
     * @return string
     */
    public function getTypeName();
}
