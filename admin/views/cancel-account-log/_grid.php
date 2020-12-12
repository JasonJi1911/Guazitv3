<?php

use admin\models\user\CancelAccountLog;
use yii\helpers\Html;
use metronic\grid\GridView;
use admin\models\user\ExtractRecord;
use admin\models\user\User;

$js = <<<JS
    var id = 0;
    $('.extract_action').on('click', function() {
        id = $(this).attr('id');
    });
    
    $("input[name=status]").on('click', function(){
        var status = $(this).val();
        if (status == 2) {
            $("#remark").parent().show();
        } else {
            $("#remark").parent().hide();
        }
    });
    
    $("#extract_submit").on('click', function(){
        var status = $("input[name=status]:checked").val();
        var remark = $("#remark").val();
        if (status == 2 && remark == '') {
            alert('请填写驳回原因！');
            return false;
        }
        
        $.get('/cancel-account-log/handle', {id: id, status: status, remark: remark}, function(s) {
            if (s.errno == 0) {
                var url = '<span class="copy-content">' + s.error + '</span>&nbsp;&nbsp;<button data-clipboard-text=' + s.error + ' class="btn blue btn-outline btn-circle btn-sm active copy-button">复制</button>';
                _this.parent('td').prepend(url);
            } else {
                alert(s.error);
                window.location.reload();
            }
        })
        
    });
    
JS;
$this->registerJs($js);

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => '用户名',
            'value' => function ($model) {
                $userInfo = User::findOne(['uid' => $model->uid]);
                return isset($userInfo) ? $userInfo->nickname : '';
            }
        ],

        [
            'attribute' => '状态',
            'format' => 'raw',
            'value' => function ($model) {
                $html = CancelAccountLog::$statuses[$model->status];
                if ($model->status == 1) {
                    return '<font color="blue">'.$html.'</font>';
                } else if ($model->status == 2) {
                    return '<font color="red">'.$html.'</font>';
                } else {
                    return '<font color="gray">'.$html.'</font>';
                }
            }
        ],
        [
            'attribute' => '审核人',
            'value' => function ($model) {
                $userInfo = $model->admin;
                return isset($userInfo->username)? $userInfo->username : '';
            }
        ],
        'remark',
        'extract_at:datetime',
        'created_at:datetime',
        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{view} {action}',
            'buttons' => [
                'action' => function ($url, $model) {
                    if ($model->status == 0) {
                        return Html::a('<i class="fa fa-edit">操作</i>', '#', ['class' => 'extract_action btn btn-outline btn-circle btn-xs blue', 'id' => $model->id, 'data-toggle' => 'modal', 'data-target' => '#myModal']);
                    }
                }
            ],
        ],
    ],
]); ?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="min-height:200px">
            <div class="modal-header">
                <button type="button" class="close closemodal" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    注销操作
                </h4>
            </div>
            <div class="modal-body">
                <div style="padding:20px">
                    状态：
                    <input type="radio" name="status" value="<?= CancelAccountLog::STATUS_CONFIRM; ?>" checked> 通过
                    &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="status" value="<?= CancelAccountLog::STATUS_REJECT; ?>"> 驳回
                    <br /><br />
                    <p style="display:none">驳回原因：<textarea class="form-control" id="remark" rows="4" style="width: 50%;"></textarea></p>
                    <button id="extract_submit" class="btn green">提交</button>
                </div>
            </div>
        </div>
    </div>
</div>
