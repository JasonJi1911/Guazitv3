<?php
use metronic\widgets\InlineFilterForm;
?>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'name')->label('名称')->textInput() ?>
<?= InlineFilterForm::end() ?>