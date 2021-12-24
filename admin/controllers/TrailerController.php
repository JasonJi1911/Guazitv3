<?php

namespace admin\controllers;

use admin\models\video\Trailer;
use Yii;

class TrailerController  extends BaseController
{
    public $name = '预告片';

    public $modelClass = 'admin\models\video\Trailer';
    public $searchModelClass = 'admin\models\video\search\TrailerSearch';

    /**
     * @inheritdoc
     */
    public function actionButtons()
    {
        $trailer_title_id = Yii::$app->request->get('trailer_title_id');
        return [
            [
                'label'   => '新增预告片',
                'url'     => ['create', 'trailer_title_id' => $trailer_title_id],
                'options' => ['class' => 'btn green'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $trailer_title_id = Yii::$app->request->get('trailer_title_id');

        $actions = parent::actions();

        $actions['create']['redirect'] = ['index', 'trailer_title_id' => $trailer_title_id];
        $actions['update']['redirect'] = ['index', 'trailer_title_id' => $trailer_title_id];

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

        $objGiftInfo = Trailer::findOne(['id' => $id]);
        $objGiftInfo->status = $shelve;
        $objGiftInfo->save();

        return $this->redirect(Yii::$app->request->referrer);
    }
}