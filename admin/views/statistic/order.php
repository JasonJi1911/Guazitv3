<?php

use admin\models\pay\Order;
use common\helpers\Tool;
use metronic\assets\DateRangePickerAsset;
use metronic\grid\GridView;
use yii\helpers\Html;

DateRangePickerAsset::register($this);

$this->render('../base/_filters');

$this->title = '订单统计';
$this->params['breadcrumbs'][] = '数据管理';
$this->params['breadcrumbs'][] = ['url' => ['income/index'], 'label' => $this->title];
?>

<div class="portlet light">
    <?= $this->render('statistic_nav')?>
<div class="portlet-body">
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="info-box info-block">
                <div class="home-block-left">
                </div>
                <div class="home-block-right">
                    <div class="sum_pay_by_time">
                        <span>充值总金额</span>
                        <div style="color: #0099FF;">
                            ¥
                            <span>
                                <?= Tool::moneyFormat($searchModel->totalRecharge(Order::TYPE_COUPON))?>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="info-box info-block">
                <div class="home-block-left" style="background-color: #e2aa95">
                </div>
                <div class="home-block-right">
                    <div class="sum_pay_by_time">
                        <span>开通会员总金额</span>
                        <div style="color: #e2aa95">
                            ¥
                            <span>
                                <?= Tool::moneyFormat($searchModel->totalRecharge(Order::TYPE_VIP))?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="info-box info-block">
                <div class="home-block-left" style="background-color: #a5b96e">
                </div>
                <div class="home-block-right">
                    <div class="sum_pay_by_time">
                        <span>收入总金额</span>
                        <div style="color: #a5b96e">
                            ¥
                            <span>
                                <?= Tool::moneyFormat($searchModel->totalRecharge())?>
                            </span>
                        </div>
                    </div>
                </div>
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
                'vipTimes:times:开通会员次数',
                'vipFee:cent:开通会员总金额',
                'totalFee:cent:收入总金额',
            ],
        ]); ?>
    </div>

</div>
