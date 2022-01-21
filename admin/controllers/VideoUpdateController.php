<?php

namespace admin\controllers;

use admin\models\video\VideoUpdate;
use Yii;

class VideoUpdateController extends BaseController
{
    public $name = '更新';

    public $modelClass = 'admin\models\video\VideoUpdate';
    public $searchModelClass = 'admin\models\video\search\VideoUpdateSearch';

    /**
     * @inheritdoc
     */
    public function actionButtons()
    {
        $video_update_title_id = Yii::$app->request->get('video_update_title_id');
        $channel_id = Yii::$app->request->get('channel_id');
        return [
            [
                'label'   => '新增更新列表',
                'url'     => ['create', 'video_update_title_id' => $video_update_title_id,'channel_id' => $channel_id],
                'options' => ['class' => 'btn green'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $video_update_title_id = Yii::$app->request->get('video_update_title_id');

        $actions = parent::actions();

        $actions['create']['redirect'] = ['index', 'video_update_title_id' => $video_update_title_id];
        $actions['update']['redirect'] = ['index', 'video_update_title_id' => $video_update_title_id];

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

        $objGiftInfo = VideoUpdate::findOne(['id' => $id]);
        $objGiftInfo->status = $shelve;
        $objGiftInfo->save();

        return $this->redirect(Yii::$app->request->referrer);
    }
}
