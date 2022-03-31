<?php
use yii\helpers\Url;
?>
<ul>
    <li class="<?php if($tab == 'home') echo 'act'?>">
        <a href="<?= Url::to(['/video/index'])?>">
            <div class="bottom-imgdiv bottom-img-index"></div>
            <div class="bottom-textdiv">首页</div>
        </a>
    </li>
    <li>
        <div class="bottom-imgdiv bottom-img-category"></div>
        <div class="bottom-textdiv">影视分类</div>
    </li>
    <li style="position: relative;">
        <div class="bottom-img-news"></div>
        <div class="bottom-textdiv" style="margin-top: 0.7rem;">新闻</div>
    </li>
    <li>
        <div class="bottom-imgdiv bottom-img-service"></div>
        <div class="bottom-textdiv">生活服务</div>
    </li>
    <li class="<?php if($tab == 'user') echo 'act'?>">
        <a href="<?= Url::to(['/video/personal'])?>">
            <div class="bottom-imgdiv bottom-img-user"></div>
            <div class="bottom-textdiv">我的</div>
        </a>
    </li>
</ul>
<script src="/js/video/jquery.min.1.11.1.js"></script>
<script>
    $(function (){
        $(".bottom-navi ul li").click(function(){
            $(this).addClass("act").siblings().removeClass("act");
        });
    });
</script>
