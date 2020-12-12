<?php
namespace api\models\apps;

class AppsTencentInfo extends \common\models\apps\AppsTencentInfo
{
    public function fields()
    {
        return [
            'wechat_app_id',
            'wechat_app_secret',
            'qq_app_id'
        ];
    }
}
