<?php

use yii\helpers\Html;
use metronic\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'title',
            'contentOptions' => [
                'width' => '10%'
            ],
        ],
        [
            'attribute' => 'content',
            'contentOptions' => [
                'width' => '50%'
            ],
        ],

        'updated_at:datetime',

        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{update} {delete} {shelve}',
            'buttons' => [
                'shelve' => function($url,$model) {

                    if ($model->status == \admin\models\Announcement::STATUS_ENABLED) {
                        return Html::a('<i class="fa fa-times">隐藏</i>', ['announcement/shelve', 'id' => $model->id, 'status' => 2],
                            ['class' => 'btn btn-outline btn-circle btn-xs red','data-confirm' ]);
                    } else {
                        return Html::a('<i class="fa fa-plus">显示</i>', ['announcement/shelve', 'id' => $model->id, 'status' => 1],
                            ['class' => 'btn btn-outline btn-circle btn-xs green', 'data-confirm']);
                    }
                },
            ],
        ],
    ],
]); ?>
