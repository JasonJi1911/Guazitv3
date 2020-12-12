<?php
namespace api\models;

class Announcement extends \common\models\Announcement
{
    use ProductTrait;

    public function fields()
    {
        return [
            'title',
            'content'
        ];
    }

    public static function currentProduct()
    {
        return \Yii::$app->common->product;
    }

    public static function find()
    {
        return parent::find()->orderBy(self::tableName() . '.updated_at desc');
    }
}