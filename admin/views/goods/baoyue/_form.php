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
/* @var $form metronic\widgets\ActiveForm */

$radioList = array_merge([0 => '无'], Goods::$tagMap);
?>

<div class="goods-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->moneyInput() ?>

    <?= $form->field($model, 'original_price')->moneyInput()->label('商品原价')->hint('仅在端上给用户展示作用，不填默认和实际价格一致') ?>

    <?= $form->field($model, 'content')->numberInput(['min' => 0])->label('获取天数')->label('获取天数<span class="required">*</span>') ?>

    <?= $form->field($model, 'apple_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'limit_num')->numberInput(['min' => 0]) ?>


    <?php if ($model->isNewRecord): ?>

        <?= $form->field($model, 'tag')->radioList($radioList,['value' => 0])->hint('此处标签只在端上显示作用，无实际逻辑') ?>

    <?php else: ?>

        <?= $form->field($model, 'tag')->radioList($radioList)->hint('此处标签只在端上显示作用，无实际逻辑') ?>

    <?php endif ?>



    <?= $form->field($model, 'display_order')->numberInput(['min' => 0, 'max' => 255])->hint('值越大显示越靠前，最大255') ?>

    <?= $form->field($model, 'type')->hiddenInput(['value' => Goods::TYPE_VIP])->label(false) ?>

    <?php ActiveForm::end() ?>

</div>
