<?php

namespace common\models;

use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property int $id 管理员ID
 * @property string $username 用户名
 * @property string $auth_key 认证KEY
 * @property string $password_hash 密码
 * @property int $role_id 角色ID
 * @property string $login_key 免密登录key
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class Admin extends \xiang\db\ActiveRecord implements StatusToggleInterface
{
    use StatusToggleTrait;

    /**
     * @var array 状态
     */
    public static $statusMap = [
        self::STATUS_ENABLED  => '启用',
        self::STATUS_DISABLED => '禁用',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }
}
