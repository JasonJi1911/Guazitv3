<?php

use yii\helpers\Html;
use metronic\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],

        'app_id',
        'ios_app_key',
        'ios_app_secret',
        'android_app_key',
        'android_app_secret',

        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{update}{delete} ',
        ],
    ],
]); ?>
