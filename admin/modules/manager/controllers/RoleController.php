<?php
namespace admin\modules\manager\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use admin\controllers\BaseController;
use admin\modules\manager\models\Permission;
use admin\modules\manager\models\PermissionAssignment;
use admin\modules\manager\models\Role;
use admin\modules\manager\models\RoleSearch;

/**
 * 角色管理
 */
class RoleController extends BaseController
{
    public $name = '角色';
    
    public $modelClass = 'admin\modules\manager\models\Role';
    public $searchModelClass = 'admin\modules\manager\models\RoleSearch';

    /**
     * Grant privileges for an existing Role model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionGrant($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $model->grant(explode(',', Yii::$app->request->post('permissions')));
            return $this->redirect(['index']);
        }

        // 已分配的权限
        $grantedPermissions = [];
        foreach (PermissionAssignment::findAll(['role_id' => $id]) as $row) {
            $grantedPermissions[$row->permission_id] = $row->permission_id;
        }
        
        // 所有权限
        $permissions = [];

        foreach (Permission::find()->all() as $permission) {

            $row = [
                'id'       => $permission->id,
                'text'     => $permission->name,
                'state'    => ['selected' => isset($grantedPermissions[$permission->id])],
                'children' => [],
            ];

            if (!$permission->pid) {
                $permissions[$permission->id] = $row;

            } else if (isset($permissions[$permission->pid])) {
                $permissions[$permission->pid]['children'][$permission->id] = $row;

            } else if (isset($permissions[$permission->ppid])) {
                $permissions[$permission->ppid]['children'][$permission->pid]['children'][$permission->id] = $row;
            }
        }

        foreach ($permissions as &$first) {
            $first['children'] = array_values($first['children']);
            foreach ($first['children'] as &$second) {
                $second['children'] = array_values($second['children']);
            }
        }
        
        return $this->render('grant', [
            'model' => $model,
            'permissions' => $permissions,
            'grantedPermissions' => $grantedPermissions,
        ]);
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
