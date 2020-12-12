<?php
namespace api\models\video;

class VideoSource extends \common\models\video\VideoSource
{
    public function fields()
    {
        return [
            'source_id' => 'id',
            'name',
            'icon' => function(){
                return $this->icon->toUrl();
            }
        ];
    }

    public static function find()
    {
        return parent::find()->andWhere(['created_at' => 0])->orderBy(self::tableName() . '.display_order desc');
    }
}