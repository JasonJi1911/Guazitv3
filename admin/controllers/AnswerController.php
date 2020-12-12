<?php
namespace admin\controllers;

class AnswerController extends BaseController
{
    public $name = '问答';

    public $modelClass = 'admin\models\Answer';
    public $searchModelClass = 'admin\models\AnswerSearch';
}
