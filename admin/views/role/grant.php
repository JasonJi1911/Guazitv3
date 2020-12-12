<?php

use yii\helpers\Html;
use metronic\widgets\ActiveForm;

$this->title = '角色授权';
$this->params['breadcrumbs'][] = ['label' => '角色管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss('#usergroup-permissions-tree .jstree-themeicon { display:none; }');
$this->registerJsFile('/js/role-grant-form.js', ['depends' => ['metronic\assets\JSTreeAsset']]);
?>

<div class="role-grant-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'name')->textInput(['readonly' => 1]) ?>
    
    <div class="form-group">
        <label class="col-md-3 control-label" for="usergroup-permission">权限<span class="required">*</span></label>
        <div class="col-md-4">
            <?= Html::hiddenInput('permissions', join(',', $grantedPermissions)) ?>
            <div id="permissions" data-json='<?= json_encode(array_values($permissions)) ?>'></div>
        </div>
    </div>

    <?php ActiveForm::end() ?>

</div>
