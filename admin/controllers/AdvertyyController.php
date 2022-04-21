<?php

namespace admin\controllers;

use admin\models\video\AdvertYY;
use Yii;

class AdvertyyController  extends BaseController
{
    public $name = '文字链广告';

    public $modelClass = 'admin\models\advert\AdvertYY';
    public $searchModelClass = 'admin\models\advert\AdvertYYSearch';

    /**
     * @inheritdoc
     */
    public function actionButtons()
    {
        $yy_id = Yii::$app->request->get('yy_id');
        return [
            [
                'label'   => '新增文字链广告',
                'url'     => ['create', 'yy_id' => $yy_id],
                'options' => ['class' => 'btn green'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $yy_id = Yii::$app->request->get('yy_id');

        $actions = parent::actions();

        $actions['create']['redirect'] = ['index', 'yy_id' => $yy_id];
        $actions['update']['redirect'] = ['index', 'yy_id' => $yy_id];

        return $actions;
    }

    /**
     * @return \yii\web\Response
     * 显示和隐藏
     */
    public function actionShelve()
    {
        $id     = Yii::$app->request->get('id');
        $shelve = Yii::$app->request->get('shelve');

        $objGiftInfo = AdvertYY::findOne(['id' => $id]);
        $objGiftInfo->status = $shelve;
        $objGiftInfo->save();

        return $this->redirect(Yii::$app->request->referrer);
    }
}