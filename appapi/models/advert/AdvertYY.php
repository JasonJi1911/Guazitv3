<?php
namespace apinew\models\advert;

class AdvertYY extends \common\models\advert\AdvertYY
{
    public function fields()
    {
        return [
            'id',
            'yy_id',
            'title',
            'url',
            'display_order',
            'status'
        ];
    }

    public static function find()
    {
        return parent::find()->andWhere([self::tableName() . '.status' => self::STATUS_ENABLED])
            ->addOrderBy(['display_order' => SORT_DESC]);
    }
}
