<?php

namespace appapi\models\video;

class TrailerTitle extends \common\models\video\TrailerTitle
{
    public function fields()
    {
        return [
            'trailer_title_id' => 'id',
            'channel_id',
            'title',
            'content',
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