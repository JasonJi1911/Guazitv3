<?php
namespace admin\controllers;

use yii\console\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class OrderController extends BaseController
{
    public $name = '订单';

    public $modelClass = 'admin\models\pay\Order';
    public $searchModelClass = 'admin\models\pay\search\OrderSearch';

    /**
     * @inheritdoc
     */
    public function actionButtons()
    {
        return [];
    }

}