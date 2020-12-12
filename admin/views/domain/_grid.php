<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
?>



<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],
        [
            'label' => '域名内容',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function($model) {
                return $model->content;
            }
        ],

        'TypeMapLabel',

        [
            'label' => '创建时间',
            'enableSorting' => false,
            'format' => 'raw',
            'value' => function($model) {
                if ($model->created_at) {
                    return date('Y-m-d H:i:s', $model->created_at);
                }
                return '--';
            }
        ],
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => ' {update} {delete}',
        ],

    ],

])?>
