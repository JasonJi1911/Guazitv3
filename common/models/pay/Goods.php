<?php

namespace common\models\pay;

use common\models\traits\GoodsTypeInterface;
use common\models\traits\GoodsTypeTrait;
use Yii;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property int $id 商品id
 * @property string $title 商品名称
 * @property string $desc 商品描述
 * @property string $icon 商品icon
 * @property int $price 商品价格 单位：分
 * @property int $original_price 商品原价 单位：分
 * @property int $giving 赠送卡券数
 * @property int $content 商品内容 type=1为卡券数量 type=2时表示天数
 * @property int $type 商品类型 1充值 2包月
 * @property string $apple_id 对应苹果商店商品id
 * @property int $tag 标记，1首充、2热销、3推荐
 * @property int $limit_num 限购（0-不限购，大于0为限购次数）
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class Goods extends \xiang\db\ActiveRecord implements GoodsTypeInterface
{
    use GoodsTypeTrait;
    
    const TAG_FIRST     = 1;
    const TAG_HOT       = 2;
    const TAG_RECOMMEND = 3;
    
    public static $tagMap = [
        self::TAG_FIRST     => '限时特惠',
        self::TAG_HOT       => '热销',
        self::TAG_RECOMMEND => '推荐'
    ];

    //商品类型
    const TYPE_RECHARGE = 1;
    const TYPE_OPEN_VIP = 2;


    //type map
    public static $typeMap = [
        'default' => self::TYPE_RECHARGE,
        'recharge' => self::TYPE_RECHARGE,
        'baoyue' => self::TYPE_OPEN_VIP,

    ];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }
}
