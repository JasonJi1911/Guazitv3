<?php
/* @var $this yii\web\View */
use admin\models\video\Rank;
use metronic\widgets\ActiveForm;
use yii\helpers\Html;
$this->registerJsFile('/js/video-select2.js', ['depends' => 'metronic\assets\Select2Asset']);
?>

<?php $form = ActiveForm::begin() ?>
<!-- 获取排行榜类型信息 --!>
<?php if ($model->isNewRecord): ?>
    <!-- 如果是新增，设置默认参数 --!>
    <?= Html::activeHiddenInput($model, 'rank_id', ['value' => Yii::$app->request->get('rank_id')]) ?>

    <?= $form->field($model, 'video_id')->select2($model->video_id ? [$model->video_id => $model->video->title] : [], ['class' => 'series']) ?>
<?php else:?>
    <?= $form->field($model, 'video_id')->textInput(['value' => $model->video->title, 'disabled' => true])->wrapper(['width' => 5]) ?>
<?php endif;?>

<?= $form->field($model, 'period')->dropDownList(Rank::$rankType)?>
<?= $form->field($model, 'display_order')->hint('排序,越大越靠前')?>
<?php ActiveForm::end() ?>
