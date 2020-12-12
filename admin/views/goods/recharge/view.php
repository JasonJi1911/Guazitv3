<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\pay\Goods */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '充值套餐', 'url' => ['/goods/recharge']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>
    </div>
    <div class="portlet-body">
        <p>
            <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('删除', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '确定要删除该商品吗?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'title',
                [
                    'attribute' => 'price',
                    'value' => function($model) {
                        if ($model->price) {
                            return $model->price/100 ;
                        }
                        return 0;
                    },
                ],
                'giving',

                'apple_id',
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d H:i'],
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => ['date', 'php:Y-m-d H:i'],
                ],
            ],
        ]) ?>
    </div>
</div>