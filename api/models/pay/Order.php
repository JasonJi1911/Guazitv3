<?php
namespace api\models\pay;

class Order extends \common\models\pay\Order
{
    public function fields()
    {
        return [
            'trade_no', 
            'original_fee', 
            'total_fee', 
            'pay_channel', 
            'goods_id', 
            'value', 
            'type', 
            'created_at'
        ];
    }

    /**
     * {@inheritdoc}
     * @return \xiang\db\ActiveQuery the newly created [[ActiveQuery]] instance.
     */
    public static function find()
    {
        return parent::find()->addOrderBy(['updated_at' => SORT_DESC]);
    }
}
