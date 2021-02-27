<?php

use yii\helpers\Html;
use metronic\grid\GridView;
use admin\models\advert\Advert;
use admin\models\advert\AdvertPosition;

$this->params['breadcrumbs'] = [];
$this->title = '广告列表';
$this->params['breadcrumbs'][] = ['url' => '/advert-position/index', 'label' => '广告位管理'];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="note note-info">
    <p>广告在前端显示为带链接图片</p>
    <p>外部跳转意为在APP浏览器内跳转</p>
</div>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],
        [
            'attribute' => 'position_id',
            'value' => function($model) {
                if (!$model->advertPosition) {
                    return '--';
                }
                return AdvertPosition::$positionMap[$model->advertPosition->position];
            }
        ],
        'title',
      /*  [
            'attribute' => 'ad_type',
            'value' => function ($model) {
                return Advert::$adTypes[$model->ad_type];
            }
        ],*/
        [
            'attribute' => 'image',
            'format' => 'raw',
            'value' => function($model){
                if ($model->ad_type == Advert::AD_TYPE_WEB) {
                    if (strpos($model->image, '.mp4') !== false)
                        return '<video src="'.$model->image.'" width="200px" height="100px" alt=""></video>';
                        
                    return Html::img($model->image->resize(200, 100), ['width' => '200px', 'height' => '100px']);
                }
                return '--';
            }
        ],
        [
            'attribute' => 'skip_url',
            'format' => 'raw',
            'value' => function($model) {
                if ($model->ad_type == Advert::AD_TYPE_WEB) {
                    return $model->skip_url;
                }
                return '--';
            }
        ],
        [
            'attribute' => 'url_type',
            'format' => 'raw',
            'value' => function($model) {
                if ($model->ad_type == Advert::AD_TYPE_WEB) {
                    return Advert::$urlTypes[$model->url_type];
                }
                return '--';
            }
        ],
      /*  [
            'label' => '苹果广告key',
            'value' => function ($model) {
                return $model->ad_key ? $model->ad_key : '--';
            }
        ],
        [
            'label' => '安卓广告key',
            'value' => function ($model) {
                return $model->ad_android_key ? $model->ad_android_key : '--';
            }
        ],*/
        'pv',
        'click',
        '@status',
        'cityName',
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{update} {shelve} {delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return '<a class="btn btn-outline btn-circle btn-xs purple" href="/advert/update?id='.$model->id.'&position_id='.$model->position_id.'" title="编辑" aria-label="编辑" data-pjax="0"><i class="fa fa-edit"> 编辑</i></a>';
                },
                'shelve' => function ($url, $model) {
                    if ($model->status == Advert::STATUS_OPEN) {
                        return Html::a('<i class="fa fa-times">关闭</i>', ['advert/shelve', 'advert_id' => $model->id, 'shelve' => 2],
                            ['class' => 'btn btn-outline btn-circle btn-xs red', 'data-confirm' => Yii::t('yii', '确定关闭该广告吗？关闭该广告不会显示在各端'),]);
                    } else {
                        return Html::a('<i class="fa fa-plus">开启</i>', ['advert/shelve', 'advert_id' => $model->id, 'shelve' => 1],
                            ['class' => 'btn btn-outline btn-circle btn-xs green', 'data-confirm' => Yii::t('yii', '确定显示该广告吗？显示的广告会展示在各端'),]);
                    }
                }
            ]
        ],
    ],
]); ?>
