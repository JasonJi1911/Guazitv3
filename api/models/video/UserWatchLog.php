<?php
namespace api\models\video;

use common\helpers\Tool;

class UserWatchLog extends \common\models\user\UserWatchLog
{
    public function fields()
    {
        return [
            'log_id' => 'id',
            'uid',
            'video_id',
            'chapter_id',
            'play_time' => function(){
                return Tool::timeToLong($this->time);
            },
            'time',
            'play_date' => function(){
                return date('Y-m-d', $this->updated_at);
            },
        ];

    }

    public static function find()
    {
        return parent::find()->addOrderBy(['updated_at' => SORT_DESC]);
    }

}