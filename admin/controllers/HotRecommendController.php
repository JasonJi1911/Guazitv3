<?php
namespace admin\controllers;

class HotRecommendController extends BaseController
{
    public $name = '热搜';

    public $modelClass = 'admin\models\video\HotRecommend';
    public $searchModelClass = 'admin\models\video\search\HotRecommendSearch';
}