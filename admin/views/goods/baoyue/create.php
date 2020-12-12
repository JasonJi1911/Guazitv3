<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\pay\Goods */

$this->title = '新增会员套餐';
$this->params['breadcrumbs'][] = ['label' => '会员套餐', 'url' => ['/goods/baoyue']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>
    </div>

    <div class="portlet-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
