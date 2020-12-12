<?php

use yii\helpers\Html;
use metronic\widgets\InlineFilterForm;
use metronic\grid\GridView;
use metronic\assets\DateRangePickerAsset;
use yii\helpers\Url;

DateRangePickerAsset::register($this);

$this->title = '充值统计';
$this->params['breadcrumbs'][] = '数据统计';
$this->params['breadcrumbs'][] = ['url' => ['income/index'], 'label' => $this->title];
?>

<div class="portlet light">
    <div class="portlet-title" style="min-height: 0px;">
        <div class="caption" style="padding: 0px;">
            <div class="tabbable-line">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="<?= Url::to(['income/index'])?>"> 充值统计 </a>
                    </li>
                    <li class="">
                        <a href="<?= Url::to(['expend/index'])?>"> 消费明细 </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-inline">
                    <div class="form-group">
                        <label>日期:&nbsp;&nbsp;<?= Html::activeDateRangePicker($searchModel, 'start_date', 'end_date', ['style' => 'display:inline']) ?></label>
                    </div>
                    <button type="submit" class="btn green" style="display:inline">搜索</button>
                </form>
            </div>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'metronic\grid\SerialColumn'],

                'date:text:日期',
                'rechargeTimes:times:充值次数',
                'rechargeFee:cent:充值总金额',
                'baoyueTimes:times:开通会员次数',
                'baoyueFee:cent:开通会员总金额',
                'totalFee:cent:收入总金额',
            ],
        ]); ?>
    </div>
</div>
