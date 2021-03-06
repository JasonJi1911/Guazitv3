<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
use admin\models\video\VideoChannel;
use yii\helpers\ArrayHelper;
?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model,'title')->textInput() ?>
<?= $form->field($model, 'channel_id')->dropDownList(ArrayHelper::map(VideoChannel::find()->all(), 'id', 'channel_name'), ['prompt' => '首页' ])?>
<?= $form->field($model,'content')->textInput() ?>
<?= $form->field($model, 'display_order')->numberInput(['min' => 0, 'max' => '255'])->wrapper(['width' => 3])->hint('0 ~ 255之间，值越大，显示越靠前') ?>
<?= $form->field($model, 'status')->dropDownList($model::$statusMap)->wrapper(['width' => 2]) ?>

<?php ActiveForm::end() ?>

