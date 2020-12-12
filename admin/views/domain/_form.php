<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
use admin\models\User;
?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'content')->textInput(['maxlength' => true])->hint('填写完整链接')  ?>
<?= $form->field($model, 'type')->dropDownList($model::$typeMap)->wrapper(['width' => 2])?>
<?php ActiveForm::end() ?>
