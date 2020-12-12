<?php

use metronic\widgets\ActiveForm;
use admin\models\advert\Advert;

?>

<div class="advert-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => '必填，最多25个字符']) ?>

    <?= $form->field($model, 'content')->textarea(['maxlength' => true, 'rows' => 7, 'placeholder' => '非必填，不能超过255个字符']) ?>

    <?php ActiveForm::end() ?>

</div>
