<?php
namespace api\models\video;

class HotRecommendList extends \common\models\video\HotRecommendList
{
    public function fields()
    {
        return [
            'recommend_id',
            'video_id'
        ];
    }

    public static function find()
    {
        return parent::find()->addOrderBy(['display_order' => SORT_DESC]);
    }
}