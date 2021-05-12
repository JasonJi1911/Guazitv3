<?php

use metronic\widgets\ActiveForm;
use common\models\channel\ChannelVideo as commonChannelVideo;
use yii\helpers\ArrayHelper;


$this->title = '播放渠道来源设置';
$this->params['breadcrumbs'][] = ['label' => '播放渠道来源列表', 'url' => 'index?os_type='.Yii::$app->request->get('os_type', commonChannelVideo::OS_TYPE_APP)];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="channle-video-form">

    <?php $form = ActiveForm::begin() ?>

    <?php $osType = Yii::$app->request->get('os_type', $model->os_type ? $model->os_type : Yii::$app->request->get('os_type', commonChannelVideo::OS_TYPE_APP) ) ?>
    <?= $form->field($model, 'os_type')->textInput(['value' => commonChannelVideo::$osType[$osType], 'readonly' => true])->wrapper(['width' => 3]) ?>

    <?= $form->field($model, 'sid')->dropDownList(ArrayHelper::map($videoSource, 'id', 'name'))->wrapper(['width' => 3]);?>

    <?= $form->field($model, 'display_order')->numberInput(['min' => 0, 'max' => '255'])->wrapper(['width' => 3])->hint('0 ~ 255之间，值越大，显示越靠前') ?>
    <?php ActiveForm::end() ?>

</div>


