<?php

use admin\models\pay\Goods;
use yii\helpers\Html;
use metronic\widgets\ActiveForm;

$this->registerJs('$(".field-goods-flag").on("change", ":checkbox", function() {
        var $this = $(this);
        var value = $this.val();

        $("#goods-flag").val(function(index, flag) {
            if ($this.prop("checked")) {
                return flag | value;
            } else {
                return flag & ~value;
            }
        });
    });');

/* @var $this yii\web\View */
/* @var $model common\models\pay\Goods */
/* @var $type common\models\pay\Goods::TYPE_RECHARGE*/
/* @var $form metronic\widgets\ActiveForm */
$radioList = array_merge([0 => '无'], Goods::$tagMap);
?>

<div class="goods-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->moneyInput(['value' => $model->price ? $model->price : '']) ?>

    <?= $form->field($model, 'content')->numberInput(['min' => 0])->label('卡券数量')->label('卡券数量<span class="required">*</span>') ?>

    <?= $form->field($model, 'giving')->hint('只对会员生效')->moneyInput() ?>

    <?= $form->field($model, 'apple_id')->textInput(['maxlength' => true]) ?>

    <?php if ($model->isNewRecord): ?>

        <?= $form->field($model, 'tag')->radioList($radioList,['value' => 0])->hint('此处标签只在端上显示作用，无实际逻辑') ?>

    <?php else: ?>

        <?= $form->field($model, 'tag')->radioList($radioList)->hint('此处标签只在端上显示作用，无实际逻辑') ?>

    <?php endif ?>



    <?= $form->field($model, 'limit_num')->numberInput(['min' => 0]) ?>

    <?= $form->field($model, 'display_order')->numberInput(['min' => 0, 'max' => 255])->hint('值越大显示越靠前，最大255') ?>

    <?= $form->field($model, 'type')->hiddenInput(['value' => Goods::TYPE_COUPON])->label(false) ?>

    <?php ActiveForm::end() ?>

</div>
