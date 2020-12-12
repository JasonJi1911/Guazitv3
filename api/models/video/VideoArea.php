<?php
namespace api\models\video;

class VideoArea extends \common\models\video\VideoArea
{
    public function fields()
    {
        return [
            'area_id' => 'id',
            'area',
        ];
    }

    public static function find()
    {
        return parent::find()->addOrderBy([self::tableName() . '.display_order' => SORT_DESC]);
    }
}