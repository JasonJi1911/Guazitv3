<?php

use yii\helpers\Html;
use metronic\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],

        'wechat_app_id',
        'wechat_app_secret',
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{update}{delete} ',
        ],
    ],
]); ?>
