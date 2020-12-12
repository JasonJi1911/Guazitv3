<?php
use yii\helpers\Html;
use metronic\assets\DateRangePickerAsset;

DateRangePickerAsset::register($this);

$this->render('../base/_filters');
?>

<form class="form-horizontal filter-form" >
    <div class="form-group">
        <label class="control-label col-md-1">搜索:</label>
        <div class="col-md-7">
            <?= Html::activeTextInput($searchModel, 'keyword', ['class' => 'form-control', 'placeholder' => '影视名/UID', 'style' => 'width:50%; float:left; margin-right:5px;']) ?>
            <button class="btn btn-primary">搜索</button>
        </div>
    </div>
    <div class="form-group picker-time">
        <label class="control-label col-md-2">观看时间:</label>
        <div class="col-md-10">
            <div style="float:left"><?= printFilters($searchModel, 'time', $searchModel::$times) ?></div>
            <?= Html::activeDateRangePicker($searchModel, 'start_date', 'end_date', ['class' => 'col-md-3', 'style' => $searchModel->time == 5 ? '' : 'display:none']) ?>
        </div>
    </div>
</form>