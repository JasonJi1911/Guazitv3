<?php
namespace admin\controllers;

class TaskInfoController extends BaseController
{
    public $name = '任务';
    
    public $modelClass = 'admin\models\user\TaskInfo';
    public $searchModelClass = 'admin\models\user\search\TaskInfoSearch';

    public function actions()
    {
        $action = parent::actions();

        unset($action['create']);

        return $action;
    }

    public function actionButtons()
    {
        return [];
    }
}
