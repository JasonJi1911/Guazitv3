<?php
namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%user_relations}}".
 *
 * @property int $id
 * @property int $uid 用户uid
 * @property int $other_uid 关注或拉黑用户id
 * @property int $type 1-关注;2-黑名单
 * @property int $status 1-关注;2-取消
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class UserRelations extends \xiang\db\ActiveRecord
{

    // type常量
    const TYPE_FOLLOW    = 1;
    const TYPE_BLACKLIST = 2;

    /**
     * @var array type
     */
    public static $typeMap = [
        self::TYPE_FOLLOW    => '关注',
        self::TYPE_BLACKLIST => '黑名单'
    ];

    const STATUS_YES = 1;
    const STATUS_NO = 0;

    public static $statusMap = [
        self::STATUS_YES => '关注',
        self::STATUS_NO  => '取消'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_relations}}';
    }
}
