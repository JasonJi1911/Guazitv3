<?php

use metronic\widgets\ActiveForm;

$this->registerJsFile('/js/video-select2.js', ['depends' => 'metronic\assets\Select2Asset']);
?>

<div class="advert-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'yy_id')->hiddenInput(['value' => Yii::$app->request->get('yy_id')])->label(false) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => '广告标题']) ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => true, 'placeholder' => '广告跳转链接']) ?>
    <?= $form->field($model, 'display_order')->numberInput(['min' => 0, 'max' => '255'])->wrapper(['width' => 3])->hint('0 ~ 255之间，值越大，显示越靠前') ?>
    <?= $form->field($model, 'status')->dropDownList($model::$statusMap)->wrapper(['width' => 2]) ?>

    <?php ActiveForm::end() ?>

</div>
