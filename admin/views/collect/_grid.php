<?php
/* @var $this yii\web\View */
use admin\models\collect\Collect;
use metronic\grid\GridView;
use yii\helpers\Html;

$this->params['breadcrumbs'] = [];
$this->title = '视频采集';
$this->params['breadcrumbs'][] = "数据中心";
$this->params['breadcrumbs'][] = $this->title;
//$this->params['breadcrumbs'][] = '视频采集';
?>

<div class="note note-info">
    <h4 class="block">温馨提示</h4>
    <p> 自动化采集。
    </p>
</div>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],
        'collect_id',
        'collect_name',
//        'collect_url',
        [
            'class' => 'metronic\grid\ActionColumn',
            'header' => "采集链接",
            'template' => '{list}',
            'buttons' => [
                'list' => function ($url, $model) {
                    return Html::a($model->collect_url,
                        [
                            '/collect/api',
                            'ac' => 'list',
                            'cjflag' => md5($model->collect_url),
                            'cjurl' => $model->collect_url,
                            'h' => '',
                            't' => '',
                            'ids' => '',
                            'wd' => '',
                            'type' => $model->collect_type,
                            'mid' => $model->collect_mid,
                            'param' => $model->collect_param,
                            'collect_id'=>$model->collect_id
                        ],
                        ['class' => 'btn btn-outline btn-circle btn-xs green',]);
                },
            ]
        ],
        'videoSource',
        [
            'attribute' => '图片选项',
            'value' => function ($model) {
                return Collect::$isDownloadPic[$model->isdownload];
            }
        ],
        [
            'attribute' => '数据类型',
            'value' => function ($model) {
                return Collect::$dataTypes[$model->collect_type];
            }
        ],
        [
            'attribute' => '资源类型',
            'value' => function ($model) {
                return Collect::$resourceMap[$model->collect_mid];
            }
        ],
        [
            'attribute' => '数据操作',
            'value' => function ($model) {
                return Collect::$collectOptions[$model->collect_opt];
            }
        ],
        [
            'attribute' => '数据过滤',
            'value' => function ($model) {
                return Collect::$collectFilters[$model->collect_filter];
            }
        ],
        [
            'class' => 'metronic\grid\ActionColumn',
            'header' => "采集操作",
            'template' => '{daily} {weekly} {all} {cancelAll}',
            'buttons' => [
                'daily' => function ($url, $model) {
                    return Html::actionButton('采集当天',
                        [
                            '/collect/api',
                            'ac' => 'cj',
                            'cjflag' => md5($model->collect_url),
                            'cjurl' => $model->collect_url,
                            'h' => '24',
                            't' => '',
                            'ids' => '',
                            'wd' => '',
                            'type' => $model->collect_type,
                            'mid' => $model->collect_mid,
                            'param' => $model->collect_param,
                            'collect_id'=>$model->collect_id,
                            'source' => $model->video_source,
                            'filter' => $model->collect_filter,
                            'filter_from' => $model->collect_filter_from,
                            'isdownload' => $model->isdownload,
                        ],
                        'eye',
                        'blue',
                        ['title' => '采集当天']);
                },
                'weekly' => function ($url, $model) {
                    return Html::actionButton('采集本周',
                        [
                            '/collect/api',
                            'ac' => 'cj',
                            'cjflag' => md5($model->collect_url),
                            'cjurl' => $model->collect_url,
                            'h' => '168',
                            't' => '',
                            'ids' => '',
                            'wd' => '',
                            'type' => $model->collect_type,
                            'mid' => $model->collect_mid,
                            'param' => $model->collect_param,
                            'collect_id'=>$model->collect_id,
                            'source' => $model->video_source,
                            'filter' => $model->collect_filter,
                            'filter_from' => $model->collect_filter_from,
                            'isdownload' => $model->isdownload,
                        ],
                        'eye',
                        'blue',
                        ['title' => '采集本周']);
                },
                'all' => function ($url, $model) {
                    return Html::actionButton('采集所有',
                        [
                            '/collect/api',
                            'ac' => 'cj',
                            'cjflag' => md5($model->collect_url),
                            'cjurl' => $model->collect_url,
                            'h' => '',
                            't' => '',
                            'ids' => '',
                            'wd' => '',
                            'type' => $model->collect_type,
                            'mid' => $model->collect_mid,
                            'param' => $model->collect_param,
                            'collect_id'=>$model->collect_id,
                            'source' => $model->video_source,
                            'filter' => $model->collect_filter,
                            'filter_from' => $model->collect_filter_from,
                            'isdownload' => $model->isdownload,
                        ],
                        'eye',
                        'blue',
                        ['title' => '采集所有']);
                },
                'cancelAll' => function ($url, $model) {
                    return Html::actionButton('清空线路',
                        [
                            '/collect/cancel-all',
                            'cjflag' => md5($model->collect_url),
                            'source' => $model->video_source,
                        ],
                        'times',
                        'red',
                        ['title' => '清空线路']);
                }
            ]
        ],
        [
            'class' => 'metronic\grid\ActionColumn',
            'header' => "任务操作",
            'template' => '{detail} {update} {delete}',
        ],
    ],
]); ?>
