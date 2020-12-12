<?php
namespace admin\controllers;

use Yii;
use admin\models\advert\AdvertPosition;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

class AdvertPositionController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AdvertPosition::find()
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @return \yii\web\Response
     * 上下架
     */
    public function actionActive()
    {
        $op = Yii::$app->request->get('op');
        $id = Yii::$app->request->get('id');

        $advertPosition= AdvertPosition::findOne(['id' => $id]);
        $op ? $advertPosition->enable() : $advertPosition->disable();
        $advertPosition->save();

        return $this->redirect(Yii::$app->request->referrer);
    }
}
