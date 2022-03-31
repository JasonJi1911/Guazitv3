<?php
use yii\helpers\Url;

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = '瓜子TV|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv - guazitv.tv';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片']);

?>
<style>
    body{background-color:#F1F5F8;font-family: PingFangSC;}
    .user-title{height:3rem;background-color: #FFFFFF;padding:0.75rem 15px;display: flex;align-items: center;flex-direction: row;}
    .user-title img.user-avatar{width: 1.5rem;height:1.5rem;}
    .user-title div{width: calc(100% - 1.5rem - 36px);height:1.5rem;line-height: 1.5rem;margin-left: 15px;font-size: 21px;font-weight: bold;color: #1E1E1E;}
    .user-list{width: calc(100% - 30px);height: 4rem;font-size: 15px;background-color: #FFFFFF;font-weight: bold;color: #282828;margin: 15px;}
    .user-list .line{width: calc(100% - 47px);margin-left: 47px;height: 1px;background: #EFEFEF;}
    .user-list .user-detail{width: 100%;height: 1rem;line-height: 1rem;display: flex;align-items: center;flex-direction: row;}
    .user-list .user-detail img{margin:0 15px;}
    .user-list .user-detail div{width: calc(100% - 84px);}
    .user-list .user-detail img:first-of-type{width: 17px;height:17px;}
    .user-list .user-detail img:last-of-type{width: 6px;height:10px;}
</style>
<!-- 未登录 -->
<a href="<?= Url::to(['/video/login'])?>" class="user-title" style="<?=$data['notlogin_show']?>" >
    <img class="user-avatar" src="/images/video/touxiang.png" />
    <div>登录 / 注册</div>
</a>
<!-- 登录 -->
<a href="<?= Url::to(['/video/user'])?>" class="user-title" style="<?=$data['login_show']?>" >
    <img class="user-avatar" src="<?=$data['user']['avatar']?>" onerror="this.src='/images/video/touxiang.png'" />
    <div><?=$data['user']['nickname']?></div>
    <img class="user-arrow" src="/images/video/right_gray.png" />
</a>

<div class="user-list" >
    <a class="user-detail" href="<?= Url::to(['/video/watch-log'])?>" >
        <img src="/images/video/watchlog.png" />
        <div>观看记录</div>
        <img src="/images/video/right_gray.png" />
    </a>
    <div class="line" ></div>
    <a class="user-detail" href="<?= Url::to(['/video/my-comment'])?>" >
        <img src="/images/video/comment_r.png" />
        <div>我的评论</div>
        <img src="/images/video/right_gray.png" />
    </a>
    <div class="line" ></div>
    <a class="user-detail" href="<?= Url::to(['/video/favorite'])?>" >
        <img src="/images/video/favorite_rr.png" />
        <div>我的收藏</div>
        <img src="/images/video/right_gray.png" />
    </a>
    <div class="line" ></div>
    <a class="user-detail" href="<?= Url::to(['/video/cooperation'])?>" >
        <img src="/images/video/cooperation.png" />
        <div>商务合作</div>
        <img src="/images/video/right_gray.png" />
    </a>
</div>

<div class="user-list" style="height:1rem;" >
    <a class="user-detail" href="<?= Url::to(['/video/set'])?>">
        <img src="/images/video/set.png" />
        <div>设置</div>
        <img src="/images/video/right_gray.png" />
    </a>
</div>

<!--底部导航-->
<div class="bottom-navi">
    <?php echo $this->render('/video/bottom',[
        'tab' =>   'user'
    ]);?>
</div>
<script src="/js/video/jquery.min.1.11.1.js"></script>
<script src="/js/video/searchHistory.js"></script>
