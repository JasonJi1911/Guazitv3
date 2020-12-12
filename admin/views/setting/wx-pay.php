<?php
/* @var $this yii\web\View*/


use metronic\widgets\ActiveForm;

$this->title = '微信支付';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="note note-info">
    <p style="color: red">请注意,此处配置直接影响线上支付功能,请谨慎修改</p>
    <p style="color: red">配置时请注意APP ID是否正确且与商户号匹配</p>
    <p style="color: red">配置时请严格按照参考手册上的提示操作,否则会导致支付调起失败</p>
</div>

<div class="portlet-body">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'mch_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'api_sec_key')->textInput(['maxlength' => true]) ?>
    <?php ActiveForm::end() ?>
</div>
