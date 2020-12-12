<?php

use metronic\widgets\ActiveForm;
use admin\models\advert\Advert;

$js = <<<JS
    $("#advert-ad_type").change(function(){
        $('#sdk_advert_size').hide();
        var adType = $(this).val();
        if (adType == 1) {
            $("#web_advert_info").show();
            $("#sdk_advert_info").hide();
        } else {
            $("#web_advert_info").hide();
            $("#sdk_advert_info").show();
            if (adType == 4) {
                $('#sdk_advert_size').show();
            }
        }
    });
JS;
$this->registerJs($js);
?>

<div class="advert-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'position_id')->hiddenInput(['value' => Yii::$app->request->get('position_id')])->label(false) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => '广告标题']) ?>

    <?php if ($model->isNewRecord):?>
        <div id="web_advert_info">
            <?= $form->field($model, 'image')->imageUpload(['width' => '600px', 'height' => '200px'])->hint('建议尺寸600*200')->label('广告图<span class="required">*</span>') ?>

            <?= $form->field($model, 'url_type')->dropDownList(Advert::$urlTypes)->wrapper(['width' => 2]) ?>

            <?= $form->field($model, 'skip_url')->textInput(['maxlength' => true, 'placeholder' => 'http://或https://']) ?>
        </div>

        <div id="sdk_advert_info" style="display:none">
            <?= $form->field($model, 'ad_key')->textInput([])?>

            <?= $form->field($model, 'ad_android_key')->textInput([])?>
        </div>

        <div id="sdk_advert_size" style="display:none">
            <?= $form->field($model, 'width')->textInput([])->hint('广点通类型广告请填写宽度')?>

            <?= $form->field($model, 'height')->textInput([])->hint('广点通类型广告请填写高度')?>
        </div>

    <?php else:?>
        <?php
        switch ($model->ad_type) {
            case Advert::AD_TYPE_WEB : // web广告
                echo $form->field($model, 'image')->imageUpload(['width' => '600', 'height' => '200'])->hint('建议上传600*200的图片');

                echo $form->field($model, 'url_type')->dropDownList(Advert::$urlTypes)->wrapper(['width' => 2]);
                echo $form->field($model, 'skip_url')->textInput(['maxlength' => true, 'placeholder' => 'http://或https://']);
                break;

            default :   //sdk广告
                echo $form->field($model, 'ad_key')->textInput([]);

                echo $form->field($model, 'ad_android_key')->textInput([]);

                if ($model->ad_type == Advert::AD_TYPE_GUANGDIANTONG) {
                    echo $form->field($model, 'width')->textInput([])->hint('广点通类型广告请填写宽度');

                    echo $form->field($model, 'height')->textInput([])->hint('广点通类型广告请填写高度');
                }

                break;
        }
        ?>
    <?php endif;?>

    <?php ActiveForm::end() ?>

</div>
