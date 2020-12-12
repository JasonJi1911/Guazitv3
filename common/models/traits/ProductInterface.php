<?php

namespace common\models\traits;

/**
 * 产品线接口
 */
interface ProductInterface
{
    // 产品类型常量
    const PRODUCT_UNKNOWN = 0;
    const PRODUCT_APP  = 1;
    const PRODUCT_MP   = 2;
    const PRODUCT_PC   = 3;

    /**
     * 获取全部产品线名称
     * @return array
     */
    public static function productTexts();

    /**
     * 获取当前产品线名称
     * @return string
     */
    public function getProductText();
}
