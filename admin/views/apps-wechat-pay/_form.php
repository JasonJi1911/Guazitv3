<?php

use common\models\Category;
use metronic\widgets\ActiveForm;
?>

<div class="category-form">

    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'wechat_app_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'mch_id')->textarea(['rows' => 7])->wrapper(['width' => 5]) ?>
    <?= $form->field($model, 'api_sec_key')->textarea(['rows' => 7])->wrapper(['width' => 5]) ?>
    <?php ActiveForm::end() ?>

</div>
