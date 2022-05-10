<?php
namespace apinew\models\user;

class UserAuthApp extends \common\models\user\UserAuthApp
{
    public function fields()
    {
        return [
            'uid',
            'openid',
            'unionid',
            'name',
            'avatar',
            'type',
        ];
    }
}