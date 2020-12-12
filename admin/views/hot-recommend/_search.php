<?php
use metronic\widgets\InlineFilterForm;
?>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'title')->label('标题')->textInput() ?>
<?= InlineFilterForm::end() ?>