<?php

/* @var $this \yii\web\View */
/* @var $content string */

use pc\assets\AppAsset;
use yii\helpers\Html;

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
    <link rel="shortcut icon" type="image/x-icon" href="http://img.guazitv.tv/LOGO.ico">
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
