<?php
/* @var $this yii\web\View */
use admin\models\video\Rank;
use admin\models\video\VideoChannel;
use metronic\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'channel_id')->dropDownList(ArrayHelper::map(\admin\models\video\VideoChannel::find()->all(), 'id', 'channel_name'))?>
<?= $form->field($model, 'title')->hint('用于显示在首页各个频道底部的排行处标题')?>
<?= $form->field($model, 'description')->hint('描述,仅作后台参考,前端不展示')?>
<?= $form->field($model, 'display_order')->hint('排序,越大越靠前')?>
<?= $form->field($model, 'status')->dropDownList(\admin\models\video\Rank::$statuses)->wrapper(['width' => 2]) ?>
<?php ActiveForm::end() ?>
