<?php
use metronic\widgets\InlineFilterForm;
?>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'status')->dropDownList($searchModel::$statusMap, ['prompt' => '全部']) ?>
<?= $form->field($searchModel, 'action')->dropDownList($searchModel::$actionMap, ['prompt' => '全部']) ?>
<?= InlineFilterForm::end() ?>
