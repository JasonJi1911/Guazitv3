<?php
namespace api\models\apps;

class PushPassageway extends \common\models\apps\PushPassageway
{
    public function fields()
    {
        return [
            'p_key',
            'app_id',
            'app_key',
            'app_secret'
        ];
    }
    
    public static function find()
    {
        return parent::find()->andWhere([self::tableName() . '.status' => self::STATUS_ENABLED]);
    }
}
