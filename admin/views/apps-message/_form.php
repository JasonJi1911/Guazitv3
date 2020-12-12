<?php

use common\models\Category;
use metronic\widgets\ActiveForm;
?>

<div class="category-form">

    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'message_type')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ali_sign_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ali_verify_code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'yun_account_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'yun_token')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'yun_app_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'yun_template_id')->textInput(['maxlength' => true]) ?>
    <?php ActiveForm::end() ?>

</div>
