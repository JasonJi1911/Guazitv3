<?php

use yii\helpers\Html;
use metronic\widgets\InlineFilterForm;
use metronic\grid\GridView;
use metronic\assets\DateRangePickerAsset;
use yii\helpers\Url;

DateRangePickerAsset::register($this);

$this->title = '充值订单列表';
$this->params['breadcrumbs'][] = '订单管理';
$this->params['breadcrumbs'][] = ['url' => ['index', 'type' => $cur_type], 'label' => $types[$cur_type]['label'] . '列表'];

$this->render('../base/_filters');

?>

<div class="portlet light">
    <div class="portlet-title" style="min-height: 0px;">
        <div class="caption" style="padding: 0px;">
            <div class="tabbable-line">
                <ul class="nav nav-tabs">
                    <li class="">
                        <a href="<?= Url::to(['order/index', 'type' => 'recharge'])?>"> 充值订单 </a>
                    </li>
                    <li class="active">
                        <a href="<?= Url::to(['order/index', 'type' => 'baoyue'])?>"> 会员订单 </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal filter-form">
                    <div class="form-group">
                        <label class="control-label col-md-2">搜索:</label>
                        <div class="col-md-7">
                            <?= Html::activeTextInput($searchModel, 'keyword', ['class' => 'form-control', 'placeholder' => '订单号/UID/用户名', 'style' => 'width:50%; float:left; margin-right:5px;']) ?>
                            <button class="btn btn-primary">搜索</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">终端来源:</label>
                        <div class="col-md-10">
                            <?= printFilters($searchModel, 'from_channel', $searchModel::$fromChannelTexts) ?>
                            <?= Html::activeHiddenInput($searchModel, 'from_channel') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">支付方式:</label>
                        <div class="col-md-10">
                            <?= printFilters($searchModel, 'pay_channel', $searchModel::$payChannels) ?>
                            <?= Html::activeHiddenInput($searchModel, 'pay_channel') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">支付状态:</label>
                        <div class="col-md-10">
                            <?= printFilters($searchModel, 'status', $searchModel::$statuses) ?>
                            <?= Html::activeHiddenInput($searchModel, 'status') ?>
                        </div>
                    </div>
                    <div class="form-group picker-time">
                        <label class="control-label col-md-2">下单时间:</label>
                        <div class="col-md-10">
                            <div style="float:left"><?= printFilters($searchModel, 'time', $searchModel::$times) ?></div>
                            <?= Html::activeDateRangePicker($searchModel, 'start_date', 'end_date', ['class' => 'col-md-3', 'style' => $searchModel->time == 5 ? '' : 'display:none']) ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
//                'out_trade_no:text:外部订单号',
//                'user.uid:text:用户ID',
//                'user.nickname:text:用户名',
                'total_fee:cent:订单金额',
                'months:text:月份数',
                'fromChannelText:text:终端来源',
                'payChannelText:text:支付方式',
                'statusText:text:支付状态',
//                'note:text:备注',
                'created_at:datetime:下单时间',
            ],
        ]); ?>
    </div>
</div>
