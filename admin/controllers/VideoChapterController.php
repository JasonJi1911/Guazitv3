<?php
namespace admin\controllers;

use admin\models\video\search\VideoChapterSearch;
use admin\models\video\Video;
use admin\models\video\VideoChapter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class VideoChapterController extends Controller
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (!($seriesId = Yii::$app->request->get('video_id')) || !($video = Video::findOne($seriesId))) {
            throw new NotFoundHttpException;
        }

        Yii::$app->set('video', $video);
        return true;
    }


    /**
     * Lists all BookChapter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $video_id = Yii::$app->request->get('video_id');

        $searchModel = new VideoChapterSearch();
        $searchModel->video_id = $video_id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new BookChapter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $video_id = Yii::$app->request->get('video_id');

        $model = new VideoChapter();
        $model->video_id = $video_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'video_id' => $video_id]);
        } else {
            Yii::warning($model->getErrors());
        }

        //新建章节 填充序号
        $display_order = VideoChapter::find()
            ->select('display_order')
            ->where(['video_id' => $video_id, 'deleted_at' => 0])
            ->orderBy('display_order desc')
            ->scalar();
        $model->display_order = $display_order ? $display_order + 1 : 1;

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing BookChapter model.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $video_id = Yii::$app->request->get('video_id');
        $id        = Yii::$app->request->get('id');

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'video_id' => $video_id]);
        }

        // 上一章
        $lastVideo = VideoChapter::find()
            ->select(['id'])
            ->andWhere(['video_id' => $video_id])
            ->andWhere(['<', 'display_order', $model->display_order])
            ->orderBy('display_order desc, id desc')
            ->one();

        // 下一章
        $nextVideo = VideoChapter::find()
            ->select(['id'])
            ->andWhere(['video_id' => $video_id])
            ->andWhere(['>', 'display_order', $model->display_order])
            ->orderBy(' display_order asc, id asc')
            ->one();

        return $this->render('update', [
            'model' => $model,
            'lastVideo' => $lastVideo,
            'nextVideo' => $nextVideo
        ]);
    }

    /**
     * Deletes an existing BookChapter model.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $video_id = Yii::$app->request->get('video_id');
        $id        = Yii::$app->request->get('id');

        $this->findModel($id)->delete();

        return $this->redirect(['index', 'video_id' => $video_id]);
    }

    /**
     * Finds the BookChapter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BookChapter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VideoChapter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 批量操作
     */
    public function actionBatch()
    {
        $action = Yii::$app->request->get('action');
        $ids    = Yii::$app->request->post('ids');

        $result = false;

        switch ($action) {

            case 'batch_delete':
                // 批量上架
                $result = Yii::$app->db->createCommand()->update(VideoChapter::tableName(), ['deleted_at' => time()], ['id' => $ids])->execute();
                break;

        }

        exit($result===false ? '0' : '1');
    }



}