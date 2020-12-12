<?php
namespace api\models\pay;

class PayErrorLog extends \common\models\pay\PayErrorLog
{
    public function fields()
    {
        return [
            'date',
            'trade_no',
            'type',
            'uid'
        ];
    }
}
