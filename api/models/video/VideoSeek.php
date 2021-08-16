<?php
namespace api\models\video;

class VideoSeek extends \common\models\video\VideoSeek
{
    public function fields()
    {
        return [
            'seek_id' => 'id',
            'video_name',
            'channel_id',
            'area_id',
            'year',
            'director_name',
            'actor_name'
        ];
    }

    public static function find()
    {
        return parent::find()->addOrderBy(['created_at' => SORT_DESC]);
    }
}