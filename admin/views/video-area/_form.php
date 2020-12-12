<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
use admin\models\User;
?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?>
<?= $form->field($model,'description')->textarea(['rows' => 4]) ?>
<?= $form->field($model,'display_order')->hint('排序,越大越靠前')?>
<?php ActiveForm::end() ?>
