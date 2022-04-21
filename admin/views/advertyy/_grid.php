<?php

use admin\models\advert\AdvertYY;
use yii\helpers\Html;

$this->params['breadcrumbs'] = [];
$this->title = '文字链广告列表';
$this->params['breadcrumbs'][] = ['url' => '/advertyy-title/index', 'label' => '文字链模块管理'];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],
        [
            'attribute' => 'yy_id',
            'value' => function($model) {
                if (!$model->advertyyTitle) {
                    return '--';
                }
                return $model->advertyyTitle->title;
            }
        ],
        'title',
        'url',
        'display_order',
        '@status',
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{update} {shelve} {delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return '<a class="btn btn-outline btn-circle btn-xs purple" href="/advertyy/update?id='.$model->id.'&yy_id='.$model->yy_id.'" title="编辑" aria-label="编辑" data-pjax="0"><i class="fa fa-edit"> 编辑</i></a>';
                },
                'shelve' => function($url,$model) {

                    if ($model->status == AdvertYY::STATUS_DISABLED) {
                        return Html::a('<i class="fa fa-plus">显示</i>', ['advertyy/active', 'id' => $model->id, 'op' => 1],
                            ['class' => 'btn btn-outline btn-circle btn-xs green', 'data-confirm']);
                    } else {
                        return Html::a('<i class="fa fa-times">隐藏</i>', ['advertyy/active', 'id' => $model->id, 'op' => 0],
                            ['class' => 'btn btn-outline btn-circle btn-xs red','data-confirm' ]);
                    }
                },
            ]
        ],
    ],
]); ?>
