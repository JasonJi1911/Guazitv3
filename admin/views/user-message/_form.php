<?php

use admin\models\user\UserMessage;
use metronic\widgets\ActiveForm;
use admin\models\MessageNotice;

$js = <<<JS
    $('#messagenotice-choice_user').change(function(){
        var choiceUser = $(this).val();
        if (choiceUser == 1) {
            $(".field-messagenotice-uid").show();
        } else {
            $(".field-messagenotice-uid").hide();
            $("#messagenotice-uid").val(0)
        }
    })
JS;
$this->registerJs($js)

?>

<div class="wx-text-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'type')->dropDownList(UserMessage::$messageMap) ?>

    <?= $form->field($model, 'content')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'uid')->numberInput(['min' => 1])->hint('用户id')->wrapper(['width' => 5])  ?>

    <?= $form->field($model, 'created_at')->hiddenInput(['value' => time()])->label(false) ?>

    <?php ActiveForm::end() ?>

</div>
