<?php

namespace admin\controllers;

use admin\models\video\VideoUpdateTitle;
use Yii;

class VideoUpdateTitleController extends BaseController
{
    public $name = '更新位';

    public $modelClass = 'admin\models\video\VideoUpdateTitle';
    public $searchModelClass = 'admin\models\video\search\VideoUpdateTitleSearch';

    /**
     * @return \yii\web\Response
     * 显示和隐藏
     */
    public function actionShelve()
    {
        $id     = Yii::$app->request->get('id');
        $shelve = Yii::$app->request->get('shelve');

        $objGiftInfo = VideoUpdateTitle::findOne(['id' => $id]);
        $objGiftInfo->status = $shelve;
        $objGiftInfo->save();

        return $this->redirect(Yii::$app->request->referrer);
    }
}
