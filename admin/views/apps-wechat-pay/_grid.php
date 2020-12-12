<?php

use yii\helpers\Html;
use metronic\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],

        'wechat_app_id',
        'mch_id',

        'api_sec_key',

        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{chapter} {update}{delete} ',
        ],
    ],
]); ?>
