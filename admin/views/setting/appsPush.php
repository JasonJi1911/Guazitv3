<?php
/* @var $this yii\web\View*/
use metronic\widgets\ActiveForm;

?>

<div class="portlet-body">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'ios_app_key')->textInput(['maxlength' => true, 'rows' => 7]) ?>
    <?= $form->field($model, 'ios_app_secret')->textInput(['maxlength' => true, 'rows' => 7]) ?>
    <?= $form->field($model, 'android_app_key')->textInput(['maxlength' => true, 'rows' => 7]) ?>
    <?= $form->field($model, 'android_app_secret')->textInput(['maxlength' => true]) ?>
    <?php ActiveForm::end() ?>
</div>