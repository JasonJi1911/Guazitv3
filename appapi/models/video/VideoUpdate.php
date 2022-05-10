<?php

namespace apinew\models\video;

class VideoUpdate extends \common\models\video\VideoUpdate
{
    public function fields()
    {
        return [
            'video_update_id' => 'id',
            'video_id',
            'video_update_title_id',
            'title',
            'stitle',
            'week',
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
