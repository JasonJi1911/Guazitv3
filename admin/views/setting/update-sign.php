<?php
/* @var $this yii\web\View*/

use metronic\widgets\ActiveForm;
use yii\helpers\Url;

if (Yii::$app->session->getFlash('updated')) {
    \metronic\assets\ToastrAsset::register($this);
    $this->registerJs('toastr.success("保存成功", "", {timeOut: 1000});');
}

$this->params['breadcrumbs'] = [];
$this->title = '签到设置';
$this->params['breadcrumbs'][] = ['url' => '#', 'label' => '配置管理'];
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
    $('.sign-award').on('change', function() {
        var num = $.trim($(this).val());
        if (num == '') {
            $(this).val(0);
        }
    })
JS;

$this->registerJs($js);


?>
<div class="portlet light">
    <div class="portlet-title" style="min-height: 0px;">
        <div class="caption" style="padding: 0px;">
            <div class="tabbable-line">
                <ul class="nav nav-tabs">
                    <?php foreach ($tags as $tag): ?>
                        <li class="<?= Yii::$app->request->getUrl() == $tag['route'] ? 'active' : ''?>">
                            <a href="<?= Url::to([$tag['route']])?>"> <?= $tag['label']?> </a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>

    </div>
    <div class="note note-info">
        <p>设置连续签到的梯次奖励积分数量</p>
    </div>
    <div class="sign-form">

        <?php $form = ActiveForm::begin() ?>

        <?php foreach ($model as $v) { ?>

            <div class="form-group field-sign-gold has-success">
                <label class="col-md-3 control-label" for="sign-gold">
                    第<?= $v->day ?>天
                    <input type="hidden" class="form-control" name="SignGold[day][]" value="<?= $v->day ?>">
                </label>
                <div class="col-md-2">
                    <input type="number" class="form-control sign-award" name="SignGold[award][]" value="<?= $v->score ?>">
                </div>
            </div>
        <?php } ?>

        <?php ActiveForm::end() ?>

    </div>
</div>
