<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
use common\models\video\City;
use yii\helpers\ArrayHelper;
use admin\models\advert\AdvertYYTitle;
?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model,'title')->textInput() ?>
<?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(City::find()->groupBy('city_name')->orderBy("id asc")->all(), 'id', 'city_name'))?>
<?= $form->field($model, 'product')->dropDownList($model::$productMap)->wrapper(['width' => 2])?>
<?= $form->field($model, 'platform')->dropDownList(AdvertYYTitle::$platformmap)->wrapper(['width' => 2]) ?>
<?= $form->field($model, 'display_order')->numberInput(['min' => 0, 'max' => '255'])->wrapper(['width' => 3])->hint('0 ~ 255之间，值越大，显示越靠前') ?>
<?= $form->field($model, 'status')->dropDownList($model::$statusMap)->wrapper(['width' => 2]) ?>

<?php ActiveForm::end() ?>

