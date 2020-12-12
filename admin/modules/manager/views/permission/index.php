<?php

use yii\helpers\Html;
use metronic\grid\GridView;
use metronic\widgets\InlineFilterForm;

$this->title = '权限列表';
$this->params['breadcrumbs'][] = ['label' => '权限管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>
        <div class="actions">
            <?= Html::createButton('新增权限项') ?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <?php $form = InlineFilterForm::begin() ?>
                <?= $form->field($searchModel, 'pid')->dropDownList($searchModel::getPermissionOptions(), ['prompt' => '全部']) ?>
                <?= $form->field($searchModel, 'name') ?>
                <?= InlineFilterForm::end() ?>
            </div>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'label' => '权限',
                    'attribute' => 'name',
                ],
                // [
                //     'label' => '上级权限',
                //     'attribute' => 'pid',
                //     'value' => function ($model) {
                //         return $model->parent->name ?? '-';
                //     },
                // ],
                // [
                //     'label' => '上上级权限',
                //     'attribute' => 'ppid',
                //     'value' => function ($model) {
                //         return $model->grandParent->name ?? '-';
                //     },
                // ],
                [
                    'attribute' => 'is_menu',
                    'value' => 'isMenuText',
                ],
                'route',
                'params',
                [
                    'attribute' => 'icon',
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        if ($model->icon) {
                            return Html::tag('span', '', ['aria-hidden' => 'true', 'class' => $model->iconText]);
                        } else {
                            return '';
                        }
                    },
                ],

                [
                    'class' => 'metronic\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ],
            ],
        ]); ?>
    </div>
</div>
