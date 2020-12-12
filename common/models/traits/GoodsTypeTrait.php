<?php
namespace common\models\traits;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * 频道Trait
 */
trait GoodsTypeTrait
{
    /**
     * @var array 频道
     */
    public static $goodsTypeMap = [
        self::TYPE_COUPON   => '卡券',
        self::TYPE_VIP      => '会员',
    ];

    /**
     * 获取频道名称
     * @return string
     */
    public function getTypeName()
    {
        return ArrayHelper::getValue(static::$goodsTypeMap, $this->type);
    }
}
