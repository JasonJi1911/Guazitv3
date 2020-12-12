<?php
namespace api\models;

use Yii;

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
        return Yii::$app->request->product;
    }
}
