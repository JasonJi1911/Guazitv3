<?php
namespace api\models\video;

class ActorArea extends \common\models\video\ActorArea
{
    public function fields()
    {
        return [
            'area_id'    => 'id',
            'area_label' => 'area'
        ];
    }

    public static function find()
    {
        return parent::find()->addOrderBy(['display_order' => SORT_DESC]);
    }
}