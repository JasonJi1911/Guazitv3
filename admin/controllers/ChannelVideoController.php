<?php
namespace admin\controllers;

use admin\models\channel\ChannelVideo;
use admin\models\channel\ChannelVideoSearch;
use common\models\channel\ChannelVideo as commonChannelVideo;
use admin\models\video\VideoSource;
use Yii;
use yii\web\Controller;
use common\helpers\Tool;

/**
 * 视频渠道设置
 * 1 手机（APP wap）
 * 2 pc
 * 3 tv
 */

 class ChannelVideoController extends Controller{
    public $modelClass = 'admin\models\channel\ChannelVideo';
    public $searchModelClass = 'admin\models\channel\ChnnelVideoSearch';
    
    public function actionButton(){
        $osType = Yii::$app->request->get('os_type', ChannelVideo::OS_TYPE_APP);
        return [
            [
                'label'   => '新增版本',
                'url'     => ['create', 'os_type' => $osType],
                'options' => ['class' => 'btn green'],
            ],
        ];
    }

    public function actions(){
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['update']);
        return $actions;
    }



     public function actionIndex(){
        $seachChannelVideo=new ChannelVideoSearch();
        $dataProvider = $seachChannelVideo->search(Yii::$app->request->queryParams);
        $channelVideoData=[];
        foreach ($dataProvider->getModels() as $key=>$val) {
            $videoSource=VideoSource::find()->where(['id'=>$val['sid']])->asArray()->one();
            if($videoSource){
                $info=[
                    'id'=>$val['id'],
                    'sid'=>$val['sid'],
                    'name'=>$videoSource['name'],
                    'display_order'=>$videoSource['display_order'],
                    'icon'=>$videoSource['icon'],
                ];
                $channelVideoData[]=$info;
            }
            
        }
        $videoSource=VideoSource::find()->asArray()->all();
        return $this->render('_grid', [
            'dataProvider' => $dataProvider,
        ]);  
    }


    public function actionCreate(){
       $sid=[];
       $model = new commonChannelVideo();
       $osType = Yii::$app->request->get('os_type', commonChannelVideo::OS_TYPE_APP);
       $channelVideoData=ChannelVideo::find()->where(['os_type'=>$osType])->asArray()->all();
       foreach($channelVideoData as $key=>$val){
            $sid[]=$val['sid'];
       }
       $videoSource=VideoSource::find()->where(['not in','id',$sid])->orderBy("display_order desc")->asArray()->all();
       if (Yii::$app->request->isPost) {
        $post = Yii::$app->request->post();
        if(is_array($post['ChannelVideo'])){
            $fields = ['sid', 'os_type', 'display_order', 'created_at','updated_at'];
            foreach($post['ChannelVideo'] as $key=>$val){
                if(is_array($val)){
                    foreach($val as $v){
                       if(isset($v['0']) && $key == 'sid'){
                           $display_order=isset($post['ChannelVideo']['display_order'][$v[0]])?$post['ChannelVideo']['display_order'][$v[0]]:0;
                           $cloumn[]=[$v['0'],$osType,$display_order,time(),time()];
                       }
                    }
                }
            }
            if(count($cloumn)){
                Yii::$app->db->createCommand()->batchInsert(commonChannelVideo::tableName(),$fields,$cloumn)->execute();
            }
        }
        return $this->redirect(['index', 'os_type' => $osType]);
       }
        
       return $this->render('_form', [
        'model'=>$model,
        'videoSource' => $videoSource,
       ]);

    }

    public function actionDelete(){
        $id = Yii::$app->request->get('id');
        $model = ChannelVideo::findOne($id);
        if ($model) {
            $model->delete();
        }
        return $this->redirect('index');
    }

    public function actionUpdate()
    {
        $id = Yii::$app->request->get('id');
        $osType = Yii::$app->request->get('os_type', commonChannelVideo::OS_TYPE_APP);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if(is_array($post['ChannelVideo'])){
                $upDao = new ChannelVideo();
                $oldAttr =  ChannelVideo::find()->andWhere(['id' => $id])->asArray()->one();
                $upDao->oldAttributes = $oldAttr;
                $post['ChannelVideo']['os_type'] = $osType;
                $rows = $upDao->updateAttributes($post['ChannelVideo']);
            }
            return $this->redirect(['index', 'os_type' => $osType]);
        }

        $sid=[];
        $model = commonChannelVideo::find()->andWhere(['os_type'=>$osType, 'id'=>$id])->one();

        $channelVideoData=ChannelVideo::find()->where(['os_type'=>$osType])->asArray()->all();
        foreach($channelVideoData as $key=>$val){
            if ($val['sid'] != $model->sid)
                $sid[]=$val['sid'];
        }
        $videoSource=VideoSource::find()->where(['not in','id',$sid])->orderBy("display_order desc")->asArray()->all();

        return $this->render('_update', [
            'model'=>$model,
            'videoSource' => $videoSource,
        ]);
    }
 }