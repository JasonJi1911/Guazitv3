<?php

use metronic\grid\GridView;
use yii\helpers\Html;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'label' => '权限',
            'attribute' => 'name',
        ],
        // [
        //     'label' => '上级权限',
        //     'attribute' => 'pid',
        //     'value' => function ($model) {
        //         return $model->parent->name ?? '-';
        //     },
        // ],
        // [
        //     'label' => '上上级权限',
        //     'attribute' => 'ppid',
        //     'value' => function ($model) {
        //         return $model->grandParent->name ?? '-';
        //     },
        // ],
        [
            'attribute' => 'is_menu',
            'value' => 'isMenuText',
        ],
        'route',
        'params',
        [
            'attribute' => 'icon',
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
            'value' => function ($model) {
                if ($model->icon) {
                    return Html::tag('span', '', ['aria-hidden' => 'true', 'class' => $model->iconText]);
                } else {
                    return '';
                }
            },
        ],

        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{update} {delete}',
        ],
    ],
]); ?>
