<?php
/* @var $this yii\web\View */
use admin\models\VideoChannel;
use yii\helpers\Html;

?>

<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],

        [
            'label' => '频道',
            'value' => function($model) {
                $channel = \admin\models\video\VideoChannel::findOne($model->channel_id);
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

        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::actionButton('榜单影片', ['rank-video/index', 'rank_id' => $model->id, 'channel_id' => $model->channel_id], 'eye', 'blue', ['title' => '查看该榜单的影片列表']);
                },
                'delete' => function ($url, $model) {
                    $options = ['data-confirm' => '您确定要删除该榜单吗？', 'data-method' => 'delete'];
                    if ($model->videoNum != 0) {
                        $options = ['onclick' => 'alert("榜单下有影片榜单不可删除");return false;'];
                    }
                    return Html::actionButton('删除', $url, 'trash-o', 'dark', $options);
                }
            ],
        ],
    ]
])?>
