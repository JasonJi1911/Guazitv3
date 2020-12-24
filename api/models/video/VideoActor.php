<?php
namespace api\models\video;

use api\models\video\Actor;

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

    public function getActor()
    {
        return $this->hasMany(Actor::className(), ['actor_id' => 'actor_id']);
    }
}