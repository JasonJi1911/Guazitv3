<?php
namespace api\models\video;

class TopicVideo extends \common\models\video\TopicVideo
{
    public function fields()
    {
        return [
            'topic_id',
            'video_id',
            'display_order',
        ];
    }

    public static function find()
    {
        return parent::find()->orderBy('display_order desc');
    }
}