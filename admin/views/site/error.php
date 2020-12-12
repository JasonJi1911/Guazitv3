<?php

/* @var $this \yii\web\View */

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
    <link href="/css/error.min.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<body class="page-500-full-page">
    <?php $this->beginBody() ?>
    <div class="row">
        <div class="col-md-12 page-500">
            <div class=" number font-red"> <?= $exception->statusCode ?: $exception->getCode() ?> </div>
            <div class=" details">
                <h3><?= Html::encode($name) ?></h3>
                <p><?= nl2br(Html::encode($message)) ?></p>
                <p>
                    <a href="javascript:;" class="btn red btn-outline" onclick="history.back()"> 返回上一页 </a>
                    <br>
                </p>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
