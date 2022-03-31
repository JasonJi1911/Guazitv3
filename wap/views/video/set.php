<?php
use yii\helpers\Url;

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = '瓜子TV|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv - guazitv.tv';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片']);

$js = <<<JS
$(function (){
    $('#logout').click(function(){
        $.get('/site/logout', {}, function(res) {
            if(res.errno==0){
                removeuser();
                window.location.href='/video/personal';
            }
        });
    });
});
JS;

$this->registerJs($js);
?>

<style>
    body{background-color:#F1F5F8;font-family: PingFangSC;}
    a.outer-div{display: block;}
    #logout{position: absolute;width: calc(100% - 30px);height: 1rem;line-height: 1rem;left: 15px;bottom: 10px;background-color: #FFFFFF;border-radius: 10px;}
</style>
<div class="display-flex outer-div sms-title pink" >
    <a class="div-box position-r white-arrow" href="<?= Url::to(['/video/personal'])?>">
        <img src="/images/video/icon-fh-1.png">
    </a>
    <div class="text-center title-width">设置</div>
    <div class="div-box position-r"></div>
</div>

<a class="outer-div" href="<?= Url::to(['/video/aboutus'])?>" >
    <span class="font14">关于我们</span>
    <div class="display-flex fr" style="height: 100%;">
        <img class="user-arrow ml10"  src="/images/video/right_gray.png" />
    </div>
</a>
<button id="logout" class="fontW7 font14" style="<?=$data['login_show']?>" >退出登录</button>
<script src="/js/video/jquery.min.1.11.1.js"></script>
<script src="/js/video/searchHistory.js"></script>
