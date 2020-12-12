<?php
namespace admin\controllers;

use admin\models\video\search\TopicVideoSearch;
use admin\models\video\Topic;
use admin\models\video\TopicVideo;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TopicVideoController extends Controller
{
    public function beforeAction($action)
    {

        if (!parent::beforeAction($action)) {
            return false;
        }

        if (!($topicId = Yii::$app->request->get('topic_id')) || !($topic = Topic::findOne($topicId))) {
            throw new NotFoundHttpException;
        }

        Yii::$app->set('topic', $topic);

        return true;
    }

    /**
     * Lists all BookChapter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $topic_id = Yii::$app->request->get('topic_id');

        $searchModel = new TopicVideoSearch();
        $searchModel->topic_id = $topic_id;

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
        $topic_id = Yii::$app->request->get('topic_id');

        $model = new TopicVideo();
        $model->topic_id = $topic_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'topic_id' => $topic_id]);
        }

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
        $topic_id = Yii::$app->request->get('topic_id');
        $id        = Yii::$app->request->get('id');

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'topic_id' => $topic_id]);
        }

        // 上一章
        $lastVideo = TopicVideo::find()
            ->select(['id'])
            ->andWhere(['topic_id' => $topic_id])
            ->andWhere(['<', 'display_order', $model->display_order])
            ->orderBy('display_order desc, id desc')
            ->one();

        // 下一章
        $nextVideo = TopicVideo::find()
            ->select(['id'])
            ->andWhere(['video_id' => $topic_id])
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
     * Finds the BookChapter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TopicVideo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TopicVideo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Deletes an existing BookChapter model.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $topic_id = Yii::$app->request->get('topic_id');
        $id        = Yii::$app->request->get('id');

        $this->findModel($id)->delete();

        return $this->redirect(['index', 'topic_id' => $topic_id]);
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
                // 批量删除
                $result = Yii::$app->db->createCommand()->update(TopicVideo::tableName(), ['deleted_at' => time()], ['id' => $ids])->execute();
                break;

        }

        exit($result===false ? '0' : '1');
    }


}