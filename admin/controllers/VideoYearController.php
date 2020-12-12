<?php
namespace admin\controllers;

class VideoYearController extends BaseController
{
    public $name = '影视年代';

    public $modelClass = 'admin\models\video\VideoYear';
    public $searchModelClass = 'admin\models\video\search\VideoYearSearch';
}