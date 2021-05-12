<?php

use yii\helpers\Html;
use metronic\grid\GridView;
use admin\models\channel\ChannelVideo;
use common\models\channel\ChannelVideo as commonChannelVideo;
use admin\models\video\VideoSource;
use yii\helpers\Url;
\metronic\assets\ToastrAsset::register($this);

$this->title = '播放渠道列表';
$this->params['breadcrumbs'][] = ['label' => '播放渠道管理', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
    .modal-body .table-bordered {
        display: none;
    }
</style>

<div class="portlet light">
    <?php $osType = Yii::$app->request->get('os_type', commonChannelVideo::OS_TYPE_APP); ?>
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase">播放渠道列表</span>
        </div>
        <div class="actions">
            <a class="btn green" href="/channel-video/create?os_type=<?= $osType ?>">新增播放渠道</a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="portlet-title" style="margin-bottom: 10px;">
            <div class="caption" style="padding: 0px;">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs">
                        <?php foreach (commonChannelVideo::$osType as $index => $osText) { ?>
                            <li class="<?php if ($index == $osType) {echo 'active';} ?>">
                                <a href="<?= Url::to(['channel-video/index', 'os_type' => $index])?>">
                                    <?= $osText ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'os_type',
                [
                    'attribute' => 'os_type',
                    'enableSorting' => false,
                    'value' => function($model) {
                        return commonChannelVideo::$osType[$model->os_type];
                    }
                ],
                [
                    'attribute' => '播放渠道',
                    'format' => 'raw',
                    'value' => function($model) {
                        $videoSource=VideoSource::find()->where(['id'=>$model->sid])->asArray()->one();
                        if($videoSource){
                           return $videoSource['name'];
                        }
                        return '失效线路';
                    },
                ],
                'display_order',
                [
                    'attribute' => 'created_at',
                    'enableSorting' => false,
                    'value' => function($model) {
                        return date('m/d H:i:s',$model->created_at);
                    }
                ],
                [
                    'class' => 'metronic\grid\ActionColumn',
                    'template' => '{delete}{update}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a("<i class='fa fa-edit'> 编辑</i>", ['channel-video/update', 'id' => $model->id, 'os_type' => $model->os_type],
                                ['class' => 'btn btn-outline btn-circle btn-xs red']);
                        },
                    ]
                ],
            ],
        ]); ?>
    </div>
</div>

