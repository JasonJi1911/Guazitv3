<?php
namespace admin\controllers;

class VideoCategoryController extends BaseController
{
    public $name = '频道分类';

    public $modelClass = 'admin\models\video\VideoCategory';
    public $searchModelClass = 'admin\models\video\search\VideoCategorySearch';
}