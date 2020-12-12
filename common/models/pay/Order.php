<?php

namespace common\models\pay;

use common\models\traits\FromChannelInterface;
use common\models\traits\FromChannelTrait;
use common\models\traits\GoodsTypeInterface;
use common\models\traits\GoodsTypeTrait;
use common\models\traits\PayChannelInterface;
use common\models\traits\PayChannelTrait;
use common\models\traits\ProductInterface;
use common\models\traits\ProductTrait;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property int $id
 * @property string $trade_no 交易号
 * @property string $out_trade_no 外部交易号
 * @property int $original_fee 原金额 单位：分
 * @property int $total_fee 交易金额 单位：分
 * @property int $pay_channel 支付类型 1-苹果支付 2-支付宝 3-微信支付 4-签到获取 5-系统赠送
 * @property int $uid 充值账户ID
 * @property int $from_uid 付费用户ID
 * @property int $from_channel 来源渠道
 * @property int $goods_id 商品id
 * @property int $value 商品价值，会员为天数，卡券为数量
 * @property int $type 类型
 * @property int $product 产品线 1app 2公众号 3小程序
 * @property int $status 交易状态 1-默认 2-交易成功 3-交易失败
 * @property int $lid 推广链接id
 * @property int $gid 代理id
 * @property int $video_id 作品id
 * @property int $op_userid op操作用户uid
 * @property int $op_time op操作时间
 * @property int $is_rebate 是否扣量订单 1是 0不是
 * @property string $note 备注
 * @property string $ip ip地址
 * @property int $notify_time 支付回调时间
 * @property int $created_at 订单创建时间
 * @property int $updated_at 订单更新时间
 * @property int $deleted_at 订单删除时间
 */
class Order extends \xiang\db\ActiveRecord implements GoodsTypeInterface, PayChannelInterface, ProductInterface, FromChannelInterface
{
    use GoodsTypeTrait, PayChannelTrait, FromChannelTrait;

    // 支付状态常量
    const STATUS_DEFAULT        = 1;
    const STATUS_SUCCESS        = 2;
    const STATUS_FAILED         = 3;

    //是否扣量订单
    const IS_REBATE_NO          = 0;
    const IS_REBATE_YES         = 1;

    /**
     * @inheritdoc
     */
    public function getProductText()
    {
        return ArrayHelper::getValue(static::productTexts(), $this->product);
    }

    /**
     * @inheritdoc
     */
    public static function productTexts()
    {
        return [
            self::PRODUCT_APP  => 'App',
            self::PRODUCT_MP   => '公众号',
        ];
    }

    /**
     * from_channel和product的映射关系
     * @var array
     */
    public static $channelProductMap = [
        self::FROM_CHANNEL_IOS      => self::PRODUCT_APP,
        self::FROM_CHANNEL_ANDROID  => self::PRODUCT_APP,
        self::FROM_CHANNEL_MP       => self::PRODUCT_MP,
    ];

    /**
     * @var array 支付状态
     */
    public static $statuses = [
        self::STATUS_SUCCESS => '已支付',
        self::STATUS_DEFAULT => '未支付',
    ];



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order}}';
    }
}
