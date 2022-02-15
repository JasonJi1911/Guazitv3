<?php

use metronic\widgets\ActiveForm;

$this->registerJsFile('/js/video-select2.js', ['depends' => 'metronic\assets\Select2Asset']);
?>

<div class="advert-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'trailer_title_id')->hiddenInput(['value' => Yii::$app->request->get('trailer_title_id')])->label(false) ?>

<?php if ($model->isNewRecord):?>
    <div id="book" >
        <?= $form->field($model, 'video_id')->select2($model->video_id ? [$model->video_id => $model->video->title ] : [], ['class' => 'series'])->hint('作品信息必填,否则前端将无法展示')->wrapper(['width' => 5]) ?>
    </div>

<?php else:?>
    <?php echo $form->field($model, 'video_id')->select2($model->video_id ? [$model->video_id => $model->video->title ] : [], ['class' => 'series'])->wrapper(['width' => 5])->hint('作品信息必填,否则前端将无法展示')->label('作品');?>
<?php endif;?>

<!--    --><?//= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => '标题']) ?>
<!--    --><?//= $form->field($model, 'stitle')->textInput(['maxlength' => true, 'placeholder' => '副标题']) ?>
    <?= $form->field($model, 'online_time')->datetimePickerInput(['value' => date('Y-m-d H:i:s', $model->online_time ? $model->online_time : time()), 'start-date' => date('Y-m-d')])?>
    <?= $form->field($model, 'display_order')->numberInput(['min' => 0, 'max' => '255'])->wrapper(['width' => 3])->hint('0 ~ 255之间，值越大，显示越靠前') ?>
    <?= $form->field($model, 'status')->dropDownList($model::$statusMap)->wrapper(['width' => 2]) ?>

    <?php ActiveForm::end() ?>

</div>
