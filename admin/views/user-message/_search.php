<?php

use yii\helpers\ArrayHelper;
use metronic\widgets\InlineFilterForm;
?>

<div class="note note-info">
    <p>1、此处消息会显示在个人中心的消息页面内</p>
    <p>2、消息类型只作标记,仅用于区分筛选</p>
</div>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'type')->dropDownList($searchModel::$messageMap, ['prompt' => '全部']) ?>
<?= InlineFilterForm::end() ?>
