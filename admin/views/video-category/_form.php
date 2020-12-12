<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use admin\models\VideoChannel;

?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'channel_id')->dropDownList(ArrayHelper::map(\admin\models\video\VideoChannel::findAll(['deleted_at' => 0]), 'id', 'channel_name'))->label('所属频道')->wrapper(['width' => 3])?>
<?= $form->field($model,'description')->textarea(['rows' => 3])->hint('分类描述,后端标记作用,前端不显示') ?>
<?= $form->field($model, 'display_order')->numberInput(['min' => 0, 'max' => '255'])->hint('0 ~ 255之间，值越大展示越靠前')->wrapper(['width' => 2])?>
<?php ActiveForm::end() ?>
