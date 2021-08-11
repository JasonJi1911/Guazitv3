<?php

use admin\models\video\VideoChannel;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use metronic\grid\GridView;

$viewBasePath = Yii::$app->controller->viewBasePath;

$this->params['breadcrumbs'] = [];
$this->title = '类型绑定';
$this->params['breadcrumbs'][] = "数据中心";
$this->params['breadcrumbs'][] = ['url' => '/collect/index', 'label' => '视频采集'];
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
    $('.bindModel').on('click', function (){
       $('#typeid').val($(this).attr("data-typeid")); 
       $('#typename').val($(this).attr("data-typename"));
       var bindName = $(this).text().trim();
       if(bindName == "绑定")
       {
            $('#cancelBind').attr("disabled", true);;
       }
       else {
            $('#cancelBind').attr("disabled", false);;
       }
    });

    $('#bind').on('click', function() {
        var channelid = $('#channelid').val();
        var collectid = $('#collectid').val();
        var typeid = $('#typeid').val();
        var typename = $('#typename').val();
        var money = $.trim($('#money').val());
        $.get('/collect/bind', {typeid: typeid, typename: typename, collectid: collectid, channelid: channelid}, function(s) {
            console.log(s);
            console.log(s.data.channelName);
            if (s.errno != 0) {
                alert(s.error);
                return;
            }
            // window.location.reload();
            
            $('#type_' + typeid + ' i').text(' '+s.data.channelName);
            $('#bindModal').modal('hide');
        })
    });
    
    $('#cancelBind').on('click', function() {
        var collectid = $('#collectid').val();
        var typeid = $('#typeid').val();
        
        $.get('/collect/cancel-bind', {typeid: typeid, collectid: collectid}, function(s) {
            console.log(s);
            console.log(s.data.channelName);
            if (s.errno != 0) {
                alert(s.error);
                return;
            }
            // window.location.reload();
            alert('解绑成功')
            $('#type_' + typeid + ' i').text(' '+'绑定');
            $('#bindModal').modal('hide');
        })
    });
JS;

$this->registerJs($js);

?>
<input type="hidden" value="<?= $collect_id ?>" id="collectid">
<input type="hidden" value="" id="typeid">
<input type="hidden" value="" id="typename">
<div class="modal fade" id="bindModal" tabindex="-1" role="dialog" aria-labelledby="goldModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                </button>
                <h4 class="modal-title" id="bindModalLabel">
                    类型绑定
                </h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-xs-4"><?= Yii::$app->setting->get('system.currency_unit')?>选择分类</div>
                        <div class="col-sm-8 col-md-8 col-xs-8">
                            <?= Html::dropDownList("channel_bind", null, ArrayHelper::map(VideoChannel::find()->all(), 'id', 'channel_name'), ['id' => 'channelid']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" title="" type="button" id="cancelBind" data-clipboard-text="">
                    解绑
                </button>
                <button class="btn btn-primary" title="" type="button" id="bind" data-clipboard-text="">
                    保存
                </button>
                <button type="button" class="btn btn-default cancel" data-dismiss="modal">取消
                </button>
            </div>
        </div>
    </div>
</div>

<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>
        <div class="actions">
            <?php foreach (Yii::$app->controller->actionEditButtons() as $button): ?>
                <?= Html::a($button['label'], $button['url'], $button['options']); ?>
            <?php endforeach ?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="note note-info">
            <h4 class="block">温馨提示</h4>
            <p> 设置绑定类型。
            </p>
        </div>
        <div class="container">
            <div class="row">
                <?php foreach ($data['type'] as $k=>$v) :?>
                    <div class="col-md-2">
                        <?= Html::label($v['type_name']) ?>
                        <?= Html::actionButton(!isset($v['channel_name'])?'绑定': $v['channel_name'], '#', 'diamond', 'blue',
                            ['data-toggle' => 'modal', 'data-target' => '#bindModal',
                                'class'=>'bindModel', 'data-typeid' => $v['type_id'], 'data-typename'=>$v['type_name'], 'id'=> 'type_'.$v['type_id']]);
                        ?>
                    </div>
                <?php endforeach;?>
            </div>
        </div>

        <div class="container margin-top-20">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'vod_name',
                    'type_name',
                    'vod_play_from',
                    'vod_time',
                ],
            ]);
            ?>
        </div>
    </div>
</div>


