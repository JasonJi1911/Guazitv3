<?php

use yii\helpers\Html;
use metronic\grid\GridView;
use admin\models\video\VideoUploadTask;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '上传任务管理';
$this->params['breadcrumbs'][] = ['url' => ['video/index'], 'label' => '影视列表'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="portlet light ">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>

        <div class="actions">
            <?= Html::a('影视列表', ['/video/index'], ['class' => 'btn btn-success']) ?>
            <?= Html::button('返回', ['class' => 'btn default', 'onclick' => 'history.back()']) ?>
        </div>
    </div>

    <div class="note note-info">
        <p>
            上传影视前，请先<font color="red">新增影片</font>，在影片剧集管理里面创建上传影视任务；<br/>
            上传任务列表会展示所有的上传任务；<br/>
            任务会按照上传顺序依次处理，当一个任务在 <font color="red"><b>处理中</b></font> 状态时间过长时，可以删除该任务（删除任务不会删除任务关联的影视），防止该任务阻塞后续任务的进行。
        </p>
    </div>

    <div class="portlet-body">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'file',
                [
                    'label' => '影视名称',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($model) {
                        if ($model->video) {
                            return Html::a('《'.$model->video->title.'》');
                        }
                        return '-';
                    }
                ],

                [
                    'attribute' => 'upload_type',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($model) {
                        if (isset (VideoUploadTask::$uploadTypeMap[$model->upload_type])) {
                            return VideoUploadTask::$uploadTypeMap[$model->upload_type];
                        }
                        return '-';
                    }
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($model) {
                        if (!isset (VideoUploadTask::$statusMap[$model->status])) {
                            return '-';
                        }

                        if ($model->status == VideoUploadTask::STATUS_IN_HAND) {
                            return '<span style="color:red;">'.VideoUploadTask::$statusMap[$model->status].'</span>';
                        } else if ($model->status == VideoUploadTask::STATUS_DONE){
                            return '<span style="color:green;">'.VideoUploadTask::$statusMap[$model->status].'</span>';
                        } else {
                            return '<span style="color:#cccccc;">'.VideoUploadTask::$statusMap[$model->status].'</span>';
                        }
                    }
                ],
                //'import_chapters',
                'created_at:datetime:创建时间',
//                'updated_at',
                //'deleted_at',


                [
                    'class' => 'metronic\grid\ActionColumn',
                    'template' => '{delete}'
                ],
            ],
        ]); ?>
    </div>
</div>
