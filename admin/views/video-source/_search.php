<?php
use metronic\widgets\InlineFilterForm;
?>
<div class="note note-info">
    <h4 class="block">温馨提示</h4>
    <p>添加视频的来源，每添加一个视频来源，都会在影片列表下的剧集管理中新增一条源地址，用来前台页面展示出换源效果
    </p>
</div>
<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'name')->label('源名称')->textInput() ?>
<?= InlineFilterForm::end() ?>
