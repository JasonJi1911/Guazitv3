<?php
namespace admin\controllers;

class ActorController extends BaseController
{
    public $name = '演员';

    public $modelClass = 'admin\models\video\Actor';
    public $searchModelClass = 'admin\models\video\search\ActorSearch';
}