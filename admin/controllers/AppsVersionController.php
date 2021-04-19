<?php
namespace admin\controllers;


use admin\models\apps\AppsVersion;
use admin\models\apps\AppsVersionSearch;
use common\models\apps\AppsCheckSwitch;
use yii\web\Controller;
use common\helpers\Tool;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * 版本管理
 */
class AppsVersionController extends Controller
{
    public $modelClass = 'admin\models\apps\AppsVersion';
    public $searchModelClass = 'admin\models\apps\AppsVersionSearch';


    /**
     * @inheritdoc
     */
    public function actionButtons()
    {
        $osType = Yii::$app->request->get('os_type', AppsVersion::OS_TYPE_IOS);

        return [
            [
                'label'   => '新增版本',
                'url'     => ['create', 'os_type' => $osType],
                'options' => ['class' => 'btn green'],
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();

        unset($actions['index']);
        unset($actions['create']);
        unset($actions['update']);

        return $actions;
    }

    /**
     * Lists all AppVersion models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new AppsVersionSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        foreach ($dataProvider->getModels() as $model) {
            
            $count = AppsCheckSwitch::find()->andWhere(['version_id' => $model->id])->count();
           
            if ($count == 0) {
                if ($model->os_type == AppsVersion::OS_TYPE_IOS) {
                    $where = ['channel' => 'ios'];
                } else {
                    $where = ['<>', 'channel', 'ios'];
                }
                $channel = AppsCheckSwitch::find()->andWhere(['version_id' => 0])->andWhere($where)->groupBy('channel')->all();

                $fields = ['version_id', 'channel', 'label', 'status', 'file_path', 'created_at', 'updated_at'];
                $column = [];
                foreach ($channel as $item) {
                    $column[] = [$model->id, $item->channel, $item->label, AppsCheckSwitch::STATUS_OFF, '', time(), time()];
                }

                Yii::$app->db->createCommand()->batchInsert(AppsCheckSwitch::tableName(), $fields, $column)->execute();
            }
        }
     
        $checkSwitchList = AppsCheckSwitch::find()->andWhere(['version_id' => $dataProvider->getKeys()])->asArray()->all();
        $checkSwitch = [];
        foreach ($checkSwitchList as $item) {
            $info = [
                'id' => $item['id'],
                'label' => $item['label'],
                'status' => $item['status'],
                'file_path' => $item['file_path'],
            ];

            $checkSwitch[$item['version_id']][] = $info;
        }

        return $this->render('_grid', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'checkSwitch' => $checkSwitch,
        ]);
    }


    /**
     * Creates a new AppVersion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        set_time_limit(0);

        $model = new AppsVersion();

        $osType = Yii::$app->request->get('os_type', AppsVersion::OS_TYPE_IOS);

        $where = ['channel' => 'ios'];

        if ($osType == AppsVersion::OS_TYPE_ANDROID) {
            $where = ['and',['<>', 'channel', 'ios'],['<>', 'channel', 'tv']];
        }

        if($osType == AppsVersion::OS_TYPE_TV){
            $where =['channel' => 'tv'];
        }
        
        // 获取对应系统渠道
        $checkSwitch = AppsCheckSwitch::find()->andWhere($where)->andWhere(['version_id' => 0])->indexBy('id')->asArray()->all();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            
            $filePath = $post['file_path'];
            $channelIds = array_values(array_filter($post['channel_ids']));
            $model->upload_file = UploadedFile::getInstances($model, 'upload_file');

            unset($post['AppVersion']['upload_file']);
            unset($post['file_path']);
            unset($post['channel_ids']);

            $t = Yii::$app->db->beginTransaction();
            try {
                if ($model->load($post) && $model->save()) {
                    if ($channelIds && $model->os_type != AppsVersion::OS_TYPE_IOS) {
                        $rootPath = getcwd() . '/../../install/';
                        $dirPath = 'uploads/channel_package/';
                        if($model->os_type == AppsVersion::OS_TYPE_TV){
                            $dirPath = 'uploads/channel_tv_package/';
                        }
                        
                        if (!file_exists($rootPath . $dirPath)) {
                            mkdir($rootPath . $dirPath, 0777, true);
                        }

                        foreach ($channelIds as $index => $id) {
                            $fileName = $model->upload_file[$index]->name;
                            $fileUrl = $dirPath . $fileName;
                            move_uploaded_file($model->upload_file[$index]->tempName, $rootPath . $fileUrl);

                            $filePath[$id] = "http://app.guazitv6.com" . '/' . $fileUrl;

                        }
                    }

                    $fields = [
                        'version_id', 'channel', 'label', 'status', 'file_path', 'created_at',
                        'updated_at'
                    ];
                    $column = [];
                    foreach ($filePath as $index => $item) {
                        $column[] = [
                            $model->id, $checkSwitch[$index]['channel'], $checkSwitch[$index]['label'],
                            AppsCheckSwitch::STATUS_OFF, "{$item}", time(), time()
                        ];
                    }

                    Yii::$app->db->createCommand()->batchInsert(AppsCheckSwitch::tableName(), $fields, $column)->execute();
                    $t->commit();

                    $osType = Yii::$app->request->get('os_type', AppsVersion::OS_TYPE_IOS);
                    return $this->redirect(['index', 'os_type' => $osType]);
                }
            }catch(\Exception $e) {
                $t->rollback();
                return $e->getMessage();
            }
        }

        return $this->render('_form', [
            'model' => $model,
            'checkSwitch' => $checkSwitch,
        ]);
    }

    /**
     * Updates an existing AppVersion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        set_time_limit(0);

        $model = AppsVersion::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        // 获取安卓所有渠道
        $checkSwitch = AppsCheckSwitch::find()->andWhere(['version_id' => $model->id])->indexBy('id')->asArray()->all();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $filePath = $post['file_path'];
            $channelIds = array_values(array_filter($post['channel_ids']));
            $model->upload_file = UploadedFile::getInstances($model, 'upload_file');

            unset($post['AppVersion']['upload_file']);
            unset($post['file_path']);
            unset($post['channel_ids']);

            $t = Yii::$app->db->beginTransaction();
            try {
                if ($model->load($post) && $model->save()) {
                    if ($model->os_type != AppsVersion::OS_TYPE_IOS && $channelIds) {
                        $rootPath = getcwd() . '/../../install/';
                        $dirPath = 'uploads/channel_package/';
                        if($model->os_type == AppsVersion::OS_TYPE_TV){
                            $dirPath = 'uploads/channel_tv_package/';
                        }

                        if (!file_exists($rootPath.$dirPath)) {
                            mkdir($rootPath.$dirPath, 0777, true);
                        }

                        foreach ($channelIds as $index => $id) {
                            $fileName = $model->upload_file[$index]->name;
                            $fileUrl = $dirPath.$fileName;
                            move_uploaded_file($model->upload_file[$index]->tempName, $rootPath.$fileUrl);

                            $filePath[$id] = "http://app.guazitv6.com" . '/' . $fileUrl;
                        }
                    }

                    $updateSql = "";
                    foreach ($filePath as $index => $item) {
                        $updateSql .= "update " . AppsCheckSwitch::tableName() . " set file_path = '{$item}', updated_at = " . time() . " where id = {$index};";
                    }

                    Yii::$app->db->createCommand($updateSql)->execute();
                    $t->commit();

                    $osType = Yii::$app->request->get('os_type', AppsVersion::OS_TYPE_IOS);
                    return $this->redirect(['index', 'os_type' => $osType]);
                }

            }catch(\Exception $e) {
                $t->rollback();
                return $e->getMessage();
            }
        }


        return $this->render('_form', [
            'model' => $model,
            'checkSwitch' => $checkSwitch,
        ]);
    }

    public function actionUpdateSwitch()
    {
        $id = Yii::$app->request->post('id');
        $status = Yii::$app->request->post('status');
        $type = Yii::$app->request->post('type');

        $appVersion = AppsVersion::findOne($id);
        if ($type == 1) {
            $appVersion->force_update = ($status == 'true') ? AppsVersion::FORCE_UPDATE_YES : AppsVersion::FORCE_UPDATE_NOT;
        } else {
            AppsVersion::updateAll(['is_release' => AppsVersion::RELEASE_OFF, 'force_update' => AppsVersion::FORCE_UPDATE_NOT], ['os_type' => $appVersion->os_type]);
            $appVersion->is_release = ($status == 'true') ? AppsVersion::RELEASE_ON : AppsVersion::RELEASE_OFF;
        }
        $appVersion->save();

        return Tool::responseJson(0, '操作成功!');
    }

    //删除
    public function actionDelete() {
        $id = Yii::$app->request->get('id');
        $model = AppsVersion::findOne($id);
        if ($model) {
            $model->delete();
        }

        return $this->redirect('index');
    }
}