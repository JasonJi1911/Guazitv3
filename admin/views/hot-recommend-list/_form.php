<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
use admin\models\video\HotRecommend;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
$this->registerJsFile('/js/video-select2.js', ['depends' => 'metronic\assets\Select2Asset']);
?>
<div class="note note-info">
    <p>添加的热词显示在各端搜索页的热门搜索的关键词列表中
    </p>
</div>

<?php $form = ActiveForm::begin() ?>


<?php if ($model->isNewRecord): ?>
    <?= Html::activeHiddenInput($model, 'recommend_id', ['value' => Yii::$app->request->get('recommend_id')]) ?>
    <?= $form->field($model, 'video_id')->select2($model->video_id ? [$model->video_id => $model->video->title] : [], ['class' => 'series']) ?>
    <?= $form->field($model, 'recommend_id')->hiddenInput(['value' => Yii::$app->request->get('recommend_id')])->label(false)?>
<?php else:?>
    <?= $form->field($model, 'video_id')->textInput(['value' => $model->video->title, 'disabled' => true])->wrapper(['width' => 5]) ?>
<?php endif;?>

<?= $form->field($model, 'display_order')->numberInput(['min' => 0])->wrapper(['width' => 3])?>
<?php ActiveForm::end() ?>
