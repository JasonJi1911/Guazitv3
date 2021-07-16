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
    <meta name="description" content="瓜子视频（瓜子TV）是澳大利亚、新西兰华人影视视频分享平台，网站包含最新的电视剧、美剧、日韩剧、华语电影、好莱坞电影、以及各种动漫和重大体育赛事直播。在这里，一定有你想看的一切！">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" >
    <link rel="shortcut icon" type="image/x-icon" href="http://img.guazitv8.com/LOGO.ico">
    <link href="http://img.guazitv8.com/LOGO.png" rel="apple-touch-icon-precomposed">
    <link href="http://img.guazitv8.com/LOGO.png" rel="Shortcut Icon" type="image/x-icon">
    <link href="http://img.guazitv8.com/LOGO.png" rel="Bookmark">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6TXJP66KCH"></script>
    
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-6TXJP66KCH');
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
