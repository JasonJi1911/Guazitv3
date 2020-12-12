<?php
/* @var $this yii\web\View*/
use metronic\widgets\ActiveForm;

?>

<div class="note note-info">
    支付宝支付需要先申请支付宝APP支付<br>
    支付宝公钥直接粘贴保存即可<br>
    商户私钥需要去掉首尾-----BEGIN RSA PRIVATE KEY-----，并去掉回车，然后粘贴保存。
</div>

<div class="portlet-body">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'alipay_app_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'alipay_public_key')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'rsa_private_key')->textarea(['rows' => 12]) ?>
    <?php ActiveForm::end() ?>
</div>

