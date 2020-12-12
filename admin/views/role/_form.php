<?php

use yii\helpers\Html;
use metronic\widgets\ActiveForm;
?>

<div class="role-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'detail')->textarea(['maxlength' => true, 'rows' => 7]) ?>


    <?php ActiveForm::end() ?>

</div>
