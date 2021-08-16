<?php

/* @var $this \yii\web\View */
/* @var $content string */

use wap\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<script>
    if(('standalone' in window.navigator)&&window.navigator.standalone){
        window.desc_status = 'in_desc';
        var noddy,remotes=false;
        document.addEventListener('click',function(event){
            noddy=event.target;
            while(noddy.nodeName!=='A'&& noddy.nodeName!=='HTML')
                noddy=noddy.parentNode;
            if('href' in noddy && noddy.href.indexOf('http')!==-1&&(noddy.href.indexOf(document.location.host)!==-1||remotes)){
                event.preventDefault();
                document.location.href=noddy.href;
            }
        },false);
    }
</script>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<meta name="keywords" content="瓜子TV-澳新华人在线视频分享网站">-->
    <meta name="description" content="吉祥视频">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" >
    <link rel="shortcut icon" type="image/x-icon" href="/images/video/logo_ico.ico">
    <link href="/images/video/logo-02.png" rel="apple-touch-icon-precomposed">
    <link href="/images/video/logo-02.png" rel="Shortcut Icon" type="image/x-icon">
    <link href="/images/video/logo-02.png" rel="Bookmark">
    <!-- Global site tag (gtag.js) - Google Analytics -->
<!--    <script async src="https://www.googletagmanager.com/gtag/js?id=G-R9BCW62LFW"></script>-->
<!--    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6TXJP66KCH"></script>-->
    <script async src="/js/video/gtag_id_G-6TXJP66KCH.js"></script>
    
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-R9BCW62LFW');
    </script>
<!--    <script>-->
<!--        var _hmt = _hmt || [];-->
<!--        (function() {-->
<!--        var hm = document.createElement("script");-->
<!--        hm.src = "https://hm.baidu.com/hm.js?acb48993923bb825b8c964792dfee455";-->
<!--        var s = document.getElementsByTagName("script")[0]; -->
<!--        s.parentNode.insertBefore(hm, s);-->
<!--        })();-->
<!--    </script>-->
    
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<style>
    a:hover,
    a:focus {
        color: #000;
        text-decoration: none !important;
    }
</style>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">

<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
