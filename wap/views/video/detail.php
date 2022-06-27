<?php
use yii\helpers\Url;
use common\models\advert\AdvertPosition;

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = $info['info']['video_name'].'-瓜子TV|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv - guazitv.tv';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片']);

$js = <<<JS
$(function(){
    
    //实例化video对象
/*    setTimeout(function() {
      $('.go-back').hide();
    },5000);*/
    
    //弹出倍速框
    $('.video-source-btn-speed').click(function() {
        $('.pop-video-mask').show();
       $(".pop-video-mask").show();
       $(".video-pop-speed").css("bottom",0);
       $("body").addClass("body-mode");
    });
    
    //关闭遮罩
    $('.pop-video-mask').click(function() {
        colseMask();
    });
    
    //关闭遮罩抽离
    function colseMask() {
        $(".pop-mask").hide();
        $(".pop-intro").css("bottom","-100%");
        $("body").removeClass("body-mode");
        $(".pop-video-mask").hide();
    }
    
    //选中播放视频
    if($('#select-index').val() != 0) {
        $('.clearfix-overflow').scrollLeft(parseInt($('#select-index').val())*(parseInt($('.clearfix-overflow li').eq(0).css('width'))+15));
    }
    
    //返回首页
    $('.go-back').click(function() {
        window.location.href = '/';
    });
    
    //用户点击，切换剧集
    $('.switch-next').click(function() {
        
        $('.switch-next').removeClass('on');
        $(this).addClass('on');
        var videoId = $(this).attr('data-video-id');
        var chapterId = $(this).attr('data-chapter-id');
        
        window.location.href = '/video/detail?video_id=' + videoId + '&chapter_id=' + chapterId
        /*
        if(type == 1) {
            $(".clearfix-overflow li").eq($(this).parent().find('.on').index()-1).addClass('on');
            $(".sort-asc li").eq($(this).parent().find('.on').index()-1).addClass('on');
            $(".sort-desc li").eq((sum-$(this).parent().find('.on').index())).addClass('on')
        }else {
            $(".clearfix-overflow li").eq((sum-$(this).parent().find('.on').index())).addClass('on');
            $(".sort-asc li").eq((sum-$(this).parent().find('.on').index())).addClass('on');
            $(".sort-desc li").eq($(this).parent().find('.on').index()-1).addClass('on')
        }
        
        //改变所有视频来源的章节ID
        $('.next-source').each(function(i,n){
            $(n).attr('data-video-chapter-id', chapterId);
        });
        
        
        //关闭遮罩
        $(".pop-mask").hide();
        $(".pop-video-mask").hide();
        $(".pop-intro").css("bottom","-100%");
        $("body").removeClass("body-mode");
        
       $.get('/video/switch-video', {'video_id': videoId, 'chapter_id': chapterId, 'source_id': sourceId}, function(s) {
           if(s.data) {
               $('.piclist-link-ifram').css('display', 'block');
               $('#my-iframe').attr('src', s.data.info.resource_url);
           }
       }) */
    });
    
    //切换视频源
    $('.next-source').click(function() {
        var videoId = $(this).attr('data-video-id');
        var chapterId = $(this).attr('data-video-chapter-id');
        var sourceId = $(this).attr('data-source-id');
         window.location.href = "/video/detail?video_id="+videoId+"&chapter_id="+chapterId+"&source_id="+sourceId;
    });
    
//    $("#my-iframe").load(function (){
//        var interval = setInterval(showalert, 1000); 
//        function showalert() 
//        {
//            var time = $("#my-iframe").contents().find(".yzmplayer-ptime").text();
//            var dTime = $("#my-iframe").contents().find('.yzmplayer-dtime').text();
//
//            if (time == "" || dTime == ""  
//                || time == undefined || dTime == undefined 
//                || dTime == "00:00" || dTime == "0:00" || dTime == "0:0")
//                return ;
//            
//            var videoId = $('.switch-next.on').attr('data-video-id');
//            var chapterId = $('#next_chapter').val();
//            if(chapterId == 0)
//            {
//                clearInterval(interval);
//                return;
//            }
//            
//            var sourceId = $('.on .next-source').attr('data-source-id');
//            var intStime = parseInt(time.split(':')[0] * 60) + parseInt(time.split(':')[1]);
//            var intDtime = parseInt(dTime.split(':')[0] * 60) + parseInt(dTime.split(':')[1]);
//            if(dTime.split(':').length == 3)
//            {
//               intStime = parseInt(time.split(':')[0] * 3600) + parseInt(time.split(':')[1] * 60) + parseInt(time.split(':')[2]); 
//               intDtime = parseInt(dTime.split(':')[0] * 3600) + parseInt(dTime.split(':')[1] * 60) + parseInt(dTime.split(':')[2]); 
//            }
//
//             if ((intStime+10) >= intDtime)
//             {
//                 window.location.href = "/video/detail?video_id="+videoId+"&chapter_id="+chapterId+"&source_id="+sourceId;
//                 clearInterval(interval);
//             }
//        }
//    });
    
});
JS;

$this->registerJs($js);
?>

<style>
    .on {
        color: #FF556E;
    }

    .box{
        height: 100%;
    }
    
    .browser{
        padding: 0 10px;
        color: #8D8D95;
    }

    .browser1:after{
        content: '|';
        position: relative;
        left: 10px;
    }

    .browser:hover{
        color: #FF556E;
        border-right: #0c203a;
    }
    
    .video-play-left-cover {
        width: 100%;
        height: 100%;
        /*position: absolute;*/
        top: 0;
        left: 0;
        z-index: 99;
    }

    .video-play-left img {
        width: 100%;
        height: 100%;
    }
    
    .btn-add-play{
        z-index: 1000;
        display: block;
        top: 10px;
        right: 10px;
        width: 120px;
        line-height: 2.5;
        /* background-color: rgb(51, 51, 51); */
        position: absolute;
        font-size: 12px;
        border-radius: 15px;
        text-align: center;
        color: #fff;
        background: rgb(51, 51, 51);
        opacity: 0.8;
    }
    
    .btn-add-detail{
        z-index: 1000;
        display: block;
        bottom: 20px;
        right: 10px;
        width: 140px;
        line-height: 2.5;
        position: absolute;
        font-size: 12px;
        border-radius: 15px;
        text-align: center;
        color: #fff;
        background: rgb(51, 51, 51);
        opacity: 0.8;
    }
    
    .ad-arrow {
        display: inline-block;
        width: 6px;
        height: 6px;
        /*background: transparent;*/
        border-top: 1px solid #fff;
        border-right: 1px solid #fff;
        -webkit-transform: rotate(
            45deg
        );
        transform: rotate(
            45deg
        );
        margin: 0 2px;
        vertical-align: 1px;
    }
    
    .add-box a:hover{
        color: #FF556E;
    }
    
    .c-videoplay {
        z-index: 930;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        -o-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    
    .c-player-icon {
        width: 1.0rem;
        height: 1.0rem;
        font-size: 1rem;
        background-position: 0 0;
        background-image: url(/images/video/player-bg.png);
        background-size: 2rem 3rem;
        display: inline-block;
        background-repeat: no-repeat;
    }
    
    .handle-ad {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: .4rem;
        z-index: 940;
    }
    
    .handle-ad .player-fullscreen {
        right: .05rem;
    }
    
    .handle-ad .player-voice, .handle-ad .player-fullscreen {
        position: absolute;
        bottom: 15px;
    }
    
    .handle-ad .c-player-fullscreen {
        background-position: -40px -50px;
    }
    
    .handle-ad .c-player-icon {
        width: 40px;
        height: 40px;
        background-size: 100px 150px;
    }
    
    #timer1:after{
        content: '|';
        position: relative;
        left: 10px;
        color: #fff;
    }

    .height-auto{height: auto;}
</style>

<div class="video-box">
    <div class="video-title">
        <?= $info['info']['video_name']?>
        <span class="go-back"></span>
    </div>
    <div class="video-banner swiper-container swiper-container-video">
        <ul class="swiper-wrapper clearfix">
            <li class="swiper-slide">
                <div class="piclist-img" style="height: 3.8rem">
                    <input type="hidden" id="next_chapter" value="<?= $info['info']['next_chapter'] ?>">
                    <?php if($info['info']['resource_type'] == 1) :?>
                        <?php if(!empty($info['info']['horizontal_cover'])) :?>
                            <a href="javascript:void(0);" class="piclist-link" style="background-image:url(<?= $info['info']['horizontal_cover']?>);height: 3.8rem;z-index: 99"></a>
                            <!--                    <div class="video-play-btn">-->
                            <!--                        <div class="play-toggle-box">-->
                            <!--                            <div class="play-toggle">-->
                            <!--                            </div>-->
                            <!--                        </div>-->
                            <!--                    </div>-->
                        <?php endif;?>
                        <video id="play-video" class="video-js vjs-big-play-centered" controls data-setup="{}" style="height: 3.8rem" playsinline>
                            <?php if(substr($info['info']['resource_url'], strrpos($info['info']['resource_url'], ".") + 1) == 'm3u8') : ?>
                                <source id="source" src="<?= $info['info']['resource_url']?>" type="application/x-mpegURL">
                            <?php else:?>
                                <source id="source" src="<?= $info['info']['resource_url']?>">
                            <?php endif;?>
                        </video>
                    <?php else:?>
<!--                        <iframe name="my-iframe" id="my-iframe" src="--><?//= $info['info']['resource_url']?><!--" allowfullscreen="true" allowtransparency="true" frameborder="0" scrolling="no"  width="100%" height="100%" scrolling="no" style="height: 3.8rem"></iframe>-->
                        <?php foreach ($info['advert'] as $key => $advert) : ?>
                            <?php if(!empty($advert) && $advert['position_id'] == AdvertPosition::POSITION_PLAY_BEFORE_PC) :?>
                                <?php if(strpos($advert['ad_image'], '.mp4') !== false) {
                                    $ad_type = 'mp4';
                                    $ad_url = $advert['ad_image'];
                                    $ad_link = $advert['ad_skip_url'];
                                }else{
                                    $ad_type = 'img';
                                    $ad_url = $advert['ad_image'];
                                    $ad_link = $advert['ad_skip_url'];
                                }?>
                            <?php endif;?>
                        <?php endforeach;?>
                        <?php echo $this->render('/Dplayer/jianghu',[
                            'url'   =>      explode('v=',$info['info']['resource_url'])[1],
                            'ad_url' =>    $ad_url,
                            'ad_link'  =>   $ad_link,
                            'ad_type'  =>   $ad_type,
                            'videos'    =>  $info['info']['videos'],
                            'play_chapter_id'   => $info['info']['play_chapter_id'],
                            'source_id'         => $info['info']['source_id'],
                            'source'            =>  $info['info']['source']
                        ]);?>
                    <?php endif;?>
                </div>
            </li>
        </ul>
        <div class="swiper-pagination"></div>
        <!--        <a href="javascript:history.back(-1)" class="go-back"></a>-->
    </div>
</div>

<div class="video-detail-intro clearfix">
    <input type="hidden" value="<?= $source_id?>" id="video-source">
    <h1 class="fl video-name"><?= $info['info']['video_name']?></h1>
    <div class="fl video-source clearfix">
        <span class="fl">来源</span>
        <p class="fl video-source-btn">
            <?php foreach ($info['info']['source'] as $key => $value): ?>
                <?php if(empty($source_id) && $key == 0) : ?>
                    <img src="<?= $value['icon']?>" alt="">
                    <span class="source-name"><?= $value['name']?></span>
                <?php endif;?>
                <?php if($value['source_id'] == $source_id) : ?>
                    <img src="<?= $value['icon']?>" alt="">
                    <span class="source-name"><?= $value['name']?></span>
                <?php endif;?>
            <?php endforeach;?>
        </p>
    </div>
    <span class="fr video-intro-btn">简介</span>
</div>
<p class="video-detail-eval"><em class="fontArial"><?= $info['info']['score']?></em>/<?= $info['info']['category']?>/<?= $info['info']['area']?>/<?= $info['info']['year']?></p>
<div class="video-add-column video-top-ad">
    <a href="" target="_blank">
        <img src="" alt="">
    </a>
</div>
<div class="video-detail-series">
    <div class="clearfix video-detail-series-top">
        <span class="fl">剧集</span>
        <span class="fr video-detail-series-btn"><?=$info['info']['is_finished']!=1 ? '更新至' . count($info['info']['videos']) . '集' : count($info['info']['videos']) . '集完'?></span>
    </div>
    <input type="hidden" id="videos-sum" value="<?= count($info['info']['videos'])?>">
    <div class="video-detail-series-bottom swiper-container">
        <ul class="swiper-wrapper clearfix clearfix-overflow">
            <?php foreach ($info['info']['videos'] as $key => $video): ?>
                <?php if($video['chapter_id'] == $info['info']['play_chapter_id']) :?>
                    <?php if($key>2) : ?>
                        <input type="hidden" value="<?= $key?>" id="select-index">
                    <?php else:?>
                        <input type="hidden" value="0" id="select-index">
                    <?php endif;?>
                <?php endif;?>
                <li class="swiper-slide switch-next <?= $video['chapter_id'] == $info['info']['play_chapter_id'] ? 'on' : ''?>" data-video-id="<?= $video['video_id']?>" data-chapter-id="<?= $video['chapter_id']?>" data-type="1"><a href="javascript:void(0)"><?= $video['title']?></a></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<div class="h6F3 mt20"></div>
<!-- 猜你喜欢 -->
<div class="video-index-column mt20">
    <h3 class="video-index-title">猜你喜欢</h3>
    <dl class="video-list-box clearfix">
        <?php foreach ($info['guess_like'] as $key => $list): ?>
            <?php if($key < 6) :?>
                <dd>
                    <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                        <div class="video-item-top">
                            <img originalSrc="<?= $list['cover']?>" src="/images/default-cover.jpg">
                            <div class="mark-box">
                                <p class="mark"><?= $list['flag']?></p>
                            </div>
                        </div>
                        <h5 class="video-item-name"><?= $list['video_name']?></h5>
                        <p class="video-item-play"><?= $list['play_times']?></p>
                    </a>
                </dd>
            <?php endif;?>
        <?php endforeach;?>
    </dl>
</div>
<div class="video-add-column video-bottom-add">
    <a href="" target="_blank">
        <img src="" alt="">
    </a>
</div>
<!--<div class="video-other-more clearfix">-->
<!--    <a href="" class="fl more-item ">-->
<!--        <span>查看更多</span>-->
<!--    </a>-->
<!--    <a href="javascript:;" class="fl more-item  more-change">-->
<!--        <span class="change">换一换</span>-->
<!--    </a>-->
<!--</div>-->
<!-- 评论 -->
<?php if(!$info['comments']['list']){
    $comment_style = "display:none";
}else{
    $comment_style = "";
}?>
<div class="comment-part" id="comment-part">
    <div class="comment-title">
        <div style="<?=$comment_style?>">评论（<span><?= $info['commentcount']?></span>）</div>
    </div>
    <?php if($info['comments']['list']):?>
        <?php foreach ($info['comments']['list'] as $comment):?>
            <div class="comment-list">
                <ul>
                    <li class="comment-avatar" >
                        <?php if($comment['avatar']):?>
                            <img src="<?=$comment['avatar']?>" />
                        <?php else :?>
                            <img src="/images/video/touxiang.png" />
                        <?php endif;?>
                    </li>
                    <li class="comment-detail">
                        <div class="h05 color70 fontW4 mt5" ><?=$comment['nickname']?></div>
                        <div class="h05 color00 fontW4 mt5 height-auto" onclick="showreply(<?=$comment['comment_id']?>)" ><?=$comment['content']?></div>
                        <div id="commentid<?=$comment['comment_id']?>">
                            <?php if($comment['reply_info']['list']):?>
                                <input type="hidden" id="reply-current-<?=$comment['comment_id']?>" value="<?=$comment['reply_info']['current_page']?>" />
                                <input type="hidden" id="reply-total-<?=$comment['comment_id']?>" value="<?=$comment['reply_info']['total_page']?>" />
                                <div class="h05 color70 fontW4 comment-reply mt5" >
                                    <?php foreach ($comment['reply_info']['list'] as $key=>$reply):?>
                                        <div class="h04 height-auto"><?=$reply['nickname']?>：<?=$reply['content']?></div>
                                    <?php endforeach; ?>
                                    <?php if($comment['reply_info']['total_page']>1):?>
                                        <div class="h04 reply-more" onclick="replymore(<?=$comment['comment_id']?>,this)">
                                            查看更多回复>
                                        </div>
                                    <?php endif;?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="h05 color70 fontW4 mt5"><?=date("Y-m-d",$comment['created_at'])?></div>
                    </li>
                </ul>
            </div>
        <?php endforeach;?>

        <?php $current_page = 0; $total_page = 0;
        if($info['comments']['total_page']){
            $current_page = $info['comments']['current_page'];
            $total_page = $info['comments']['total_page'];
        }?>
        <div class="comment-more color70 fontW4" id="comment-more"
            <?php if($total_page==0 || $current_page==$total_page):?>
                style="display: none;"
            <?php endif;?>  >
            <input type="hidden" id="comment-current" value="<?=$current_page?>" />
            <input type="hidden" id="comment-total" value="<?=$total_page?>" />
            查看更多评论
        </div>
    <?php endif;?>
    <div style="width:100%;height:1rem;"></div>
</div>
<div class="comment-bottom" >
    <div class="bottom-left">
        <span class="bottom-img left-img"></span>
        <span class="bottom-text">参与评论</span>
    </div>
    <div class="bottom-right <?=$info['info']['fav_status']==1? 'act' : ''?>" id="id_favors" >
        <span class="bottom-img right-img"></span>
        <span class="bottom-text">收藏</span>
    </div>
</div>
<div class="comment-shadow comment-edit"></div>
<div class="comment-description comment-edit" style="">
    <textarea class="font14" placeholder="优质友善的评论会被更多人认同哦" style=""></textarea>
    <input type="button" id="send_comment" value="发布" />
    <input type="hidden" id="reply-pid" value="" />
</div>


<!--<div class="video-index-notice">-->
<!--     <p style="padding-bottom: 5px;text-align: center;">-->
<!--        <a class="browser browser1" href="--><?//= Url::to(['map'])?><!--">网站地图</a>-->
<!--        <a class="browser browser1" href="--><?//=WAP_HOST_PATH?><!--">手机端</a>-->
<!--        <a class="browser " href="--><?//=PC_HOST_PATH?><!--">电脑端</a>-->

         <!--        <a class="browser" href="--><?//= Url::to(['site/share-down'])?><!--">APP下载</a>-->

<!--     </p>-->
<!--    <p>版权声明：如果来函说明本网站提供内容本人或法人版权所有。本网站在核实后，有权先行撤除，以保护版权拥有者的权益。-->
<!--        &nbsp; 邮箱地址： --><?//=EMAIL_NAME?>
<!--    </p>-->
<!--    <p style="text-align:center;">Copyright 2020-2021 --><?//=PC_HOST_NAME?><!-- Allrights Reserved.</p>-->
<!--</div>-->
<!--<div class="video-footer">
    <ul class="clearfix footer-top">
        <li><a href="#">关于我们</a></li>
        <li><a href="#">常见问题</a></li>
        <li><a href="#">免责声明</a></li>
    </ul>
    <p class="footer-bottom">Copyright&copy;优酷 youku.com 版权所有</p>
</div>-->
<!-- 弹窗 -->
<div class="pop-mask"></div>
<!-- 视频播放弹窗 -->
<div class="pop-video-mask"></div>
<!-- 简介 -->
<div class="pop-intro video-pop-speed">
    <div class="pop-title">
        <div class="clearfix clearfix-speed">
            <span class="fl title">选择倍速</span>
            <img src="/images/video/icon-gb.png" alt="" class="pop-close-btn fr">
        </div>
    </div>
    <div class="pop-content">
        <div class="pop-speed">
            <p class="pop-speed-li" data-type="0.5">0.5倍速</p>
            <p class="pop-speed-li speed-select" data-type="1">正常</p>
            <p class="pop-speed-li" data-type="1.5">1.5倍速</p>
            <p class="pop-speed-li" data-type="2">2.0倍速</p>
        </div>
    </div>
</div>
<!-- 简介 -->
<div class="pop-intro video-pop-intro">
    <div class="pop-title">
        <div class="clearfix">
            <span class="fl title"><?= $info['info']['video_name']?></span>
            <img src="/images/video/icon-gb.png" alt="" class="pop-close-btn fr">
        </div>
    </div>
    <div class="pop-content">
        <p class="video-detail-eval"><em class="fontArial"><?= $info['info']['score']?></em>/<?= $info['info']['category']?>/<?= $info['info']['area']?>/<?= $info['info']['year']?></p>
        <h3 class="pop-intro-title">简介</h3>
        <p class="pop-intro-detail">
            <?= $info['info']['intro']?>
        </p>
    </div>
</div>
<!-- 选集 -->
<div class="pop-intro video-pop-series">
    <div class="pop-title">
        <div class="clearfix">
            <span class="fl title">选集</span>
            <img src="/images/video/icon-gb.png" alt="" class="pop-close-btn fr ml20">
            <span class="pop-series-sort fr ml42">正序</span>
            <!-- <span class="pop-series-sort fr fsort">倒序</span> -->
        </div>
    </div>
    <div class="pop-content">
        <div class="video-detail-series-bottom pop-content-list">
            <ul class="clearfix sort-asc">
                <input type="hidden">
                <?php foreach ($info['info']['videos'] as $video): ?>
                    <li class="swiper-slide switch-next <?= $video['chapter_id'] == $info['info']['play_chapter_id'] ? 'on' : ''?>" data-video-id="<?= $video['video_id']?>" data-chapter-id="<?= $video['chapter_id']?>"  data-type="1"><a href="javascript:void(0)"><?= $video['title']?></a></li>
                <?php endforeach;?>
            </ul>
            <ul class="clearfix sort-desc">
                <input type="hidden">
                <?php foreach (array_reverse($info['info']['videos']) as $video): ?>
                    <li class="swiper-slide switch-next <?= $video['chapter_id'] == $info['info']['play_chapter_id'] ? 'on' : ''?>" data-video-id="<?= $video['video_id']?>" data-chapter-id="<?= $video['chapter_id']?>" data-type="2"><a href="javascript:void(0)"><?= $video['title']?></a></li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
<!-- 换源 -->
<div class="pop-intro video-pop-source">
    <div class="pop-title">
        <div class="clearfix">
            <span class="fl title">换源</span>
            <img src="/images/video/icon-gb.png" alt="" class="pop-close-btn fr">
        </div>
    </div>
    <div class="pop-content">
        <div class="video-detail-series-bottom  pop-content-list">
            <ul class="clearfix">
                <?php foreach ($info['info']['source'] as $key => $source): ?>
                    <li class="swiper-slide <?= (empty($source_id) && $key == 0) ? 'on' : ''?> <?= $source['source_id'] == $source_id ? 'on' : ''?>">
                         <span class="next-source" data-video-id="<?= $info['info']['video_id']?>" data-video-chapter-id="<?= $info['info']['play_chapter_id']?>" data-source-id="<?= $source['source_id']?>" style="display: block;color: #27272A;font-size: 14px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                            <?= $source['name']?>
                         </span>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
<script src="/js/video/jquery.min.1.11.1.js"></script>
<script src="/js/video/swiper.min.js"></script>
<script src="/js/video/video.js?v=1.0"></script>
<script src="/js/video/searchHistory.js"></script>
<script>
    let timer = null;
    $(document).ready(function(){
        // refreshAds();
        // $('#btn-video-play').trigger("click");
        getAD();
    });
    
    function countDown(maxtime,fn){
        timer = setInterval(function() { 
            if(!!maxtime ){  
                seconds = Math.floor(maxtime%60), 
                msg = seconds;  
                fn( msg ); 
                --maxtime;  
            } else {  
                clearInterval(timer ); 
                msg="0";
                fn(msg);
            }  
        },1000); 
    }
    
    $("#hide-add").click(function(){
        if(document.getElementById('easiImgBox'))
            document.getElementById('easiImgBox').style.display='none'; 
        
        if(document.getElementById('easiBox'))
        {
            var elevideo = document.getElementById("easi");
            elevideo.pause()
            document.getElementById('easiBox').style.display='none'; 
        }
    });

    
    function refreshAds()
    {
        var arrIndex = {};

        arrIndex['page'] = "detail";
        var advertKey = 0;
        $.get('/video/advert', arrIndex, function(res) {
            if(!res.data.hasOwnProperty("advert"))
                return false;
                
            for (var prop in res.data.advert) {
                console.log("obj." + prop + " = " + res.data.advert[prop]);
                var adddata = res.data.advert[prop];
                if (adddata.hasOwnProperty("position_id")) {
                    if (prop == "videotop") {
                        $(".video-top-ad").attr("href", adddata.ad_skip_url);
                        $(".video-top-ad img").attr("src", adddata.ad_image);
                    }
                    else if (prop == "videobottom") {
                        $(".video-bottom-add").attr("href", adddata.ad_skip_url);
                        $(".video-bottom-add img").attr("src", adddata.ad_image);
                    }
                    else if (prop == "playbefore") {
                        $(".add-box .ad_url_link").attr("href", adddata.ad_skip_url);
                        if (adddata.ad_image.indexOf(".mp4") != -1)
                        {
                            setTimeout("document.getElementById('easiBox').style.display='none'",9000);
                        }
                        else
                        {
                            // $("#easiBox").remove();
                            $(".add-box img").attr("src", adddata.ad_image);
                            setTimeout("document.getElementById('easiImgBox').style.display='none'",15000);
                            countPicAds();
                        }
                    }
                }
            }
        })
    }
    
    function countPicAds()
    {
        if($('.piclist-img #easiImgBox').length > 0)
        {
            //8s后关闭广告图
            document.getElementById('timer1').innerHTML = 8;
            countDown(7, function(msg) { 
                if(msg == '0'){
                    document.getElementById('easiImgBox').style.display='none'; 
                }
                document.getElementById('timer1').innerHTML = msg; 
            });
        }
    }

    //收藏
    var favor_tab = true;
    $("#id_favors").click(function(){
        var uid = finduser();
        if(!isNaN(uid) && uid!=""){
            if(favor_tab){
                favor_tab = false;
                var that = this;
                var arrindex = {};
                arrindex['videoid'] = '<?=$info['info']['play_video_id']?>';
                $.get('/video/change-favorite',arrindex,function(res){
                    favor_tab = true;
                    if(res.errno==0){
                        $(that).toggleClass("act");
                    }
                });
            }
        }else{//登录
            window.location.href = "/video/login";
        }
    });
    //更多回复
    var more_flag = true;
    function replymore(pid,that){
        if(more_flag){
            more_flag = false;
            var page_num = ($("#reply-current-"+pid).val()!="")?parseInt($("#reply-current-"+pid).val()):0;
            var total = ($("#reply-total-"+pid).val()!="")?parseInt($("#reply-total-"+pid).val()):0;
            var ar = {};
            ar['pid'] = pid;
            ar['page_num'] = page_num
            $.ajax({
                url: '/video/reply-more',
                data: ar,
                type:'get',
                cache:false,
                dataType:'json',
                success:function(res) {
                    more_flag = true;
                    if(res.errno==0 && res.data.length>0){
                        var html = "";
                        var data = res.data;
                        for(var i=1;i<data.length;i++){
                            html += '<div class="h04 height-auto ">'+data[i]['nickname']+'：'+data[i]['content']+'</div>';
                        }
                        if(total == page_num+1){
                            $(that).hide();
                        }else{
                            $("#reply-current-"+pid).val(++page_num);
                        }
                        $(that).before(html);
                    }
                },
                error : function() {
                    more_flag = true;
                    console.log("加载失败");
                }
            });
        }
    }
    //显示评论
    $(".comment-bottom .bottom-left").click(function (){
        var uid = finduser();
        if(!isNaN(uid) && uid!=""){
            $(".comment-edit").show();
            $("#reply-pid").val(0);
        }else{//登录
            window.location.href = "/video/login";
        }
    });
    //关闭评论
    $(".comment-shadow").click(function (){
        $(".comment-description textarea").val("");
        $(".comment-edit").hide();
    });
    //查看更多评论
    $("#comment-more").click(function(){
        if(more_flag) {
            // more_flag = false;
            var page_num = ($("#comment-current").val() != "") ? parseInt($("#comment-current").val()) : 0;
            var total = ($("#comment-total").val() != "") ? parseInt($("#comment-total").val()) : 0;
            var ar = {};
            ar['video_id'] = '<?=$info['info']['play_video_id']?>';
            ar['chapter_id'] = '<?=$info['info']['play_chapter_id']?>';
            ar['page_num'] = page_num;
            $.ajax({
                url: '/video/comment-more',
                data: ar,
                type:'get',
                cache:false,
                success:function(res) {
                    more_flag = true;
                    $("#comment-more").before(res);//添加评论列表
                    if(total==0 || total == page_num+1){
                        $("#comment-more").hide();
                    }else{
                        $("#comment-more").show();
                        $("#comment-current").val(++page_num);
                    }
                },
                error : function() {
                    more_flag = true;
                    console.log("加载失败");
                }
            });
        }
    });
    //发送
    var iscommit = true;
    $("#send_comment").click(function(){
        if(iscommit){
            iscommit = false;
            var pid = $("#reply-pid").val();
            var ar = {};
            ar['video_id'] = '<?=$info['info']['play_video_id']?>';
            ar['chapter_id'] = '<?=$info['info']['play_chapter_id']?>';
            if(pid>0){
                ar['pid'] = pid;
            }else{
                ar['pid'] = 0;
            }
            var that = this;
            var content = $(this).siblings('textarea').val();
            ar['content'] = content;
            if(content==""){
                iscommit = true;
                $("#pop-tip").text("请填写评论");
                $("#pop-tip").show().delay(1500).fadeOut();
                return false;
            }else if(content.length>100){
                iscommit = true;
                $("#pop-tip").text("评论最多100字");
                $("#pop-tip").show().delay(1500).fadeOut();
                return false;
            }else{
                $.ajax({
                    url: '/video/send-comment',
                    data: ar,
                    type:'get',
                    cache:false,
                    dataType:'json',
                    success:function(res) {
                        iscommit = true;
                        $(".comment-description textarea").val("");
                        $(".comment-edit").hide();
                        if(res.errno==0){
                            if(res.data.display==1){
                                commentNum();//本剧集评论数
                                if(pid>0){
                                    replystr(pid,res.data.data);
                                }else{
                                    commentstr(res.data.data);
                                }
                                $("#pop-tip").text("评论成功");
                                $("#pop-tip").show().delay(1500).fadeOut();
                                $(that).siblings('textarea').val("");
                            }else{
                                $("#pop-tip").text(res.data.message);
                                $("#pop-tip").show().delay(1500).fadeOut();
                            }
                        }
                    },
                    error : function() {
                        iscommit = true;
                        console.log("评论/回复提交失败");
                    }
                });
            }
        }
    });
    //评论数
    function commentNum(){
        var value = $(".comment-title").find('span').html();
        var num = parseInt(value!='' ? value : 0 )+1;
        $(".comment-title").find('span').html(num);
    }
    //新评论
    function commentstr(data){
        var html = "";
        var avatarstr = "";
        if(data['avatar']!=""){
            avatarstr = '<img src="'+data['avatar']+'" />';
        }else{
            avatarstr = '<img src="/images/video/touxiang.png" />';
        }
        html = '<div class="comment-list">'+
                    '<ul>'+
                        '<li class="comment-avatar" >'+avatarstr+'</li>'+
                        '<li class="comment-detail">'+
                            '<div class="h05 color70 fontW4 mt5" >'+data['nickname']+'</div>'+
                            '<div class="h05 color00 fontW4 mt5 height-auto" onclick="showreply('+data['comment_id']+')" >'+data['content']+'</div>'+
                            '<div id="commentid'+data['comment_id']+'">'+
                            '<div class="h05 color70 fontW4 mt5">'+data['created_time']+'</div>'+
                        '</li>'+
                    '</ul>'+
                '</div>';
        $("#comment-part .comment-title").after(html);
        $("#comment-part .comment-title div").show();
    }
    //显示回复
    function showreply(pid){
        var uid = finduser();
        if(!isNaN(uid) && uid!=""){
            $(".comment-edit").show();
            $("#reply-pid").val(pid);
        }else{//登录
            window.location.href = "/video/login";
        }
    }
    //新回复
    function replystr(pid,data){
        // console.log($('#commentid'+pid).find('div.comment-reply'));
        var html = "";
        var str = '<div class="h04 height-auto">'+data['nickname']+'：'+data['content']+'</div>';
        if($('#commentid'+pid).find('div.comment-reply').length>0){
            //已有回复
            html = str;
            $('#commentid'+pid).find('div.comment-reply').eq(0).prepend(html);
        }else{//第一个回复
            html = '<div class="h05 color70 fontW4 comment-reply mt5">'+str+'</div>';
            $('#commentid'+pid).prepend(html);
        }

        // return html;
    }
    function getAD(){
        var req = new XMLHttpRequest();
        req.open('GET', '/images/video/icon-fh-1.png', false);
        req.send(null);
        var cf_ray = req.getResponseHeader('cf-Ray');//指定cf-Ray的值
        var cf_cache_status = req.getResponseHeader('cf-cache-status');//指定cf-cache-status的值
        var citycode = '';
        if(cf_cache_status == 'HIT'){
            citycode = cf_ray.substring(cf_ray.length-3);
        }else{
            req.open('GET', document.location, false);
            req.send(null);
            cf_ray = req.getResponseHeader('cf-Ray');//指定cf-Ray的值
            if(cf_ray && cf_ray.length>3){
                citycode = cf_ray.substring(cf_ray.length-3);
            }
        }
        // citycode = 'MEL';
        // console.log(citycode);
        var advert = {};
        advert['ad_type'] = '';
        advert['ad_url'] = '';
        advert['ad_link'] = '';
        $.ajax( {
            url:'/video/advert-info',
            data:{
                'citycode' : citycode,
                'page' : 'detail',
            },
            type:'get',
            cache:false,
            dataType:'json',
            success:function(res) {
                if(res.errno == 0){
                   var ad = {};
                    //猜你喜欢上方
                    if(res.data.advert.videotop.ad_image){
                        ad = res.data.advert.playliketop;
                        $(".video-top-ad a").attr("href", ad.ad_skip_url);
                        $(".video-top-ad img").attr("src", ad.ad_image);
                    }
                    //猜你喜欢下方
                    if(res.data.advert.videobottom.ad_image){
                        ad = res.data.advert.playlikebottom;
                        $(".video-bottom-add a").attr("href", ad.ad_skip_url);
                        $(".video-bottom-add img").attr("src", ad.ad_image);
                    }
                }
            },
            error : function() {
                console.log("加载广告失败");
            },
            complete:function(XHR,TextStatus){
                if(TextStatus=='timeout'){ //超时执行的程序
                    console.log("请求超时！");
                }
            }
        });
    }
</script>