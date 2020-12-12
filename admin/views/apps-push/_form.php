<?php


use metronic\widgets\ActiveForm;
?>

<div class="category-form">

    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'app_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ios_app_key')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ios_app_secret')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'android_app_key')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'android_app_secret')->textInput(['maxlength' => true]) ?>
    <?php ActiveForm::end() ?>

</div>
