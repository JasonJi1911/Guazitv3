<?php
/* @var $this yii\web\View*/
use metronic\widgets\ActiveForm;

if (Yii::$app->session->getFlash('updated')) {
    \metronic\assets\ToastrAsset::register($this);
    $this->registerJs('toastr.success("保存成功", "", {timeOut: 1000});');
}

?>

<div class="note note-info">
    客服信息会显示在APP端 “设置-关于我们” 页面
</div>


<div class="portlet-body">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'qq')->textInput(['maxlength' => true, 'rows' => 7]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'rows' => 7]) ?>
    <?= $form->field($model, 'telphone')->textInput(['maxlength' => true, 'rows' => 7]) ?>
    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'wechat')->textInput(['maxlength' => true]) ?>
    <?php ActiveForm::end() ?>
</div>