<?php
namespace api\models\video;

class Banner extends \common\models\video\Banner
{
    /**
     * @return array|false
     */
    public function fields()
    {
        return [
            'id',
            'channel_id',
            'title',
            'image' => function($model) {
                return $model->image->toUrl();
            },
            'action',
            'content',
            'display_order',
            'product',
            'stitle',
        ];
    }


    public static function find()
    {
        return parent::find()->andWhere([self::tableName() . '.status' => self::STATUS_ENABLED])->orderBy(self::tableName() . '.display_order desc');
    }

}