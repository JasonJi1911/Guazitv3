<?php
namespace api\models\apps;

class AppsMarketChannel extends \common\models\apps\AppsMarketChannel
{
    public function fields()
    {
        return [
            'id',
            'key',
        ];
    }
}
