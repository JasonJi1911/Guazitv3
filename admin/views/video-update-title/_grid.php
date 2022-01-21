<?php
/* @var $this yii\web\View */
use admin\models\video\VideoChannel;
use admin\models\video\VideoUpdateTitle;
use yii\helpers\Html;
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
        'content',
        'display_order',
        '@status',
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => ' {view}{update} {delete} {shelve}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::actionButton('查看详情', ['/video-update/index', 'video_update_title_id' => $model->id,'channel_id' => $model->channel_id], 'eye', 'blue', ['title' => '查看详情']);
                },
                'shelve' => function($url,$model) {

                    if ($model->status == VideoUpdateTitle::STATUS_DISABLED) {
                        return Html::a('<i class="fa fa-plus">显示</i>', ['video-update-title/active', 'id' => $model->id, 'op' => 1],
                            ['class' => 'btn btn-outline btn-circle btn-xs green', 'data-confirm']);
                    } else {
                        return Html::a('<i class="fa fa-times">隐藏</i>', ['video-update-title/active', 'id' => $model->id, 'op' => 0],
                            ['class' => 'btn btn-outline btn-circle btn-xs red','data-confirm' ]);
                    }
                },
            ],
        ],

    ],

])?>
