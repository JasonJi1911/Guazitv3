<?php

use metronic\widgets\ActiveForm;
use admin\models\advert\Advert;

use api\models\advert\AdvertPosition;
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
    $("#upload_type input[type=radio]").click(function(){
        var value = $(this).val();
        if(value==1){
            $("#upload_type1").show();
            $("#upload_type2").hide();
        }else{
            $("#upload_type1").hide();
            $("#upload_type2").show();
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
        <div class="form-group field-comic-cat">
            <label class="col-md-3 control-label" for="comic-cat">上传类型
                <span class="required" aria-required="true"> * </span>
            </label>
            <div class="col-md-9" id="upload_type">
                <label class="radio-inline"><input type="radio" checked="checked" name="upload_type" value="1">图片或视频</label>
                <label class="radio-inline"><input type="radio" name="upload_type" value="2">m3u8地址</label>
            </div>
        </div>
        <div id="web_advert_info">
            <div id='upload_type1'>
            <?php
            switch (intval(Yii::$app->request->get('position_id'))) {
                case AdvertPosition::POSITION_VIDEO_INDEX_PC :
                case AdvertPosition::POSITION_PLAY_BEFORE_PC :
                case AdvertPosition::POSITION_FLASH_PC :
                case AdvertPosition::POSITION_VIDEO_TOP_PC :
                case AdvertPosition::POSITION_VIDEO_BOTTOM_PC :
                    echo $form->field($model, 'image')->imageUpload(['width' => '600px', 'height' => '200px'])->hint('建议尺寸1196*130')->label('广告图<span class="required">*</span>');
                    break;
                default:
                    echo $form->field($model, 'image')->imageUpload(['width' => '600px', 'height' => '200px'])->hint('建议尺寸600*200')->label('广告图<span class="required">*</span>');
                    break;
            }
            ?>

            </div>
            <div id='upload_type2' style="display:none;">
                <?= $form->field($model, 'imageurl')->textInput(['value' => $model->image,'maxlength' => true, 'placeholder' => '广告地址链接',"class"=>"upload_type2 form-control"])->label('广告地址<span class="required">*</span>')?>
            </div>
<!--            --><?//= $form->field($model, 'image')->imageUpload(['width' => '600px', 'height' => '200px'])->hint('建议尺寸600*200')->label('广告图<span class="required">*</span>') ?>

            <?= $form->field($model, 'url_type')->dropDownList(Advert::$urlTypes)->wrapper(['width' => 2]) ?>

            <?php
            // if (intval(Yii::$app->request->get('position_id')) == AdvertPosition::POSITION_PLAY_BEFORE_PC
            //     || intval(Yii::$app->request->get('position_id')) == AdvertPosition::POSITION_PLAY_BEFORE) {
            //     echo $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(IpAddress::find()->groupBy('city')->all(), 'id', 'city'))->wrapper(['width' => 2]);
            // }
            echo $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(IpAddress::find()->where(['not', ['sort' => 0]])->groupBy('city')->orderBy("sort desc")->all(), 'id', 'city'), ['prompt' => '全部' ])->wrapper(['width' => 2]);
            ?>
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
                if(strpos($model->image, '.m3u8')!==false){
                    $radio1 = '';
                    $radio2 = 'checked="checked"';
                    $style1 = 'style="display: none;"';
                    $style2 = '';
                }else{
                    $radio1 = 'checked="checked"';
                    $radio2 = '';
                    $style1 = '';
                    $style2 = 'style="display: none;"';
                }
                echo "<div class='form-group field-comic-cat'>";
                echo "    <label class='col-md-3 control-label' for='comic-cat'>上传类型";
                echo "        <span class='required' aria-required='true'> * </span>";
                echo "    </label>";
                echo "    <div class='col-md-9' id='upload_type'>";
                echo "        <label class='radio-inline'><input type='radio' ".$radio1." name='upload_type' value='1'>图片或视频</label>";
                echo "        <label class='radio-inline'><input type='radio' ".$radio2."name='upload_type' value='2'>m3u8地址</label>";
                echo "    </div>";
                echo "</div>";
                echo "<div id='upload_type1' ".$style1.">";

                switch (intval(Yii::$app->request->get('position_id'))) {
                    case AdvertPosition::POSITION_VIDEO_INDEX_PC :
                    case AdvertPosition::POSITION_PLAY_BEFORE :
                    case AdvertPosition::POSITION_PLAY_BEFORE_PC :
                    case AdvertPosition::POSITION_FLASH_PC :
                    case AdvertPosition::POSITION_VIDEO_TOP_PC :
                    case AdvertPosition::POSITION_VIDEO_BOTTOM_PC :
                    {
                        echo $form->field($model, 'image')->imageUpload(['width' => '600px', 'height' => '200px'])->hint('建议尺寸1196*130')->label('广告图<span class="required">*</span>');
                        if (strpos($model->image, '.mp4') !== false)
                            echo '<video class="col-xs-offset-1" style="width: 600px; height: 200px;" controls="controls" autoplay="autoplay"><source src="'.$model->image.'" type="video/mp4"></video>';
                        break;
                    }
                    default:
                        echo $form->field($model, 'image')->imageUpload(['width' => '600', 'height' => '200'])->hint('建议上传600*200的图片');
                        break;
                }

                echo "</div>";
                echo "<div id='upload_type2' ".$style2.">";
                echo $form->field($model, 'imageurl')->textInput(['value' => $model->image,'maxlength' => true, 'placeholder' => '广告地址链接',"class"=>"upload_type2 form-control"])->label('广告地址<span class="required">*</span>');
                echo "</div>";
                // echo $form->field($model, 'image')->imageUpload(['width' => '600', 'height' => '200'])->hint('建议上传600*200的图片');

                echo $form->field($model, 'url_type')->dropDownList(Advert::$urlTypes)->wrapper(['width' => 2]);
                // if (intval(Yii::$app->request->get('position_id')) == AdvertPosition::POSITION_PLAY_BEFORE_PC
                // || intval(Yii::$app->request->get('position_id')) == AdvertPosition::POSITION_PLAY_BEFORE) {
                //     echo $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(IpAddress::find()->groupBy('city')->all(), 'id', 'city'))->wrapper(['width' => 2]);
                // }
                echo $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(IpAddress::find()->where(['not', ['sort' => 0]])->groupBy('city')->orderBy("sort desc")->all(), 'id', 'city'), ['prompt' => '全部' ])->wrapper(['width' => 2]);
                echo $form->field($model, 'skip_url')->textInput(['maxlength' => true, 'placeholder' => 'http://或https://']);
                echo $form->field($model, 'platform')->dropDownList(Advert::$platformmap)->wrapper(['width' => 2]);
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
