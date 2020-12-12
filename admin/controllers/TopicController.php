<?php
namespace admin\controllers;

class TopicController extends BaseController
{
    public $name = '专题';

    public $modelClass = 'admin\models\video\Topic';
    public $searchModelClass = 'admin\models\video\search\TopicSearch';
}