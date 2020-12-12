<?php

use metronic\grid\GridView;
use common\models\apps\AppsCheckSwitch;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '过审开关';
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
    $('.rate-switch').on('switchChange.bootstrapSwitch', function(event, state) {
        var record_id = $(this).attr('data-id');
        $.ajax({
            url: '/apps-check-switch/update',
            type: 'POST',
            data: {status: state, id: record_id},
            dataType: 'json',
            success: function(data) {
                console.log(data);
            }
        })
    });
JS;
$this->registerJs($js);
?>

<div class="note note-info" style="margin-top: 10px;">
    <h4 class="block">温馨提示</h4>
    <p>开启审核开关，表示APP将展示过审界面</p>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],

        'label',
        [
            'label' => '审核状态',
            'format' => 'raw',
            'value' => function($data) {
                if ($data->status == AppsCheckSwitch::STATUS_ON) {
                    return '<font color="#dc143c">审核中</font>';
                } else {
                    return '<font color="#808080">正常</font>';
                }
            },
        ],

        [
            'label' => '审核开关',
            'format' => 'raw',
            'value' => function($data) {
                $checked = $data->status == AppsCheckSwitch::STATUS_ON ? 'checked' : '';
                return '<input type="checkbox" data-size="small" class="make-switch rate-switch" ' . $checked . ' data-on-text="开" data-on-value="1" data-off-text="关" data-id="' . $data->id . '">';
            },
        ],

    ],
]); ?>

