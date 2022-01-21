<?php

namespace api\models\video;

class VideoUpdateTitle extends \common\models\video\VideoUpdateTitle
{
    public function fields()
    {
        return [
            'video_update_title_id' => 'id',
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
