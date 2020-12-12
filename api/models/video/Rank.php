<?php
namespace api\models\video;

class Rank extends \common\models\video\Rank
{
    public function fields()
    {
        return [
            'rank_id' => 'id',
            'channel_id',
            'title',
            'description',
            'display_order'
        ];
    }

    public static function find()
    {
        return parent::find()
            ->andWhere([self::tableName() . '.status' => self::STATUS_ENABLED])
            ->orderBy(self::tableName() . '.display_order desc');
    }
}