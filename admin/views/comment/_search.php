<?php

use metronic\widgets\InlineFilterForm;
?>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'source')->dropDownList($searchModel::$sources, ['prompt' => '全部']) ?>
<?php if (Yii::$app->setting->get('system.comment_review') == 1) { ?>
<?= $form->field($searchModel, 'status')->dropDownList($searchModel::$statues, ['prompt' => '全部']) ?>
<?php } ?>
<?= InlineFilterForm::end() ?>
