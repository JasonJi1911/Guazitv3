<?php
use metronic\widgets\InlineFilterForm;
?>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'area')->label('地区名')->textInput() ?>
<?= InlineFilterForm::end() ?>