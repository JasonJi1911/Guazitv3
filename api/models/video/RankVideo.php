<?php
namespace api\models\video;

class RankVideo extends \common\models\video\RankVideo
{
    public function fields()
    {
        return [
            'rank_id',
            'video_id',
            'period',
            'display_order'
        ];
    }
}
