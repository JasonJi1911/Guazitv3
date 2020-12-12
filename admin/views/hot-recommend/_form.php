<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
use admin\models\User;
?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'title')->textInput(['maxlength' => true])->hint('最大填写36个字符') ?>
<?= $form->field($model, 'display_order')->numberInput()->wrapper(['width' => 3])->hint('值越大，推荐显示越靠前') ?>
<?php ActiveForm::end() ?>
