<?php
namespace admin\models\permission;

use admin\models\Admin;
use Yii;
use yii\helpers\ArrayHelper;

class Role extends \common\models\permission\Role
{
    /**
     * 角色常量（预留的角色，这些角色ID不能修改，否则可能会出现错误）
     */
    const ROLE_ADMIN = 1;
    
    /**
     * 关联管理员
     */
    public function getAdmins()
    {
        return $this->hasMany(Admin::className(), ['role_id' => 'id']);
    }

    /**
     * 关联权限
     */
    public function getPermissions()
    {
        return $this->hasMany(Permission::className(), ['id' => 'permission_id'])
            ->viaTable(PermissionAssignment::tableName(), ['role_id' => 'id']);
    }

    /**
     * 有没有权限执行指定的请求
     * @param       $route
     * @param array $params
     * @return bool
     * todo 权限修改
     */
    public function can($route, $params = [])
    {
        if ($this->id == self::ROLE_ADMIN) {
            return true;
        }

        // 当前请求的路由在权限表里不存在，默认都有权限
        if (!($permissions = Permission::findAll(['route' => $route])) || !$route) {
            return true;
        }

        // 已分配的权限
        $granted = ArrayHelper::map($this->permissions, 'id', 'name');

        $found = false;

        foreach ($permissions as $permission) {

            if (!isset($granted[$permission->id])) {
                continue;
            }

            $found = true;

            if (!$permission->params) {
                break;
            }

            foreach (explode('=', $permission->params) as $key => $val) {
                if (trim(Yii::$app->request->get($key)) == $val) {
                    $found = false;
                    break;
                }
            }

            if ($found) {
                break;
            }
        }

        return $found;
    }

    public function beforeDelete()
    {
        //删除账号和权限等信息
        Admin::deleteAll(['role_id' => $this->id]);
        PermissionAssignment::deleteAll(['role_id' => $this->id]);

        return parent::beforeDelete();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['name'], 'string', 'max' => 10],
            [['detail'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '角色ID',
            'name' => '角色名称',
            'detail' => '描述',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'deleted_at' => '删除时间',
        ];
    }
}
