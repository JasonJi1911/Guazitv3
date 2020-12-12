<?php
namespace admin\controllers;

use admin\models\Announcement;
use Yii;

class AnnouncementController extends BaseController
{
    public $name = '公告';
    public $modelClass = 'admin\models\Announcement';
    public $searchModelClass = 'admin\models\search\AnnouncementSearch';

    public function actionShelve()
    {
        $id = Yii::$app->request->get('id');
        $status = Yii::$app->request->get('status');

        if ($status == Announcement::STATUS_ENABLED) {
            Announcement::updateAll(['status' => Announcement::STATUS_DISABLED], ['status' => Announcement::STATUS_ENABLED]);
        }

        $announcement = Announcement::findOne(['id' => $id]);
        $announcement->status = $status;
        $announcement->save();

        return $this->redirect(Yii::$app->request->referrer);
    }
}