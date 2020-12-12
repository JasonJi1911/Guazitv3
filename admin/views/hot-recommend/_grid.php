<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use admin\models\HotRecommend;
?>



<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => '序号',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function($model) {

                return $model->recommend_id;
            }
        ],
       [
           'label' => '标题',
           'format' => 'raw',
           'enableSorting' => false,
           'value' => function($model) {
             return $model->title;
           }
       ],
        'display_order',
        '@status',
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
            'template' => ' {update} {delete} {hot_word}',
            'buttons' => [
                'hot_word' => function($url, $model){
                    return Html::actionButton('热词', ['hot-recommend-list/index', 'recommend_id' => $model->recommend_id], 'eye', 'blue', ['title' => '查看热词']);
                }
            ]
        ],

    ],

])?>
