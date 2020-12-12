<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
use admin\models\User;
?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model,'icon')->imageUpload(['width' => 300, 'height' => 300])->hint('建议上传300px*300px的图片')->label('头像<span class="required"> * </span>') ?>
<?= $form->field($model, 'display_order')->numberInput(['min' => 0, 'max' => '255'])->wrapper(['width' => 3])->hint('0 ~ 255之间，值越大，显示越靠前') ?>
<?php ActiveForm::end() ?>
