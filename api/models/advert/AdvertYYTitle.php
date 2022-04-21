<?php
namespace api\models\advert;

class AdvertYYTitle extends \common\models\advert\AdvertYYTitle
{
    public function fields()
    {
        return [
            'id',
            'title',
            'city_id',
            'display_order',
            'status',
            'product'
        ];
    }

    public static function find()
    {
        return parent::find()->andWhere([self::tableName() . '.status' => self::STATUS_ENABLED])
            ->addOrderBy(['display_order' => SORT_DESC]);
    }
}
