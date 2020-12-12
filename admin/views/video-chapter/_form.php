<?php
/* @var yii\web\View */

use common\helpers\Tool;
use metronic\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use admin\models\video\Video;
use admin\models\video\VideoSource;

?>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'title')->wrapper(['width' => 5])->hint('端上展示剧集标题，电视剧建议填写集数，电影填写清晰度，如：1 或者 第1集，或者 高清1080P等') ?>

<!--<div class="form-group field-video-display_order">-->
<!--    <label class="col-md-3 control-label" for="video-display_order">剧集序号<span class="required" aria-required="true"> * </span></label>-->
<!--    <div class="col-md-5"><input type="number" id="video-display_order" class="form-control" name="VideoChapter[display_order]" value="1" min="0" style="width: 495px;">-->
<!--        <div class="help-block"><span style="color: red;">排序按照剧集数依次增大</span>，排序错乱会导致影片剧集排序错乱</div>-->
<!--    </div>-->
<!--</div>-->

<?= $form->field($model, 'display_order')->numberInput(['min'=>0])->wrapper(['width' => 5])->hint('<span style="color: red;">排序按照剧集数依次增大</span>，排序错乱会导致影片剧集排序错乱') ?>

<?= $form->field($model, 'duration_time')->input('text',['value' => $model->duration_time ? preg_match('/[-|:|：]/', $model->duration_time) ? $model->duration_time : Tool::secToTime($model->duration_time, '-') : 0])->hint('时间格式为：时-分-秒 或 时:分:秒，如：1-45-30，即当前视频时长为1小时45分钟30秒') ?>

<?php foreach (ArrayHelper::map(VideoSource::findAll(['created_at' => 0]), 'id', 'name') as $id => $name){?>
    <?= $form->field($model, "resource[$id]")->textInput(['value' => isset(json_decode($model->resource_url, true)[$id]) ? json_decode($model->resource_url, true)[$id] : ''])->wrapper(['width' => 5])->hint('填写完整可播放连接')->label($name) ?>
<?php }?>

<?= $form->field($model, 'total_views')->numberInput(['min' => 0, 'value' => $model->total_views ? $model->total_views : 0]) ?>

<?= $form->field($model, 'play_limit')->dropDownList(Video::$playLimitMap)->wrapper(['width' => 2])->hint('当设置为用券时，相应要设置整部影片的价格') ?>

<?php ActiveForm::end() ?>
