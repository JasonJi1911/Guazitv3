<?php
namespace api\models\video;

class Industry extends \common\models\video\Industry
{
    public function fields()
    {
        return [
            'industry_id' => 'id',
            'industry_name',
            'display_order',
            'remark'
        ];
    }

    public static function find()
    {
        return parent::find()->addOrderBy(['display_order' => SORT_ASC]);
    }
}