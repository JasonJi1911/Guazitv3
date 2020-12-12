<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\pay\Goods */

$this->title = '修改套餐';
$this->params['breadcrumbs'][] = ['label' => '充值套餐', 'url' => ['/goods/recharge']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
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
