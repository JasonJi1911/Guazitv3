<?php
use yii\helpers\Url;

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = '瓜子TV|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv - guazitv.tv';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片']);

?>
<style>
    body{background-color:#F1F5F8;font-family: PingFangSC;}
    p{height: 30px;line-height: 30px;}
    .co-box1{margin: 30px 30px 0 30px;background-color: #FFFFFF;min-width: 250px;padding: 20px 0;border-radius:20px 20px 0px 0px;border-bottom: 1px dashed #FF556E;}
    .co-box2{margin: 0px 30px;background-color: #FFFFFF;min-width: 250px;padding: 20px 0;border-radius:0px 0px 20px 20px;}
    .co-box2 img{width: calc(100% - 120px);margin: 0 auto;}
    .co-box2 span{background-image: linear-gradient(to right, #FF556E , #FDB757);color: #FFFFFF;padding: 10px 30px;border-radius: 10px;line-height: 40px;}
    .left-top,.right-top,.left-bottom,.right-bottom{position: absolute;width: 10px;height: 10px;z-index: 1;background: #F1F5F8;}
    .left-top{left: -1px;top: -1px;border-radius:0px 0px 10px 0px;}
    .right-top{right: -1px;top: -1px;border-radius:0px 0px 0px 10px;}
    .left-bottom{left: -1px;bottom: -1px;border-radius:0px 10px 0px 0px;}
    .right-bottom{right: -1px;bottom: -1px;border-radius:10px 0px 0px 0px;}
</style>
<div class="display-flex outer-div sms-title pink" >
    <a class="div-box position-r white-arrow" href="<?= Url::to(['/video/personal'])?>">
        <img src="/images/video/icon-fh-1.png">
    </a>
    <div class="text-center title-width">商务合作</div>
    <div class="div-box position-r"></div>
</div>
<div class="co-box1 text-center font16 fontW7 position-r">
    <p>我们将提供一流的、用心的服务</p>
    <p>期待与您的进一步沟通！</p>
    <div class="left-bottom"></div>
    <div class="right-bottom"></div>
</div>

<div class="co-box2 text-center font16 fontW7 position-r" >
    <p>站长邮箱：<?=$data['about'][2]['content']?></p>
    <img src="/images/video/collab_qr.png" />
    <span class="fontW4" >微信客服：<?=$data['about'][5]['content']?></span>
    <div class="left-top"></div>
    <div class="right-top"></div>
</div>
