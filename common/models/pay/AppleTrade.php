<?php

namespace common\models\pay;

use Yii;

/**
 * This is the model class for table "{{%apple_trade}}".
 *
 * @property int $id
 * @property int $uid 用户ID
 * @property string $trade_no 内部交易号
 * @property string $product_id 交易商品ID
 * @property string $apple_trade_id 苹果交易号
 * @property int $price 价格 单位：分
 * @property int $is_used 1-凭证未使用 2-凭证已使用
 * @property string $ip ip地址
 * @property int $updated_at 更新时间
 * @property int $created_at 创建时间
 */
class AppleTrade extends \xiang\db\ActiveRecord
{
    //使用状态
    const IS_USED_NO = 1;
    const IS_USED_YES = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apple_trade}}';
    }
}
