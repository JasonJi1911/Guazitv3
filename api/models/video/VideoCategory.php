<?php
namespace api\models\video;

class VideoCategory extends \common\models\video\VideoCategory
{
    /**
     * @return array|false
     * 字段名称
     */
    public function fields()
    {
        return [
            'cat_id' => 'id',
            'channel_id',
            'name' => 'title',
            'description',
            'display_order',
            'created_at'
        ];
    }

    public static function find()
    {
        return parent::find()->orderBy(self::tableName() . '.display_order desc');
    }


}