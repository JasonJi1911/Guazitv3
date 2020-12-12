<?php

use common\models\Category;
use metronic\widgets\ActiveForm;
?>

<div class="category-form">

    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'app_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'package_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->imageUpload(['width' => 200, 'height' => 200])->hint('建议尺寸200*200') ?>
    <?= $form->field($model, 'channel')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'share_link')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->dropDownList(\admin\models\apps\Apps::$statuses)->wrapper(['width' => 2]) ?>
    <?php ActiveForm::end() ?>

</div>
