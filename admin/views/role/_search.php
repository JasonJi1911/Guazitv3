<?php

use metronic\widgets\InlineFilterForm;
?>
<div class="note note-info">
    <p>1、权限指的是对后台内容的查看、修改等操作的能力,如果涉及到业务逻辑则部分功能不会生效</p>
    <p>2、admin管理员角色拥有所有的权限</p>
    <p>3、系统配置模块安全性较高，只有admin管理员可以修改</p>
</div>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'name') ?>
<?= InlineFilterForm::end() ?>
