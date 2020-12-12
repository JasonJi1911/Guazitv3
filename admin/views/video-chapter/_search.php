<?php
use metronic\widgets\InlineFilterForm;
?>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'title')->label('剧集')->textInput() ?>
<?= InlineFilterForm::end() ?>