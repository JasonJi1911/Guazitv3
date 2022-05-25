<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use admin\models\advert\AdvertYYTitle;
?>
<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],
        [
            'label' => '标题',
            'enableSorting' => false,
            'format' => 'raw',
            'value' => function($model){
                return $model->title;
            }
        ],

        [
           'label' => '城市',
           'format' => 'raw',
           'enableSorting' => false,
           'value' => function($model) {
               if (!$model->city && $model->city_id != 0) {
                   return '--';
               }
                if ($model->city_id != 0) {
                    $cityName = $model->city->city_name;
                } else {
                    $cityName = '--';
                }
               return $cityName;
           }
        ],
        [
            'label' => '展示渠道',
            'format' => 'raw',
            'value' => function($model){
                return AdvertYYTitle::$productMap[$model->product];
            }
        ],
        [
            'attribute' => 'platform',
            'format' => 'raw',
            'value' => function($model) {
                if (!empty($model->platform)) {
                    return AdvertYYTitle::$platformmap[$model->platform];
                }
                return '--';
            }
        ],
        'display_order',
        '@status',
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => ' {view}{update} {delete} {shelve}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::actionButton('查看广告', ['/advertyy/index', 'yy_id' => $model->id], 'eye', 'blue', ['title' => '查看广告']);
                },
                'shelve' => function($url,$model) {

                    if ($model->status == AdvertYYTitle::STATUS_DISABLED) {
                        return Html::a('<i class="fa fa-plus">显示</i>', ['advertyy-title/active', 'id' => $model->id, 'op' => 1],
                            ['class' => 'btn btn-outline btn-circle btn-xs green', 'data-confirm']);
                    } else {
                        return Html::a('<i class="fa fa-times">隐藏</i>', ['advertyy-title/active', 'id' => $model->id, 'op' => 0],
                            ['class' => 'btn btn-outline btn-circle btn-xs red','data-confirm' ]);
                    }
                },
            ],
        ],

    ],

])?>
