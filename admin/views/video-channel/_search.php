<?php
use metronic\widgets\InlineFilterForm;
?>

<div class="note note-info">
    <h4 class="block">温馨提示</h4>
    <p><span style="color: red">APP端</span>首页推荐最多只显示3个<br/>
        <span style="color: red">网页端</span>首页推荐最多只显示5个
    </p>
</div>
<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'channel_name')->label('频道名')->textInput() ?>
<?= InlineFilterForm::end() ?>