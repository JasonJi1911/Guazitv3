<?php
/* @var yii\web\View */

use common\models\video\VideoFeedcountry;
use metronic\widgets\ActiveForm;
use admin\models\user\User;
?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

<div class="form-group field-user-mobile_areacode">
    <label class="col-md-3 control-label" for="user-mobile_areacode">区号</label>
    <div class="col-md-3"><select id="user-mobile_areacode" class="form-control" name="User[mobile_areacode]">
            <?php $countrylist = VideoFeedcountry::find()->andWhere(['<>','mobile_areacode',''])->all();
            foreach ($countrylist as $country):?>
                <option value="<?= '+'.$country['mobile_areacode']?>"><?= $country['country_name']?></option>
            <?php endforeach;?>
        </select>
        <div class="help-block"></div>
    </div>
</div>

<?= $form->field($model,'mobile')->textInput(['maxlength' => true]) ?>
<?= $form->field($model,'gender')->dropDownList(User::$genderMap)->wrapper(['width' => 2]) ?>
<?= $form->field($model,'avatar')->imageUpload(['width' => 150, 'height' => 200])->hint('建议上传150px*200px的图片') ?>
<?= $form->field($model, 'status')->dropDownList(User::$statusMap)->wrapper(['width' => 2]) ?>
<?php ActiveForm::end() ?>
