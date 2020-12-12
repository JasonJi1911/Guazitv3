<?php
/* @var $this yii\web\View */
use metronic\widgets\InlineFilterForm;

?>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'period')->dropDownList($searchModel::$periodStatus, ['prompt' => '全部']) ?>
<?= $form->field($searchModel, 'title')->label('影片标题') ?>
<?= InlineFilterForm::end() ?>
