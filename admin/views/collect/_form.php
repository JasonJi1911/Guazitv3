<?php

use metronic\widgets\ActiveForm;
use admin\models\collect\Collect;
use admin\models\video\VideoSource;

use common\models\IpAddress;
use yii\helpers\ArrayHelper;

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

<div class="collect-form">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'collect_id')->hiddenInput(['value' => Yii::$app->request->get('collect_id')])->label(false) ?>

    <?= $form->field($model, 'collect_name')->textInput(['maxlength' => true, 'placeholder' => '采集名称']) ?>

    <?= $form->field($model, 'collect_url')->textInput(['maxlength' => true, 'placeholder' => '采集链接']) ?>

    <?= $form->field($model, 'collect_type')->dropDownList(Collect::$dataTypes)->wrapper(['width' => 3]) ?>

    <?= $form->field($model, 'collect_mid')->dropDownList(Collect::$resourceMap)->wrapper(['width' => 3]) ?>

    <?= $form->field($model, 'collect_opt')->dropDownList(Collect::$collectOptions)->wrapper(['width' => 3]) ?>

    <?= $form->field($model, 'collect_filter')->dropDownList(Collect::$collectFilters)->wrapper(['width' => 3]) ?>

    <?= $form->field($model, 'video_source')->dropDownList(ArrayHelper::map(VideoSource::find()->all(), 'id', 'name'))->wrapper(['width' => 3]) ?>

    <?= $form->field($model, 'isdownload')->dropDownList(Collect::$isDownloadPic)->wrapper(['width' => 3]) ?>

    <?= $form->field($model, 'collect_param')->textInput(['maxlength' => true, 'placeholder' => '采集参数'])->hint('提示信息：一般&开头，例如老版xml格式采集下载地址需加入&ct=1') ?>

    <?= $form->field($model, 'collect_filter_from')->textInput(['maxlength' => true, 'placeholder' => '过滤代码'])->hint('过滤提示：多组地址的资源开启白名单后只会入库指定代码的地址。比如 youku,iqiyi') ?>
    <?php ActiveForm::end() ?>
</div>
