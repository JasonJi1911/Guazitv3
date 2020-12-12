<?php
namespace admin\modules\api\models;

class VideoChapter extends \common\models\video\VideoChapter
{
    public $source;

    public function rules()
    {
        return [
            [['video_id', 'title', 'resource_url', 'play_limit', 'duration_time', 'display_order'], 'required'],

            [['video_id',  'total_views', 'display_order'], 'integer'],
            [['resource_url'], 'string', 'max' => 256],
            [['title'], 'string', 'max' => 64],
            [['source'], 'string', 'max' => 64],
        ];
    }
}
