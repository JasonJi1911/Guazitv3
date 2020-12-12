<?php

use yii\helpers\Html;
use metronic\grid\GridView;
use admin\models\pay\PayChannel;
use yii\helpers\Url;

?>
<div class="note note-info">
    <p>1、充值通道是针对安卓的微信支付宝支付和其他三方支付使用</p>
    <p>2、默认的1和2是提供给安卓端原生支付使用，关闭后则不再前端显示</p>
    <p>3、需要接入额外的三方支付后，才可在此处进行配置</p>
    <p>4、由于三方支付的特性，不同的支付渠道适配金额不同，所以需要在子通道设置具体金额信息</p>
</div>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'icon',
            'format' => 'raw',
            'value' => function($model) {
                return Html::img($model->icon->toUrl(), ['width' => '50px', 'height' => '50px']);
            }
        ],
        'channel_name',
        [
            'attribute' => 'channel_type',
            'format' => 'raw',
            'value' => function($model) {

                if (isset(PayChannel::$channelTypeTexts[$model->channel_type])) {
                    return PayChannel::$channelTypeTexts[$model->channel_type];
                }

                return '-';
            }
        ],
        [
            'label' => '支持金额（元）',
            'format' => 'raw',
            'value' => function($model) {
                if (!$model->is_channel) {
                    return '-';
                }

                $rang = \common\helpers\Tool::moneyFormat($model->min_price) . ' ~ ';
                if ($model->max_price) {
                    $rang .= \common\helpers\Tool::moneyFormat($model->max_price);
                } else {
                    $rang .= '∞';
                }

                return $rang;
            }
        ],
        '@status',
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{update} {channel}',
            'buttons' => [
                'channel' => function ($url, $model) {
                    if (!$model->is_channel) {
                        return Html::a('<i class="fa fa-list-alt"> 子通道管理</i>', ['/pay-channel/index', 'pid' => $model->id], ['class' => 'btn btn-outline btn-circle btn-xs blue']);
                    }
                },
            ],
        ],
    ],
]); ?>
