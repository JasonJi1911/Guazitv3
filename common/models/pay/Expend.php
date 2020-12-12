<?php

namespace common\models\pay;

use common\models\traits\FromChannelInterface;
use common\models\traits\FromChannelTrait;
use common\models\traits\ProductInterface;
use common\models\traits\ProductTrait;
use Yii;

/**
 * This is the model class for table "{{%expend}}".
 *
 * @property int $id
 * @property string $expend_no 消费单号
 * @property int $uid 用户ID
 * @property int $type 类型 1-去广告
 * @property int $score 消费积分
 * @property int $from_channel 来源渠道
 * @property int $product 产品线 1app 2公众号 3小程序
 * @property int $score_remain 账户积分余额
 * @property string $note 备注
 * @property string $ip ip地址
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 更新时间
 */
class Expend extends \xiang\db\ActiveRecord implements FromChannelInterface,ProductInterface
{
    use FromChannelTrait, ProductTrait;

    //增加和消费的分界线
    const INCOME_EXPEND_FLAG = 30;

    // 类型
    const TYPE_SIGN_IN        = 1; //签到获取
    const TYPE_TASK           = 2; //任务获取
    const TYPE_RECHARGE       = 3; //充值获取
    const TYPE_SYSTEM         = 4; //系统赠送


    // 30以上为消费
    const TYPE_REMOVE_AD     = 30; //去广告
    const TYPE_SYSTEM_REDUCE = 31; //系统扣除

    //expend about
    public static $expendMap = [
        self::TYPE_SIGN_IN        => '签到获取',
        self::TYPE_TASK           => '任务获取',
        self::TYPE_RECHARGE       => '充值获取',
        self::TYPE_SYSTEM         => '系统赠送',

        self::TYPE_REMOVE_AD     => '去广告',
        self::TYPE_SYSTEM_REDUCE => '系统扣除',

    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%expend}}';
    }


}
