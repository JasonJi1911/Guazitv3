<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RechargeRate */

$this->title = '更新管理员信息';
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recharge-rate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
