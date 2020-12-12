<?php

use yii\helpers\Html;
use metronic\grid\GridView;
use metronic\assets\DateRangePickerAsset;
use yii\helpers\Url;
use admin\models\user\UserCoupon;

DateRangePickerAsset::register($this);

$this->title = '卡券消费记录列表';
$this->params['breadcrumbs'][] = '消费记录';
$this->params['breadcrumbs'][] = ['url' => ['index', 'type' => $cur_type], 'label' => $types[$cur_type]['label'] . '列表'];

$this->render('../base/_filters');

?>

<div class="portlet light">
    <div class="portlet-title" style="min-height: 0px;">
        <div class="caption" style="padding: 0px;">
            <div class="tabbable-line">
                <ul class="nav nav-tabs">
                    <li class="">
                        <a href="<?= Url::to(['expend/index', 'type' => 'expend'])?>"> 积分消费记录 </a>
                    </li>
                    <li class="active">
                        <a href="<?= Url::to(['expend/index', 'type' => 'coupon'])?>"> 卡券消费记录 </a>
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

                    <div class="form-group picker-time">
                        <label class="control-label col-md-2">时间:</label>
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
                'trade_no:text:消费单号（充值和后台赠送独有）',
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
                    'label' => '数量',
                    'value' => function($model) {
                        return ($model->type == UserCoupon::TYPE_USE ? '-' : '+') . $model->num;
                    }
                ],
                [
                    'label' => '使用于视频名称',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($model) {
                        $html = '';
                        if ($model->video) {
                            $html = $model->video->title;
                        }

                        return $html;
                    }
                ],

                [
                    'label' => '获取时间',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($model) {
                        if ($model->recv_time) {
                            return date('Y-m-d H:i:s', $model->recv_time);
                        }
                        return '-';
                    }
                ],

                [
                    'label' => '使用时间',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($model) {
                        if ($model->use_time) {
                            return date('Y-m-d H:i:s', $model->use_time);
                        }
                        return '-';
                    }
                ],

                [
                    'label' => '过期时间',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'value' => function($model) {
                        if ($model->expire_time) {
                            return date('Y-m-d H:i:s', $model->expire_time);
                        }
                        return '-';
                    }
                ],

            ],
        ]); ?>
    </div>
</div>
