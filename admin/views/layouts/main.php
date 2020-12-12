<?php

/* @var $this \yii\web\View */
/* @var $content string */

use admin\assets\AppAsset;
use admin\widgets\MenuWidget;
use yii\helpers\Html;

AppAsset::register($this);
$js = <<< JS
    $('.sidebar-toggler').click(function(){
        $('.top-logo').toggleClass('min-top-logo');
        if ($('.top-logo').hasClass('min-top-logo')){
            $('.top-logo').hide();
        } else {
            $('.top-logo').show()
        }
    })
    $('.page-content').css({'min-height': '100%'});
JS;
$this->registerJs($js);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - <?= Yii::$app->setting->get('system.siteName') ?></title>
    <?php $this->head() ?>
    <style>
        .page-header-fixed .page-container{
            margin-top:0;
            padding-top:50px;
            box-sizing: border-box;
        }
    </style>
</head>

<script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<?php $this->beginBody() ?>

<div class="page-wrapper">
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="/" style="text-decoration: none">
                    <h3 class="top-logo" style="margin: 0px; line-height: 50px;"><?= Yii::$app->setting->get('system.site_name')?></h3>
                </a>
                <div class="menu-toggler sidebar-toggler">
                    <span></span>
                </div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                <span></span>
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- END TODO DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <span class="username username-hide-on-mobile"> <?= Yii::$app->user->identity->username ?> </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <?= Html::a('<i class="icon-lock"></i> 更改密码', ['/site/password']) ?>
                            </li>
                            <li>
                                <?= Html::a('<i class="icon-key"></i> 安全退出', ['/site/logout']) ?>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <!-- BEGIN SIDEBAR -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <div class="page-sidebar navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <?= MenuWidget::widget() ?>
                <!-- END SIDEBAR MENU -->
            </div>
            <!-- END SIDEBAR -->
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content" style="margin-left: 0 !important;">
                <!-- BEGIN PAGE HEADER-->

                <?php if (!empty($this->params['breadcrumbs'])): ?>
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li><a href="/">首页</a><i class="fa fa-angle-right"></i></li>
                            <?php foreach ($this->params['breadcrumbs'] as $index => $crumb): ?>
                                <li>
                                    <?php if (is_array($crumb)): ?>
                                        <?= Html::a($crumb['label'], $crumb['url']) ?>
                                    <?php else: ?>
                                        <?= Html::tag('span', $crumb) ?>
                                    <?php endif ?>
                                    <?php if ($index != count($this->params['breadcrumbs']) - 1): ?>
                                        <i class="fa fa-angle-right"></i>
                                    <?php endif ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <!-- END PAGE BAR -->
                <?php endif ?>

                <?= $content ?>

            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->

    <!-- END FOOTER -->
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
