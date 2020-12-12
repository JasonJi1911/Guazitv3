<?php

use common\models\Category;
use metronic\widgets\ActiveForm;
?>

<div class="category-form">

    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'wechat_app_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'wechat_app_secret')->textInput(['maxlength' => true]) ?>
    <?php ActiveForm::end() ?>

</div>
