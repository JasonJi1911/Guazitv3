<?php
namespace admin\controllers;


use admin\models\pay\search\ExpendSearch;
use yii\web\Controller;
use Yii;
use admin\models\pay\Expend;
use yii\web\NotFoundHttpException;

class ExpendController extends Controller
{
    /**
     * 金币明细列表
     */
    public function actionIndex($type)
    {
        $types = [
            'expend' => ['class' => 'admin\models\pay\search\ExpendSearch',  'label' => '积分消费记录'],
            'coupon' => ['class' => 'admin\models\user\search\UserCouponSearch', 'label' => '卡券消费记录'],
        ];

        if (!isset($types[$type])) {
            throw new NotFoundHttpException;
        }

        $searchModel = new $types[$type]['class'];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($type == 'expend') {
            $tpl = 'expend';
        } else {
            $tpl = 'user-coupon';
        }

        return $this->render('/'.$tpl.'/index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'types'        => $types,
            'cur_type'     => $type,
        ]);
    }
}