<?php
namespace api\models\video;

class VideoChannel extends \common\models\video\VideoChannel
{
    public function fields()
    {
        return [
            'channel_id' => 'id',
            'channel_name',
            'icon' => function() {
                return $this->icon->toUrl();
            },
            'description',
            'areas',
            'display_order',
            'created_at'
        ];
    }

    public static function find()
    {
        return parent::find()
            ->andWhere([self::tableName().'.status' => self::STATUS_ENABLED])
            ->addOrderBy(self::tableName() . '.display_order desc');
    }
}