<?php
namespace  admin\controllers;

use admin\models\video\VideoSeek;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use Yii;

class VideoSeekController extends Controller
{
    public $name = '用户求片';

    public $modelClass = 'admin\models\video\VideoSeek';
    public $searchModelClass = 'admin\models\video\search\VideoSeekSearch';

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => VideoSeek::find()
                ->orderBy('created_at desc')
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }


    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        $model = VideoSeek::findOne($id);
        if ($model) {
            $model->delete();
        }

        return $this->redirect('index');
    }

}
