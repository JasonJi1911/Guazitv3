<?php
namespace admin\controllers;

use admin\models\search\GoodsSearch;
use yii\web\Controller;
use Yii;
use admin\models\pay\Goods;
use yii\web\NotFoundHttpException;

class GoodsController extends Controller
{
    public $modelClass = 'admin\models\pay\Goods';
    public $searchModelClass = 'admin\models\search\GoodsSearch';

    /**
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $typeStr = Yii::$app->request->get('type');
        $type = isset(Goods::$typeMap[$typeStr]) ? Goods::$typeMap[$typeStr] : Goods::$typeMap['default'];

        $searchModel = new GoodsSearch();
        $searchModel->type = $type;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render($typeStr.'/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Goods model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $map = array_flip(Goods::$typeMap);

        $tplDir = isset($map[$model->type]) ? $map[$model->type] : $map[Goods::TYPE_RECHARGE];

        return $this->render($tplDir.'/view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $typeStr = Yii::$app->request->get('type');
        $type = isset(Goods::$typeMap[$typeStr]) ? Goods::$typeMap[$typeStr] : Goods::$typeMap['default'];

        $model = new Goods();
        $model->type = $type;

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->giving)) {
                $model->giving = 0;
            }
            if (empty($model->original_price)) {
                $model->original_price = $model->price;
            }

            if ($model->save()) {
                return $this->redirect(['goods/'.$typeStr]);
            } else {
                Yii::warning($model->errors);
            }
        }

        return $this->render($typeStr.'/create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $map = array_flip(Goods::$typeMap);

        $tplDir = isset($map[$model->type]) ? $map[$model->type] : $map[Goods::TYPE_RECHARGE];

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->giving)) {
                $model->giving = 0;
            }

            if ($model->save()) {
                return $this->redirect([$tplDir]);
            }
        }

        return $this->render( $tplDir.'/update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Goods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $map = array_flip(Goods::$typeMap);

        $tplDir = isset($map[$model->type]) ? $map[$model->type] : $map[Goods::TYPE_RECHARGE];

        $model->delete();

        return $this->redirect([$tplDir]);
    }



    /**
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



}
