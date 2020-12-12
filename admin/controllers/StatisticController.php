<?php
namespace admin\controllers;

use admin\models\pay\search\IncomeSearch;
use admin\models\stat\search\UserStatSearch;
use api\models\agent\AgentInfo;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class StatisticController extends Controller
{
    /**
     * 订单统计
     */
    public function actionOrderStat()
    {
        $searchModel = new IncomeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('order', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}