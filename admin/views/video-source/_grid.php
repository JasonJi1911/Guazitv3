<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
?>



<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],
        [
            'label' => '源名称',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function($model) {
                $html = '';
                $html .= $model->name;
                return $html;
            }
        ],

        [
            'attribute' => 'icon图标',
            'format' => 'raw',
            'value' => function($model) {
                return Html::img($model->icon->resize(50, 50), ['width' => 50]);
            }
        ],
        'display_order',
        'player',
        'PlayLimit',
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
            'template' => ' {update} {delete} {up}',
        ],
    ],

])?>
