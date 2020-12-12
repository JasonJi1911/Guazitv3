<?php

namespace common\models;

use common\models\traits\OsTypeInterface;
use common\models\traits\PayChannelInterface;
use common\models\traits\PayChannelTrait;
use common\models\traits\ProductInterface;
use common\models\traits\ProductTrait;
use Yii;

/**
 * This is the model class for table "{{%recharge_rate}}".
 *
 * @property string $id
 * @property string $rate 充值比例 默认1:100
 * @property int $pay_channel 支付渠道 1苹果支付 2支付宝 3微信
 * @property int $status 支付启用状态 1启用 0未启用
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property string $deleted_at 删除时间
 */
class RechargeRate extends \xiang\db\ActiveRecord implements OsTypeInterface, PayChannelInterface
{
    use PayChannelTrait;
//    use ProductTrait;


    const STATUS_ENABLE = 1;//支付启用
    const STATUS_DISABLE = 0;//支付禁用

    public static $statusArr = [
        self::STATUS_ENABLE   => '启用',
        self::STATUS_DISABLE   => '禁用',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%recharge_rate}}';
    }

}
