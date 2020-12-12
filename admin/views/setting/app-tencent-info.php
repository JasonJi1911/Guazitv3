<?php
/* @var $this yii\web\View*/
use metronic\widgets\ActiveForm;

?>

<div class="note note-info">
    微信信息设置
</div>

<div class="portlet-body">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'wechat_app_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'wechat_app_secret')->textInput(['rows' => 6]) ?>
    <?= $form->field($model, 'qq_app_id')->textInput(['rows' => 12]) ?>
    <?php ActiveForm::end() ?>
</div>
