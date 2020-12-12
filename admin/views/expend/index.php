<?php

use yii\helpers\Html;
use metronic\grid\GridView;
use metronic\assets\DateRangePickerAsset;
use yii\helpers\Url;
use admin\models\pay\Expend;

DateRangePickerAsset::register($this);

$this->title = '积分消费记录列表';
$this->params['breadcrumbs'][] = '消费记录';
$this->params['breadcrumbs'][] = ['url' => ['index', 'type' => $cur_type], 'label' => $types[$cur_type]['label'] . '列表'];

$this->render('../base/_filters');

?>

<div class="portlet light">
    <div class="portlet-title" style="min-height: 0px;">
        <div class="caption" style="padding: 0px;">
            <div class="tabbable-line">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="<?= Url::to(['expend/index', 'type' => 'expend'])?>"> 积分消费记录 </a>
                    </li>
                    <li class="">
                        <a href="<?= Url::to(['expend/index', 'type' => 'coupon'])?>"> 卡券消费记录 </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal filter-form" >
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
                        <label class="control-label col-md-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;类型:</label>
                        <div class="col-md-10">
                            <?= printFilters($searchModel, 'expend_type', $searchModel::$expendMap) ?>
                            <?= Html::activeHiddenInput($searchModel, 'expend_type') ?>
                        </div>
                    </div>
                    <div class="form-group picker-time">
                        <label class="control-label col-md-2">消费时间:</label>
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

                'expend_no:text:消费单号',
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
                'fromChannelText:text:终端来源',
                [
                    'label' =>  Yii::$app->setting->get('system.currency_unit'),
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($model) {
                        if ($model->type >= Expend::INCOME_EXPEND_FLAG) {
                            $html = '-';
                        } else {
                            $html = '+';
                        }
                        return $html . $model->score;
                    }
                ],
                [
                    'label' => '明细',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($model) {
                        return Expend::$expendMap[$model->type];
                    }
                ],
                'created_at:datetime:下单时间',
            ],
        ]); ?>
    </div>
</div>
