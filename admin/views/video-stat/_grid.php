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
            'label' => '作品名',
            'format' => 'raw',
            'value' => function($model) {
                if (!$model->video) {
                    return '--';
                }
                $html = '';
                // 第一行：基本信息
                $html .= '<span class="basic-info">';
                $html .= $model->video->title;
                if ($model->video->play_limit) {
                    switch ($model->video->play_limit){
                        case 1:
                            $html .= '&nbsp;<span class="label label-xs label-warning">免费</span>';
                            break;
                        case 2:
                            $html .= '&nbsp;<span class="label label-xs label-primary">会员</span>';
                            break;
                        case 3:
                            $html .= '&nbsp;<span class="label label-xs label-success">用券</span>';
                            break;
                    }
                }
                return $html;
            }
        ],
        [
            'label' => '频道',
            'format' => 'raw',
            'value' => function($model) {
                if (!$model->video) {
                    return '--';
                }
                return $model->video->channel->channel_name;
            }
        ],
        'favors',
        'play_num',
        'visit_num',
        'pay_user',
        'pay_num',
        'total_income',
    ],

])?>
