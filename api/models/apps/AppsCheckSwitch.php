<?php
namespace api\models\apps;

class AppsCheckSwitch extends \common\models\apps\AppsCheckSwitch
{
    public function fields()
    {
        return [
            'version_id',
            'market_id',
            'status'
        ];
    }
}
