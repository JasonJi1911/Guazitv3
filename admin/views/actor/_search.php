<?php
use metronic\widgets\InlineFilterForm;
?>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'area_id')->dropDownList($searchModel->areaList, ['prompt' => '全部'])->wrapper(['width' => 2])->label('演员地域') ?>
<?= $form->field($searchModel, 'actor_name')->label('主演名')->textInput() ?>
<?= InlineFilterForm::end() ?>
