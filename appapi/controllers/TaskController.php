<?php
namespace apinew\controllers;

use apinew\logic\TaskLogic;
use apinew\logic\UserLogic;
use apinew\models\user\TaskInfo;

class TaskController extends BaseController
{
    /**
     * 任务中心
     * @return array
     */
    public function actionCenter()
    {
        $taskLogic = new TaskLogic();
        return $taskLogic->taskCenter();
    }

    /**
     * 完成观看视频1分钟
     * @return array
     * @throws \apinew\exceptions\LoginException
     */
    public function actionWatch()
    {
        $taskLogic = new TaskLogic();
        $taskLogic->finishTask(TaskInfo::TASK_ACTION_PLAY_VIDEO);
        return [];
    }
}
