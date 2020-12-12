<?php
/* @var $this yii\web\View*/
use metronic\widgets\ActiveForm;

?>

<div class="note note-info">
    客服信息
</div>

<div class="portlet-body">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'wechat')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'qq')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'telphone')->textInput(['maxlength' => true]) ?>
    <?php ActiveForm::end() ?>
</div>
