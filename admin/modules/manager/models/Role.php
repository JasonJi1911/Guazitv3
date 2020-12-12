<?php

namespace admin\modules\manager\models;

use Yii;

class Role extends \admin\models\Role
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name', 'detail'], 'trim'],
            [['name'], 'unique'],
            [['name'], 'string', 'max' => 10],
            [['detail'], 'string', 'max' => 50],
            [['status'], 'default', 'value' => 1]
        ];
    }
    /**
     * 授权
     *
     * @param array $permissions 权限IDs
     * @return boolean
     */
    public function grant($permissions)
    {
        // 删除已分配的权限
        PermissionAssignment::deleteAll(['role_id' => $this->id]);

        // 分配新的权限
        $data = [];
        foreach ($permissions as $permission_id) {
            $data[] = [$this->id, $permission_id];
        }

        Yii::$app->db->createCommand()->batchInsert(
                PermissionAssignment::tableName(),
                ['role_id', 'permission_id'], $data)->execute();
    }
}
