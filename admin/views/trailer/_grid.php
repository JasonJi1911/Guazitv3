<?php

use admin\models\video\Trailer;
use yii\helpers\Html;

$this->params['breadcrumbs'] = [];
$this->title = '预告片列表';
$this->params['breadcrumbs'][] = ['url' => '/trailer-title/index', 'label' => '预告位管理'];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],
        [
            'attribute' => 'trailer_title_id',
            'value' => function($model) {
                if (!$model->trailerTitle) {
                    return '--';
                }
                return $model->trailerTitle->title;
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
        'title',
//        'stitle',
//        'online_time:datetime',
        'display_order',
        '@status',
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{update} {shelve} {delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return '<a class="btn btn-outline btn-circle btn-xs purple" href="/trailer/update?id='.$model->id.'&trailer_title_id='.$model->trailer_title_id.'" title="编辑" aria-label="编辑" data-pjax="0"><i class="fa fa-edit"> 编辑</i></a>';
                },
                'shelve' => function($url,$model) {

                    if ($model->status == Trailer::STATUS_DISABLED) {
                        return Html::a('<i class="fa fa-plus">显示</i>', ['trailer/active', 'id' => $model->id, 'op' => 1],
                            ['class' => 'btn btn-outline btn-circle btn-xs green', 'data-confirm']);
                    } else {
                        return Html::a('<i class="fa fa-times">隐藏</i>', ['trailer/active', 'id' => $model->id, 'op' => 0],
                            ['class' => 'btn btn-outline btn-circle btn-xs red','data-confirm' ]);
                    }
                },
            ]
        ],
    ],
]); ?>
