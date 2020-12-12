<?php
namespace admin\controllers;

use common\models\apps\AppsCheckSwitch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;

class AppsCheckSwitchController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AppsCheckSwitch::find()->andWhere(['version_id' => 0])
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate()
    {
        $id = Yii::$app->request->post('id');
        $status = Yii::$app->request->post('status');

        $checkSwitch = AppsCheckSwitch::findOne($id);
        $checkSwitch->status = ($status == 'true') ? AppsCheckSwitch::STATUS_ON : AppsCheckSwitch::STATUS_OFF;

        if (!$checkSwitch->save()) {
            Yii::warning($checkSwitch->errors);
        }
    }
}