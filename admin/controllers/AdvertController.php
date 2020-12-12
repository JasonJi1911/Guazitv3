<?php
namespace admin\controllers;

use admin\models\advert\Advert;
use Yii;

class AdvertController extends BaseController
{
    public $name = '广告';

    public $modelClass = 'admin\models\advert\Advert';
    public $searchModelClass = 'admin\models\video\search\AdvertSearch';


    /**
     * @inheritdoc
     */
    public function actionButtons()
    {
        $positionId = Yii::$app->request->get('position_id');
        return [
            [
                'label'   => '新增广告',
                'url'     => ['create', 'position_id' => $positionId],
                'options' => ['class' => 'btn green'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $positionId = Yii::$app->request->get('position_id');

        $actions = parent::actions();

        $actions['create']['redirect'] = ['index', 'position_id' => $positionId];
        $actions['update']['redirect'] = ['index', 'position_id' => $positionId];

        return $actions;
    }

    /**
     * @return \yii\web\Response
     * 上下架
     */
    public function actionShelve()
    {
        $advertId = Yii::$app->request->get('advert_id');
        $shelve = Yii::$app->request->get('shelve');

        $advert= Advert::findOne(['id' => $advertId]);
        $advert->status = $shelve;
        $advert->save();

        return $this->redirect(Yii::$app->request->referrer);
    }

}