<?php

use yii\helpers\Html;
use metronic\grid\GridView;
use metronic\widgets\InlineFilterForm;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '活动套餐列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portlet light ">



    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>
        <div class="actions">
            <?= Html::createButton('新增活动套餐', ['goods/active/create']) ?>
        </div>
    </div>
    <div class="note note-info">
        <p>此处的活动商品给 <font style="color: red;">公众号分销渠道和代理</font> 创建充值活动时使用，活动商品不可编辑，查看 <a href="/drp/buy-activitys">公众号活动管理</a></p>
    </div>
    <div class="portlet-body">
        <div class="row goods-search">
            <div class="col-md-10">
                <?php $form = InlineFilterForm::begin() ?>
                <?= $form->field($searchModel, 'title') ?>
                <?= InlineFilterForm::end() ?>
            </div>
        </div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'metronic\grid\SerialColumn'],
                [
                    'label' => '商品ID',
                    'value' => function($dataProvider) {
                        return $dataProvider->id;
                    }
                ],
                [
                    'label' => '商品名称',
                    'format' => 'raw',
                    'value' => function($model) {
                        return $model->title;
                    }
                ],
                [
                    'attribute' => 'price',
                    'value' => function ($data) {
                        return \common\helpers\Tool::moneyFormatYuan($data->price);
                    }
                ],
                [
                    'label' => '赠送金额(元)',
                    'value' => function($model) {
                        return \common\helpers\Tool::moneyFormatYuan($model->giving);
                    }
                ],
                [
                    'class' => 'metronic\grid\ActionColumn',
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function($url, $model) {
                            return Html::actionButton('删除', $url, 'trash-o', 'dark', ['data-confirm' => '删除商品后关联的活动也会被删除，您确定要删除吗？', 'data-method' => 'delete']);
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>
</div>
