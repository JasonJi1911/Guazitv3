<?php

namespace common\models\permission;

use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%role}}".
 *
 * @property int $id 角色ID
 * @property string $name 角色名称
 * @property string $detail 描述
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class Role extends \xiang\db\ActiveRecord implements StatusToggleInterface
{
    use StatusToggleTrait;
    /**
     * 角色常量（预留的角色，这些角色ID不能修改，否则可能会出现错误）
     */
    const ROLE_ADMIN    = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%role}}';
    }
}
