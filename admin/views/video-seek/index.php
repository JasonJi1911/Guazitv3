<?php

use yii\helpers\Html;
use metronic\grid\GridView;

$this->title = '用户求片';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>
        <div class="actions">

        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'metronic\grid\SerialColumn'],
//                [
//                    'label' => '影片名称',
//                    'format' => 'raw',
//                    'value' => function($model) {
//                        $html = '';
//                        $html .= $model->video_name;
//                        return $html;
//                    }enableSorting
//                ],
                'video_name',
                [
                    'label' => '频道',
                    'format' => 'raw',
                    'value' => function($model) {
                        if (!$model->channel || !$model->channel_id) {
                            return '--';
                        }
                        return $model->channel->channel_name;
                    }
                ],
                [
                    'label' => '地区',
                    'format' => 'raw',
                    'value' =>  function ($model) {
                        if (!$model->areas) {
                            return '--';
                        }
                        return $model->areas->area;
                    }
                ],
                'year',
                'director_name',
                'actor_name',
                [
                    'label' => '求片时间',
                    'format' => 'raw',
                    'value' =>  function ($model) {
                        if (!$model->created_at) {
                            return '--';
                        }
                        return date('Y-m-d H:i:s',$model->created_at);
                    }
                ],
                [
                    'class' => 'metronic\grid\ActionColumn',
                    'template' => '{delete}',
                ]
            ],
        ]); ?>
    </div>
</div>
