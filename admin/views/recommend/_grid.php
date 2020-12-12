<?php
/* @var $this yii\web\View */
use admin\models\video\VideoChannel;
use yii\helpers\Html;
use admin\models\video\Recommend;
?>


<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],

        [
            'label' => '频道',
            'value' => function($model) {
                if (!$model->channel) {
                    return '--';
                }
                $channel = VideoChannel::findOne($model->channel_id);
                if ($channel) {
                    return $channel->channel_name;
                }

                return '--';
            }
        ],

        'title',

        '@status',

        'display_order',

        'description',

        'styleLabel:text:样式',

        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{shelve} {update} {delete}',
            'buttons' => [

                'shelve' => function($url,$model) {

                    if ($model->status == Recommend::STATUS_DISABLED) {
                        return Html::a('<i class="fa fa-plus">上架</i>', ['recommend/active', 'id' => $model->id, 'op' => 1],
                            ['class' => 'btn btn-outline btn-circle btn-xs green', 'data-confirm' => Yii::t('yii', '确定上架该推荐位吗？上架的推荐位会在各端展示'),]);
                    } else {
                        return Html::a('<i class="fa fa-times">下架</i>', ['recommend/active', 'id' => $model->id, 'op' => 0],
                            ['class' => 'btn btn-outline btn-circle btn-xs red','data-confirm' => Yii::t('yii', '确定下架该推荐位吗？下架的推荐位将不会在各端展示'), ]);
                    }
                },
            ],
        ],
    ]
])?>
