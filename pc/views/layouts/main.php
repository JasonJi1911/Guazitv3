<?php

/* @var $this \yii\web\View */
/* @var $content string */

use pc\assets\AppAsset;
use yii\helpers\Html;

$this->registerMetaTag(['name' => 'keywords', 'content' => LOGONAME.'视频,'.LOGONAME.'TV,北美视频分享网,北美华人影视视频,美国影视网,加拿大影视网,美国'.LOGONAME.'视频,加拿大'.LOGONAME.'视频,北美华人在线追剧,海外华人,免费视频,国产剧,在线视频,电视剧,综艺']);
$this->registerMetaTag(['name' => 'description', 'content' => LOGONAME.'视频('.PC_HOST_NAME.')为中文在线影视分享平台汇集了最新热门的电影,国产剧,港台剧,欧美剧,韩剧,日剧,综艺,动漫,纪录片等免费在线观看,为北美及全球的华人提供海量高清影视视频,打造免费、无广告的在线影视播放平台']);
$this->title = LOGONAME. '视频,'.LOGONAME.'TV,北美'.LOGONAME.'视频,北美影视网,北美华人视频网站,北美华人影视视频,北美华人海外在线观看';
$this->registerMetaTag(['name' => 'robots', 'content' => 'index,follow']);
$this->registerMetaTag(['name' => 'GOOGLEBOT', 'content' => 'index,follow']);
$this->registerMetaTag(['name' => 'Author', 'content' => PC_HOST_NAME]);

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
    };
</script>

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--    <meta name="keywords" content="视频,视频分享,视频搜索,视频播放,视频社区">-->
<!--    <meta name="description" content="分发，上传，社区一体的在线视频平台">-->
    <link rel="shortcut icon" type="image/x-icon" href="/images/newindex/logo-02.png">
    <link rel="icon" sizes="16x16 32x32 64x64" href="/images/newindex/logo_ico.ico">
    <link rel="icon" type="image/png" sizes="196x196" href="/images/newindex/logo-02.png">
    <link rel="icon" type="image/png" sizes="160x160" href="/images/newindex/logo-02.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/newindex/logo-02.png">
    <link rel="icon" type="image/png" sizes="64x64" href="/images/newindex/logo-02.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/newindex/logo-02.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/newindex/logo-02.png">
    <!--    http://img.guazitv.tv/LOGO.ico-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" >
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-R9BCW62LFW"></script>
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
    <?php if ($this->params['isIndex'] == "1") : ?>
        <script type="application/ld+json">{
      "@context":"http://schema.org",
      "@type":"ItemList",
      "itemListElement":[
        {
          "@type": "SiteNavigationElement",
          "position": 1,
          "name": "首页",
          "url":"http://guazitv.tv/"
        },
        {
          "@type": "SiteNavigationElement",
          "position": 2,
          "name": "电影",
          "url":"http://guazitv.tv/video/channel?channel_id=1"
        },
        {
          "@type": "SiteNavigationElement",
          "position": 3,
          "name": "连续剧",
          "url":"http://guazitv.tv/video/channel?channel_id=2"
        },
        {
          "@type": "SiteNavigationElement",
          "position": 4,
          "name": "动漫",
          "url":"http://guazitv.tv/video/channel?channel_id=4"
        },
        {
          "@type": "SiteNavigationElement",
          "position": 5,
          "name": "综艺",
          "url":"http://guazitv.tv/video/channel?channel_id=3"
        },
        {
          "@type": "SiteNavigationElement",
          "position": 6,
          "name": "纪录片",
          "url":"http://guazitv.tv/video/channel?channel_id=32"
        }
      ]
    }
    </script>
    <?php endif; ?>
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
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white classBody">

<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
