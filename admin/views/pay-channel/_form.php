<?php

use metronic\widgets\ActiveForm;
use admin\models\pay\PayChannel;
?>

<div class="advert-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'channel_name')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?= $form->field($model, 'icon')->imageUpload(['width' => 200, 'height' => 200])->hint('建议尺寸200*200') ?>

    <?php if(in_array($model->channel_type, [PayChannel::CHANNEL_TYPE_THIRD_WAP, PayChannel::CHANNEL_TYPE_THIRD_WEBVIEW]) && $model->pid == 0) :?>
        <?= $form->field($model, 'gateway')->textInput(['maxlength' => true])->hint('支付网关，支付时会携带参数跳转到该地址') ?>
    <?php endif ?>

    <?= $form->field($model, 'min_price')->moneyInput() ?>

    <?= $form->field($model, 'max_price')->moneyInput()->hint('填0时，不限制') ?>

    <?php ActiveForm::end() ?>

</div>
