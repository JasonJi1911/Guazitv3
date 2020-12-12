<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use admin\models\video\VideoChannel;
?>



<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
       [
           'label' => '频道名',
           'format' => 'raw',
           'enableSorting' => false,
           'value' => function($model) {
//                if (preg_match('/\//', $model->channel_name)) {
//                    return '--';
//                }
               $html = '';
               $html .= $model->channel_name;
               return $html;
           }
       ],
        [
          'label' => '频道icon',
            'enableSorting' => false,
            'format' => 'raw',
            'value' => function($model){
               return Html::img($model->icon->resize(50,50),['width' => 50]);
            }
        ],
        [
          'label' => '描述',
          'value' => function($model){
            return $model->description;
          }
        ],
        [
            'label' => '影片数',
            'value' => function($model) {
                return $model->getVideo()->count();
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
            'template' => ' {update} {delete} {kingkong} {up}',
            'buttons' => [
                'delete' => function ($url, $model) {
                    $options = ['data-confirm' => '您确定要删除该频道吗？', 'data-method' => 'delete'];

                    if ($model->getVideo()->count() != 0) {
                        $options = ['onclick' => 'alert("频道下有影片不可删除");return false;'];
                    }

                    return Html::actionButton('删除', $url, 'trash-o', 'dark', $options);
                },

                'kingkong' => function($url, $model){
                    if ($model->is_kingkong == VideoChannel::STATUS_KINGKONG_YES){
                        return Html::a('<i class="fa fa-times">取消首页推荐</i>', ['video-channel/kingkong', 'channel_id' => $model->id, 'is_kingkong' => 0],
                            ['class' => 'btn btn-outline btn-circle btn-xs red','data-confirm' ]);
                    }else{
                        return Html::a('<i class="fa fa-plus">设为首页推荐</i>', ['video-channel/kingkong',  'channel_id' => $model->id, 'is_kingkong' => 1],
                            ['class' => 'btn btn-outline btn-circle btn-xs green', 'data-confirm']);
                    }
                }
            ],
        ],

    ],

])?>
