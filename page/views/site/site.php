<?php
use yii\helpers\Html;
$title = Yii::$app->setting->get('system.site_name');
?>
<html>
<head>
    <?= Html::csrfMetaTags() ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="icon" href="/youtiao/favicon.ico" type="image/x-icon" id="page_favionc">
    <title><?= $title?></title>
    <!-- Theme stylesheet -->
    <link href="/css/site/style.css" rel="stylesheet" type="text/css">
    <link href="/css/site/responsive.css" rel="stylesheet" type="text/css">
    <!-- Roboto Font stylesheet -->
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700" rel="stylesheet" type="text/css">
    <!-- FontAwesome stylesheet -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- LayerSlider stylesheet -->
    <link rel="stylesheet" href="/css/site/layerslider.css" type="text/css">

    <link href="/css/site/lightbox.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="layerslider/skins/v5/skin.css" type="text/css"> -->
</head>
<body>
<style type="text/css">
    .embed-container .embed-container-l p{
        line-height: 30px;
        font-family: 'PingFang SC', 'NotoSansHans-Regular', 'AvenirNext-Regular', "proxima-nova", "Hiragino Sans GB", "Source Han Sans", "WenQuanYi Micro Hei", "Open Sans", "Helvetica Neue", Arial, sans-serif !important;
        text-indent: 30px;
        font-size: 18px;
    }
    .embed-container-l {
        margin-top:40px;
        width: 60%;
        float: left;
        padding: 0 5%;
    }

    .embed-container-r {
        width: 30%;
        float: left;
    }

    .embed-container-r img{
        width: 260px;
        margin-top: -20px;
    }

    .separator30 {
        height:30px;
    }
    #navigationWrap {
        margin:40px 0;
    }
</style>
<!--BEGIN TOP CONTAINER (slider&nav)-->
<section id="topContainer" style="position: absolute;">
    <div id="navigationWrap">
        <div class="row">
            <!--            <div class="three-col"><img src="/images/site/logo.png?v=1" alt="Delicious Mint" style="width: 100px;height: 100px;border-radius:25px;"></div>-->
            <div class="clear"></div>
        </div>
    </div>

    <!-- BEGIN SLIDER -->
    <div id="sliderWraper" class="row">
        <div id="layerslider" style="width: 1170px; max-width: 1170px; height: 690px; visibility: visible;" class="ls-container ls-v5">
            <!-- first slide -->
            <div class="ls-inner" style="background-color: transparent; width: 1170px; height: 690px; text-align: center"><div class="ls-slide ls-animating" style="width: 1170px; height: 690px; visibility: visible; display: none; left: auto; right: 0px; top: 0px; bottom: auto;"><div class="ls-gpuhack" style="width: auto; height: auto; padding: 0px; border-width: 0px; left: 0px; top: 0px;"></div>

                    <p class="ls-l sliderText slogan" style="top: 50px; text-align:center;left: 380px; width: auto; height: auto; font-size: 70px; padding: 0px; border-width: 0px; margin-left: 0px; margin-top: 0px; transform-origin: 50% 50% 0px; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, -0.002, 0, 0, 0, 1); opacity: 1; visibility: visible;" data-ls="offsetxin: 0; offsetxout : 0; offsetyin: 50; durationin: 2000;">
                        <span><?= $title?></span> <br><span style="font-size: 45px!important; line-height: 65px;">海量影片<span></span></span></p>
                    <!-- <span>Quality</span> &amp; Fresh<br>iPhone Wallpapers</p> -->

                    <a href="javascript:;" onclick="location.href='#'" class="buttonBig ls-l" style="top: 300px;text-align: center; left: 480px; width: auto; height: auto; font-size: 18px; padding: 18px 35px; border-width: 2px; margin-left: 0px; margin-top: 0px; transform-origin: 50% 50% 0px; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, -0.002, 0, 0, 0, 1); opacity: 1; visibility: visible;" data-ls="offsetxin: 0; offsetxout: 0; delayin: 300; offsetyin: 100; durationin: 2000;"><i style="font-size: 25px;" class="fa fa-apple"></i> 下载iOS版</a>


                </div></div>

            <div class="ls-loading-container" style="z-index: -1; display: none;"><div class="ls-loading-indicator"></div></div><div class="ls-shadow"></div></div>    </div>
    <!-- END SLIDER -->
    <div class="clear"></div>
</section>
<!--END TOP CONTAINER-->


<!--BEGIN CONTENT WRAPPER-->
<div id="contentWrapper" style="top: 912px;">
    <!--SCREENS CONTAINER-->
    <section id="screensContainer" class="section-80-130 whiteBgSection ">
        <img class="triangleTop" src="/images/site/tri-white-top.png" alt="">

        <h1 class="sectionTitle">百万影片</h1>
        <div class="titleSeparator"></div>
        <!--        <h3 class="sectionDescription">一目了然应用画面</h3>-->
        <div class="separator30"></div>

        <!--Screens images-->
        <div id="screensViewportWrap" class="row">
            <div id="screensLeftAr" class="screensArrows"><i class="fa fa-angle-left"></i></div>
            <div id="screensOfHide">
                <div id="screensWrapOuter" style="transform: translate(0px, 0px);">
                    <div id="screensWrap" class="shuffle" style="position: relative; height: 533px; transition: height 500ms ease-out;">

                        <div class="screen-item shuffle-item filtered" data-groups="[&quot;socialn&quot;, &quot;all&quot;]" style="position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 500ms ease-out, opacity 500ms ease-out;">
                            <a data-lightbox="screens1"><img src="/images/site/1125_2436_1.png?v=1" alt="SCREEN" class="screenImg"></a>
                            <!-- <span>Splash Screen</span> -->
                        </div>

                        <div class="screen-item shuffle-item filtered" data-groups="[&quot;media&quot;, &quot;all&quot;]" style="position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(297px, 0px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 500ms ease-out, opacity 500ms ease-out;">
                            <a data-lightbox="screens2"><img src="/images/site/1125_2436_2.png?v=2" alt="SCREEN" class="screenImg"></a>
                        </div>

                        <div class="screen-item shuffle-item filtered" data-groups="[&quot;socialn&quot;, &quot;all&quot;]" style="position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(594px, 0px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 500ms ease-out, opacity 500ms ease-out;">
                            <a  data-lightbox="screens3"><img src="/images/site/1125_2436_3.png?v=2" alt="SCREEN" class="screenImg"></a>
                        </div>

                        <div class="screen-item shuffle-item filtered" data-groups="[&quot;socialn&quot;, &quot;all&quot;]" style="position: absolute; top: 0px; left: 0px; opacity: 1; transform: translate3d(891px, 0px, 0px) scale3d(1, 1, 1); visibility: visible; transition: transform 500ms ease-out, opacity 500ms ease-out;">
                            <a data-lightbox="screens4"><img src="/images/site/1125_2436_4.png?v=3" alt="SCREEN" class="screenImg"></a>
                        </div>

                    </div>
                </div>
            </div>
            <div id="screensRightAr" class="screensArrows screensArrowsActive"><i class="fa fa-angle-right"></i></div>
        </div>
    </section>
    <!--END SCREENS WRAPPER-->

    <!--BEGIN DEMO WRAPPER-->
    <!--END DEMO WRAPPER-->

    <!--BEGIN FOOTER WRAPPER-->
    <section id="footerContainer" class="section-160-30 footer grayBgSection">
        <div class="separator30"></div>

        <div class="separator80"></div>
        <p>Copyright © <?= date('Y')?> <?= $title?>  All Rights Reserved. </p>

    </section>
    <!--END FOOTER WRAPPER-->

</div>
<!--END CONTENT WRAPPER-->

<!-- jQuery & GreenSock -->
<script src="/js/site/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="/js/site/greensock.js" type="text/javascript"></script>

<!-- LayerSlider script files -->
<script src="/js/site/layerslider.transitions.js" type="text/javascript"></script>
<script src="/js/site/layerslider.kreaturamedia.jquery.js" type="text/javascript"></script>

<!-- Lightbox -->
<script src="/js/site/lightbox.min.js"></script>

<!-- Shuffle.js (screens) -->
<script src="/js/site/jquery.shuffle.modernizr.js"></script>

<!-- Theme JS -->
<script src="/js/site/delicioustheme.js" type="text/javascript"></script>
<script>

    var slogan_width = $('.slogan').innerWidth();
    var buttonBig_width = $('.buttonBig').innerWidth();
    var screen_width = $('.ls-gpuhack').innerWidth();

    var width_d1 = (screen_width - slogan_width) / 2;
    var width_d2 = (screen_width - buttonBig_width) / 2;

    $('.slogan').css('left', width_d1)
    $('.buttonBig').css('left', width_d2)

</script>
</body>
</html>
