<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use admin\models\VideoChannel;

$this->registerJs('$(".field-video-flag").on("change", ":checkbox", function() {
        var $this = $(this);
        var value = $this.val();
        
        $("#topic-flag").val(function(index, flag) {
            if ($this.prop("checked")) {
                return flag | value;
            } else {
                return flag & ~value;
            }
        });
    });');

?>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'name')->wrapper(['width' => 5]) ?>

<?= $form->field($model, 'channel_id')->dropDownList(ArrayHelper::map(\admin\models\video\VideoChannel::findAll(['deleted_at' => 0]), 'id', 'channel_name'))->label('所属频道')->wrapper(['width' => 3])?>

<?= $form->field($model, 'cover')->imageUpload(['width' => 250, 'height' => 100])->hint('建议上传702*316px的图片')->label('图片<span class="required">*</span>') ?>

<?= $form->field($model, 'intro')->textarea(['rows' => 5])->wrapper(['width' => 5]) ?>

<?= $form->field($model, 'display_order')->numberInput(['min' => 0, 'max' => '255'])->hint('0 ~ 255之间，值越大展示越靠前')->wrapper(['width' => 2])?>

<?= $form->field($model, 'is_hot')->dropDownList($model::$isHotMap)->label('是否为热门')->hint('选择热门时，该专题将在热门专题显示')->wrapper(['width' => 2])?>

<?php ActiveForm::end() ?>
