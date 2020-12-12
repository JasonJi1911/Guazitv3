<?php

use common\models\Category;
use metronic\widgets\ActiveForm;
?>

<div class="category-form">

    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'alipay_app_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'alipay_public_key')->textarea(['rows' => 7])->wrapper(['width' => 5]) ?>
    <?= $form->field($model, 'rsa_private_key')->textarea(['rows' => 7])->wrapper(['width' => 5]) ?>
    <?php ActiveForm::end() ?>

</div>
