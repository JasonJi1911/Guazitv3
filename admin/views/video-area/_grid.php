<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use admin\models\VideoArea;
use admin\models\VideoChannel;
?>



<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
       [
           'label' => '地区',
           'format' => 'raw',
           'enableSorting' => false,
           'value' => function($model) {
             return $model->area;
           }
       ],
        'description',
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
            'template' => ' {update} {delete} {up}',
            'buttons' => [
                'delete' => function ($url, $model) {
                    $options = ['data-confirm' => '您确定要删除该地区吗？', 'data-method' => 'delete'];

                    if ($model->getVideo()->count() != 0) {
                        $options = ['onclick' => 'alert("地区下有影片不可删除");return false;'];
                    }

                    return Html::actionButton('删除', $url, 'trash-o', 'dark', $options);
                },
            ]
        ],
        
    ],

])?>
