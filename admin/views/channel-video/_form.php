<?php

use metronic\widgets\ActiveForm;
use common\models\channel\ChannelVideo as commonChannelVideo;


$this->title = '播放渠道来源设置';
$this->params['breadcrumbs'][] = ['label' => '播放渠道来源列表', 'url' => 'index?os_type='.Yii::$app->request->get('os_type', commonChannelVideo::OS_TYPE_APP)];
$this->params['breadcrumbs'][] = $this->title;

// $js = <<<JS

//     $('.release-switch').on('switchChange.bootstrapSwitch', function(event, state) {
//         var type = 2;
//         var record_id = $(this).attr('data-id');
//         console.log('11111');
//         // $.ajax({
//         //     url: '/channel-video/update',
//         //     type: 'POST',
//         //     data: {status: state, id: record_id, type: type},
//         //     dataType: 'json',
//         //     success: function(data) {
//         //         console.log(data);
//         //     }

//         // })
//     });
// JS;
// $this->registerJs($js);
?>

<div class="channle-video-form">

    <?php $form = ActiveForm::begin() ?>

    <?php $osType = Yii::$app->request->get('os_type', $model->os_type ? $model->os_type : Yii::$app->request->get('os_type', commonChannelVideo::OS_TYPE_APP) ) ?>
    <?= $form->field($model, 'os_type')->hiddenInput(['value' => $osType])->label(false) ?>

    <div class="form-group field-appversion-file_path required">
        <label class="col-md-3 control-label" for="appversion-ver_sn"><?=commonChannelVideo::$osType[$osType];?>播放渠道来源<span class="required"></span></label>
        <div class="col-md-5">
            <table class="table table-striped table-bordered">
                <tbody>
                <?php foreach ($videoSource as $index => $item) { ?>
                    <tr>
                        <td>
                            <label class="checkbox-inline" style="width: 150px;">
                                <?=$form->field($model, 'sid['.$item['id'].']')->checkboxList([$item['id']=>$item['name']])->label('');?>
                            </label>
                        </td>
                        <td>
                            <?= $form->field($model, 'display_order['.$item['id'].']')->textInput()->label('sort'); ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php ActiveForm::end() ?>

</div>


