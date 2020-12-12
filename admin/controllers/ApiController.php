<?php
namespace admin\controllers;

use Yii;
use yii\web\Controller;

/**
 * 接口控制器
 * @package admin\controllers
 */
class ApiController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionVideo()
    {
        $post = Yii::$app->request->post();

    }
}

