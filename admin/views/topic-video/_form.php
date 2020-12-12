<?php
/* @var $this yii\web\View */
use admin\models\video\TopicVideo;
use metronic\widgets\ActiveForm;
use yii\helpers\Html;
$this->registerJsFile('/js/video-select2.js', ['depends' => 'metronic\assets\Select2Asset']);
?>

<?php $form = ActiveForm::begin() ?>

<?php if ($model->isNewRecord): ?>
    <?= Html::activeHiddenInput($model, 'topic_id', ['value' => Yii::$app->request->get('topic_id')]) ?>
    <?= $form->field($model, 'video_id')->select2([], ['class' => 'series']) ?>
<?php else:?>
    <?= $form->field($model, 'video_id')->textInput(['value' => $model->video->title, 'disabled' => true])->wrapper(['width' => 5]) ?>
<?php endif;?>

<?= $form->field($model, 'display_order')->numberInput(['min' => 0, 'max' => '255', 'value' => $model->display_order ? $model->display_order : 1])->hint('0 ~ 255之间，值越大展示越靠前')->wrapper(['width' => 3])?>

<?php ActiveForm::end() ?>
