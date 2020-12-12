<?php
namespace admin\controllers;

class UserWatchLogController extends BaseController
{
    public $name = '用户观影记录';

    public $modelClass = 'admin\models\user\UserWatchLog';
    public $searchModelClass = 'admin\models\user\search\UserWatchLogSearch';



    /**
     * @inheritdoc
     */
    public function actionButtons()
    {
        return [];
    }

}