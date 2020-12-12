<?php
namespace admin\models\pay;
use admin\models\user\User;
use admin\models\video\Video;
use yii\helpers\ArrayHelper;
use Yii;

class Order extends \common\models\pay\Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['original_fee', 'total_fee', 'pay_channel', 'uid', 'from_uid', 'from_channel', 'goods_id', 'value', 'type', 'product', 'status', 'lid', 'gid', 'video_id', 'op_userid', 'op_time', 'is_rebate', 'notify_time', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['trade_no'], 'string', 'max' => 32],
            [['out_trade_no'], 'string', 'max' => 64],
            [['note'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 15],
            [['trade_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trade_no' => '交易号',
            'out_trade_no' => '外部交易号',
            'original_fee' => '原金额 单位：分',
            'total_fee' => '交易金额 单位：分',
            'pay_channel' => '支付类型 1-苹果支付 2-支付宝 3-微信支付 4-签到获取 5-系统赠送',
            'uid' => '充值账户ID',
            'from_uid' => '付费用户ID',
            'from_channel' => '来源渠道',
            'goods_id' => '商品id',
            'value' => '商品价值，会员为天数，卡券为数量',
            'type' => '类型',
            'product' => '产品线 1app 2公众号 3小程序',
            'status' => '交易状态 1-默认 2-交易成功 3-交易失败',
            'lid' => '推广链接id',
            'gid' => '代理id',
            'op_userid' => 'op操作用户uid',
            'op_time' => 'op操作时间',
            'is_rebate' => '是否扣量订单 1是 0不是',
            'note' => '备注',
            'ip' => 'ip地址',
            'notify_time' => '支付回调时间',
            'created_at' => '订单创建时间',
            'updated_at' => '订单更新时间',
            'deleted_at' => '订单删除时间',
        ];
    }

    /**
     * 关联用户
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['uid' => 'uid']);
    }

    /**
     * 关联影视
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'video_id']);
    }


    /**
     * 关联商品
     */
    public function getGoods()
    {
        return $this->hasOne(Goods::className(), ['id' => 'goods_id']);
    }

    /**
     * 获取支付渠道文本
     * @return string
     */
    public function getPayChannelText() {
        return ArrayHelper::getValue(static::$payChannels, $this->pay_channel);
    }

    /**
     * 获取支付状态文本
     * @return string
     */
    public function getStatusText()
    {
        return ArrayHelper::getValue(self::$statuses, $this->status);
    }


    /**
     * 获取用户成功充值次数
     * @param array $agentList
     * @return int
     */
    public function getUserSucOrder($agentList=[]) {
        $where = [
            'uid' => $this->uid,
            'status' => self::STATUS_SUCCESS,
            'gid' => $agentList,
        ];

        //只有超级管理员可以看到扣量订单
        if (Yii::$app->user->id != 1) {
            $where ['is_rebate'] = Order::IS_REBATE_NO;
        }

        return self::find()
            ->andWhere($where)
            ->andWhere(['<', 'id', $this->id])
            ->count();
    }

    public static function currentProduct()
    {
        return array_keys(static::productTexts());
    }
}
