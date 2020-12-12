<?php
/* @var $this yii\web\View */
use admin\models\video\VideoChannel;
use metronic\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use admin\models\video\VideoYear;
?>

<div class="note-info note">
    <h4>温馨提示:</h4>
    <h5>样式页面显示效果点击下方关键词查看</h5>
    <a href="/img/recommend/20200422220230.jpg" target="_blank">【竖排6个横排1个】</a>
    <a href="/img/recommend/02.jpg" target="_blank">【竖排6个】</a>
    <a href="/img/recommend/04.jpg" target="_blank">【横排7个】</a>
    <a href="/img/recommend/03.jpg" target="_blank">【横排6个】</a>
    <a href="/img/recommend/05.jpg" target="_blank">【竖排滑动】</a>
</div>
<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'title')->hint('用于显示在首页各个频道推荐位的标题')?>

<?= $form->field($model, 'channel_id')->dropDownList(ArrayHelper::map(VideoChannel::findAll(['deleted_at' => 0]), 'id', 'channel_name'),
    [
        'onchange' => '
         $.post("'.yii::$app->urlManager->createUrl('recommend/category').'?channelId="+$(this).val(),function(data){
                $("select#recommend-tag").html(data);
            });
         
         $.post("'.yii::$app->urlManager->createUrl('recommend/area').'?channelId="+$(this).val(),function(data){
                $("select#recommend-area").html(data);
            });
        ',
    ]
)?>

<?= $form->field($model, 'tag')->dropDownList($model->getCategory($model->channel_id), ['prompt' => '全部', 'value' => $model->getSearch('tag')])->label('标签')?>

<?= $form->field($model, 'area')->dropDownList($model->getArea($model->channel_id), ['prompt' => '全部', 'value' => $model->getSearch('area')])->label('地区')?>

<?= $form->field($model, 'year')->dropDownList(ArrayHelper::map(VideoYear::findAll(['deleted_at' => 0]), 'id', 'year'), ['prompt' => '全部', 'value' => $model->getSearch('year')])->label('年代')?>

<?= $form->field($model, 'description')->textarea(['rows' => 5])->wrapper(['width' => 5])->hint('描述,仅作后台参考,前端不展示') ?>

<?= $form->field($model, 'display_order')->numberInput(['min' => 0, 'max' => '255'])->wrapper(['width' => 5])->hint('0 ~ 255之间，排序值越大展示越靠前')?>

<?= $form->field($model, 'style')->dropDownList(\admin\models\video\Recommend::$styleMap) ?>

<?php ActiveForm::end() ?>
