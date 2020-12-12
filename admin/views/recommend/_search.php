<?php
/* @var $this yii\web\View */
use metronic\widgets\InlineFilterForm;
use yii\helpers\ArrayHelper;
use admin\models\video\VideoChannel;
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

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'channel_id')->dropDownList(ArrayHelper::map(VideoChannel::findAll(['status' => VideoChannel::STATUS_ENABLED]), 'id', 'channel_name'), ['prompt' => '全部']) ?>
<?= $form->field($searchModel, 'title') ?>
<?= InlineFilterForm::end() ?>
