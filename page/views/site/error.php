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
    <title>系统繁忙</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <?php $this->head() ?>
    <link href="/css/error.min.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="favicon.ico" />
    <style>
        .error{
            width: 100%;
        }
        body{
            background:#fff;
        }
        .error_tips{
            padding: 0 40px;
        }
        .error_tips h2{
            font-size:16px;
            font-weight: 500;
            text-align:center;
            
        }
        .error_tips p{
            color: #575757;
            line-height:24px;
        }
        .goback{
            text-align:center;
        }
        .goback a{
            color:#969696;
            border:1px solid #c8c8c8;
        }
    </style>
</head>
<!-- END HEAD -->
<body class="">
    <?php $this->beginBody() ?>
    <div class="">
        <!-- <div class="col-md-12 page-500">
            <div class=" number font-red"> <?= $exception->statusCode ?: $exception->getCode() ?> </div>
            <div class=" details">
                <h3><?= Html::encode($name) ?></h3>
                <p><?= nl2br(Html::encode($message)) ?></p>
                <p>
                    <a href="javascript:;" class="btn red btn-outline" onclick="history.back()"> 返回上一页 </a>
                    <br>
                </p>
            </div>
        </div> -->
        <img src="/images/error.jpg" alt="" class="error">
        <div class="error_tips">
            <h2>页面发生错误</h2>
            <p>错误代码<?= $exception->statusCode ?: $exception->getCode() ?>，请刷新后重试，若仍有问题，请检查网络</p>
        </div>
        <p class="goback">
            <a href="javascript:;" class="btn btn-outline" onclick="history.back()"> 返回上一页 </a>
            <br>
        </p>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
