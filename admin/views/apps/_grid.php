<?php

use yii\helpers\Html;
use metronic\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],

        'name',
        'package_name',
        [
            'attribute' => 'icon',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function($model) {
                return Html::img($model->icon->resize(150 * 2, 100 * 2), ['width' => 150 . 'px', 'height' => 100 . 'px']);
            }
        ],
        'channel',
        'share_link',
        'description',
        '@status',


        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{push} {alipay} {message} {login} {pay} {update}{delete} ',
            'buttons' => [
                'push' => function ($url, $model) {
                    return Html::a('<i class="fa fa-book">app推送配置</i>', ['apps-push/index'], ['class' => 'btn btn-outline btn-circle btn-xs blue']);
                },
                'alipay' => function ($url, $model) {
                    return Html::a('<i class="fa fa-book">阿里支付</i>', ['apps-alipay/index'], ['class' => 'btn btn-outline btn-circle btn-xs blue']);
                },
                'message' => function ($url, $model) {
                    return Html::a('<i class="fa fa-book">短信服务</i>', ['apps-message/index'], ['class' => 'btn btn-outline btn-circle btn-xs blue']);
                },
                'login' => function ($url, $model) {
                    return Html::a('<i class="fa fa-book">微信登陆</i>', ['apps-wechat-login/index'], ['class' => 'btn btn-outline btn-circle btn-xs blue']);
                },

                'pay' => function ($url, $model) {
                    return Html::a('<i class="fa fa-book">微信支付</i>', ['apps-wechat-pay/index'], ['class' => 'btn btn-outline btn-circle btn-xs blue']);
                },


            ],
        ],
    ],
]); ?>
