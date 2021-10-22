<?php
namespace api\models\video;

class VideoFeedback extends \common\models\video\VideoFeedback
{
    public function fields()
    {
        return [
            'id',
            'country',
            'internets',
            'systems',
            'browsers',
            'description',
            'video_id',
            'chapter_id',
            'source_id',
            'uid'
        ];
    }

    public static function find()
    {
        return parent::find()->addOrderBy(['created_at' => SORT_DESC]);
    }
}