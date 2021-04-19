<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
use admin\models\video\Banner;
use admin\models\video\VideoChannel;
use common\models\IpAddress;
use yii\helpers\ArrayHelper;


$this->registerJsFile('/js/video-select2.js', ['depends' => 'metronic\assets\Select2Asset']);

$js = <<<JS
    $('#action').on('change', function() {
        var action = $(this).val(); 
        if (action == 1) { //漫画详情
            $('#book').show();
            $('#scheme').hide();
            $('#url').hide();
        } else if (action == 2) { //APP内部
            $('#book').hide();
            $('#scheme').show();
            $('#url').hide();
        } else { //链接
            $('#book').hide();
            $('#scheme').hide();
            $('#url').show();
        }
    })
    
    $('#banner-position').on('change', function(){
        if ($(this).val() >= '3') {
            $('.field-banner-status').hide();
        } else {
             $('.field-banner-status').show();
        }
    })

JS;

$this->registerJs($js);



?>
<style>
    .colors {
        display: -webkit-box;
        display: -webkit-flex;
        display: flex;
        flex-wrap: wrap
    }
    .colors div{
        width: 50px;
        height: 50px;
        margin-right: 4px;
        margin-bottom: 4px;
    }
    .colors div:hover{
        border: 3px solid #888;
    }
</style>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($model,'title')->textInput() ?>


<?= $form->field($model,'stitle')->textInput() ?>


<?= $form->field($model, 'action')->dropDownList($model::$actionMap, ['id' => 'action', 'disabled' => $model->isNewRecord ? false : true])?>

<?php if ($model->isNewRecord):?>
    <div id="book" style="<?= ($model->action && $model->action != Banner::ACTION_VIDEO) ? 'display: none;' : ''?>">
        <?= $form->field($model, 'video_id')->select2($model->video_id ? [$model->video_id => $model->video->title ] : [], ['class' => 'series'])->hint('作品信息必填,否则前端将无法展示')->wrapper(['width' => 5]) ?>
    </div>

    <div id="scheme" style="<?= ($model->action != Banner::ACTION_SCHEME) ? 'display: none;' : ''?>">
        <?= $form->field($model, 'scheme')->dropDownList($model::$schemeMap)->label('跳转链接')?>
    </div>

    <div id="url" style="<?= ($model->action != Banner::ACTION_URL && $model->action != Banner::ACTION_BROWSER_URL) ? 'display: none;' : ''?>">
        <?= $form->field($model, 'url')->textInput()->hint('域名请添加http://或者https://协议,否则会导致无法访问')->label('链接<span class="required">*</span>')?>
    </div>

<?php else:?>
    <?php
    switch ($model->action) {
        case Banner::ACTION_VIDEO : //漫画
            $model->video_id = $model->content;
            echo $form->field($model, 'video_id')->select2($model->video_id ? [$model->video_id => $model->video->title ] : [], ['class' => 'series'])->wrapper(['width' => 5])->hint('作品信息必填,否则前端将无法展示')->label('作品');
            break;

        case Banner::ACTION_SCHEME : //APP内页面
            $model->scheme = $model->content;
            echo $form->field($model, 'scheme')->dropDownList($model::$schemeMap)->label('跳转链接');
            break;

        case Banner::ACTION_URL : //链接
        case Banner::ACTION_BROWSER_URL:
            $model->url = $model->content;
            echo $form->field($model, 'url')->textInput()->hint('域名请添加http://或者https://协议,否则会导致无法访问')->label('链接<span class="required">*</span>');
            break;

        default :
            break;
    }
    ?>
<?php endif;?>

<?= $form->field($model, 'channel_id')->dropDownList(ArrayHelper::map(VideoChannel::find()->all(), 'id', 'channel_name'), ['prompt' => '首页' ])?>

<?= $form->field($model, 'image')->imageUpload(['width' => Banner::API_BOOK_BANNER_WIDTH, 'height' => Banner::API_BOOK_BANNER_HEIGHT])->hint('建议大小'.Banner::API_BOOK_BANNER_WIDTH.'*'.Banner::API_BOOK_BANNER_HEIGHT.',该图片是必传图片')->label('图片<span class="required" aria-required="true"> * </span>') ?>
<?= $form->field($model, 'display_order')->numberInput()->wrapper(['width' => 3])->hint('0 ~ 255之间，值越大，显示越靠前') ?>




<?= $form->field($model, 'status')->dropDownList($model::$statusMap)->wrapper(['width' => 2]) ?>

<?= $form->field($model, 'product')->dropDownList($model::$sourceBanner)->wrapper(['width' => 2])?>

<?=$form->field($model, 'city_id')->dropDownList(ArrayHelper::map(IpAddress::find()->where(['not', ['sort' => 0]])->groupBy('city')->orderBy("sort desc")->all(), 'id', 'city'), ['prompt' => '全部' ])->wrapper(['width' => 2]);?>


<?php ActiveForm::end() ?>

