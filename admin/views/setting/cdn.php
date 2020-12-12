<?php
/* @var $this yii\web\View*/
use metronic\widgets\ActiveForm;

?>

<div class="note note-info">
    cdn设置
</div>

<div class="portlet-body">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'cdn_switch')->switch($model::$itemsMap) ?>
    <?= $form->field($model, 'cdn_host_path')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'cdn_mp_asset')->textInput(['maxlength' => true]) ?>
    <?php ActiveForm::end() ?>
</div>

