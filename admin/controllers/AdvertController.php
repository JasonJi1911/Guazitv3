<?php
namespace admin\controllers;

use admin\models\advert\Advert;
use yii\data\ActiveDataProvider;
use Yii;
use common\helpers\Tool;

class AdvertController extends BaseController
{
    public $name = '广告';

    public $modelClass = 'admin\models\advert\Advert';
    public $searchModelClass = 'admin\models\video\search\AdvertSearch';


    /**
     * @inheritdoc
     */
    public function actionButtons()
    {
        $positionId = Yii::$app->request->get('position_id');
        return [
            [
                'label'   => '新增广告',
                'url'     => ['create', 'position_id' => $positionId],
                'options' => ['class' => 'btn green'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $positionId = Yii::$app->request->get('position_id');

        $actions = parent::actions();

        $actions['create']['redirect'] = ['index', 'position_id' => $positionId];
        $actions['update']['redirect'] = ['index', 'position_id' => $positionId];

        return $actions;
    }

    /**
     * @return \yii\web\Response
     * 上下架
     */
    public function actionShelve()
    {
        $advertId = Yii::$app->request->get('advert_id');
        $shelve = Yii::$app->request->get('shelve');

        $advert= Advert::findOne(['id' => $advertId]);
        $advert->status = $shelve;
        $advert->save();

        return $this->redirect(Yii::$app->request->referrer);
    }
    
    public function actionAutoClick()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Advert::find()->where(["status" => "1"])->groupBy("skip_url")
        ]);
        return $this->render('_autoclick',[
            'dataProvider' => $dataProvider
        ]);
    }
    
    public function actionRunClick()
    {
        $advertId = Yii::$app->request->get('advert_id');
        $adUrl = Yii::$app->request->get('adUrl');
        // $adUrl = "http://www.kantv9.com";
        
        $proxyUrl = "http://tiqu.linksocket.com:81/abroad?num=1&type=2&lb=1&sb=0&flow=1&regions=au&port=1&n=0";
        $getData = Tool::httpGet($proxyUrl);
        $proxyData = json_decode($getData['data']);
        
        if ($proxyData->success != true || count($proxyData->data) <= 0) {
            $data["status"] = 500;
            $data["msg"] = "动态IP失效";
            return Tool::responseJson(0, '操作成功', $data);
        }
        
        $proxyResult = Tool::httpGetProxy($adUrl,  $proxyData->data[0]->ip, $proxyData->data[0]->port);
        
        $data["status"] = 200;
        $data["advert_id"] = $advertId;
        $data["url"] = $adUrl;
        $data["proxyData"] = $proxyData;
        $data["proxyResult"] = $proxyResult;
        $data["proxyip"] = $proxyData->data[0]->ip;
        $data["proxyport"] = $proxyData->data[0]->port;
        $data["proxyUrl"] = "http://".$proxyData->data[0]->ip.":".$proxyData->data[0]->port;
        
        return Tool::responseJson(0, '操作成功', $data);
    }

}