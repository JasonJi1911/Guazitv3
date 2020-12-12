<?php
namespace admin\controllers;

class UserStatController extends BaseController
{
    public $name = '用户统计';

    public $modelClass = 'admin\models\stat\UserStat';
    public $searchModelClass = 'admin\models\stat\search\UserStatSearch';


    /**
     * @inheritdoc
     */
    public function actionButtons()
    {
        return [];
    }
}