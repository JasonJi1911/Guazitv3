<?php
namespace apinew\models\video;

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
            'watchplay_time'=>function(){
                return date('H:i', $this->updated_at);
            },
            'total_time',
            'created_at',
            'updated_at'
        ];

    }

    public static function find()
    {
        return parent::find()->addOrderBy(['updated_at' => SORT_DESC]);
    }

    public function getVideo(){
        return $this->hasOne(Video::className(), ['video_id' => 'id']);
    }

}