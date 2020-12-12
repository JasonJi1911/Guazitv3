<?php
namespace api\models\advert;

class AdvertPosition extends \common\models\advert\AdvertPosition
{
    public function fields()
    {
        return [];
    }

    public static function find()
    {
        return parent::find()->andWhere([self::tableName() . '.status' => self::STATUS_ENABLED]);
    }
}
