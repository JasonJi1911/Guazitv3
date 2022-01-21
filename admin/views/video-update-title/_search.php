<?php
use metronic\widgets\InlineFilterForm;
use yii\helpers\ArrayHelper;
use admin\models\video\VideoChannel;
?>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'channel_id')->dropDownList(ArrayHelper::map(VideoChannel::findAll(['status' => VideoChannel::STATUS_ENABLED]), 'id', 'channel_name'), ['prompt' => '全部']) ?>
<?= $form->field($searchModel, 'status')->dropDownList($searchModel::$statusMap, ['prompt' => '全部']) ?>
<?= InlineFilterForm::end() ?>
