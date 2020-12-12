<?php

use yii\helpers\Html;
use metronic\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],

        'alipay_app_id',
        'alipay_public_key',

        'rsa_private_key',

        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{chapter} {update}{delete} ',
        ],
    ],
]); ?>
