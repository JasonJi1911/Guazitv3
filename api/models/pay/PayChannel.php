<?php

namespace api\models\pay;

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
    public function fields()
    {
        return [
            'icon' => function () { //icon地址
                return $this->icon->toUrl();
            },
            'title' => function () {
                return $this->channel_name;
            },
            'channel_id' => function() {
                return $this->id; //对外暴露的渠道id
            },
            'pay_type' => function () {
                return $this->channel_type;
            },
            'gateway' => function () {
                if ($this->pid) {
                    $channel = PayChannel::find()->where(['id' => $this->pid])->one();
                    if ($channel) {
                        return isset(PayChannel::$channelPayApi[$channel->channel_id]) ? API_HOST_PATH.PayChannel::$channelPayApi[$channel->channel_id] : '';
                    }
                    return '';
                }

                return isset(PayChannel::$channelPayApi[$this->channel_id]) ? API_HOST_PATH.PayChannel::$channelPayApi[$this->channel_id] : '';
            },
            'channel_code' => function () {
                if ($this->pid) {
                    $channel = PayChannel::find()->where(['id' => $this->pid])->one();

                    if ($channel) {
                        return $channel->channel_id;
                    }
                }

                return $this->channel_id;
            },
            'min_price' => function () {
                return $this->min_price;
            },
            'max_price' => function () {
                return $this->max_price;
            },
            'status' => function () {
                if (!$this->pid) {
                    return $this->status;
                }

                if ($this->status == PayChannel::STATUS_DISABLED) {
                    return $this->status;
                }

                $channel = PayChannel::find()->where(['id' => $this->pid])->one();

                if ($channel) {
                    return $channel->status;
                }

                return $this->status;
            }
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {
        $query = parent::find();
        $query->andWhere(['status' => PayChannel::STATUS_ENABLED]);

        return $query;
    }
}
