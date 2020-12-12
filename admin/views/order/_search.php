<?php
use yii\helpers\Html;
use yii\helpers\Url;
use metronic\assets\DateRangePickerAsset;

DateRangePickerAsset::register($this);

// 筛选
function printFilters($model, $attribute, $items)
{
    $params = Yii::$app->request->queryParams;
    $route  = '/' . Yii::$app->requestedRoute;

    unset($params['page'], $params[$attribute]);

    if ($attribute == 'time') {
        unset($params['start_date'], $params['end_date']);
    }

    if (!$model->$attribute) {
        echo Html::a('全部', [$route] + $params, ['class' => 'btn btn-xs green']);
    } else {
        echo Html::a('全部', [$route] + $params, ['class' => 'btn btn-link']);
    }

    foreach ($items as $id => $text) {
        $params[$attribute] = $id;
        if ($model->$attribute == $id) {
            echo Html::a($text, [$route] + $params, ['class' => 'btn btn-xs green']);
        } else {
            echo Html::a($text, [$route] + $params, ['class' => 'btn btn-link']);
        }
    }
}
$this->registerJs('
$(".watch-time").on("click", "a", function() {
    var $this = $(this);

    if ($this.text() == "自定义时间") {
        if (!$this.hasClass("btn-xs")) {
            $this.toggleClass("btn-xs green btn-link").siblings(".btn-xs").toggleClass("btn-xs green btn-link");
        }

        $(".daterange-picker").show().click();
        return false;
    }
});
');
?>

<form class="form-horizontal filter-form" >

    <div class="portlet light">
        <div class="portlet-title" style="min-height: 0px;">
            <div class="caption" style="padding: 0px;">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs">
                        <li class="<?php if (Yii::$app->request->get('type') == 1){echo 'active';}?>">
                            <a href="<?= Url::to(['order/index', 'type' => 1])?>"> 充值订单 </a>
                        </li>
                        <li class="<?php if (Yii::$app->request->get('type') == 2){echo 'active';}?>">
                            <a href="<?= Url::to(['order/index', 'type' => 2])?>"> 会员订单 </a>
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
        </div>
    </div>

</form>