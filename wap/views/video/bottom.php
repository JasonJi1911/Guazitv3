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
    <li class="<?php if($tab == 'category') echo 'act'?>">
        <a href="<?= Url::to(['/video/listall'])?>">
            <div class="bottom-imgdiv bottom-img-category"></div>
            <div class="bottom-textdiv">分类</div>
        </a>
    </li>
<!--    <li style="position: relative;">-->
<!--        <div class="bottom-img-news"></div>-->
<!--        <div class="bottom-textdiv" style="margin-top: 0.7rem;">新闻</div>-->
<!--    </li>-->
    <li class="<?php if($tab == 'favorite') echo 'act'?>">
        <a href="<?= Url::to(['/video/favorite','bottom'=>'bottom'])?>">
            <div class="bottom-imgdiv bottom-img-service"></div>
            <div class="bottom-textdiv">收藏</div>
        </a>
    </li>
    <li class="<?php if($tab == 'watchlog') echo 'act'?>">
        <a href="<?= Url::to(['/video/watch-log','bottom'=>'bottom'])?>">
            <div class="bottom-imgdiv bottom-img-watchlog"></div>
            <div class="bottom-textdiv">记录</div>
        </a>
    </li>
    <li class="<?php if($tab == 'user') echo 'act'?>">
        <a href="<?= Url::to(['/video/personal'])?>">
            <div class="bottom-imgdiv bottom-img-user"></div>
            <div class="bottom-textdiv">我的</div>
        </a>
    </li>
</ul>
