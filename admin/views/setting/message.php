<?php
/* @var $this yii\web\View*/
use metronic\widgets\ActiveForm;
use \admin\models\apps\AppsMessage;

$js = <<<JS
    $("#appsmessage-message_type").change(function(){
        var type = $(this).val();
        if (type == 1) {
            $(".aliyun").show();
            $(".yunzhixun").hide();
        } else {
            $(".aliyun").hide();
            $(".yunzhixun").show();
        }
    });
JS;
$this->registerJs($js);

?>

<div class="note note-info">
    短信服务设置
</div>

<div class="portlet-body">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'message_type')->dropDownList(AppsMessage::$messageType) ?>
    <div class="aliyun" <?php if ($model->message_type == AppsMessage::MESSAGE_YUNZHIXUN) {echo 'style="display:none"';} ?>>
    <?= $form->field($model, 'ali_sign_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ali_verify_code')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="yunzhixun" <?php if ($model->message_type == AppsMessage::MESSAGE_ALIYUN) {echo 'style="display:none"';} ?>>
    <?= $form->field($model, 'yun_account_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'yun_token')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'yun_app_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'yun_template_id')->textInput(['maxlength' => true]) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>

