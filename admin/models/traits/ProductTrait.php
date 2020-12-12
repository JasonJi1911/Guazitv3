<?php
namespace admin\models\traits;

use common\models\traits\ProductInterface;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * 产品线Trait
 */
trait ProductTrait
{
    /**
     * @inheritdoc
     */
    public static function currentProduct()
    {
        $map = [
            'app'  => ProductInterface::PRODUCT_APP,
            'mp'   => ProductInterface::PRODUCT_MP,
            'wap'  => ProductInterface::PRODUCT_MP,
            'pc'   => ProductInterface::PRODUCT_PC,
        ];

        return ArrayHelper::getValue($map, Yii::$app->controller->module->id);
    }
}
