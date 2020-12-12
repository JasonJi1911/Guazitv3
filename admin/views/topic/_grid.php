<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use admin\models\Topic;
use admin\models\VideoChannel;
?>

<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],

        [
            'attribute' => 'name',
            'options' => ['width' => '18%'],
        ],

        [
            'attribute' => '所属频道',
            'format' => 'raw',
            'value' => function ($model) {
                if (!$model->channel) {
                    return '--';
                }
                return $model->channel->channel_name;
//                $channel = \common\models\video\VideoChannel::findOne(['id' => $model->channel_id]);
//                return $channel->channel_name;
            }
        ],

        [
            'attribute' => 'cover',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model) {
                return Html::img($model->cover->resize(\admin\models\video\Topic::TOPIC_COVER_WIDTH, \admin\models\video\Topic::TOPIC_COVER_HEIGHT), ['width' => \admin\models\video\Topic::TOPIC_COVER_WIDTH . 'px', 'height' => \admin\models\video\Topic::TOPIC_COVER_HEIGHT . 'px']);
            }
        ],

        [
            'attribute' => 'intro',
            'options' => ['width' => '30%'],
        ],

        'display_order',

        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{chapter} {update} {delete}',
            'buttons' => [
                'chapter' => function ($url, $model) {
                    return Html::a('<i class="fa fa-book"> 影片管理</i>', ['topic-video/index', 'topic_id' => $model->id], ['class' => 'btn btn-outline btn-circle btn-xs blue']);
                },
            ]
        ],
    ]
])?>
