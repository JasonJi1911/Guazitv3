<?php
namespace admin\controllers;

class UserMessageController extends BaseController
{
    public $name = '消息';
    
    public $modelClass = 'admin\models\user\UserMessage';
    public $searchModelClass = 'admin\models\search\UserMessageSearch';
}
