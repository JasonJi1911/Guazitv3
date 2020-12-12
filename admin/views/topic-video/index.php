<?php

use common\helpers\Tool;
use yii\helpers\Html;
use metronic\grid\GridView;
use metronic\widgets\InlineFilterForm;
use admin\models\video\Video;
/* @var $this yii\web\View */
/* @var $searchModel admin\models\BookChapterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '影片列表';
$this->params['breadcrumbs'][] = ['label' => '影片管理', 'url' => ['topic/index']];

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>
        <div class="actions">
            <?= Html::createButton('新增影片', ['create', 'topic_id' => Yii::$app->topic->id, 'channel_id' => Yii::$app->topic->channel_id]) ?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <?php $form = InlineFilterForm::begin([]) ?>
                <div style="display: none">
                    <?= $form->field($searchModel, 'topic_id')->hiddenInput() ?>
                </div>
                <?= $form->field($searchModel, 'display_order')->dropDownList(['asc' => '升序', 'desc' => '降序']) ?>

                <?= InlineFilterForm::end() ?>
            </div>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\CheckboxColumn'],

                [
                    'label' => '影片',
                    'value' => function($model) {
                        if ($model->video_id) {
                            $video = Video::findOne(['id' => $model->video_id]);
                            return $video->title;
                        }
                        return '';
                    }
                ],
                [
                    'attribute' => '展示排序',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->display_order ;
                    }
                ],

                [
                    'attribute' => '创建时间',
                    'value' => function($model) {
                        return date("Y-m-d H:i",$model->created_at);
                    }
                ],
                [
                    'class' => 'metronic\grid\ActionColumn',
                    'template' => '{update}{delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::updateActionButton(['update', 'topic_id' => $model->topic_id, 'id' => $model->id]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::deleteActionButton(['delete', 'topic_id' => $model->topic_id, 'id' => $model->id], '您确定要删除该影片吗？');
                        },
                    ]
                ],
            ],
            'batchActions' => [
                [
                    'url'    => ['batch', 'action' => 'batch_delete', 'topic_id' => Yii::$app->topic->id],
                    'label'  => '批量删除',
                    'class'  => 'btn-danger btn-sm',
                ],
            ],

        ]); ?>
    </div>
</div>
