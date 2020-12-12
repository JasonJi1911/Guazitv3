<?php
namespace api\models\video;

class VideoYear extends \common\models\video\VideoYear
{
    public function fields()
    {
        return [
            'year_id' => 'id',
            'year'
        ];
    }

    public static function find()
    {
        return parent::find()->addOrderBy(self::tableName() . '.display_order desc');
    }
}