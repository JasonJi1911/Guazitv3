<?php

use admin\models\user\TaskInfo;
use yii\helpers\Html;
use metronic\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form metronic\widgets\ActiveForm */
/* @var $model admin\models\user\TaskInfo */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'title')->textInput(['readonly' => 'readonly']) ?>

    <?= $form->field($model, 'desc')->textInput() ?>

    <?= $form->field($model, 'award_type')->dropDownList(TaskInfo::$awardTypeMap)->hint('如果是会员则表示天') ?>

    <?= $form->field($model, 'award_num')->numberInput(['step' => 0.01, 'min' => 0]) ?>

    <?php if ($model->task_type == TaskInfo::TASK_TYPE_DAILY):?>
        <?= $form->field($model, 'limit_num')->numberInput(['step' => 0.01])?>
        <?= $form->field($model, 'icon')->imageUpload(['width' => '100', 'height' => '100'])->hint('icon图,尺寸建议为100*100')?>
    <?php endif;?>

    <?php ActiveForm::end() ?>

</div>
