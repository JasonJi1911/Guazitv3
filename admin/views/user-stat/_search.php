<?php
use yii\helpers\Html;
use metronic\assets\DateRangePickerAsset;

DateRangePickerAsset::register($this);

$this->render('../base/_filters');
?>

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