<?php

use yii\helpers\Html;


/* @var $this yii\web\View */

$this->title = '新增管理员';
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>
    </div>
    <div class="portlet-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
