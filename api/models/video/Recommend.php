<?php
namespace api\models\video;

class Recommend extends \common\models\video\Recommend
{
    public function fields()
    {
        return [
            'recommend_id' => 'id',
            'channel_id',
            'title',
            'style',
            'search',
            'description'
        ];
    }

    public static function find()
    {
        return parent::find()
            ->andWhere([self::tableName().'.status' => self::STATUS_ENABLED])
            ->orderBy(self::tableName() . '.display_order desc');
    }

    public static function selectLimit($style)
    {

    }
}