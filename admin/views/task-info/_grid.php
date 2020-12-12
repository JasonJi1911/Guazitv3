<?php

use yii\helpers\Html;
use metronic\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],
        
        'title',

        [
            'label' => 'icon',
            'format' => 'raw',
            'value' => function($model) {
                return Html::img($model->icon->resize(50,50),['width' => 50,'height' => 50]);
            }
        ],

        'taskTypeLabel:text:任务类型',
        
        'limit_num',

        [
            'label' => '奖励（类型）',
            'value' => function($model) {
                return $model->award_num . '（' . $model->awardTypeLabel . '）';
            }
        ],

        '@status',
        
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{update}',
        ],
    ],
]); ?>
