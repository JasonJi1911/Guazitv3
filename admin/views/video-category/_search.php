<?php
use metronic\widgets\InlineFilterForm;
?>

<div class="note note-info">
    <h4 class="block">温馨提示</h4>
    <p>排序值越大，终端展示数据越靠前
    </p>
</div>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'channel_id')->dropDownList($searchModel->channelList, ['prompt' => '全部'])->wrapper(['width' => 2])->label('频道') ?>
<?= $form->field($searchModel, 'title')->label('分类名称')->textInput() ?>
<?= InlineFilterForm::end() ?>