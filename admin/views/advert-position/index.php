<?php
/* @var $this yii\web\View */
use admin\models\advert\Advert;
use admin\models\advert\AdvertPosition;
use metronic\grid\GridView;
use yii\helpers\Html;

$this->title = '广告位管理';
$this->params['breadcrumbs'][] = '广告位管理';
?>

<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>
        <div class="actions">

        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <div class="note note-info">
                    <h4 class="block">温馨提示</h4>
                    <p> 广告展示形式：当一个广告位设置有多条广告时，每次访问系统会随机展示其中一条。
                    </p>
                </div>
            </div>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'metronic\grid\SerialColumn'],

                [
                    'attribute' => '广告位置',
                    'value' => function ($model) {
                        return AdvertPosition::$positionMap[$model->position];
                    }
                ],
                [
                    'attribute' => '广告总数',
                    'value' => function ($model) {
                        return Advert::find()->where(['position_id' => $model->id])->count();
                    }
                ],
                '@status',
                [
                    'class' => 'metronic\grid\ActionColumn',
                    'template' => '{view} {shelve}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::actionButton('查看广告', ['/advert/index', 'position_id' => $model->id], 'eye', 'blue', ['title' => '查看广告']);
                        },
                        'shelve' => function ($url, $model) {
                            if ($model->status == AdvertPosition::STATUS_ENABLED) {
                                return Html::a('<i class="fa fa-times">关闭</i>', ['advert-position/active', 'id' => $model->id, 'op' => 0],
                                    ['class' => 'btn btn-outline btn-circle btn-xs red', 'data-confirm' => Yii::t('yii', '确定关闭该广告位置吗？关闭该广告位置会在各端隐藏'),]);
                            } else {
                                return Html::a('<i class="fa fa-plus">开启</i>', ['advert-position/active', 'id' => $model->id, 'op' => 1],
                                    ['class' => 'btn btn-outline btn-circle btn-xs green', 'data-confirm' => Yii::t('yii', '确定开启该广告位置吗？开启该广告位置会在各端显示'),]);
                            }
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>
</div>
