<?php

use common\helpers\Tool;
use yii\helpers\Html;
use metronic\grid\GridView;
use metronic\widgets\InlineFilterForm;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\BookChapterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '剧集列表';
$this->params['breadcrumbs'][] = ['label' => '影片管理', 'url' => ['video/index']];

$this->params['breadcrumbs'][] = Yii::$app->video->title . $this->title;
?>

<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>
        <div class="actions">
            <?= Html::createButton('新增剧集', ['create', 'video_id' => Yii::$app->video->id]) ?>
            <?= Html::createButton('上传剧集', ['/video/upload', 'video_id' => Yii::$app->video->id], ['class' => 'btn btn-warning']) ?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <?php $form = InlineFilterForm::begin([]) ?>
                <div style="display: none">
                    <?= $form->field($searchModel, 'video_id')->hiddenInput() ?>
                </div>
                <?= $form->field($searchModel, 'display_order')->dropDownList(['asc' => '升序', 'desc' => '降序']) ?>
                <?= $form->field($searchModel, 'title') ?>
                <?= InlineFilterForm::end() ?>
            </div>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\CheckboxColumn'],

                'title',

                [
                    'label' => '播放时长',
                    'value' => function($model) {
                        if ($model->duration_time) {
                            return Tool::secToTime($model->duration_time);
                        }
                        return '';
                    }
                ],

                'total_views',

                'limitLabel',

                'display_order',


                [
                    'class' => 'metronic\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::updateActionButton(['update', 'video_id' => $model->video_id, 'id' => $model->id]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::deleteActionButton(['delete', 'video_id' => $model->video_id, 'id' => $model->id], '您确定要删除该章节吗？');
                        },
                    ]
                ],
            ],


            'batchActions' => [
                [
                    'url'    => ['batch', 'action' => 'batch_delete', 'video_id' => Yii::$app->video->id],
                    'label'  => '批量删除',
                    'class'  => 'btn-danger btn-sm',
                ],
            ],
        ]); ?>
    </div>
</div>
