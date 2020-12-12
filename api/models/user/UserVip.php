<?php
namespace api\models\user;

class UserVip extends \common\models\user\UserVip
{
    public function fields()
    {
        return [
            'start_time',
            'continue_time',
            'end_time'
        ];
    }

}
