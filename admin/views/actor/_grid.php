<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
?>



<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],
        [
            'label' => '主演名',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function($model) {
                $html = '';
                $html .= $model->actor_name;
                return $html;
            }
        ],

        [
            'attribute' => '头像',
            'format' => 'raw',
            'value' => function($model) {
                return Html::img($model->avatar->resize(75, 75)->toUrl(), ['width' => 70]);
            }
        ],
        '@weight',
        [
            'attribute' => '身份',
            'format' => 'raw',
            'value' => function($model) {
                if ($model->type == 1){
                    return '演员';
                }else{
                    return '导演';
                }
            }
        ],
        'areaLabel',
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
