<?php
/* @var $this yii\web\View */

use admin\models\user\UserVip;
use yii\helpers\Html;
use metronic\grid\GridView;
use admin\models\user\user;
use common\helpers\Tool;

$js = <<<JS
    $('#recharge').on('click', function() {
        var uid = $('#uid').val();
        var money = $.trim($('#money').val());
        $.get('/user/gold', {uid: uid, money: money}, function(s) {
            if (s.errno) {
                alert(s.error);
                return;
            }
            window.location.reload();
        })
    })
    
    // 卡券管理
    $('#coupon').on('click', function() {
        var uid = $('#uid').val();
        var num = $.trim($('#coupon-num').val());
        $.get('/user/coupon', {uid: uid, num: num}, function(s) {
            if (s.errno) {
                alert(s.error);
                return;
            }
            window.location.reload();
        })
    })
    
    // 查看好友
    $(".select_child").on('click', function() {
        var uid = $(this).attr('data-uid');
        $.get('/user/friend-list', {uid: uid}, function(data) {
            $('#select_child .modal-body').html(data);
        })
    })
    
        $('#vip-buy').on('click', function() {
        var uid = $('#uid').val();
        var days = $.trim($('#days').val());
        $.get('/user/vip-buy', {uid: uid, days: days}, function(s) {
            if (s.errno) {
                alert(s.error);
                return;
            }
            window.location.reload();
        })
    })

JS;

$this->registerJs($js);
?>
<style>
    .close{
        font-size:30px;
        text-indent:0 ;
        width: 28px;
    }
</style>
<input type="hidden" value="" id="uid">
<!-- 充值 -->
<div class="modal fade" id="goldModal" tabindex="-1" role="dialog" aria-labelledby="goldModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                </button>
                <h4 class="modal-title" id="goldModalLabel">
                    系统充值
                </h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-xs-4"><?= Yii::$app->setting->get('system.currency_unit')?>（扣除数不能超过当前总数）</div>
                        <div class="col-sm-8 col-md-8 col-xs-8">
                            <input type="number" value="" id="money" class="input-sm" placeholder="最大10000000" style="padding: 5px 5px; width: 20%" oninput="if(value > 10000000){alert('最多输入八位数！');value = ''}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" title="" type="button" id="recharge" data-clipboard-text="">
                    保存
                </button>
                <button type="button" class="btn btn-default cancel" data-dismiss="modal">取消
                </button>
            </div>
        </div>
    </div>
</div>
<!-- 观影券 -->
<div class="modal fade" id="couponModal" tabindex="-1" role="dialog" aria-labelledby="couponModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                </button>
                <h4 class="modal-title" id="couponModal">
                    <?= Yii::$app->setting->get('system.currency_coupon')?>充值
                </h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-xs-4"><?= Yii::$app->setting->get('system.currency_coupon')?></div>
                        <div class="col-sm-8 col-md-8 col-xs-8">
                            <input type="number" value="" id="coupon-num" class="input-sm" placeholder="最大10000000" style="padding: 5px 5px; width: 20%" oninput="if(value > 10000000){alert('最多输入八位数！');value = ''}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" title="" type="button" id="coupon" data-clipboard-text="">
                    保存
                </button>
                <button type="button" class="btn btn-default cancel" data-dismiss="modal">取消
                </button>
            </div>
        </div>
    </div>
</div>
<!-- 开通会员 -->
<div class="modal fade" id="vipModal" tabindex="-1" role="dialog" aria-labelledby="vipModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                </button>
                <h4 class="modal-title" id="vipModalLabel">
                    开通会员
                </h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-xs-4">开通天数</div>
                        <div class="col-sm-8 col-md-8 col-xs-8">
                            <input type="number" value="" id="days" class="input-sm" placeholder="最大9999天" style="padding: 5px 5px; width: 20% " oninput="if(value > 9999){alert('最多输入四位数！');value = ''}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" title="" type="button" id="vip-buy" data-clipboard-text="">
                    保存
                </button>
                <button type="button" class="btn btn-default cancel" data-dismiss="modal">取消
                </button>
            </div>
        </div>
    </div>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => '昵称(UID)',
            'format' => 'raw',
            'enableSorting' => false,
            'value' => function ($model){
                $html = '';
                $html .= Html::img($model->avatar->toUrl(), ['width' => 25]);
                $html .= '&nbsp;' . $model->nickname;
                $html .= '&nbsp;<span style="color:#00A1CB">(' . $model->uid . ')</span>';

                return $html;
            },
        ],
        'mobile',
        [
            'label' => '性别',
            'value' => function ($model){
                if ($model->gender) {
                    return $model->gender == User::GENDER_FEMALE ? '女' : '男';
                } else {
                    return '-';
                }
            },
        ],
        'fromChannelText',

        [
            'label' => '是否会员',
            'format' => 'raw',
            'value' => function($model) {

                $userVip = UserVip::findOne(['uid' => $model->uid]);

                if ($userVip && $userVip->end_time > time()) {
                    $endTime = date('Y-m-d H:i:s', intval($userVip->end_time));

                    $html = '是<br><small>有效期至：' . $endTime;

                    return $html;
                } else {
                    return '否';
                }
            }
        ],

        [
            'label' => Yii::$app->setting->get('system.currency_coupon'),
            'value' => function($model) {
                if ($model->asset) {
                    return $model->asset->coupon_remain;
                } else {
                    return '0';
                }
            }
        ],

        [
            'label' => Yii::$app->setting->get('system.currency_unit'),
            'value' => function($model) {
                if ($model->asset) {
                    return $model->asset->score_remain;
                } else {
                    return '0';
                }
            }
        ],

        [
            'label' => '注册时间',
            'value' => function ($model){
                if ($model->created_at) {
                    return date('Y-m-d H:i:s', $model->created_at);
                }

                return '--';
            },
        ],

        '@status',

        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{vip-buy} {gold} {coupon} {update} {delete}',
            'buttons' => [
                'vip-buy' => function($url, $model) {
                    return Html::actionButton('开通会员', '#', 'diamond', 'blue', ['data-toggle' => 'modal', 'data-target' => '#vipModal', 'onclick' => "$('#uid').val(".$model->uid.")"]);
                },
                'gold' => function ($url, $model){
                    return Html::actionButton(Yii::$app->setting->get('system.currency_unit') . '充值', '#', 'bitcoin', 'yellow', [
                        'data-toggle' => 'modal', 'data-target' => '#goldModal',
                        'onclick' => "$('#uid').val(" . $model->uid . ")",
                    ]);
                },
                'coupon' => function ($url, $model){
                    return Html::actionButton(Yii::$app->setting->get('system.currency_coupon') . '充值', '#', 'print', 'green', [
                        'data-toggle' => 'modal', 'data-target' => '#couponModal',
                        'onclick' => "$('#uid').val(" . $model->uid . ")",
                    ]);
                },
            ],
        ],
    ],
]); ?>

<div class="modal fade" id="select_child" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 800px;">
            <div class="modal-header">
                <h4 class="modal-title">好友列表</h4>
            </div>
            <div class="modal-body" style="max-height: 450px;overflow-y: scroll;">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
