<?php

use metronic\widgets\InlineFilterForm;
?>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'pid')->dropDownList($searchModel::getPermissionOptions(), ['prompt' => '全部']) ?>
<?= $form->field($searchModel, 'name') ?>
<?= InlineFilterForm::end() ?>
