<?php
/* @var $this yii\web\View*/

use metronic\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['url' => '#', 'label' => '配置管理'];

?>

<div class="portlet light">
    <div class="portlet-title" style="min-height: 0px;">
        <div class="caption" style="padding: 0px;">
            <div class="tabbable-line">
                <ul class="nav nav-tabs">
                    <?php foreach ($tags as $tag): ?>
                        <li class="<?= '/setting/aliyun' == $tag['route'] ? 'active' : ''?>">
                            <a href="<?= Url::to([$tag['route']])?>"> <?= $tag['label']?> </a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>

    <div class="note note-info">
        阿里云access信息,使用阿里云oss、推送等服务时需要
    </div>

    <div class="portlet-body">
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'access_key')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'access_secret')->textInput(['maxlength' => true]) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>