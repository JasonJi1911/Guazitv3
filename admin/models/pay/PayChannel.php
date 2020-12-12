<?php

namespace admin\models\pay;

use common\helpers\RedisKey;
use common\helpers\RedisStore;
use Yii;

/**
 * This is the model class for table "bw_pay_channel".
 *
 * @property int $id id
 * @property string $channel_name 名称
 * @property string $channel_id 支付渠道id
 * @property int $channel_type 渠道类型 1原生 2三方web 3三方SDK
 * @property int $is_channel 是否支付通道 1是 0不是
 * @property int $min_price 支持的最小金额
 * @property int $max_price 支持的最大金额
 * @property int $pid 父级id
 * @property string $icon icon地址
 * @property int $status 状态 1开启 2关闭
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class PayChannel extends \common\models\pay\PayChannel
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['min_price', 'max_price', 'pid', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['channel_name'], 'string', 'max' => 64],
            [['channel_id'], 'string', 'max' => 16],
            [['gateway'], 'string', 'max' => 128],
            [['channel_name',], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'channel_name' => '通道名称',
            'channel_id' => '支付渠道id',
            'channel_type' => '通道类型',
            'gateway' => '支付网关',
            'is_channel' => '是否支付通道 1是 0不是',
            'min_price' => '最小金额(分)',
            'max_price' => '最大金额(分)',
            'pid' => '父级id',
            'icon' => '图标',
            'status' => '当前状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'deleted_at' => '删除时间',
        ];
    }


    public function afterSave($insert, $changedAttributes)
    {
        $redis = new RedisStore();
        $key = RedisKey::getPayChannelKey();
        $redis->del($key);

        parent::afterSave($insert, $changedAttributes); 
    }
}
