<?php
/* @var $this yii\web\View*/
use metronic\widgets\ActiveForm;

?>

<div class="note note-info">
    图片等文件存储配置,支持存oss和本地,配置方法请参考详细手册
</div>

<div class="portlet-body">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'save_type')->dropDownList($model::$saveTypeMap) ?>
    <?= $form->field($model, 'bucket')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'server_point')->textInput(['maxlength' => true]) ?>
    <?php ActiveForm::end() ?>
</div>
