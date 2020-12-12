<?php
namespace admin\controllers;

class VideoSourceController extends BaseController
{
    public $name = '视频源';

    public $modelClass = 'admin\models\video\VideoSource';
    public $searchModelClass = 'admin\models\video\search\VideoSourceSearch';
}