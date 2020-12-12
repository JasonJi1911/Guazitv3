<?php

use metronic\widgets\InlineFilterForm;
?>
<div class="note note-info">
    <h4>温馨提示</h4>
    <p>1、任务对应完成的规则是系统内置好的,任务的标题和描述只显示作用</p>
    <p>2、每日任务的前两个的icon图会在个人中心处显示,其余的icon图可以不设置</p>
    <p>3、完成任务次数只针对每日任务生效</p>
    <p>4、下线状态的任务将在前端不显示</p>
</div>

<?php $form = InlineFilterForm::begin() ?>
<?= $form->field($searchModel, 'title')->textInput() ?>
<?= $form->field($searchModel, 'task_type')->dropDownList(\admin\models\user\TaskInfo::$typeMap, ['prompt' => '全部'])->label('任务类型') ?>
<?= InlineFilterForm::end() ?>
