<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%user_coupon}}".
 *
 * @property int $id 自增主键
 * @property int $uid 用户uid
 * @property string $trade_no 交易号
 * @property int $num 消耗数量
 * @property int $recv_time 获取时间
 * @property int $use_time 使用时间
 * @property int $expire_time 过期时间
 * @property int $video_id 使用于视频的id
 * @property int $type 状态 1使用 2获取
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class UserCoupon extends \xiang\db\ActiveRecord
{
    const TYPE_USE = 1;
    const TYPE_GET = 2;
    const TYPE_SYSTEM_REDUCE = 3;
    
    public static $typeMap = [
        self::TYPE_USE => '使用',
        self::TYPE_GET => '获取',
        self::TYPE_SYSTEM_REDUCE => '系统扣除',
    ];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_coupon}}';
    }
}
