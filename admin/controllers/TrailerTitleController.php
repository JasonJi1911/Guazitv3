<?php

namespace admin\controllers;

use admin\models\video\TrailerTitle;
use Yii;

class TrailerTitleController extends BaseController
{
    public $name = '预告位';

    public $modelClass = 'admin\models\video\TrailerTitle';
    public $searchModelClass = 'admin\models\video\search\TrailerTitleSearch';

    /**
     * @return \yii\web\Response
     * 显示和隐藏
     */
    public function actionShelve()
    {
        $id     = Yii::$app->request->get('id');
        $shelve = Yii::$app->request->get('shelve');

        $objGiftInfo = TrailerTitle::findOne(['id' => $id]);
        $objGiftInfo->status = $shelve;
        $objGiftInfo->save();

        return $this->redirect(Yii::$app->request->referrer);
    }
}