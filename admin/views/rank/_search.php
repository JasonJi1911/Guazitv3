<?php
/* @var $this yii\web\View */
use metronic\widgets\InlineFilterForm;

?>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'title') ?>
<?= InlineFilterForm::end() ?>
