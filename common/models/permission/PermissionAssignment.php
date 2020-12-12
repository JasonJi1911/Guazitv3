<?php

namespace common\models\permission;

use Yii;

/**
 * This is the model class for table "{{%permission_assignment}}".
 *
 * @property int $role_id 角色ID
 * @property int $permission_id 权限ID
 */
class PermissionAssignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%permission_assignment}}';
    }
}
