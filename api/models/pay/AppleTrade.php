<?php
namespace api\models\pay;

class AppleTrade extends \common\models\pay\AppleTrade
{
    public function fields()
    {
        return [
            'uid',
            'trade_no',
            'product_id',
            'apple_trade_id',
            'price',
            'is_used'
        ];
    }
}
