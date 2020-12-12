<?php

/* @var $this yii\web\View*/
/* @var $searchModel admin\models\DayStatSearch*/

use metronic\assets\DateRangePickerAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '每日统计';
$this->params['breadcrumbs'][] = '数据统计';
$this->params['breadcrumbs'][] = $this->title;

DateRangePickerAsset::register($this);

?>

<div class="portlet light">
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-inline">
                    <div class="form-group">
                        <label>日期:&nbsp;&nbsp;<?= Html::activeDateRangePicker($searchModel, 'start_date', 'end_date', ['style' => 'display:inline']) ?></label>
                    </div>
                    <button type="submit" class="btn green">搜索</button>
                </form>
                <a href="/day-stat/index?type=export&start_date=<?= $searchModel->start_date ?>&end_date=<?= $searchModel->start_date ?>" class="btn green" style="float:right;margin-top:-40px">导出</a>
            </div>
        </div>

        <?= \metronic\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'date:日期',
                'android_incr:安卓新增',
                'apple_incr:苹果新增',
                'mp_incr:公众号新增',
                'total_incr:总新增',
                'total_user:总用户',
                'day_active:日活',
                'recharge_incr:充值新增',
                'recharge_total:充值总数',
                'vip_incr:vip新增',
                'vip_total:vip总数'
            ]
        ])?>
    </div>
</div>
