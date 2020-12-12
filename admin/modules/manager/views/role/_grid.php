<?php

use yii\helpers\Html;
use metronic\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'name',
        'detail',

        [
            'attribute' => 'updated_at',
            'format' => ['date', 'php:Y-m-d H:i'],
        ],

        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{update} {grant} {delete}',
            'buttons' => [
                'grant' => function ($url, $model) {
                    return Html::actionButton('授权', ['grant', 'id' => $model->id], 'share', 'blue');
                },
                'delete' => function ($url, $model) {
                    $options = ['data-confirm' => '删除后角色对应的账号也会被删除,您确定要删除吗？', 'data-method' => 'delete'];

                    return Html::actionButton('删除', $url, 'trash-o', 'dark', $options);
                }
            ],
            'visibleButtons' => [
                'grant'  => function ($model, $key, $index) {
                    // 管理员不能授权
                    return $model->id != 1;
                },
                'delete' => function ($model, $key, $index) {
                    // 预留的角色不能删除
                    return $model->id < 10 ? false : true;
                }
            ],
        ],
    ],
]); ?>
