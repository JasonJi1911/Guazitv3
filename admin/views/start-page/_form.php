<?php

use metronic\widgets\ActiveForm;
use admin\models\advert\StartPage;

$this->registerJsFile('/js/video-select2.js', ['depends' => 'metronic\assets\Select2Asset']);

$js = <<<JS
    $('#skip_type').on('change', function() {
        var skip_type = $(this).val(); 
        if (skip_type == 1) { // 作品
            $('#video').show();
            $('#web_url').hide();
            $('#sdk_advert_info').hide();
            $('.field-startpage-image').show();
        } else if (skip_type == 2 || skip_type == 3) { // web_url
            $('#video').hide();
            $('#web_url').show();
            $('#sdk_advert_info').hide();
            $('.field-startpage-image').show();
        }  else { // SDK广告
            $('#video').hide();
            $('#web_url').hide();
            $('#sdk_advert_info').show();
            $('.field-startpage-image').hide();
        }
        
    })
JS;
$this->registerJs($js);

?>

<div class="start-page-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php
        $contentTypes = StartPage::$skipTypeMap;
    ?>

    <?= $form->field($model, 'skip_type')->dropDownList($contentTypes, ['id' => 'skip_type', 'disabled' => $model->isNewRecord ? false : true])?>

    <?php if ($model->isNewRecord):?>
        <div id="video">
            <?= $form->field($model, 'video_id')->select2($model->video_id ? [$model->video_id => $model->video->name] : [], ['class' => 'series'])->wrapper(['width' => 5])->hint('作品信息必填,否则前端将无法展示')->label('作品<span class="required">*</span>') ?>
        </div>

        <div id="web_url">
            <?= $form->field($model, 'web_url')->textInput()->hint('域名请添加http://或者https://协议,否则会导致无法访问')->label('链接<span class="required">*</span>')?>
        </div>

        <div id="sdk_advert_info" style="display:none">
            <?= $form->field($model, 'ad_key')->textInput([])?>

            <?= $form->field($model, 'ad_android_key')->textInput([])?>
        </div>

    <?php else:?>
        <?php
        switch ($model->skip_type) {
            case StartPage::SKIP_TYPE_VIDEO : //作品
                $model->video_id = $model->content;
                echo $form->field($model, 'video_id')->select2($model->video_id ? [$model->video_id => $model->video->title] : [], ['class' => 'series'])->wrapper(['width' => 5])->hint('作品信息必填,否则前端将无法展示')->label('作品<span class="required">*</span>');
                break;

            case StartPage::SKIP_TYPE_WEB : //链接
            case StartPage::SKIP_TYPE_BROWSER:
                $model->web_url = $model->content;
                echo $form->field($model, 'web_url')->textInput()->hint('域名请添加http://或者https://协议,否则会导致无法访问')->label('链接<span class="required">*</span>');
                break;

            default :   //sdk广告
                echo $form->field($model, 'ad_key')->textInput([]);
                echo $form->field($model, 'ad_android_key')->textInput([]);
                break;
        }
        ?>
    <?php endif;?>

    <?php if ($model->skip_type < StartPage::AD_TYPE_CHUANSHANJIA) { ?>
    <?= $form->field($model, 'image')->imageUpload(['width' => 200, 'height' => 200])->hint('建议图片尺寸1242*2208,建议压缩图片大小')->label('启动图<span class="required">*</span>') ?>
    <?php } ?>

    <?php ActiveForm::end() ?>

</div>
