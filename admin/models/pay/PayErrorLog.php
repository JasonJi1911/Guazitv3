<?php
namespace admin\models\pay;

class PayErrorLog extends \common\models\pay\PayErrorLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'type', 'uid', 'created_at'], 'integer'],
            [['note'], 'required'],
            [['trade_no'], 'string', 'max' => 32],
            [['out_trade_no'], 'string', 'max' => 64],
            [['note'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => '日期,年月日 20180808',
            'trade_no' => '内部交易号',
            'out_trade_no' => '外部交易号',
            'type' => '异常类型 1-验签失败 2-重复通知 3-支付失败 4-订单不存在 5-订单信息不一致...',
            'uid' => '用户ID',
            'note' => '备注信息',
            'created_at' => '创建时间',
        ];
    }
}
