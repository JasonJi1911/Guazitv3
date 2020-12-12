<?php
namespace admin\modules\manager\controllers;

use Yii;
use admin\controllers\BaseController;

/**
 * 角色权限管理
 */
class PermissionController extends BaseController
{
    public $name = '权限';

    public $modelClass = 'admin\modules\manager\models\Permission';
    public $searchModelClass = 'admin\modules\manager\models\PermissionSearch';

    /**
     * Creates a new Permission model.
     * @return mixed
     */
    public function actionCreate($pid = null)
    {
        $model = new Permission();
        
        $model->pid  = $pid;
        $model->ppid = ($model->parent->pid ?? 0);
        $model->initPriority();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 更改PID时调用的方法
     */
    public function actionChangePid($pid)
    {
        $model = new Permission();
        $model->pid  = $pid;
        $model->ppid = ($model->parent->pid ?? 0);
        $model->initPriority();

        exit(json_encode(['ppid' => $model->ppid, 'priority' => $model->priority])); 
    }
}
