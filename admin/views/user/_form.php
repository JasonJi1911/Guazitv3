<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
use admin\models\user\User;
?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>
<?= $form->field($model,'mobile')->textInput(['maxlength' => true]) ?>
<?= $form->field($model,'gender')->dropDownList(User::$genderMap)->wrapper(['width' => 2]) ?>
<?= $form->field($model,'avatar')->imageUpload(['width' => 150, 'height' => 200])->hint('建议上传150px*200px的图片') ?>
<?= $form->field($model, 'status')->dropDownList(User::$statusMap)->wrapper(['width' => 2]) ?>
<?php ActiveForm::end() ?>
