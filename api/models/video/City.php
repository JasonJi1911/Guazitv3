<?php
namespace api\models\video;

class City extends \common\models\video\City
{
    public function fields()
    {
        return [
            'city_id'   => 'id',
            'city_code',
            'city_name',
        ];
    }

//    public static function find()
//    {
//        return parent::find()->addOrderBy(['display_order' => SORT_ASC]);
//    }
}