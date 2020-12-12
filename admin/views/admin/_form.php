<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use metronic\widgets\ActiveForm;
use admin\models\Admin;
use admin\models\Role;
use admin\models\Book;

/* @var $this yii\web\View */
/* @var $model admin\models\Admin */
/* @var $form metronic\widgets\ActiveForm */


?>
<div class="note note-info">
    <p style="color: red">创建管理员时需要选择角色，如没有角色需要新增</p>
</div>

<div class="admin-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput(['value' => ''])->hint('密码长度在6~18位之间') ?>
    <?php if ($model->isNewRecord):?>
    <?= $form->field($model, 'role_id')->dropDownList(ArrayHelper::map(Role::find()->where(['>', 'id', 1])->all(), 'id', 'name'))->wrapper(['width' => 2])->hint('<a href="/manager/role/create">点我新增角色</a>') ?>
    <?php endif;?>

    <?= $form->field($model, 'status')->dropDownList(Admin::$statuses)->wrapper(['width' => 2]) ?>
    <?php ActiveForm::end() ?>

</div>
