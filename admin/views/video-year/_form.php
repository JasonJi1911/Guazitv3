<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
use admin\models\User;
?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>
<?= $form->field($model,'description')->textarea(['rows' => 4]) ?>
<?= $form->field($model, 'display_order')->numberInput(['min' => 0, 'max' => '255'])->hint('0 ~ 255之间，值越大展示越靠前')->wrapper(['width' => 2])?>
<?php ActiveForm::end() ?>
