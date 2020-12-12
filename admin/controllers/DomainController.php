<?php
namespace admin\controllers;

class DomainController extends BaseController
{
    public $name = '域名池管理';

    public $modelClass = 'admin\models\Domain';
    public $searchModelClass = 'admin\models\DomainSearch';
}