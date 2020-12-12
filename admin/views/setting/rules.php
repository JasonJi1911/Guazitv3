<?php
/* @var $this yii\web\View*/
use metronic\widgets\ActiveForm;

if (Yii::$app->session->getFlash('updated')) {
    \metronic\assets\ToastrAsset::register($this);
    $this->registerJs('toastr.success("保存成功", "", {timeOut: 1000});');
}

?>

<div class="note note-info">
    APP基础信息配置
</div>

<div class="portlet-body">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'coupon_intro')->textarea(['maxlength' => true, 'rows' => 7]) ?>
    <?= $form->field($model, 'task_intro')->textarea(['maxlength' => true, 'rows' => 7]) ?>
    <?= $form->field($model, 'score_intro')->textarea(['maxlength' => true, 'rows' => 7]) ?>
    <?php ActiveForm::end() ?>
</div>