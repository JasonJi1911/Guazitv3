<?php
namespace admin\models\permission;

class PermissionAssignment extends \common\models\permission\PermissionAssignment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'permission_id'], 'required'],
            [['role_id', 'permission_id'], 'integer'],
            [['role_id', 'permission_id'], 'unique', 'targetAttribute' => ['role_id', 'permission_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'role_id' => '角色ID',
            'permission_id' => '权限ID',
        ];
    }
}
