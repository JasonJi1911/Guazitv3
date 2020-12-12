<?php
namespace api\models\video;

class HotRecommend extends \common\models\video\HotRecommend
{
    public function fields()
    {
        return [
            'recommend_id',
            'title'
        ];
    }

    public static function find()
    {
        return parent::find()->andWhere(['status' => self::STATUS_ENABLED])->addOrderBy(['display_order' => SORT_DESC]);
    }
}