<?php
namespace api\models\video;

class VideoActor extends \common\models\video\VideoActor
{
    public function fields()
    {
        return [
            'video_id',
            'actor_id',
        ];
    }

    public static function find()
    {
        return parent::find()->addOrderBy(['display_order' => SORT_DESC]);
    }
}