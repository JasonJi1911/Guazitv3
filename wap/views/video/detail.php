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
    
    $("#my-iframe").load(function (){
        var interval = setInterval(showalert, 1000); 
        function showalert() 
        {
            var time = $("#my-iframe").contents().find(".yzmplayer-ptime").text();
            var dTime = $("#my-iframe").contents().find('.yzmplayer-dtime').text();

            if (time == "" || dTime == ""  
                || time == undefined || dTime == undefined 
                || dTime == "00:00" || dTime == "0:00" || dTime == "0:0")
                return ;
            
            var videoId = $('.switch-next.on').attr('data-video-id');
            var chapterId = $('#next_chapter').val();
            if(chapterId == 0)
            {
                clearInterval(interval);
                return;
            }
            
            var sourceId = $('.on .next-source').attr('data-source-id');
            var intStime = parseInt(time.split(':')[0] * 60) + parseInt(time.split(':')[1]);
            var intDtime = parseInt(dTime.split(':')[0] * 60) + parseInt(dTime.split(':')[1]);
            if(dTime.split(':').length == 3)
            {
               intStime = parseInt(time.split(':')[0] * 3600) + parseInt(time.split(':')[1] * 60) + parseInt(time.split(':')[2]); 
               intDtime = parseInt(dTime.split(':')[0] * 3600) + parseInt(dTime.split(':')[1] * 60) + parseInt(dTime.split(':')[2]); 
            }

             if ((intStime+10) >= intDtime)
             {
                 window.location.href = "/video/detail?video_id="+videoId+"&chapter_id="+chapterId+"&source_id="+sourceId;
                 clearInterval(interval);
             }
        }
    });
    
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
                        <?php if(!empty($info['advert'])) :?>
                            <?php foreach ($info['advert'] as $key => $advert) : ?>
                                <?php if(!empty($advert) && $advert['position_id'] == AdvertPosition::POSITION_PLAY_BEFORE) :?>
                                    <!--<?php if(strpos($advert['ad_image'], '.mp4') !== false) :?>-->
                                        <!--<div id="easiBox" class="">-->
                                        <!--    <video id="easi" style="width: 100%; height: 100%;" playsinline webkit-playsinline autoplay>-->
                                        <!--        <source src="<?= $advert['ad_image']?>" type="video/mp4">-->
                                        <!--    </video>-->
                                        <!--    <div class="c-videoplay" id="btn-video-play">-->
                                        <!--        <i class="c-player-icon c-player-big"></i>-->
                                        <!--    </div>-->
                                        <!--    <a class="btn-add-play" href="<?= $advert['ad_skip_url']?>" target="_blank">-->
                                        <!--        了解详情-->
                                        <!--        <i class="ad-arrow-wrapper ad-arrow"></i>-->
                                        <!--    </a>-->
                                            <!--<div style="">-->
                                            <!--    <div class="handle-ad">-->
                                            <!--        <span class="player-fullscreen" style="">-->
                                            <!--            <i class="c-player-icon c-player-fullscreen"></i>-->
                                            <!--        </span>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                        <!--</div>-->
                                    <!--<?php else:?>-->
                                        <!--<div class="video-play-left-cover" id="easiImgBox">-->
                                        <!--    <a id="imgad" href="<?= $advert['ad_skip_url']?>" target="_blank" class="">-->
                                        <!--        <img src="<?= $advert['ad_image']?>"-->
                                        <!--             onerror="this.src='/images/video/default-cover-ver.png'"-->
                                        <!--             id="video-cover" class="video-play-btn-iframe"-->
                                        <!--             style="width: 100%; height: 100%;">-->
                                        <!--    </a>-->
                                        <!--</div>-->
                                        <div id="easiImgBox" style="height: 100%" class="add-box">
                                            <!--<div style="text-align: center;line-height: 30px;width: 180px;background: rgb(51, 51, 51);position: absolute;right: 10px;opacity: 0.8;z-index: 999;margin-top: 10px;border-radius: 30px;">-->
                                            <!--    <div style="border-bottom: 1px solid #888;font-size:10px;line-height:28px;">-->
                                                    <!--<a href="<?= $advert['ad_skip_url']?>" target="_blank" style="color:#fff;">视频加载中，-->
                                                        <!--<span id="timer1" style="color:#FF556E"></span> 秒后开始播放-->
                                                    <!--</a>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <a href="<?= $advert['ad_skip_url']?>" target="_blank" class="btn-add-detail ad_url_link">
                                                点击查看广告详情
                                                <i class="ad-arrow-wrapper ad-arrow"></i>
                                            </a>
                                            <a href="<?= $advert['ad_skip_url']?>" target="_blank" class="ad_url_link">
                                            <div id="imgad" href="<?= $advert['ad_skip_url']?>" target="_blank" class="video-play-left-cover ad_url_link">
                                                <img src=""
                                                     onerror="this.src='/images/video/load.gif'"
                                                     id="video-cover" class="video-play-btn-iframe"
                                                     style="width: 100%; height: 100%;">
                                            </div>
                                            </a>
                                            <a class="btn-add-play" href="javascript:void(0);" id="hide-add">
                                                <span id="timer1" style="color:#FF556E;margin-right: 10px;">10</span>
                                                跳过广告
                                                <i class="ad-arrow-wrapper ad-arrow"></i>
                                            </a>
                                        </div>
                                    <!--<?php endif;?>-->
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php endif;?>
                        <iframe name="my-iframe" id="my-iframe" src="<?= $info['info']['resource_url']?>" allowfullscreen="true" allowtransparency="true" frameborder="0" scrolling="no"  width="100%" height="100%" scrolling="no" style="height: 3.8rem"></iframe>
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
<div class="video-add-column">
    <?php foreach ($info['advert'] as $key => $value): ?>
        <?php if($key == 2) : ?>
            <a href="<?= $value['ad_skip_url']?>">
                <img src="<?= $value['ad_image']?>" alt="">
            </a>
        <?php endif;?>
    <?php endforeach;?>
</div>
<div class="video-detail-series">
    <div class="clearfix video-detail-series-top">
        <span class="fl">剧集</span>
        <span class="fr video-detail-series-btn"><?= count($info['info']['videos']) != $info['info']['episode_num'] ? '更新至' . count($info['info']['videos']) . '集' : count($info['info']['videos']) . '集完'?></span>
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
                            <img src="<?= $list['cover']?>" alt="">
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

<!--<div class="video-other-more clearfix">-->
<!--    <a href="" class="fl more-item ">-->
<!--        <span>查看更多</span>-->
<!--    </a>-->
<!--    <a href="javascript:;" class="fl more-item  more-change">-->
<!--        <span class="change">换一换</span>-->
<!--    </a>-->
<!--</div>-->

<div class="video-index-notice">
     <p style="padding-bottom: 5px;text-align: center;">
        <a class="browser browser1" href="<?= Url::to(['map'])?>">网站地图</a>
        <a class="browser browser1" href="http://m.guazitv.tv">手机端</a>
        <a class="browser browser1" href="http://www.guazitv.tv">电脑端</a>
        <a class="browser" href="<?= Url::to(['site/share-down'])?>">APP下载</a></p>
    <p>本网站为非赢利性站点，所有内容均由机器人采集于互联网，或者网友上传，本站只提供WEB页面服务，本站不存储、不制作任何视频，不承担任何由于内容的合法性及健康性所引起的争议和法律责任。若本站收录内容侵犯了您的权益，请附说明联系邮箱，本站将第一时间处理。站长邮箱：guazitv@163.com</p>
</div>
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
<script>

    let timer = null;
    $(document).ready(function(){
        
        refreshAds();
        // $('#btn-video-play').trigger("click");
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
                            setTimeout("document.getElementById('easiImgBox').style.display='none'",30000);
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
</script>