<?php
namespace admin\controllers;

use admin\models\video\Banner;
use Yii;

class BannerController extends BaseController
{
    public $name = 'Banner图';

    public $modelClass = 'admin\models\video\Banner';
    public $searchModelClass = 'admin\models\video\search\BannerSearch';

    /**
     * @return \yii\web\Response
     * 显示和隐藏
     */
    public function actionShelve()
    {
        $id     = Yii::$app->request->get('id');
        $shelve = Yii::$app->request->get('shelve');

        $objGiftInfo = Banner::findOne(['id' => $id]);
        $objGiftInfo->status = $shelve;
        $objGiftInfo->save();

        return $this->redirect(Yii::$app->request->referrer);
    }
}