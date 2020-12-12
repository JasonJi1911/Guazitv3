<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use admin\models\VideoArea;
use admin\models\VideoChannel;
?>


<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],
        [
            'label' => '频道ID',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function($model) {
                if (!$model->channel) {
                    return '--';
                }
                if (!empty($model->channel_id)) {
                    $channelName = $model->channel->channel_name;
                } else {
                    $channelName = '首页';
                }
                return $channelName;
            }
        ],
       [
           'label' => '分类名',
           'format' => 'raw',
           'enableSorting' => false,
           'value' => function($model) {
               if (preg_match('/\//', $model->title)) {
                   return '--';
               }
               $html = '';
               $html .= $model->title;
               return $html;
           }
       ],

        'description',
        [
            'label' => '影片数',
            'value' => function($model) {
                return $model->getVideoCount();
            }
        ],
        'display_order',
        [
            'label' => '创建时间',
            'enableSorting' => false,
            'format' => 'raw',
            'value' => function($model) {
                if ($model->created_at) {
                    return date('Y-m-d H:i:s', $model->created_at);
                }
                return '--';
            }
        ],
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => ' {update} {delete} {up}',
            'buttons' => [
                'delete' => function ($url, $model) {
                    $options = ['data-confirm' => '您确定要删除该分类吗？', 'data-method' => 'delete'];

                    if ($model->getVideoCount() != 0) {
                        $options = ['onclick' => 'alert("分类下有影片不可删除");return false;'];
                    }

                    return Html::actionButton('删除', $url, 'trash-o', 'dark', $options);
                },
            ]

        ],

    ],

])?>
