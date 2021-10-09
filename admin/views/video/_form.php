<?php
/* @var $this yii\web\View */
/* @var $model Video */

use metronic\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use admin\models\video\VideoChannel;
use admin\models\video\Video;
use yii\helpers\Html;
use admin\models\video\VideoArea;
use admin\models\video\VideoYear;
use admin\models\video\VideoSource;

\metronic\assets\MultipleSelect2Asset::register($this);

$horizontal_cover_width = ADMIN_COMIC_HORIZONTAL_WIDTH * 4;
$horizontal_cover_height = ADMIN_COMIC_HORIZONTAL_HEIGHT * 4;

?>
<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'title')->wrapper(['width' => 3, 'maxlength' => true]) ?>

<?= $form->field($model, 'summary')->wrapper(['width' => 3]) ?>

<?= $form->field($model, 'channel_id')->dropDownList(ArrayHelper::map(VideoChannel::find()->all(), 'id', 'channel_name'))->label('所属频道')->wrapper(['width' => 3])?>

<div class="form-group field-comic-cat">
    <label class="col-md-3 control-label" for="comic-cat">分类
        <span class="required" aria-required="true"> * </span>
    </label>
    <?= Html::hiddenInput('category_ids', is_array($model->category_ids) ? implode(',', $model->category_ids) : $model->category_ids)?>
    <div class="col-md-9" id="checkbox_category">

    </div>
</div>

<div class="form-group field-comic-cat">
    <label class="col-md-3 control-label" for="comic-cat">发布端
        <span class="required" aria-required="true"> * </span>
    </label>
    <div class="col-md-9" id="checkbox_client">
        <?php foreach (\api\helpers\Common::productTexts() as $value => $label): ?>
            <label class="checkbox-inline">

                <input type="checkbox" name="Video[client][]" value="<?= $value ?>" <?= ($model->isNewRecord || strpos($model->publish_clients, (string)$value) !== false) ? 'checked="checked"' : '' ?>> <?= $label ?>
            </label>
        <?php endforeach ?>
    </div>
</div>

<?= $form->field($model, 'cover')->imageUpload(['width' => Video::ADMIN_COVER_WIDTH, 'height' => Video::ADMIN_COVER_HEIGHT])->hint('建议上传150px*200px的图片')->label('竖版封面<span class="required">*</span>') ?>

<?= $form->field($model, 'horizontal_cover')->imageUpload(['width' => $horizontal_cover_width, 'height' => $horizontal_cover_height])->hint('建议大小'.$horizontal_cover_width.'*'.$horizontal_cover_height.'px的图片，为了保证端上展示效果，务必上传横板封面')->label('横板封面<span class="required">*</span>') ?>

<div class="form-group field-video-actor required">
    <label class="col-md-3 control-label" for="video-actor">主演:</label>
    <div class="col-md-5">
        <div class="input-group input-group-lg select2-bootstrap-append">
            <select id="select2-button-addons-single-input-group-lg"
                    class="form-control js-data-example-ajax select2-hidden-accessible" multiple="" tabindex="-1" aria-hidden="true" name="Video[actors][]">
                <?php foreach ($model->actor as $actor):?>
                    <option value="<?= $actor->actor_id?>" selected="selected"><?= $actor->actor_name?></option>
                <?php endforeach;?>
            </select>
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"
                        data-select2-open="select2-button-addons-single-input-group-lg">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
        <div class="help-block">必须把导演排到首页</div>
    </div>
</div>


<?= $form->field($model, 'score')->numberInput(['width' => 3,'min' => '1', 'max' => 100, 'value' => $model->score ?: 1])->hint('请输入1-100的数字') ?>


<?= $form->field($model, 'total_views')->numberInput(['width' => 3, 'min' => 0]) ?>

<?= $form->field($model, 'total_favors')->numberInput(['width' => 3, 'min' => 0]) ?>

<?= $form->field($model, 'is_finished')->dropDownList(Video::$finishedStatus)->wrapper(['width' => 2]) ?>

<?= $form->field($model, 'is_down')->dropDownList(Video::$isDownMap)->wrapper(['width' => 2]) ?>

<?= $form->field($model,'area')->dropDownList(ArrayHelper::map(VideoArea::findAll(['deleted_at' => 0]),'id','area'))->wrapper(['width' => 3]) ?>

<?= $form->field($model,'year')->dropDownList(ArrayHelper::map(VideoYear::findAll(['deleted_at' => 0]),'id','year'))->wrapper(['width' => 3]) ?>

<?= $form->field($model,'total_price')->numberInput(['width' => 3, 'min' => 0])->hint('单位（张），本影片总价格，当本影片有用券剧集时，改价格才生效') ?>

<?= $form->field($model, 'status')->dropDownList(Video::$statusMap)->wrapper(['width' => 2]) ?>

<?= $form->field($model, 'is_sensitive')->dropDownList(Video::$sensitivityMap)->hint('敏感视频不会出现在书库和搜索结果中，只能通过推荐位和推送等形式触达用户')->wrapper(['width' => 2]) ?>

<?= $form->field($model, 'description')->textarea(['rows' => 5])->wrapper(['width' => 5]) ?>

<?php foreach ($model->chapterSource as $i => $s){?>
    <input type="hidden" name="Video[chapters][<?=$i?>][id]" value="<?=$s['id']?>" />
    <?= $form->field($model, "chapters[$i][resource_url]")->textarea(['value' => $s['resource_url'],'rows' => 5])->wrapper(['width' => 5])->hint('填写完整可播放连接,格式：标题+$+链接')->label($s['name']) ?>
<?php }?>

<?php ActiveForm::end() ?>
<script type="text/javascript">

    window.onload = function () {

        $('#video-channel_id').change(function () {
            var channel_id = $(this).val();
            videoTag(channel_id);
        });

        // 标签显示
        function videoTag(channel_id) {

            var category_ids = $("input[name='category_ids']").val().split(',');
            var html = '';
            $.post('/video/category-search', {'channel_id':channel_id}, function (data) {
                $.each(JSON.parse(data),function (index, value) {
                    if ($.inArray(value.id,category_ids) >= 0) {
                        html += '<label class="checkbox-inline"><input type="checkbox" checked="checked" name="Video[category][]" value='+ value.id +'>' + value.title + '</label>';
                    } else {
                        html += '<label class="checkbox-inline"><input type="checkbox" name="Video[category][]" value='+ value.id +'>' + value.title + '</label>';
                    }
                });
                $('#checkbox_category').empty();
                $('#checkbox_category').append(html);
            });
        }

        videoTag($('#video-channel_id').val());
    }

</script>
