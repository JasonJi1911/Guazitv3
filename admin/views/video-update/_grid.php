<?php

use admin\models\video\VideoUpdate;
use yii\helpers\Html;

$this->params['breadcrumbs'] = [];
$this->title = '更新列表';
$this->params['breadcrumbs'][] = ['url' => '/video-update-title/index', 'label' => '更新位管理'];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],
        [
            'attribute' => 'video_update_title_id',
            'value' => function($model) {
                if (!$model->videoUpdateTitle) {
                    return '--';
                }
                return $model->videoUpdateTitle->title;
            }
        ],
        [
            'label' => '频道',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function($model) {
                if ($model->channel_id != 0) {
                    $channelName = $model->channel->channel_name;
                } else {
                    $channelName = '--';
                }
                return $channelName;
            }
        ],
        [
            'attribute' => 'video_id',
            'format' => 'raw',
            'value' => function($model) {
                if (!$model->video) {
                    return '--';
                }
                return $model->video->title;
            }
        ],
        [
            'attribute' => 'week',
            'format' => 'raw',
            'value' => function($model) {
                if (!$model::$weekTypes[$model->week]) {
                    return '--';
                }
                return $model::$weekTypes[$model->week];
            }
        ],
        'title',
        'stitle',
        'display_order',
        '@status',
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{update} {shelve} {delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return '<a class="btn btn-outline btn-circle btn-xs purple" href="/video-update/update?id='.$model->id.'&video_update_title_id='.$model->video_update_title_id.'" title="编辑" aria-label="编辑" data-pjax="0"><i class="fa fa-edit"> 编辑</i></a>';
                },
                'shelve' => function($url,$model) {

                    if ($model->status == VideoUpdate::STATUS_DISABLED) {
                        return Html::a('<i class="fa fa-plus">显示</i>', ['video-update/active', 'id' => $model->id, 'op' => 1],
                            ['class' => 'btn btn-outline btn-circle btn-xs green', 'data-confirm']);
                    } else {
                        return Html::a('<i class="fa fa-times">隐藏</i>', ['video-update/active', 'id' => $model->id, 'op' => 0],
                            ['class' => 'btn btn-outline btn-circle btn-xs red','data-confirm' ]);
                    }
                },
            ]
        ],
    ],
]); ?>
