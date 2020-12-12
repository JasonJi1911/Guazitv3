<?php
namespace admin\controllers;

use admin\models\advert\StartPage;
use Yii;

class StartPageController extends BaseController
{
    public $name = '启动图';

    public $modelClass = 'admin\models\advert\StartPage';
    public $searchModelClass = 'admin\models\advert\StartPageSearch';

    /**
     * 上下架
     * @return \yii\web\Response
     */
    public function actionShelve()
    {
        $id     = Yii::$app->request->get('id');
        $shelve = Yii::$app->request->get('shelve');

        $objGiftInfo = StartPage::findOne(['id' => $id]);
        $objGiftInfo->status = $shelve;
        $objGiftInfo->save();

        return $this->redirect(Yii::$app->request->referrer);
    }
}
