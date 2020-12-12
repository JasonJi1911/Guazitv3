<?php
namespace admin\controllers;

class ActorAreaController extends BaseController
{
    public $name = '地区';

    public $modelClass = 'admin\models\video\ActorArea';
    public $searchModelClass = 'admin\models\video\search\ActorAreaSearch';
}
