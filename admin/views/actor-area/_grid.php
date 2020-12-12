<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
?>



<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],

        'area',

        [
            'label' => '演员数',
            'value' => function($model) {
                return $model->getActor()->count();
            }
        ],

        'display_order',

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
            'buttons' => [
                'delete' => function ($url, $model) {
                    $options = ['data-confirm' => '您确定要删除该地区吗？', 'data-method' => 'delete'];

                    if ($model->getActor()->count() != 0) {
                        $options = ['onclick' => 'alert("地区下有演员不可删除");return false;'];
                    }

                    return Html::actionButton('删除', $url, 'trash-o', 'dark', $options);
                },
            ]
        ],
    ],

])?>
