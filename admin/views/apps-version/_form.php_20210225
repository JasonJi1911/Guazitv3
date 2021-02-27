<?php

use metronic\widgets\ActiveForm;
use admin\models\apps\AppsVersion;

$this->title = '版本控制';
$this->params['breadcrumbs'][] = ['label' => '版本控制列表', 'url' => 'index?os_type='.Yii::$app->request->get('os_type', AppsVersion::OS_TYPE_IOS)];
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
    $('.upload-button').click(function(){
        $(this).parent().find('.upload_file').click();
    })
    $('.upload_file').change(function(){
        var file = $(this).val();
        var pos=file.lastIndexOf('\\\');
        var fileName = file.substring(pos+1);
        $(this).parents('tr').find('.file_path').val(fileName);
        if (fileName) {
            $(this).parents('tr').find('.channel_ids').val($(this).attr('data-id'));
        } else {
            $(this).parents('tr').find('.channel_ids').val('');
        }
    })

    $('.form-actions .green').on('click', function () {
        // 安卓端必须设置最少一个渠道包
        if ($('#appversion-os_type').val() == 2) {
            var flag = 0;
            $(".file_path").each(function(){
                if ($(this).val()) {
                    flag = 1;
                    return false;   // 跳出循环
                }
            });
            if (flag == 0) {
                alert('最少设置一个渠道包地址！');
                return false;
            }
        }
        
        // $('#overlay').show();
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

<style>
    .field-appversion-upload_file {
        margin-bottom: 0;
    }
</style>

<div class="app-version-form">

    <?php $form = ActiveForm::begin() ?>

    <?php $osType = Yii::$app->request->get('os_type', $model->os_type ? $model->os_type : Yii::$app->request->get('os_type', AppsVersion::OS_TYPE_IOS) ) ?>
    <?= $form->field($model, 'os_type')->hiddenInput(['value' => $osType])->label(false) ?>

    <?= $form->field($model, 'ver_sn')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-appversion-file_path required">
        <label class="col-md-3 control-label" for="appversion-ver_sn">渠道包地址 <span class="required">*</span></label>
        <div class="col-md-5">
            <table class="table table-striped table-bordered">
                <tbody>
                <?php foreach ($checkSwitch as $index => $item) { ?>
                    <tr>
                        <td style="width: 20%; line-height: 35px;"><?= $item['label'] ?></td>
                        <td>
                            <input type="text" class="form-control file_path" name="file_path[<?= $item['id'] ?>]" value="<?= $item['file_path'] ?>" >
                        </td>
                        <td width="10%" <?php echo ($osType == AppsVersion::OS_TYPE_IOS) ? 'style="display:none"' : ''; ?> >
                            <span class="btn default btn-file upload-button">
                                <span class="fileinput-new">上传安装包</span>
                                <input type="hidden" name="channel_ids[]" class="channel_ids" value="">
                            </span>
                            <?= $form->field($model, 'upload_file[]')->fileInput(['class' => 'upload_file', 'data-id' => $item['id'], 'style' => ['display' => 'none']])->label(false) ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?= $form->field($model, 'content')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'online_time')->datetimePickerInput(['value' => date('Y-m-d H:i:s', $model->online_time ? $model->online_time : time()), 'start-date' => date('Y-m-d')])?>

    <?php ActiveForm::end() ?>

</div>


