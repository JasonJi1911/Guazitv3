<?php
namespace admin\controllers;


class RankController extends BaseController
{
    public $name = '排行';

    public $modelClass = 'admin\models\video\Rank';
    public $searchModelClass = 'admin\models\video\search\RankSearch';
}