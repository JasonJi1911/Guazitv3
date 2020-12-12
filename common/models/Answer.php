<?php
namespace common\models;

use xiang\db\ActiveRecord;

/**
 * This is the model class for table "{{%answer}}".
 * @property int $id 主键
 * @property string $title 标题
 * @property int $type 问题类型
 * @property string $answer 问题答案
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 * @property int $deleted_at 删除时间
 */
class Answer extends ActiveRecord
{
    const TYPE_COMMON       = 1; // 常见问题
    const TYPE_NOVICE       = 2; // 新手问题
    const TYPE_GOLD         = 3; // 金币问题
    const TYPE_INVITE       = 4; // 邀请好友问题
    const TYPE_READ         = 5; // 阅读问题
    const TYPE_VIP          = 6; // 会员问题
    const TYPE_OTHER        = 7; // 其他问题
    public static $typeMap = [
        self::TYPE_COMMON   => '常见问题',
        self::TYPE_NOVICE   => '新手问题',
        self::TYPE_GOLD     => '金币问题',
        self::TYPE_INVITE   => '邀请好友问题',
        self::TYPE_READ     => '阅读问题',
        self::TYPE_VIP      => '会员问题',
        self::TYPE_OTHER    => '其他问题',
    ];

    public static function tableName()
    {
        return '{{%answer}}';
    }

}
