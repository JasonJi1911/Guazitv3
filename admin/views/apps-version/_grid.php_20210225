<?php

use yii\helpers\Html;
use metronic\grid\GridView;
use admin\models\apps\AppsVersion;
use common\models\apps\AppsCheckSwitch;
use yii\helpers\Url;
\metronic\assets\ToastrAsset::register($this);

$this->title = '版本控制列表';
$this->params['breadcrumbs'][] = ['label' => '版本控制管理', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
    $('.update-switch').on('switchChange.bootstrapSwitch', function(event, state) {
        var record_id = $(this).attr('data-id');
        var type = $(this).attr('data-type');
        $.ajax({
            url: '/apps-version/update-switch',
            type: 'POST',
            data: {status: state, id: record_id, type: type},
            dataType: 'json',
            success: function(data) {
                toastr.success("操作成功", "");
                setTimeout(function() { location.reload(); }, 1000);
            }
        })
    });

    $('.data-detail').on('click', function () {
        var versionId = $(this).attr('data-id');
        $(".modal-body .table-bordered").hide();
        $("#check-switch-"+versionId).show();
    });
    
    $('.rate-switch').on('switchChange.bootstrapSwitch', function(event, state) {
        var type = 1;
        var record_id = $(this).attr('data-id');
        $.ajax({
            url: '/apps-check-switch/update',
            type: 'POST',
            data: {status: state, id: record_id, type: type},
            dataType: 'json',
            success: function(data) {
                console.log(data);
            }
        })
    });

    $('.release-switch').on('switchChange.bootstrapSwitch', function(event, state) {
        var type = 2;
        var record_id = $(this).attr('data-id');
        $.ajax({
            url: '/apps-check-switch/update',
            type: 'POST',
            data: {status: state, id: record_id, type: type},
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
    <p>Android支持多渠道更新控制，若不需要多渠道，只维护一个渠道即可</p>
    <p>新增版本号时，填写对应的渠道包地址，或上传相应渠道版本的的安装包</p>
    <p>审核过程中，可以开启审核状态，<font color="red">审核状态</font>开启的版本不会提醒更新（<font color="red">提醒：购买上架服务的，审核功能才生效</font>）</p>
    <p><font color="red">发布状态</font>的版本才会提醒更新</p>
    <p>开启强制更新，APP端会强制更新软件包，才能继续使用</p>
</div>

<style>
    .modal-body .table-bordered {
        display: none;
    }
</style>

<div class="portlet light">
    <?php $osType = Yii::$app->request->get('os_type', AppsVersion::OS_TYPE_IOS); ?>
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase">版本列表</span>
        </div>
        <div class="actions">
            <a class="btn green" href="/apps-version/create?os_type=<?= $osType ?>">新增版本</a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="portlet-title" style="margin-bottom: 10px;">
            <div class="caption" style="padding: 0px;">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs">
                        <?php foreach (AppsVersion::$osType as $index => $osText) { ?>
                            <li class="<?php if ($index == $osType) {echo 'active';} ?>">
                                <a href="<?= Url::to(['apps-version/index', 'os_type' => $index])?>">
                                    <?= $osText ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'ver_sn',
                [
                    'attribute' => 'os_type',
                    'enableSorting' => false,
                    'value' => function($model) {
                        return AppsVersion::$osType[$model->os_type];
                    }
                ],
                'content',
                'online_time:datetime',

                [
                    'attribute' => 'force_update',
                    'format' => 'raw',
                    'value' => function($model) {
//                        if (($model->os_type == AppsVersion::OS_TYPE_IOS && $model->is_release == AppsVersion::RELEASE_ON) || $model->os_type == AppsVersion::OS_TYPE_ANDROID) {
                        if ($model->is_release == AppsVersion::RELEASE_ON) {
                            $checked = $model->force_update == AppsVersion::FORCE_UPDATE_YES ? 'checked' : '';
                            return '<input type="checkbox" data-size="small" class="make-switch update-switch" ' . $checked . ' data-on-text="是" data-on-value="1" data-off-text="否" data-id="' . $model->id . '" data-type="1">';
                        }
                        return '-';
                    },
                ],
                [
                    'attribute' => 'is_release',
                    'format' => 'raw',
//                    'visible' => (Yii::$app->request->get('os_type', AppsVersion::OS_TYPE_IOS) == AppsVersion::OS_TYPE_IOS) ? 1 : 0,
                    'value' => function($model) {
                        $checked = $model->is_release == AppsVersion::RELEASE_ON ? 'checked' : '';
                        return '<input type="checkbox" data-size="small" class="make-switch update-switch" ' . $checked . ' data-on-text="是" data-on-value="1" data-off-text="否" data-id="' . $model->id . '" data-type="2">';
                    },
                ],
                [
                    'class' => 'metronic\grid\ActionColumn',
                    'template' => '{detail} {update} {delete}',
                    'buttons' => [
                        'detail' => function ($url, $model) {
                            return Html::a('<i class="fa fa-eye"> 详情</i>', '#', ['data-toggle' => 'modal', 'data-target' => '#channel-check', 'class' => 'data-detail btn btn-outline btn-circle btn-xs blue', 'data-id' => $model->id]);
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<i class="fa fa-edit"> 编辑</i>', ['apps-version/update?id='.$model->id.'&os_type='.$model->os_type], ['class' => 'btn btn-outline btn-circle btn-xs purple']);
                        },

                    ]
                ],
            ],
        ]); ?>
    </div>
</div>

<div class="modal fade" id="channel-check" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 800px;">
            <div class="modal-header">
                <h4 class="modal-title">渠道过审列表</h4>
            </div>
            <div class="modal-body" style="max-height: 450px;overflow-y: scroll;">
                <?php foreach ($checkSwitch as $index => $list) { ?>
                <table class="table table-striped table-bordered" id="check-switch-<?= $index ?>">
                    <thead>
                        <tr><th>渠道名称</th><th>审核开关</th><th>渠道下载地址</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list as $item) { ?>
                        <tr>
                            <td><?= $item['label'] ?></td>
                            <td>
                                <?php $checked = $item['status'] == AppsCheckSwitch::STATUS_ON ? 'checked' : ''; ?>
                                <div class="bootstrap-switch-container">
                                    <input type="checkbox" data-size="small" class="make-switch rate-switch" <?= $checked ?> data-on-text="开" data-on-value="1" data-off-text="关" data-id="<?= $item['id'] ?>">
                                </div>
                            </td>
                            <td>
                                <?= $item['file_path'] ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
