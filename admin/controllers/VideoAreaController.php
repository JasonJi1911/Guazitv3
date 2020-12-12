<?php
namespace admin\controllers;


class VideoAreaController extends BaseController
{
    public $name = '影视地区';

    public $modelClass = 'admin\models\video\VideoArea';
    public $searchModelClass = 'admin\models\video\search\VideoAreaSearch';
}