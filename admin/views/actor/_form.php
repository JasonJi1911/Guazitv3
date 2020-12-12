<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
use admin\models\User;
?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'actor_name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model,'avatar')->imageUpload(['width' => 300, 'height' => 300])->hint('建议上传300px*300px的图片')->label('头像<span class="required"> * </span>') ?>
<?= $form->field($model, 'weight')->numberInput(['min' => 0, 'max' => 100000000])->hint('权重越大越靠前')->wrapper(['width' => 3]) ?>
<?= $form->field($model, 'type')->dropDownList($model::$actionMap)->wrapper(['width' => 2]) ?>
<?= $form->field($model, 'area_id')->dropDownList($model->areaList)->wrapper(['width' => 2])->label('演员地域') ?>
<?php ActiveForm::end() ?>
