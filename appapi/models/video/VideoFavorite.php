<?php
namespace apinew\models\video;

class VideoFavorite extends \common\models\video\VideoFavorite
{
    public function fields()
    {
        return [
            'uid',
            'video_id',
            'chapter_id',
            'status',
            'created_at'
        ];
    }

    public static function find()
    {
        return parent::find()->addOrderBy(['created_at' => SORT_DESC]);
    }
}