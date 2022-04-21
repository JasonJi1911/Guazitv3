<?php

namespace admin\controllers;

use admin\models\advert\AdvertYYTitle;
use Yii;

class AdvertyyTitleController extends BaseController
{
    public $name = '文字链模块';

    public $modelClass = 'admin\models\advert\AdvertYYTitle';
    public $searchModelClass = 'admin\models\advert\AdvertYYTitleSearch';

    /**
     * @return \yii\web\Response
     * 显示和隐藏
     */
    public function actionShelve()
    {
        $id     = Yii::$app->request->get('id');
        $shelve = Yii::$app->request->get('shelve');

        $objGiftInfo = AdvertYYTitle::findOne(['id' => $id]);
        $objGiftInfo->status = $shelve;
        $objGiftInfo->save();

        return $this->redirect(Yii::$app->request->referrer);
    }
}