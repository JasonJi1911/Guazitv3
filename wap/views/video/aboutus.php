<?php
use yii\helpers\Url;

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = '瓜子TV|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv - guazitv.tv';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片']);

?>
<style>
    .h100{height:100%;}
    .logo-box{padding: 30px 0;}
    .logo-box img{margin: 0 auto;width: 60px;}
    .logo-box div{margin: 0 auto;line-height: 40px;}
    a.outer-div{display: block;}
    .company-box{width: 100%;height: 30px;position: absolute;bottom: 0;}
</style>
<div class="display-flex outer-div sms-title pink" >
    <a class="div-box position-r white-arrow" href="<?= Url::to(['/video/set'])?>">
        <img src="/images/video/icon-fh-1.png">
    </a>
    <div class="text-center title-width">关于我们</div>
    <div class="div-box position-r"></div>
</div>
<div class="text-center logo-box">
    <img src="/images/video/guazi.png" />
    <div class="fontW7 font12">瓜子TV</div>
</div>
<a class="outer-div" href="<?= Url::to(['/video/agreement'])?>">
    <span class="font14">软件许可及服务协议</span>
    <div class="display-flex fr h100" >
        <img class="user-arrow ml10"  src="/images/video/right_gray.png" />
    </div>
</a>
<div class="line" ></div>
<a class="outer-div" href="<?= Url::to(['/video/privacy'])?>">
    <span class="font14">隐私政策</span>
    <div class="display-flex fr h100">
        <img class="user-arrow ml10"  src="/images/video/right_gray.png" />
    </div>
</a>
<div class="line" ></div>
<div class="outer-div">
    <span class="font14">Email</span>
    <div class="display-flex fr h100">
        <div class="font14 color91"><?=$data['about'][2]['content']?></div>
    </div>
</div>
<div class="line" ></div>
<div class="outer-div">
    <span class="font14">客服电话</span>
    <div class="display-flex fr h100">
        <div class="font14 color91"><?=$data['about'][3]['content']?></div>
    </div>
</div>
<div class="line" ></div>
<div class="outer-div">
    <span class="font14">QQ</span>
    <div class="display-flex fr h100">
        <div class="font14 color91"><?=$data['about'][4]['content']?></div>
    </div>
</div>
<div class="line" ></div>
<div class="outer-div">
    <span class="font14">微信</span>
    <div class="display-flex fr h100">
        <div class="font14 color91"><?=$data['about'][5]['content']?></div>
    </div>
</div>
<div class="line" ></div>
<div class="colorB2 text-center company-box"><?=$data['company']?></div>
