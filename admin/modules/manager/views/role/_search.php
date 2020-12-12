<?php

use metronic\widgets\InlineFilterForm;
?>
<div class="note note-info">
    <p>1、权限指的是对后台内容的查看修改等操作的能力，仅限内容模块，如果涉及到业务逻辑则部分功能不会生效</p>
    <p>2、管理员有且只有一个，拥有所有的权限，每个用户都有属于自己的角色</p>
    <p style="color: red;">3、管理配置里面的参数权限太高，为了安全只允许管理员进行修改</p>
</div>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'name') ?>
<?= InlineFilterForm::end() ?>
