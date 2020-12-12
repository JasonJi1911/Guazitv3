<?php
namespace admin\models\pay;

class AppleTrade extends \common\models\pay\AppleTrade
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'price', 'is_used', 'updated_at', 'created_at'], 'integer'],
            [['trade_no', 'product_id', 'apple_trade_id'], 'string', 'max' => 64],
            [['ip'], 'string', 'max' => 15],
            [['apple_trade_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户ID',
            'trade_no' => '内部交易号',
            'product_id' => '交易商品ID',
            'apple_trade_id' => '苹果交易号',
            'price' => '价格 单位：分',
            'is_used' => '1-凭证未使用 2-凭证已使用',
            'ip' => 'ip地址',
            'updated_at' => '更新时间',
            'created_at' => '创建时间',
        ];
    }
}
