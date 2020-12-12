<?php

use yii\helpers\Html;
use metronic\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],

        'message_type',
        'ali_sign_name',
        'ali_verify_code',
        'yun_account_id',
        'yun_token',
        'yun_app_id',
        'yun_template_id',
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{update}{delete} ',
        ],
    ],
]); ?>
