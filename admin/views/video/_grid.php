<?php
/* @var $this yii\web\View */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use admin\models\video\VideoCategory;
use admin\models\video\Video;
use admin\models\video\Actor;
?>

<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [

        ['class' => 'yii\grid\CheckboxColumn'],
//
//        [
//            'attribute' => 'cover',
//            'format' => 'raw',
//            'enableSorting' => false,
//            'value' => function ($model) {
//                return Html::img($model->thumb);
//            }
//        ],

        [
            'attribute' => 'cover',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function($model) {
                return Html::img($model->cover->resize(ADMIN_COMIC_VERTICAL_WIDTH * 2, ADMIN_COMIC_VERTICAL_HEIGHT * 2), ['width' => ADMIN_COMIC_VERTICAL_WIDTH . 'px', 'height' => ADMIN_COMIC_VERTICAL_HEIGHT . 'px']);
            }
        ],

        [
            'attribute' => 'horizontal_cover',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function($model) {
                return Html::img($model->horizontal_cover->resize(ADMIN_COMIC_HORIZONTAL_WIDTH * 2, ADMIN_COMIC_HORIZONTAL_HEIGHT * 2), ['width' => ADMIN_COMIC_HORIZONTAL_WIDTH . 'px', 'height' => ADMIN_COMIC_HORIZONTAL_HEIGHT . 'px']);
            }
        ],

        [
            'label' => '频道/名称',
            'format' => 'raw',
            'options' => ['width' => '20%'],
            'value' => function($model) {
                $html = '';
                // 第一行：基本信息
                $html .= '<span class="basic-info">';
                if (!$model->channel ) {
                    return '--';
                }
                // if (preg_match('/\//', $model->title)) {
                //     return '--';
                // }
                if ($model->channel_id) {
                    $display = "[{$model->channel->channel_name}]";
                } else {
                    $display = '[]';
                }
                // 分类/名称
                $display .= " {$model->title}";

                $html .= Html::a($display, ['video/update', 'id' => $model->id]);

                // 状态
                $html .= '&nbsp;<small>[' . $model->finishedStatusText . ']</small>';

                // 标签
                if ($model->score) {
                    $html .= '&nbsp;<span class="label label-xs label-danger">'. bcdiv($model->score, 10 ,1) .'</span>';
                }

                // 标签
                if ($model->play_limit) {
                    if (!isset(Video::$playLimitMap[$model->play_limit])) {
                        return '';
                    }
                    if ($model->play_limit == 1) {
                        $label = 'label-success';
                    } else if ($model->play_limit == 2){
                        $label = 'label-info';
                    } else {
                        $label = 'label-warning';
                    }
                    $html .= '&nbsp;<span class="label label-xs ' . $label . '" >'. Video::$playLimitMap[$model->play_limit] .'</span>';
                }

                // 最新章节
                if ($model->type == Video::STATUS_CONTINUOUS) {
                    if ($model->is_finished == Video::STATUS_FINISHED) {
                        $html .= '<br><small class="last-chapter">' . $model->episode_num . ' 集全</small>';
                    } else {
                        $html .= '<br><small class="last-chapter">最新剧集：更新至 ' . $model->episode_num . ' 集</small>';
                    }
                }

                $director = '';
                $author   = '';
                foreach ($model->actor as $actor) {

                    if ($actor->type == Actor::TYPE_ACTOR) {
                        $author .= ' ' . $actor->actor_name;
                    } else {
                        $director .= ' ' . $actor->actor_name;
                    }

                }

                // 导演
                $html .= '<br><small class="director">导&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;演：' . $director . '</small>';

                // 演员
                $html .= '<br><small class="author">演&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;员：' . $author . '</small>';

                // 上架时间
                $html .= '<br><small class="update-time">上架时间：' . ($model->issue_date ? date('Y-m-d H:i', $model->issue_date) : '--') . '</small>';


                return $html;
            }
        ],

        [
            'attribute' => '地区/年代',
            'format' => 'raw',
            'value' => function ($model) {
                if (!$model->areas || !$model->years) {
                    return '--';
                }
                return $model->areas->area . ' / ' . $model->years->year;
            }
        ],

        'source',

        [
            'label' => '标签',
            'options' => ['width' => '20%'],
            'value' => function($model) {
                if ($model->category_ids) {
                    $cat = VideoCategory::find()->where(['in', 'id', explode(',', $model->category_ids)])->asArray()->all();
                    return implode(',', ArrayHelper::getColumn($cat, 'title'));
                }
                return '-';
            }
        ],

//        [
////            'attribute' => '是否敏感',
////            'format' => 'raw',
////            'value' => function ($model) {
////                return $model->is_sensitive ;
////            }
////        ],

        'SensitivityText',

        '@status',

        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{chapter} {update} {shelve} {delete}',
            'buttons' => [

                'chapter' => function ($url, $model) {
                    return Html::a('<i class="fa fa-book"> 剧集管理</i>', ['video-chapter/index', 'video_id' => $model->id], ['class' => 'btn btn-outline btn-circle btn-xs blue']);
                },

                'shelve' => function($url,$model) {

                    if ($model->status == Video::STATUS_DISABLED) {
                        return Html::a('<i class="fa fa-plus">上架</i>', ['video/shelve', 'video_id' => $model->id, 'shelve' => 1],
                            ['class' => 'btn btn-outline btn-circle btn-xs green', 'data-confirm' => Yii::t('yii', '确定上架该影片吗？上架的影片会在各端展示'),]);
                    } else {
                        return Html::a('<i class="fa fa-times">下架</i>', ['video/shelve', 'video_id' => $model->id, 'shelve' => 2],
                            ['class' => 'btn btn-outline btn-circle btn-xs red','data-confirm' => Yii::t('yii', '确定下架该影片吗？下架的影片将不会在各端展示'), ]);
                    }
                },
            ],
        ],
    ],

    'batchActions' => [
        [
            'url'    => ['batch', 'action' => 'shelve'],
            'label'  => '批量上架',
            'class'  => 'btn-info btn-sm',
        ],
        [
            'url'    => ['batch', 'action' => 'unshelve'],
            'label'  => '批量下架',
            'class'  => 'btn-danger btn-sm',
        ],
    ],

])?>
