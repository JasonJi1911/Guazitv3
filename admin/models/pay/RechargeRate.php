<?php
namespace admin\models\pay;

class RechargeRate extends \common\models\RechargeRate
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rate', 'pay_channel', 'status', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['status', 'pay_channel'], 'unique', 'targetAttribute' => ['status', 'pay_channel']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rate' => '充值比例',
            'pay_channel' => '支付渠道',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}