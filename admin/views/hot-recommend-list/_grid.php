<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use admin\models\video\HotRecommend;
?>



<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [

        [
          'label' => '分类',
            'enableSorting' => false,
            'format' => 'raw',
            'value' => function($model){
                return $model->hot->title;
            }
        ],

        [
          'label' => '系列',
            'enableSorting' => false,
            'format' => 'raw',
            'value' => function($model){
                if (!$model->video) {
                    return '--';
                }
                return $model->video->title;
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
            'template' => ' {update} {delete} ',

            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::updateActionButton(['update', 'recommend_id' => $model->recommend_id, 'id' => $model->id]);
                }
            ],
        ],

    ],

])?>
