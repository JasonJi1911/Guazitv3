<?php

namespace apinew\models\video;

class Trailer extends \common\models\video\Trailer
{
    public function fields()
    {
        return [
            'trailer_id' => 'id',
            'video_id',
            'trailer_title_id',
            'title',
            'stitle',
            'online_time',
            'display_order',
            'status',
            'created_at',
            'updated_at'
        ];
    }

    public static function find()
    {
        return parent::find()->andWhere([self::tableName() . '.status' => self::STATUS_ENABLED])->orderBy(self::tableName() . '.display_order desc');
    }
}