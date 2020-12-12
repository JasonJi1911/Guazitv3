<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'display_order')->numberInput(['min' => 0, 'max' => 256])->hint('值越大越靠前')->wrapper(['width' => 3]) ?>
<?php ActiveForm::end() ?>
