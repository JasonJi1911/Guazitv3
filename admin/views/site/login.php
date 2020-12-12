<?php

/* @var $this \yii\web\View */
//9WotZs8h59rk6QDF
use yii\helpers\Url;
use admin\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="<?= Yii::$app->language ?>">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <title><?= Yii::$app->setting->get('system.siteName') ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <?php $this->head() ?>
    <link href="/css/login.min.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<body class="login">
    <?php $this->beginBody() ?>
    <!-- BEGIN LOGO -->
    <div class="logo">
        <a href="/">
<!--            <img src="/img/logo-login.png?st" alt="" style="width:270px; margin-bottom:-30px;" />-->
        </a>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN LOGIN -->
    <div class="content">
        <!-- BEGIN LOGIN FORM -->
        <?= Html::beginForm(['site/login'], 'post', ['autocomplete' => 'off', 'class' => 'login-form']) ?>
            <h3 class="form-title font-green">登录</h3>
            <?php if ($model->hasErrors()): ?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                <strong>登录失败!</strong>
                <p style="margin-top:10px;">您的登录信息有误，请确认后重新登录：</p>
                <ul>
                    <?php foreach ($model->getErrors() as $error): ?>
                    <li><?= $error[0] ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
            <?php endif ?>
            <div class="form-group">
                <?= Html::activeTextInput($model, 'username', ['class' => 'form-control form-control-solid placeholder-no-fix', 'placeholder' => '用户名', 'autocomplete' => 'off']) ?>
            </div>
            <div class="form-group">
                <?= Html::activePasswordInput($model, 'password', ['class' => 'form-control form-control-solid placeholder-no-fix', 'placeholder' => '密码', 'autocomplete' => 'off']) ?>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <?= Html::activeTextInput($model, 'captcha', ['class' => 'form-control form-control-solid placeholder-no-fix', 'placeholder' => '验证码', 'autocomplete' => 'off', 'size' => 4]) ?>
                    </div>
                    <div class="col-md-6">
                        <img src="<?= Url::to(['site/captcha']) ?>" onclick="this.src='<?= Url::to(['site/captcha']) ?>?t='+(new Date().valueOf())" />
                    </div>
                </div>
            </div>
            <div class="form-actions text-center">
                <button type="submit" class="btn green uppercase">登录</button>
            </div>
        <?= Html::endForm() ?>
        <!-- END LOGIN FORM -->
    </div>
    <div class="copyright"> <?= date('Y') ?> © <?= Yii::$app->setting->get('system.site_name');?> </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
