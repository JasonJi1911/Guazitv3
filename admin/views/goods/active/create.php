<?php

use metronic\widgets\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = '新增活动套餐';
$this->params['breadcrumbs'][] = ['label' => '活动套餐', 'url' => ['goods/active']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>
    </div>

    <div class="portlet-body">
        <div class="goods-form">

            <?php $form = ActiveForm::begin() ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'price')->moneyInput(['value' => $model->price ? $model->price/100 : '']) ?>

            <?= $form->field($model, 'giving')->moneyInput(['value' => $model->price ? $model->price/100 : ''])->label('赠送金额') ?>

            <?= $form->field($model, 'content')->hiddenInput(['value' => 0])->label(false) ?>

            <?php ActiveForm::end() ?>

        </div>
    </div>

</div>
