<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use admin\models\video\VideoArea;
use admin\models\video\VideoChannel;
use yii\helpers\ArrayHelper;
use admin\models\video\Banner;
use admin\models\video\Video;
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
           'label' => '频道',
           'format' => 'raw',
           'enableSorting' => false,
           'value' => function($model) {
               if (!$model->channel && $model->channel_id != 0) {
                   return '--';
               }
                if ($model->channel_id != 0) {
                    $channelName = $model->channel->channel_name;
                } else {
                    $channelName = '首页';
                }


               return $channelName;
           }
       ],

        'actionLabel',

        [
            'label' => '内容',
            'format' => 'raw',
            'value' => function($model){
                //根据type来操作
                switch ($model->action) {
                    case Banner::ACTION_VIDEO : //作品
                        $video = Video::findOne($model->content);
                        return Html::a($video['title'], ['/video/update', 'id' => $model->content]);

                    case Banner::ACTION_SCHEME : //APP内页面
                        return ArrayHelper::getValue(Banner::$schemeMap, $model->content);

                    case Banner::ACTION_URL : //链接
                    case Banner::ACTION_BROWSER_URL:
                        return $model->content;

                    default :
                        return '';
                }
            }
        ],
        [
            'label' => '图片',
            'format' => 'raw',
            'value' => function($model){
                return Html::img($model->image->resize(500,120),['width' => 200,'height' => 120]);
            }
        ],
        'display_order',
        'cityName',
        '@status',
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => ' {update} {delete} {shelve}',
            'buttons' => [
                'shelve' => function($url,$model) {

                    if ($model->status == Banner::STATUS_DISABLED) {
                        return Html::a('<i class="fa fa-plus">显示</i>', ['banner/active', 'id' => $model->id, 'op' => 1],
                            ['class' => 'btn btn-outline btn-circle btn-xs green', 'data-confirm']);
                    } else {
                        return Html::a('<i class="fa fa-times">隐藏</i>', ['banner/active', 'id' => $model->id, 'op' => 0],
                            ['class' => 'btn btn-outline btn-circle btn-xs red','data-confirm' ]);
                    }
                },
            ],
        ],

    ],

])?>
