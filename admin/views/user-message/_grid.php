<?php

use admin\models\user\UserMessage;
use metronic\grid\GridView;
use admin\models\MessageNotice;
use yii\helpers\ArrayHelper;

?>

<div class="portlet light">
    <div class="portlet-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'uid',
                'value' => function($model) {
                    if ($model->user) {
                        return $model->user->nickname;
                    }
                    return '--';
                }
            ],
            [
                'label' => '消息标题',
                'attribute' => 'type',
                'value' => function($model) {
                    return ArrayHelper::getValue(UserMessage::$messageMap, $model->type);
                }
            ],

            'content',
            [
                'attribute' => 'created_at',
                'value' => function($model) {
                    return date("Y-m-d H:i",$model->created_at);
                }
            ],
            [
                'class' => 'metronic\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]); ?>
    </div>
</div>
