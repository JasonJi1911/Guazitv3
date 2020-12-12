<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

?>

<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],

        [
            'attribute' => '封面图',
            'format'    => 'raw',
            'enableSorting' => false,
            'value' => function($model) {
                if (!$model->video) {
                    return '--';
                }
                return Html::img($model->video->thumb);
            }
        ],

        [
            'label' => '影片名称',
            'value' => function($model) {
                if (!$model->video) {
                    return '--';
                }
                return $model->video->title;
            }
        ],

        [
            'label' => '类型',
            'value' => function($model) {
                return $model->periodText;
            }
        ],
        'display_order',
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::actionButton('编辑', ['rank-video/update', 'rank_id' => $model->rank_id, 'id' => $model->id], 'edit', 'purple');
                },
                'delete' => function ($url, $model) {
                    return Html::actionButton('删除', ['rank-video/delete', 'rank_id' => $model->rank_id, 'id' => $model->id], 'trash-o', 'dark');
                },
            ]
        ],
    ]
])?>
