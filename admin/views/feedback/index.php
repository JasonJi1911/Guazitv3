<?php

use yii\helpers\Html;
use metronic\grid\GridView;
use common\helpers\OssUrlHelper;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户反馈';
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
    var id = 0;
    $('.reply_action').on('click', function() {
        id = $(this).attr('id');
        // var replyContent = $(this).parent().parent().find('td').eq(4).text();
        // $('#reply_content').val(replyContent);
    });
    
    // 查看大图
    $(".select_image").click(function () {
        var image = $(this).attr('src');
        $('.big_image').attr('src', image);
    })
    
    $("#reply_submit").on('click', function(){
        var replyContent = $.trim($("#reply_content").val());
        
        if (replyContent == '') {
            alert('请填写回复内容！');
            return false;
        }
        
        $.get('/feedback/reply', {id: id, reply_content: replyContent}, function(s) {
            if (s.errno == 0) {
                alert(s.error);
                window.location.reload();
            } else {
                alert(s.error);
                return false;
            }
        })
        
    });
 
JS;

$this->registerJs($js);
?>

<style>
    .select_image {
        width: 50px;
        height: 80px;
        margin-right: 10px;
    }
</style>

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
                [
                    'label' => '用户信息',
                    'contentOptions' => [
                        'width' => '10%'
                    ],
                    'format' => 'raw',
                    'value' => function ($model) {
                        $html = '';
                        if ($model->user) {
                            $html .= '&nbsp;'.Html::a(empty($model->user->nickname) ? USER_NICKNAME_PREFIX . (1000000 + $model->user->uid) : $model->user->nickname);
                            $html .= '&nbsp;<span style="color:#00A1CB">('.$model->user->uid.')</span>';
                        }
                        return $html;
                    }
                ],
                [
                    'label' => '联系方式',
                    'contentOptions' => [
                        'width' => '5%'
                    ],
                    'format' => 'raw',
                    'value' => function($model) {
                        return $model->contact;
                    }
                ],
                [
                    'label' => '反馈内容',
                    'contentOptions' => [
                        'width' => '30%'
                    ],
                    'format' => 'raw',
                    'value' => function($model) {
                        $html = '';
                        $images = json_decode($model->images, true);
                        if ($images) {
                            foreach ($images as $img) {
                                $ossUrlHelper = new OssUrlHelper($img);
                                $html .= '<img src="'.$ossUrlHelper->toUrl().'" class="select_image" data-toggle="modal" data-target="#select_image">';
                            }
                        }
                        $html .= htmlspecialchars($model->content) ;
                        return $html;
                    }
                ],
                [
                    'label' => '回复内容',
                    'contentOptions' => [
                        'width' => '30%'
                    ],
                    'value' => function($model) {
                        return $model->reply;
                    }
                ],

                [   'label' => '用户来源',
                    'attribute' => 'source',
                    'options' => ['width' => '5%'],
                    'value' => 'sourceText'
                ],

                [   'label' => '反馈时间',
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d H:i'],
                    'options' => ['width' => '12%'],
                ],

                [
                    'class' => 'metronic\grid\ActionColumn',
                    'template' => '{reply} {delete}',
                    'buttons' => [
                        'reply' => function ($url, $model) {
                            if ($model->reply) { // 如果有反馈
                                return '';
                            }
                            return Html::a('<i class="fa fa-edit">回复</i>', '#', ['class' => 'reply_action btn btn-outline btn-circle btn-xs blue', 'id' => $model->id, 'data-toggle' => 'modal', 'data-target' => '#myModal']);
                        }
                    ],
                ]

            ],
        ]); ?>
    </div>
</div>

<div class="modal fade" id="select_image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <img src="" class="big_image" width="100%" height="100%">
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="min-width: 400px;min-height:200px">
            <div class="modal-header">
                <button type="button" class="close closemodal" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    回复内容
                </h4>
            </div>
            <div class="modal-body" style="text-align: center;">
                <div>
                    <textarea class="form-control" id="reply_content" rows="4" style="width: 100%;"></textarea>
                    <button id="reply_submit" class="btn green" style="margin-top: 10px;">提交</button>
                </div>
            </div>
        </div>
    </div>
</div>
