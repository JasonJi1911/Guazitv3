<?php
namespace api\models\user;

use common\helpers\Tool;

class UserCoupon extends \common\models\user\UserCoupon
{
    public function fields()
    {
        return [
            'uid',
            'num',
            'recv_time',
            'use_time',
            'expire_time' => function() {
                return date('Y-m-d H:i:s', $this->expire_time);
            },
            'video_id',
            'type'
        ];
    }

    public static function find()
    {
        return parent::find()->addOrderBy([self::tableName() . '.use_time' => SORT_DESC, self::tableName() . '.recv_time' => SORT_DESC, self::tableName() . '.updated_at' => SORT_DESC]);
    }
}
