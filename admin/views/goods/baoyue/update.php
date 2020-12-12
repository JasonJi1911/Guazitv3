<?php

use yii\helpers\Html;
use metronic\grid\GridView;
use metronic\widgets\InlineFilterForm;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = '修改会员套餐';
$this->params['breadcrumbs'][] = ['label' => '会员套餐', 'url' => ['//goods/baoyue']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['goods/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
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
