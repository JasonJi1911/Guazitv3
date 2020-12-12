<?php

use yii\helpers\Html;
use yii\helpers\Url;
use metronic\widgets\ActiveForm;
use admin\modules\manager\models\Permission;
use common\helpers\Icon;

$this->registerJsFile('/js/manager/permission-form.js', ['depends' => 'metronic\assets\Select2Asset']);
?>

<div class="permission-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => '中文，不超过15个字符']) ?>
    
    <?= Html::activeHiddenInput($model, 'ppid') ?>
    <?= $form->field($model, 'pid')->dropDownList($model::getPermissionOptions(), ['prompt' => '没有上级分类', 'data-url' => Url::to(['change-pid'])]) ?>
    
    <?= $form->field($model, 'is_menu')->dropDownList(Permission::$isMenus)->wrapper(['width' => 2]) ?>

    <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'params')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->select2(Icon::simpleLines(), ['prompt' => '请选择图标']) ?>

    <?= $form->field($model, 'priority')->numberInput(['min' => 1, 'max' => $model->maxPriority]) ?>

    <?php ActiveForm::end() ?>

</div>
