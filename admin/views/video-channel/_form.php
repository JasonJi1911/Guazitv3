<?php
/* @var yii\web\View */
use metronic\widgets\ActiveForm;
use admin\models\video\VideoArea;
use yii\helpers\ArrayHelper;


?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'channel_name')->textInput(['maxlength' => true]) ?>


<div class="form-group field-videochannel-area">
    <label class="col-md-3 control-label" for="videochannel-area">地区
        <span class="required" aria-required="true"> * </span>
    </label>
    <div class="col-md-9">
        <?php
        if (is_array($model->areas)) {
            $areas = $model->areas;
        } else {
            $areas = explode(',', $model->areas);
        }
        foreach (ArrayHelper::map(VideoArea::find()->all(), 'id', 'area') as $value => $label): ?>
            <label class="checkbox-inline">
                <input type="checkbox" name="ChannelAreas[]" value="<?= $value ?>" <?= in_array($value, $areas) ? 'checked="checked"' : '' ?>> <?= $label ?>
            </label>
        <?php endforeach ?>
    </div>
</div>


<?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>
<?= $form->field($model, 'icon')->imageUpload(['width' => 150, 'height' => 200])->hint('建议上传150px*200px的图片')->label('频道Icon<span class="required">*</span>') ?>
<?= $form->field($model, 'display_order')->numberInput(['min' => 0, 'max' => '255'])->hint('0 ~ 255之间，值越大展示越靠前')->wrapper(['width' => 2])?>
<?php ActiveForm::end() ?>
