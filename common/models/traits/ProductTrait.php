<?php
namespace common\models\traits;

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
    public static function productTexts()
    {
        return [
            self::PRODUCT_APP  => 'App',
            self::PRODUCT_MP  => 'Wap',
            self::PRODUCT_PC   => 'PC',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getProductText()
    {
        return ArrayHelper::getValue(static::productTexts(), $this->product);
    }

    /**
     * @inheritdoc
     */
    public static function currentProduct()
    {
    }
    
    /**
     * @inheritdoc
     */
    public static function find()
    {
        //连表查询的时候，多张表有product时，指定一张表的product
        return parent::find()->andWhere([self::tableName().'.product' => static::currentProduct()]);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        //根据module取当前产品线
        $product = static::currentProduct();
        if ($product) {
            $this->product = $product;
        }

        return true;
    }
}
