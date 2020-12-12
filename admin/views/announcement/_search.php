<?php

use metronic\widgets\InlineFilterForm;
?>

<div class="note note-info">
    <h4 class="block">温馨提示</h4>
    <p>用户每次首次启动APP时弹出，标题和内容支持自定义
    </p>
</div>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'title') ?>
<?= InlineFilterForm::end() ?>
