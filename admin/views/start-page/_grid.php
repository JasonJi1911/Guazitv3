<?php

use yii\helpers\Html;
use metronic\grid\GridView;
use admin\models\advert\StartPage;
use admin\models\video\Video;

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],
        [
            'attribute' => 'skip_type',
            'enableSorting' => false,
            'value' => function($model) {
                return StartPage::$skipTypeMap[$model->skip_type];
            }
        ],
        'title',
        [
            'attribute' => 'image',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function($model) {
                return Html::img($model->image->resize(50, 50), ['width' => '50px', 'height' => '50px']);
            }
        ],

        [
            'label' => '内容',
            'value' => function($model) {
                //根据type来操作
                switch ($model->skip_type) {
                    case StartPage::SKIP_TYPE_VIDEO : //书籍
                        $video = Video::findOne($model->content);
                        if ($video) {
                            return $video->title;
                        }
                        return '--';

                    case StartPage::SKIP_TYPE_WEB : //web_url
                    case StartPage::SKIP_TYPE_BROWSER:
                        return $model->content;

                    default :
                        return '';
                }
            }
        ],

//        'ad_key',
//        'ad_android_key',

        '@status',
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{update} {delete} {shelve}',
            'buttons' => [

                'shelve' => function($url,$model) {

                    if ($model->status == StartPage::STATUS_DISABLED) {
                        return Html::a('<i class="fa fa-plus">显示</i>', ['start-page/shelve', 'id' => $model->id, 'shelve' => 1],
                            ['class' => 'btn btn-outline btn-circle btn-xs green', 'data-confirm' => Yii::t('yii', '确定显示该启动页吗？显示的启动页会在各端展示'),]);
                    } else {
                        return Html::a('<i class="fa fa-times">隐藏</i>', ['start-page/shelve', 'id' => $model->id, 'shelve' => 2],
                            ['class' => 'btn btn-outline btn-circle btn-xs red','data-confirm' => Yii::t('yii', '确定隐藏启动页吗？隐藏的启动页将不会在各端展示'), ]);
                    }
                },
            ],
        ],
    ],
]); ?>
