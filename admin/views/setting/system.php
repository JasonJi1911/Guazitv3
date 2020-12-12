<?php
/** @var $model admin\models\setting\SettingSystem */
/* @var $this yii\web\View*/
use metronic\widgets\ActiveForm;
?>

<div class="note note-info">
    系统基础信息设置
</div>

<div class="portlet-body">
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'site_name')->textInput(['maxlength' => true])->hint('此网站的名称,显示在后台的标题等地方') ?>

    <div class="form-group field-comic-cat">
        <label class="col-md-3 control-label" for="comic-cat">地区限制
            <span class="required" aria-required="true"> * </span>
        </label>
        <div class="col-md-9" id="checkbox_client">
            <?php foreach (\api\helpers\Common::$areaTexts as $value => $label): ?>
                <label class="checkbox-inline">
                    <input type="checkbox" name="SettingSystem[areas][]" value="<?= $value ?>" <?= strpos($model->area_limit, (string)$value) !== false ? 'checked="checked"' : '' ?>> <?= $label ?>
                </label>
            <?php endforeach ?>
        </div>
    </div>

    <?= $form->field($model, 'currency_unit')->textInput(['maxlength' => true])->label('货币名称')->hint('在用户信息等处显示') ?>
    <?= $form->field($model, 'currency_coupon')->textInput(['maxlength' => true])->label('付费货币名称')->hint('用于支付付费视频') ?>
    <?= $form->field($model, 'comment_switch')->switch($model::$itemsMap)->hint('开关开启之后,用户的评论需要经过审核才会展示出来') ?>
    <?= $form->field($model, 'ad_switch')->switch($model::$itemsMap)->hint('全站广告开关') ?>
    <?= $form->field($model, 'remove_ad_score')->numberInput(['maxlength' => true])->hint('播放视频时，跳过广告所需要的积分') ?>
    <?= $form->field($model, 'play_ad_time')->numberInput(['maxlength' => true])->hint('播放视频前的广告<span style="color: red">秒</span>数') ?>
    <?= $form->field($model, 'coupon_expire_time')->numberInput(['maxlength' => true])->hint('购买用券视频后的有效<span style="color: red">天</span>数') ?>
    <?= $form->field($model, 'third_pay')->switch($model::$itemsMap)->hint('开关开启之后,IOS客户端将展示三方支付，如：微信，支付宝') ?>
    <?= $form->field($model, 'vip_play_all')->switch($model::$itemsMap)->hint('开关开启之后,VIP用户可播放全站视频') ?>
    <?php ActiveForm::end() ?>
</div>

