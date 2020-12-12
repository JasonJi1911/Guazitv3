<?php
namespace api\models\video;

class Actor extends \common\models\video\Actor
{
    public function fields()
    {
        return [
            'actor_id',
            'area_id',
            'actor_name',
            'avatar' => function() {
                return $this->avatar->toUrl();
            },
            'type' => function() {
                return $this->type;
            },
            'type_name' => function() {
                return self::$actionMap[$this->type];
            }
        ];
    }

    public static function find()
    {
        return parent::find()->addOrderBy([self::tableName() . '.type' => SORT_DESC, self::tableName() . '.weight' => SORT_DESC]);
    }
}