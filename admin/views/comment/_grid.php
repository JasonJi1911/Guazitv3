<?php

use common\models\setting\SettingSystem;
use yii\helpers\Html;
use metronic\grid\GridView;
use admin\models\video\Comment;
use metronic\assets\DateRangePickerAsset;

DateRangePickerAsset::register($this);
$this->render('../base/_filters');
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\CheckboxColumn'],

        [
            'attribute' => 'uid',
            'value' => 'user.nickname',
        ],
        [
            'attribute' => 'video_id',
            'value' => 'video.title',
        ],

        [
            'attribute' => 'content',
            'options' => ['width' => '30%'],
        ],

        [
            'attribute' => 'source',
            'value' => 'sourceText',
            'options' => ['width' => '6%'],
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function($model) {
                $color = ($model->status == Comment::STATUS_EXAMINE_ING) ? '#808080' : '#0000FF';
                return '<font color="'.$color.'">'.Comment::$statues[$model->status].'</font>';
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'php:Y-m-d H:i'],
            'options' => ['width' => '12%'],
        ],

        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{review} {delete} {forbid-user}',
            'buttons' => [
                'forbid-user' => function ($url, $model) {
                    $options = ['data-confirm' => '确定要封禁此用户吗？'];
                    return Html::actionButton('封禁此用户', ['user/active', 'op' => 0, 'id' => $model->uid], 'ban', 'red', $options);
                },
                'review' => function ($url, $model) {
                    if (Yii::$app->setting->get('system.comment_switch') == SettingSystem::COMMENT_REVIEW_ON && $model->status == Comment::STATUS_EXAMINE_ING) {
                        return Html::a('<i class="fa fa-edit">通过</i>', ['comment/review', 'id' => $model->id], ['class' => 'btn btn-outline btn-circle btn-xs blue', 'data-confirm' => Yii::t('yii', '确定通过此评论吗？通过后会在各端展示'),]);
                    }
                },
            ],
        ],
    ],

    'batchActions' => [
        [
            'url'    => ['examine'],
            'label'  => '批量审核',
            'class'  => 'btn-success btn-sm batch-examine',
        ],
    ],
]); ?>
