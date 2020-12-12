<?php
use metronic\widgets\InlineFilterForm;
?>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'year')->label('年代')->textInput() ?>
<?= InlineFilterForm::end() ?>