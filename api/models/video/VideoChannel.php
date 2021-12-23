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
            'icon_gray' => function() {
                if($this->icon_gray){
                    return $this->icon_gray->toUrl();
                }else{
                    return '';
                }
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