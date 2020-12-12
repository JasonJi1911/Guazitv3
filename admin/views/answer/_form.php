<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'type')->dropDownList(\admin\models\Answer::$typeMap)?>
<?= $form->field($model, 'answer')->textInput(['maxlength' => true]) ?>
<?php ActiveForm::end() ?>
