<?php

namespace common\models\pay;

use Yii;

/**
 * This is the model class for table "{{%pay_error_log}}".
 *
 * @property int $id
 * @property int $date 日期,年月日 20180808
 * @property string $trade_no 内部交易号
 * @property string $out_trade_no 外部交易号
 * @property int $type 异常类型 1-验签失败 2-重复通知 3-支付失败 4-订单不存在 5-订单信息不一致...
 * @property int $uid 用户ID
 * @property string $note 备注信息
 * @property int $created_at 创建时间
 */
class PayErrorLog extends \yii\db\ActiveRecord
{
    //错误list
    const TYPE_VERIFY_FAILED = 1;   //验签失败
    const TYPE_NOTIFY_REPEAT = 2;   //重复通知
    const TYPE_PAY_FAILED = 3;      //支付失败
    const TYPE_ORDER_NOT_EXIST = 4; //订单不存在
    const TYPE_ORDER_INCORRECT = 5; //订单信息不一样
    const TYPE_CONFIRM_TRADE_FAILED = 6; //处理订单支付失败
    const TYPE_GOODS_NOT_EXIST = 7; //订单购买的商品不存在


    static public $typeMap = [
        self::TYPE_VERIFY_FAILED => '数据验签失败',
        self::TYPE_NOTIFY_REPEAT => '重复通知',
        self::TYPE_PAY_FAILED => '返回支付失败',
        self::TYPE_ORDER_NOT_EXIST => '订单不存在',
        self::TYPE_ORDER_INCORRECT => '订单信息不一致',
        self::TYPE_CONFIRM_TRADE_FAILED => '处理订单失败',
        self::TYPE_GOODS_NOT_EXIST => '订单购买的商品不存在',
    ];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pay_error_log}}';
    }
}
