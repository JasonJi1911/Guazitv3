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
           'label' => '用户名',
           'format' => 'raw',
           'contentOptions' => [
               'width' => '18%'
           ],
           'enableSorting' => false,
           'value' => function($model) {
               $html = '';
               if ($model->user) {
                   $html .= '&nbsp;'.$model->user->nickname;
                   $html .= '&nbsp;<span style="color:#00A1CB">('.$model->uid.')</span>';
               }
               return $html;
           }
        ],

        [
            'label' => '手机号',
            'format' => 'raw',
            'contentOptions' => [
                'width' => '10%'
            ],
            'enableSorting' => false,
            'value' => function($model) {
                return $model->user ? $model->user->mobile : '';
            }
        ],

        [
            'label' => '影视名称',
            'format' => 'raw',
            'contentOptions' => [
                'width' => '18%'
            ],
            'enableSorting' => false,
            'value' => function($model) {
                if (!$model->video) {
                    return '--';
                }
                return $model->video->title;
            }
        ],

        [
            'label' => '剧集',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function($model) {
                if (!$model->chapter) {
                    return '--';
                }
                return $model->chapter->title;
            }
        ],

        [
            'label' => '观看时间',
            'format' => 'raw',
            'contentOptions' => [
                'width' => '15%'
            ],
            'enableSorting' => false,
            'value' => function($model) {
                return date('Y-m-d H:i:s', $model->updated_at);
            }
        ],


    ],

])?>
