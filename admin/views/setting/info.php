<?php
/* @var $this yii\web\View*/
use metronic\widgets\ActiveForm;

?>

<div class="note note-info">
    APP基础信息配置
</div>

<div class="portlet-body">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'icon')->imageUpload(['width' => 40, 'height' => 40])->hint('建议大小'. 40 . '*' . 40 . ',该图片是必传图片')->label('图标<span class="required" aria-required="true"> * </span>') ?>
    <?= $form->field($model, 'package_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'channel')->textInput(['maxlength' => true])->hint('相当于标记信息') ?>
    <?php ActiveForm::end() ?>
</div>
