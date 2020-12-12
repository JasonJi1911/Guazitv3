<?php

use yii\helpers\Html;
use metronic\widgets\InlineFilterForm;
use metronic\grid\GridView;
use metronic\assets\DateRangePickerAsset;
use yii\helpers\Url;

DateRangePickerAsset::register($this);

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],

        'trade_no:text:订单号',
        [
            'label' => '昵称（UID）',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function($model) {
                $html = '';
                if ($model->user) {
                    $html .= Html::img($model->user->avatar->toUrl(), ['height' => 25, 'width' => 25]);
                }
                if ($model->user) {
                    $html .= '&nbsp;'.Html::a($model->user->nickname);
                    $html .= '&nbsp;<span style="color:#00A1CB">('.$model->uid.')</span>';
                }
                return $html;
            }
        ],
        [
            'label' => '套餐名称',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function($model) {
                $html = '';
                if ($model->goods) {
                    $html .= '&nbsp;' . $model->goods->title;
                }
                return $html;
            }
        ],
        'total_fee:cent:交易金额',
        'fromChannelText:text:终端来源',
        'payChannelText:text:支付方式',
        'statusText:text:支付状态',
        'created_at:datetime:下单时间',
    ],
]); ?>
