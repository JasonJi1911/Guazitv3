<?php
use yii\helpers\Url;
use pc\assets\StyleInAsset;
use common\models\advert\AdvertPosition;

// $this->metaTags['keywords'] = '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片';
$this->registerMetaTag(['name' => 'keywords', 'content' => '吉祥tv,澳洲吉祥tv,新西兰吉祥tv,澳新吉祥tv,吉祥视频,吉祥影视,电影,电视剧,榜单,综艺,动画,记录片']);
// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = $data['info']['video_name'].'-吉祥TV - 澳新华人在线视频分享平台,海量高清视频在线观看';
StyleInAsset::register($this);

$js = <<<JS
$(function(){
    
    // var videoPath = $('#player1').data('src');
    // var videoImage = '';
    //
    // var dp = new DPlayer({
    //     element: document.getElementById('player1'),
    //     theme: '#FADFA3',
    //     loop: true,
    //     lang: 'zh-cn',
    //     hotkey: true,
    //     preload: 'auto',
    //     volume: 0.7,
    //     autoplay: true,
    //     playbackSpeed:[0.5, 0.75, 1, 1.25, 1.5, 2,2.5,3,5,7.5,10],
    //     video: {
    //         url: videoPath,
    //         pic: videoImage,
    //         type: 'hls'
    //     },
    // });
    
    $('.slider-for').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
      slidesToShow: 5,
      slidesToScroll: 1,
      asNavFor: '.slider-for',
      dots: false,
      arrows:true,
      focusOnSelect: true
    });
    var swiper = new Swiper('.swiper-container', {
         slidesPerView: 5,
         spaceBetween: 15,
         navigation: {
           nextEl: '.swiper-button-next',
           prevEl: '.swiper-button-prev',
         },      
    });	
        
    $('.qy-player-basic-intro').click(function(event) {
			$('.qy-player-intro-pop').slideToggle();
			$(this).toggleClass('selected');
    });
    $('.comment-c-itemwrap').hover(function() {
        $(this).find('.comment-ft-btn__dn').show();
    },function(){
        $(this).find('.comment-ft-btn__dn').hide();
    });
    $('.anchor-list').each(function(index, el) {
        $(this).hover(function() {
            $(this).find('.popBox').show();
        }, function() {
            $(this).find('.popBox').hide();
        });
    });
    $(window).scroll(function(event) {
        var _top = $(window).scrollTop();
        if(_top > 300){
            $('.anchor-list').last().show();
        }else{
            $('.anchor-list').last().hide();
        }
        if(_top > 900){
            $('.qy-comment-page .qycp-form-fixed ').show()
        }else{
            $('.qy-comment-page .qycp-form-fixed ').hide()
        }
    });
    $('.backToTop').click(function() {
        $('html,body').stop(true, false).animate({
            scrollTop: 0
        })
    });
    $('.comment-form').hover(function() {
        $(this).toggleClass('form__focused');
    });
    $('.comment-btn-fixed').click(function(event) {
        $('.qycp-form-fixed').addClass('show');
    });
    
    //点击播放
    //播放源
    $('.video-play-btn-source').click(function() {
        //隐藏封面
        $('.video-play-left-cover').hide();
        if(document.getElementById('picBox'))
            $("#picBox").hide();
        //实例化video对象
        var myVideo = videojs('play-video', {
            bigPlayButton: true,
            textTrackDisplay: false,
            posterImage: false,
            errorDisplay: false,
            playbackRates: [0.5,1,1.5,2]
        });
        myVideo.play();
        //dp.play();
    });
    
    //播放iframe
    $('.video-play-btn-iframe').click(function() {
        //隐藏封面
        $('.video-play-left-cover').hide();
        if(document.getElementById('picBox'))
            $("#picBox").hide();
        //dp.play();
    });
    
    
    //显示播放源
    $(".video-source").hover(function(){
        $('.video-source-list').css('display', 'block');
    },function(){
        $('.video-source-list').css('display', 'none');
    });
        
    //用户点击，切换剧集
    $('.switch-next').click(function() {
        $('.switch-next-li').removeClass('on');
        $(this).addClass('on');
        var videoId = $(this).attr('data-video-id');
        var chapterId = $(this).attr('data-chapter-id');
        var sourceId = $('.sourceTab .hover a').attr('data-source-id');
        var type = $(this).attr('data-type');
        
        window.location.href = '/video/detail?video_id=' + videoId + '&chapter_id=' + chapterId+"&source_id="+sourceId;
        // window.location.href = '/video/detail?video_id=' + videoId + '&chapter_id=' + chapterId;
    });
        
    //切换视频源
    $('.next-source').click(function() {
        var videoId = $(this).attr('data-video-id');
        var chapterId = $(this).attr('data-video-chapter-id');
        var sourceId = $(this).attr('data-source-id');
         window.location.href = "/video/detail?video_id="+videoId+"&chapter_id="+chapterId+"&source_id="+sourceId;
    });
    
    // $("#my-iframe").load(function (){
    //     var interval = setInterval(showalert, 1000); 
    //     function showalert() 
    //     {
    //         var time = $("#my-iframe").contents().find(".yzmplayer-ptime").text();
    //         var dTime = $("#my-iframe").contents().find('.yzmplayer-dtime').text();

    //         if (time == "" || dTime == ""  
    //             || time == undefined || dTime == undefined 
    //             || dTime == "00:00" || dTime == "0:00" || dTime == "0:0")
    //             return ;
            
    //         var videoId = $('.switch-next.selected').attr('data-video-id');
    //         var chapterId = $('#next_chapter').val();
    //         if(chapterId == 0)
    //         {
    //             clearInterval(interval);
    //             return;
    //         }
            
    //         var sourceId = $('.on .next-source').attr('data-source-id');
    //         var intStime = parseInt(time.split(':')[0] * 60) + parseInt(time.split(':')[1]);
    //         var intDtime = parseInt(dTime.split(':')[0] * 60) + parseInt(dTime.split(':')[1]);
    //         if(dTime.split(':').length == 3)
    //         {
    //           intStime = parseInt(time.split(':')[0] * 3600) + parseInt(time.split(':')[1] * 60) + parseInt(time.split(':')[2]); 
    //           intDtime = parseInt(dTime.split(':')[0] * 3600) + parseInt(dTime.split(':')[1] * 60) + parseInt(dTime.split(':')[2]); 
    //         }

    //          if ((intStime+10) >= intDtime)
    //          {
    //              window.location.href = "/video/detail?video_id="+videoId+"&chapter_id="+chapterId+"&source_id="+sourceId;
    //              clearInterval(interval);
    //          }
    //     }
    // });
    
    $('.func-swicthCap').click(function(){
        var videoId = $(this).attr('data-video-id');
        var chapterId = $(this).attr('data-chapter-id');
        // var sourceId = $('.sourceTab .hover a').attr('data-source-id');
        var sourceId = $(this).attr('data-source-id');;
        
        window.location.href = '/video/detail?video_id=' + videoId + '&chapter_id=' + chapterId+"&source_id="+sourceId;
    });
    
});
JS;

$this->registerJs($js);
?>

<?php
$channelName = '';
if(isset($channel_id))
{
    foreach ($channels['list'] as $s_k => $s_v) {
        if($s_v['channel_id'] == $channel_id) {
            $channelName = $s_v['channel_name'];
        }
    }
}
else
{
    $channelName = '热搜';
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <style>
        body{
            overflow-y: scroll !important;
            background-color: #F9F9F9 !important;
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

        .on .tag-item{
            color: rgb(255, 85, 110);
        }

        .box{
            height: 100%;
        }

        .video-play-btn-iframe {
            width:100%;
            height:100%;
        }

        .qy-mod-link div img
        {
            opacity: 1.0;
        }

        .qy-mod-link:hover div img
        {
            opacity: 0.8;
        }

        .rank-enter-link:hover
        {
            color: #ff4d8d;
        }

        .dn{
            display: block;
        }

        .nn{
            display: none;
        }

        .qy-player-basic-intro.selected .qy-svgicon-intro
        ,.qy-player-basic-intro.selected .basic-txt
        {
            color: rgb(255, 85, 110);
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
            width: 4.0rem;
            height: 4.0rem;
            font-size: 1rem;
            background-position: 0 0;
            background-image: url(/images/video/player-bg.png);
            background-size: 8rem 12rem;
            display: inline-block;
            background-repeat: no-repeat;
            cursor: pointer;
        }

        .btn-add-play{
            z-index: 1000;
            display: block;
            bottom: 60px;
            right: 10px;

            width: 80px;
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
            top: 40px;
            right: 10px;
            width: 160px;
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

        .wechat-block{
            width: 100%;
            height: 100%;
            position: absolute;
            /* top: 0; */
            /* left: 0; */
            z-index: 10000;
        }

        .qy-svgicon-rightarrow_cu::before {
            content: "\EAC2"
        }

        .qy-svgicon-rightarrow_xi::before {
            content: "\EAC3"
        }

        .qy-svgicon-leftarrow_cu::before {
            content: "\EAC4"
        }

        .qy-svgicon-leftarrow_xi::before {
            content: "\EAC5"
        }

        .pointer-none{
            cursor: not-allowed;
            opacity: 0.3;
        }
        .pointer-none .func-inner{
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
</head>
<body style="background-color:#fff;" class="qy-aura3 qy-advunder-show classBody">
<script src="/js/jquery.js"></script>
<script src="/js/VideoSearch.js"></script>
<div class="c"></div>
<div class="qy-play-top">
    <div class="play-top-flash">
        <div class="qy-play-container">
            <!--<a href="https://bit.ly/2ZeD8lq" target="_blank" class="">-->
            <!--    <img src="/images/NewVideo/yeeyi-banner.png" style="width:100%;">-->
            <!--</a>-->
            <?php if(!empty($data['advert'])) :?>
                <?php foreach ($data['advert'] as $key => $advert): ?>
                    <?php if(!empty($advert) && intval($advert['position_id']) == intval(AdvertPosition::POSITION_VIDEO_TOP_PC)) :?>
                        <a href="<?=$advert['ad_skip_url']?>" target="_blank" class="video-top-ad">
                            <img src="<?=$advert['ad_image']?>" style="width:100%;border-radius:10px;">
                        </a>
                    <?php endif;?>
                <?php endforeach;?>
            <?php endif;?>
            <div class="qy-player-wrap">
                <div class="player-mn">
                    <div class="player-mnc">
                        <div class="qy-flash-box">
                            <div class="flash-box">
                                <div class="iqp-player">
                                    <input type="hidden" id="next_chapter" value="<?= $data['info']['next_chapter'] ?>">
                                    <input type="hidden" id="last_chapter" value="<?= $data['info']['last_chapter'] ?>">
<!--                                    <div class="wechat-block" id='wechat-block'>-->
<!--                                        <img src="" class="video-play-btn-iframe wechat-url" onerror="this.src='/images/video/load.gif'">-->
<!--                                        <div class="wechat_tip" style="-->
<!--                                                position: absolute;-->
<!--                                                left: 62%;-->
<!--                                                top: 43%;-->
<!--                                                font-size: 55px;-->
<!--                                                font-weight: 1000;-->
<!--                                                color: #FF556E;">-->
<!---->
<!--                                        </div>-->
<!--                                    </div>-->
                                    <?php if($data['info']['resource_type'] == 1) :?>
                                        <div class="video-play-left-cover">
                                            <img src="<?= $data['info']['horizontal_cover'] ?>" alt=""
                                                 onerror="this.src='/images/video/default-cover-ver.png'"
                                                 id="video-cover" class="video-play-btn-source">
                                        </div>
                                        <video id="play-video" class="video-js vjs-big-play-centered" controls data-setup="{}">
                                            <?php if(substr($data['info']['resource_url'], strrpos($data['info']['resource_url'], ".") + 1) == 'm3u8') : ?>
                                                <source id="source" src="<?= $data['info']['resource_url']?>" type="application/x-mpegURL">
                                            <?php else:?>
                                                <source id="source" src="<?= $data['info']['resource_url']?>" >
                                            <?php endif;?>
                                        </video>
                                    <?php else:?>
                                        <input type="hidden" id="play_resource" value="<?= $data['info']['resource_url']?>" />
                                        <!--<iframe name="my-iframe" id="my-iframe" src=""-->
                                        <!--        allowfullscreen="true" allowtransparency="true"-->
                                        <!--        frameborder="0" scrolling="no" width="100%"-->
                                        <!--        height="100%" scrolling="no"></iframe>-->
                                        <?php foreach ($data['advert'] as $key => $advert) : ?>
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
                                        <?php echo $this->render('/MyPlayer/jianghu',[
                                            'url'   =>      explode('v=',$data['info']['resource_url'])[1],
                                            'ad_url' =>    $ad_url,
                                            'ad_link'  =>   $ad_link,
                                            'ad_type'  =>   $ad_type,
                                            'videos'    =>  $data['info']['videos'],
                                            'play_chapter_id'   => $data['info']['play_chapter_id'],
                                            'source_id'         => $data['info']['source_id'],
                                            'source'            => $data['info']['source'],
                                            'last_chapter'      => $data['info']['last_chapter'],
                                            'next_chapter'      => $data['info']['next_chapter']
                                        ]);?>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <div class="c"></div>
                        <div class="player-mnb">
                            <div class="player-mnb-left">
                                <div class="qy-flash-func qy-flash-func-v1">
                                    <div class="func-item func-comment">
                                        <div class="func-inner">
                                            <span class="func-name qy-comment J_comment"  onclick="window.location.href = '#GNbox-PL'" ><?=$data['commentcount']?></span>
                                        </div>
                                    </div>
                                    <div class="func-item func-like-v1">
                                        <div class="func-inner">
                                            <span class="func-name qy-dianzan"><?= $data['info']['total_views']?></span>
                                        </div>
                                    </div>
                                    <div class="func-item func-collect">
                                        <div class="func-inner">
                                            <span class="func-name qy-shoucang" id="id_favors"><?= $data['info']['total_favors']?></span>
                                        </div>
                                    </div>
<!--                                    <div class="func-item func-like-v1">-->
<!--                                        <div class="func-inner">-->
<!--                                            <span class="like-icon-box">-->
<!--                                                <i title="" class="qy-svgicon qy-svgicon-report"></i>-->
<!--                                            </span>-->
<!--                                            <span class="func-name" id='err_feedback'>片源报错</span>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                </div>
                            </div>
                            <div class="player-mnb-mid">
                                <div class="func-item func-like-v1">
                                    <div class="func-inner">
                                        <span class="func-name qy-shouji">手机看</span>
                                    </div>
                                </div>
                                <div class="func-item func-like-v1">
                                    <div class="func-inner">
                                        <a href="<?= Url::to(['/video/seek'])?>" target="_blank"><span class="func-name qy-qiupian">求片</span></a>
                                    </div>
                                </div>
                                <!--<?= json_encode($data['info']['test'], JSON_UNESCAPED_UNICODE) ?>-->
                            </div>
                            <!--<div class="player-mnb-right">
                                <div class="qy-flash-func qy-flash-func-v1">
                                    <div class="func-item <?/*= $data['info']['last_chapter'] == 0 ? 'pointer-none': ''*/?>">
                                        <div title="上一集" class="func-inner func-swicthCap"
                                             data-video-id="<?/*= $data['info']['video_id']*/?>"
                                             data-chapter-id="<?/*= $data['info']['last_chapter']*/?>"
                                             data-source-id="<?/*= $source_id*/?>">
                                            <span class="qy-svgicon qy-svgicon-leftarrow_cu"></span>
                                            <span class="func-name">上一集</span>
                                        </div>
                                    </div>
                                    <div class="func-item <?/*= $data['info']['next_chapter'] == 0 ? 'pointer-none': ''*/?>">
                                        <div title="下一集" class="func-inner func-swicthCap"
                                             data-video-id="<?/*= $data['info']['video_id']*/?>"
                                             data-chapter-id="<?/*= $data['info']['next_chapter']*/?>"
                                             data-source-id="<?/*= $source_id*/?>">
                                            <span class="func-name">下一集</span>
                                            <span class="qy-svgicon qy-svgicon-rightarrow_cu"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                        <div class="Altsjk">
                            <div class="Altsjk-01">
                                扫一扫，手机观看更便捷
                                <input class="GB" type="button" name="" id="" value="" />
                            </div>
                            <div class="Altsjk-02">
                                <img src="/images/newindex/ryewm_wap.png" />
                                <div class="Altsjk-02-a">
                                    <!--                    --><?//= Url::to(['/site/share-down'])?>
                                    <a href="javascript:void(0);" onclick="showwarning();"><img src="/images/NewVideo/ipad.png" />iPhone客户端</a>
                                    <a href="javascript:void(0);" onclick="showwarning();"><img src="/images/NewVideo/ipad.png" />iPad客户端</a>
                                    <a href="javascript:void(0);" onclick="showwarning();"><img src="/images/NewVideo/anzhuo.png" />安卓客户端</a>
                                </div>
                            </div>
                            <div class="Altsjk-03">
                                没有<?=LOGONAME?>视频APP？ <a href="javascript:void(0);" onclick="showwarning();">立即下载</a>
                                <!--                <a href="--><?//= Url::to(['/site/share-down'])?><!--" target="_blank">立即下载</a>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="player-sd">
                    <div class="player-sdc">
                        <div class="qy-player-side-loading" style="display: none;">
                            <img src="/images/NewVideo/con-loading-black.gif" alt="正在加载" class="loading-img">
                            <p class="loading-txt">正在加载…</p>
                        </div>
                        <div class="qy-player-side qy-episode-side">
                            <div class="qy-player-side-head">
                                <div class="head-title">
                                    <h2 class="header-txt">
                                        <a href="" class="header-link">
                                            <?= $data['info']['video_name']?>
                                        </a>
                                        <p class="update-tip-1">
                                            <?php if($data['channel_id'] == '2'){?>
                                                更新至<?= count($data['info']['videos'])?>集
                                            <?php } elseif($data['channel_id'] == '3'){?>
                                                更新至<?= $data['info']['videos'][count($data['info']['videos'])-1]['title']?>
                                            <?php } ?>
                                        </p>
                                    </h2>
                                </div>
                            </div>
                            <div class="qy-player-side-body v_scroll_plist_bc qy-advunder-show" style="height: 100%;">
                                <div class="body-inner">
                                    <?php if($data['channel_id'] == '2'){?>
                                        <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
                                            <div class="padding-box">
                                                <div class="qy-episode-tab">
                                                    <ul class="tab-bar TAB_CLICK sourceTab" id=".srctabShow">
                                                        <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                            <li class="bar-li <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'hover' : ''?>" id='srcTab-<?=$source['resId']?>'>
                                                                <a href="javascript:void(0);"
                                                                   class="bar-link"
                                                                   data-source-id="<?= $source['resId']?>">
                                                                    <?= $source['resName'] ?>
                                                                </a>
                                                            </li>
                                                        <?php endforeach;?>
                                                    </ul>
                                                </div>
                                                <div class="c"></div>
                                                <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                    <div class="srctabShow <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'dn' : 'nn'?>" id='srctab-<?=$source['resId']?>'>
                                                        <?php
                                                        $page = ceil(count($source['data'])/30);
                                                        $count = count($source['data']);
                                                        $ontab = 1;
                                                        foreach ($source['data'] as $index => $value){
                                                            if ($data['info']['play_chapter_id'] != $value['chapter_id'])
                                                                continue;

                                                            $ontab = ceil(($index+1) / 30);
                                                            break;
                                                        }
                                                        ?>
                                                        <div class="qy-episode-tab">
                                                            <ul class="tab-bar TAB_CLICK" id=".tabShow<?=$key?>">
                                                                <?php for($k=0; $k<$page; $k++){?>
                                                                    <li class="bar-li <?= $k+1 == $ontab? 'hover': ''?>">
                                                                        <a href="javascript:void(0);" class="bar-link">
                                                                            <?= $k*30 + 1?>-<?= ($k == ($page -1))? $count:$k*30 + 30?></a>
                                                                    </li>
                                                                <?php }?>
                                                            </ul>
                                                        </div>
                                                        <div class="c"></div>
                                                        <?php for($i=0; $i<$page; $i++){?>
                                                            <ul class="qy-episode-num tabShow<?=$key?> <?= (($i+1) == $ontab)? 'dn': 'nn'?>">
                                                                <?php foreach ($source['data'] as $index => $value) : ?>
                                                                    <?php if($index>=$i*30 && $index < ($i*30+30)){?>
                                                                        <li class="select-item switch-next-li switch-next <?= $data['info']['play_chapter_id'] == $value['chapter_id']
                                                                        && ((empty($source_id) && $key == 0) || ($source['resId'] == $source_id))? 'selected' : ''?>"
                                                                            data-video-id="<?= $value['video_id']?>"
                                                                            data-chapter-id="<?= $value['chapter_id']?>"
                                                                            data-type="<?= $data['info']['catalog_style']?>"
                                                                            id='chap-<?=$source['resId']?>-<?=$value['chapter_id']?>'>
                                                                            <div class="select-link">
                                                                                <?= intval($value['title'])?>
                                                                            </div>
                                                                        </li>
                                                                    <?php }?>
                                                                <?php endforeach;?>
                                                            </ul>
                                                        <?php }?>
                                                    </div>
                                                <?php endforeach;?>
                                                <div class="c"></div>
                                            </div>
                                        </div>
                                    <?php } elseif($data['channel_id'] == '1'){?>
                                        <div class="qy-episode-tab">
                                            <ul class="tab-bar TAB_CLICK sourceTab" id=".tabShow">
                                                <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                    <li class="bar-li <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'hover' : ''?>" id='srcTab-<?=$source['resId']?>'>
                                                        <a href="javascript:void(0);"
                                                           class="bar-link"
                                                           data-source-id="<?= $source['resId']?>">
                                                            <?= $source['resName'] ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                        <div class="h20"></div>
                                        <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
                                            <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                <ul class="qy-play-list tabShow
                                                <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'dn' : 'nn'?>"
                                                    style="margin-bottom: 100px;" id='srctab-<?=$source['resId']?>'>
                                                    <?php foreach ($source['data'] as $value) : ?>
                                                        <li class="play-list-item switch-next-li switch-next <?= $data['info']['play_chapter_id'] == $value['chapter_id']
                                                        && ((empty($source_id) && $key == 0) || ($source['resId'] == $source_id))? 'selected' : ''?>"
                                                            data-video-id="<?= $value['video_id']?>"
                                                            data-chapter-id="<?= $value['chapter_id']?>"
                                                            data-type="<?= $data['info']['catalog_style']?>"
                                                            id='chap-<?=$source['resId']?>-<?=$value['chapter_id']?>'>
                                                            <div class="mod-left">
                                                                <div class="mod-img-link">
                                                                    <img src="<?= $value['cover']?>" class="mod-img">
                                                                    <i class="img-border"></i>
                                                                </div>
                                                            </div>
                                                            <div class="mod-right">
                                                                <h3 class="main-title">
                                                                    <span class="title-link"><?= $value['title']?></span>
                                                                </h3>
                                                                <div class="sub-title" style="">
                                                                    <i class="qy-svgicon qy-svgicon-hot"></i>
                                                                    <span class="count"><?= $data['info']['total_views']?></span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php endforeach;?>
                                                </ul>
                                            <?php endforeach;?>
                                        </div>
                                    <?php } elseif($data['channel_id'] == '3'){?>
                                        <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
                                            <div class="qy-episode-tab">
                                                <ul class="tab-bar TAB_CLICK sourceTab" id=".tabShow">
                                                    <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                        <li class="bar-li <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'hover' : ''?>" id='srcTab-<?=$source['resId']?>'>
                                                            <a href="javascript:void(0);"
                                                               class="bar-link"
                                                               data-source-id="<?= $source['resId']?>">
                                                                <?= $source['resName'] ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach;?>
                                                </ul>
                                            </div>
                                            <div class="h20"></div>
                                            <div class="qy-player-side-body v_scroll_plist_bc" style="height: 100%;">
                                                <div class="body-inner">
                                                    <div class="side-content v_scroll_plist_content">
                                                        <div class="">
                                                            <div class="qy-player-side-list qy-advunder-show">
                                                                <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                                    <ul class="qy-play-list tabShow
                                                                    <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'dn' : 'nn'?>"
                                                                        style="margin-bottom: 100px;" id='srctab-<?=$source['resId']?>'>
                                                                        <?php foreach ($source['data'] as $value) : ?>
                                                                        <a href="<?= Url::to(['video/detail', 'video_id'=>$value['video_id'], 'chapter_id'=>$value['chapter_id']])?>"><li class="play-list-item-new"><?= $value['title']?></li></a>
                                                                        <?php endforeach;?>
                                                                    </ul>
                                                                <?php endforeach;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } elseif($data['channel_id'] >= '4'){?>
                                        <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
                                            <div class="qy-episode-update">
                                                <p class="update-tip">
                                                    更新至第<?= count($data['info']['videos'])?>集
                                                </p>
                                            </div>
                                            <div class="qy-episode-tab">
                                                <ul class="tab-bar TAB_CLICK sourceTab" id=".tabShow">
                                                    <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                        <li class="bar-li <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'hover' : ''?>" id='srcTab-<?=$source['resId']?>'>
                                                            <a href="javascript:void(0);"
                                                               class="bar-link"
                                                               data-source-id="<?= $source['resId']?>">
                                                                <?= $source['resName'] ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach;?>
                                                </ul>
                                            </div>
                                            <div class="c"></div>
                                            <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                <ul class="qy-episode-txt tabShow
                                                <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'dn' : 'nn'?>"
                                                    style="margin-bottom: 100px;" id='srctab-<?=$source['resId']?>'>
                                                    <?php foreach ($source['data'] as $key1 =>$value) : ?>
                                                        <li class="select-item switch-next-li switch-next <?= $data['info']['play_chapter_id'] == $value['chapter_id']
                                                        && ((empty($source_id) && $key == 0) || ($source['resId'] == $source_id))? 'selected' : ''?>"
                                                            data-video-id="<?= $value['video_id']?>"
                                                            data-chapter-id="<?= $value['chapter_id']?>"
                                                            data-type="<?= $data['info']['catalog_style']?>"
                                                            id='chap-<?=$source['resId']?>-<?=$value['chapter_id']?>'>
                                                            <div class="select-inline">
                                                                <div class="select-title">
                                                                    <span class="select-pre"><?= $key1+1?></span>
                                                                    <div href="" class="select-link"><?= $value['title']?></div>
                                                                </div>
                                                            </div>
                                                            <i class="playon-icon"></i>
                                                        </li>
                                                    <?php endforeach;?>
                                                </ul>
                                            <?php endforeach;?>
                                        </div>
                                    <?php } ?>
                                    <?php foreach ($data['advert'] as $key => $advert): ?>
                                        <?php $adtab = false;
                                        if(!empty($advert) && intval($advert['position_id']) == intval(AdvertPosition::POSITION_VIDEO_RIGHT_PC)){
                                            $adtab = true;
                                            break;
                                        }?>
                                    <?php endforeach;?>
                                    <?php if($adtab) :?>
                                        <div class="video-right-ad-img J_video_right_ad_img">
                                            <img "<?=$advert['ad_image']?>" onerror="this.src='/images/NewVideo/GG03.png'">
                                        </div>
                                    <?php endif;?>
                                </div>
                                <div class="side-scrollbar">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="qy-player-side-ear"></div>
            </div>
            <?php if(!empty($data['advert'])) :?>
                <?php foreach ($data['advert'] as $key => $advert) : ?>
                    <?php if(!empty($advert) && $advert['position_id'] == AdvertPosition::POSITION_VIDEO_BOTTOM_PC) :?>
                        <a href="<?=$advert['ad_skip_url']?>" target="_blank" class="video-bottom-add">
                            <img src="<?=$advert['ad_image']?>">
                        </a>
                    <?php endif;?>
                <?php endforeach;?>
            <?php endif;?>
            <div class="advert_2">
                <div class="advert_content">
                    <div class="advert_content_title">悉尼交易市场</div>
                    <div class="advert_content_ad">
                        <ul>
                            <li><a href="javascript:;">冰箱急售</a></li>
                            <li><a href="javascript:;">翡翠耳钉</a></li>
                            <li><a href="javascript:;">两张音乐剧门票</a></li>
                            <li><a href="javascript:;">售99新51寸Samsung智能新机</a></li>
                            <li><a href="javascript:;">最新款iPhone13pro</a></li>
                            <li><a href="javascript:;">2021最新款苹果智能蓝牙</a></li>
                            <li><a href="javascript:;">苹果台式机9折起</a></li>
                        </ul>
                    </div>
                </div>
                <div class="advert_content">
                    <div class="advert_content_title">悉尼交易市场</div>
                    <div class="advert_content_ad">
                        <ul>
                            <li><a href="javascript:;">冰箱急售</a></li>
                            <li><a href="javascript:;">翡翠耳钉</a></li>
                            <li><a href="javascript:;">两张音乐剧门票</a></li>
                            <li><a href="javascript:;">售99新51寸Samsung智能新机</a></li>
                            <li><a href="javascript:;">最新款iPhone13pro</a></li>
                            <li><a href="javascript:;">2021最新款苹果智能蓝牙</a></li>
                            <li><a href="javascript:;">苹果台式机9折起</a></li>
                        </ul>
                    </div>
                </div>
                <div class="advert_content">
                    <div class="advert_content_title">悉尼交易市场</div>
                    <div class="advert_content_ad">
                        <ul>
                            <li><a href="javascript:;">冰箱急售</a></li>
                            <li><a href="javascript:;">翡翠耳钉</a></li>
                            <li><a href="javascript:;">两张音乐剧门票</a></li>
                            <li><a href="javascript:;">售99新51寸Samsung智能新机</a></li>
                            <li><a href="javascript:;">最新款iPhone13pro</a></li>
                            <li><a href="javascript:;">2021最新款苹果智能蓝牙</a></li>
                            <li><a href="javascript:;">苹果台式机9折起</a></li>
                        </ul>
                    </div>
                </div>
                <div class="advert_content last">
                    <div class="advert_content_title last">
                        悉尼交易市场
                        <img src="/images/Index/chahao.png">
                    </div>
                    <div class="advert_content_ad last">
                        <ul>
                            <li><a href="javascript:;">冰箱急售</a></li>
                            <li><a href="javascript:;">翡翠耳钉</a></li>
                            <li><a href="javascript:;">两张音乐剧门票</a></li>
                            <li><a href="javascript:;">售99新51寸Samsung智能新机</a></li>
                            <li><a href="javascript:;">最新款iPhone13pro</a></li>
                            <li><a href="javascript:;">2021最新款苹果智能蓝牙</a></li>
                            <li><a href="javascript:;">苹果台式机9折起</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="qy-player-info-area">
                <div class="qy-player-detail">
                    <div class="qy-player-detail-con">
                        <div class="detail-mn">
                            <div class="detail-mnc">
                                <div class="detail-left">
                                    <div class="qy-player-title ">
                                        <h1 class="player-title">
                                            <em class="title-txt"><?= $data['info']['video_name']?></em>
                                            <span class="sub-title">第1集</span>
                                            <span class="sub-title"><?= $data['info']['tag']?></span>
                                        </h1>
                                    </div>
                                    <div id="titleRow" class="qy-player-intro">
                                        <div class="intro-mn">
                                            <div class="intro-mnc">
                                                <div class="qy-player-basic-intro">
                                                    <div class="basic-item qy-player-brief">
                                                        <i class="qy-svgicon qy-svgicon-intro"></i>
                                                        <span class="basic-txt">简介</span>
                                                        <span class="qy-play-icon arrow966-icon"></span>
                                                    </div>
                                                </div>
                                                <div class="qy-player-hot">
                                                    热度<?= $data['info']['total_views']?>
                                                </div>
                                                <div class="qy-player-tag" style="">
                                                    <?php foreach (explode(' ',$data['info']['category']) as $cate) : ?>
                                                        <span href="" class="tag-item"><?= $cate?></span>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="c"></div>
                <div class="qy-player-detail-pop">
                    <div class="qy-player-intro-pop">
                        <div class="intro-left">
                            <div class="intro-ip">
                                <div href="" class="intro-img-link">
                                    <img src="<?= $data['info']['cover']?>"alt="" class="intro-img">
                                </div>
<!--                                <div class="title-wrap">-->
<!--                                    <p class="main">-->
<!--                                        <span class="link-txt">-->
<!--                                            --><?//= $data['info']['video_name']?>
<!--                                        </span>-->
<!--                                    </p>-->
<!--                                </div>-->
                            </div>
                        </div>
                        <div class="intro-right">
                            <ul class="intro-detail">
                                <li class="intro-detail-item">
                                    <em class="item-title">导演：</em>
                                    <span class="item-content">
                                            <?php foreach (explode('|',$data['info']['director']) as $dic) : ?>
                                                <span class="name-wrap">
                                                    <span href="" class="name-link"><?= $dic?></span>
                                                </span>
                                            <?php endforeach;?>
                                        </span>
                                </li>
                                <li class="intro-detail-item">
                                    <em class="item-title">演员：</em>
                                    <span class="item-content">
                                            <?php foreach ($data['info']['actors'] as $key => $act) : ?>
                                                <span class="name-wrap">
                                                    <span class="name-link"><?= $act['actor_name']?></span>
                                                </span>
                                            <?php endforeach;?>
                                        </span>
                                </li>
                                <li class="intro-detail-item">
                                    <em class="item-title">本集简介:</em>
                                    <span class="item-content">
                                            <span class="content-paragraph">
                                                <?= $data['info']['intro']?>
                                            </span>
                                        </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="c"></div>
            </div>
        </div>
    </div>
</div>
<!--a href="http://guazitv.tv/video/spring-festival" target="_blank" class="">
<img src="http://img.guazitv8.com/audio/advert/22c68f3da80ecfb1836e662bfd1b2e91.jpg" style="width:100%;border-radius:5px;">
</a-->
<div class="c"></div>
<div class="qy-play-container-1">
    <div class="qy-play-con">
        <div class="play-con-mn">
            <div class="play-con-mnc">
                <div class="c"></div>

                <div class="GNbox-PL" id="GNbox-PL" name="zt">
                    评论<span>(<?=$data['commentcount']?>)</span>
                </div>
                <!--评论输入区-->
                <div class="GNbox-content">
                    <img src="/images/Index/default_header.png">
                    <div class="GNbox-PLsr" name="zt">
<!--                        <div>-->
<!--                            来说两句吧！-->
<!--                        </div>-->
                        <textarea placeholder="来说两句吧！注意，以下行为将被封号：严重剧透、发布广告、木马链接、宣传同类网站、辱骂工作人员等。"></textarea>
                        <div class="GNbox-PL-box">
                            <!--                    <input class="GNbox-Btnbq" type="button" name="" id="" value="" />-->
                            <!--                    <input class="GNbox-Btntp" type="button" name="" id="" value="发起投票" />-->
                            <input class="GNbox-Btnfs" type="button" name="" id="send_comment" value="发布" />
                        </div>
                    </div>
                </div>
                <!--评论留言位置-->
                <?php if(!$data['comments']['list']){
                    $comment_style = "display:none";
                }else{
                    $comment_style = "";
                }?>
                <div class="GNbox-PL-text" id="comment-part" style="<?=$comment_style?>">
                    <?php if($data['comments']['list']):?>
                        <?php foreach ($data['comments']['list'] as $comment):?>
                            <div class="div-commentlist">
                                <ul class="per-now-box ul-box" name="zt">
                                    <li class="per-now-h">
                                        <div class="navTopLogonImg">
<!--                                            <a href="--><?//=Url::to(['/video/other-home','uid'=>$comment['uid']])?><!--">-->
                                                <?php if($comment['avatar']):?>
                                                    <img src="<?=$comment['avatar']?>" />
                                                <?php else :?>
                                                    <img src="/images/Index/user_c.png" />
                                                <?php endif;?>
<!--                                            </a>-->
                                        </div>
                                    </li>
                                    <li >
                                        <div class="per-now-box-01">
                                            <div>
                                                <?=$comment['nickname']?>
                                            </div>
                                        </div>
                                        <div class="per-now-box-02" name="zt">
                                            <?=$comment['content']?>
                                        </div>
                                        <ul class="per-now-box-03" name="zt">
                                            <li><?=date("Y-m-d",$comment['created_at'])?></li>
                                            <li><input class="per-btn-z" type="button" name="" onclick="addlikes(<?=$comment['comment_id']?>,this);" value="" /><span><?=$comment['likes_num']?></span></li>
                                            <li><input class="per-btn-reply" type="button" name="" onclick="showreply(<?=$comment['comment_id']?>,this);" value="" /></li>
                                        </ul>
                                        <?php if($comment['reply_info']['list']):?>
                                            <div class="div-reply">
                                                <?foreach ($comment['reply_info']['list'] as $key=>$reply):?>
                                                    <ul class="per-now-box ul-box <?php if($key+1==count($comment['reply_info']['list'])):?>per-now-box_last<?endif;?>" name="zt">
                                                        <li class="per-now-h">
                                                            <div class="navTopLogonImg">
                                                                <!--                                                                <a href="javascript"><img src="/images/newindex/logon.png" /></a>-->
<!--                                                                <a href="--><?//=Url::to(['/video/other-home','uid'=>$reply['uid']])?><!--">-->
                                                                    <?php if($reply['avatar']):?>
                                                                        <img src="<?=$reply['avatar']?>" />
                                                                    <?php else :?>
                                                                        <img src="/images/Index/user_c.png" />
                                                                    <?php endif;?>
<!--                                                                </a>-->
                                                            </div>
                                                        </li>
                                                        <li >
                                                            <div class="per-now-box-01">
                                                                <div>
                                                                    <?=$reply['nickname']?>
                                                                </div>
                                                            </div>
                                                            <div class="per-now-box-02" name="zt">
                                                                <?=$reply['content']?>
                                                            </div>
                                                            <ul class="per-now-box-03" name="zt">
                                                                <li><?=date("m-d",$reply['created_at'])?></li>
                                                                <li><input class="per-btn-z" type="button" name="" onclick="addlikes(<?=$reply['comment_id']?>,this);" value="" /><span><?=$reply['likes_num']?></span></li>
                                                                <li></li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                <?php endforeach; ?>
                                                <?php if($comment['reply_info']['total_page']!=0 && $comment['reply_info']['current_page']==$comment['reply_info']['total_page']):?>
                                                    <div class="div-replyname" id="reply-more-<?=$comment['comment_id']?>" onclick="findmorereply(<?=$comment['comment_id']?>)" style="display: none;">
                                                        <input type="hidden" id="reply-current-<?=$comment['comment_id']?>" value="<?=$comment['reply_info']['current_page']?>" />
                                                        <input type="hidden" id="reply-total-<?=$comment['comment_id']?>" value="<?=$comment['reply_info']['total_page']?>" />
                                                        查看更多回复
                                                    </div>
                                                <?php endif;?>
                                            </div>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>
                    <?php $current_page = 0; $total_page = 0;
                    if($data['comments']['total_page']){
                        $current_page = $data['comments']['current_page'];
                        $total_page = $data['comments']['total_page'];
                    }?>
                    <div class="more-comment" id="comment-more"
                        <?php if($total_page==0 || $current_page==$total_page):?>
                            style="display: none;"
                        <?php endif;?>  name="zt">
                        <input type="hidden" id="comment-current" value="<?=$current_page?>" />
                        <input type="hidden" id="comment-total" value="<?=$total_page?>" />
                        查看更多评论
                    </div>
                </div>
            </div>
        </div>
        <aside class="qy-aura3 play-con-sd">
            <div class="qy-mod-wrap side-wrap ">
                <div class="qy-mod-title">
                    <h3 class="mod-title"><?= $channelName ?> · 风云榜
<!--                        <div class="qy-rank-enter">-->
<!--                            <a href="--><?//= Url::to(['hot-play', 'channel_id' => $channel_id])?><!--" class="rank-enter-link">-->
<!--                                <span class="more">全部榜单&nbsp;</span>-->
<!--                                <i class="qy-svgicon qy-svgicon-rightarrow_cu"></i>-->
<!--                            </a>-->
<!--                        </div>-->
                    </h3>
                </div>
                <div class="qy-mod-rank-des-min">
                    <ul class="rank-list">
                        <?php foreach ($hotword['tab'] as $key => $tab): ?>
                            <?php if($tab['title'] == $channelName) :?>
                                <?php foreach ($tab['list'] as $key => $list): ?>
                                    <li class="rank-item">
                                        <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"
                                           class="rank-item-link">
                                            <div class="mod-left">
                                                <img class="Movie-Ranking-img" src="/images/hotPlay/bangdan<?= $key+1?>.png">
                                            </div>
                                            <div class="mod-right">
                                                <h3 class="main-title">
                                                    <div class="sub-right"><span class="count"><?= $list['score']?></span></div>
                                                    <p href="javascript:" class="title-link"><?= $list['video_name']?></p>
                                                </h3>
                                                <div class="sub-box">
                                                    <p class="sub-des">
                                                        <?php foreach (explode(' ',$list['category']) as $category): ?>
                                                            <span><?= $category?></span>
                                                        <?php endforeach;?></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach;?>
                            <?php endif;?>
                        <?php endforeach;?>
                    </ul>
                </div>
                <div class="Title-04" name="zt">
                    相关视频
                </div>
                <?php foreach ($data['guess_like'] as $key => $list) :?>
                    <?php if($key < 8) :?>
                        <!--剧集-->
                        <div class="JJXG">
                            <div class="JJXG-L">
                                <a href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>">
                                    <img src="<?= $list['cover']?>"/>
                                </a>
                            </div>
                            <div class="JJXG-R" name="zt">
                                <a href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>"><?= $list['video_name']?></a>
                                <div class="JJXG-R-tp" name="zt">
                                    <?php foreach (explode(' ',$list['category']) as $cate) : ?>
                                        <span><?= $cate?></span>
                                    <?php endforeach;?>
                                    <span><?= $list['year'] ?></span>
                                    <span><?= $list['area'] ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </aside>
    </div>
</div>

<div class="c"></div>
<script src="/js/jquery.js"></script>
<script src="/js/video.js"></script>
<script src="/js/VideoSearch.js"></script>
<script>
    let timer = null;
    let wechattimer = null
    let picUrl = "/video/get-wechat";
    let checkUrl = "/video/check-wechat";
    let clearUrl = "/video/clear-catch";
    $(document).ready(function(){
        $(".wechat-block").remove("");
        if ($("#play_resource").val() != "")
            $("#my-iframe").attr('src', $("#play_resource").val() + "&ad_url=<?php echo $ad_url;?>&ad_link=<?php echo $ad_link;?>&ad_type=<?php echo $ad_type;?>");
        // refreshWechat();
        // alert(document.getElementById('wechat-block').style.display);
        if(document.getElementById('wechat-block') && document.getElementById('wechat-block').style.display!='none')
        {
            setTimeout(function(){
                clearInterval(wechattimer);
                document.getElementById('wechat-block').style.display='none';

                // if(document.getElementById('easiBox') && document.getElementById('easiBox').style.display!='none')
                //     $('#btn-video-play').trigger("click");

                // if(document.getElementById('picBox') && document.getElementById('picBox').style.display!='none')
                //     countPicAds();

                // setTimeout("document.getElementById('easiBox').style.display='none'",15000);
                // setTimeout("document.getElementById('picBox').style.display='none'",15000);
            },30000);
        }
        // else
        // {
        //     setTimeout("document.getElementById('easiBox').style.display='none'",15000);
        //     setTimeout("document.getElementById('picBox').style.display='none'",15000);
        // }
        // $('#btn-video-play').trigger("click");
        // countPicAds();
        // refreshAds();
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
                        $(".video-bottom-add img").attr("src", adddata.ad_image );
                    }
                    else if (prop == "playbefore") {
                        $(".add-box .ad_url_link").attr("href", adddata.ad_skip_url);
                        if (adddata.ad_image.indexOf(".mp4") != -1)
                        {
                            $("#picBox").remove();
                            $(".add-box video").html("");
                            $(".add-box video").html("<source src='"+ adddata.ad_image + "' type='video/mp4'></source>");
                            $(".add-box video").load();
                            // $(".add-box video").trigger('play');
                            // countVieoAds();
                            $('#btn-video-play').trigger("click");
                            setTimeout("document.getElementById('easiBox').style.display='none'",15000);
                            $("#my-iframe").attr('src', $("#play_resource").val());
                        }
                        else
                        {
                            $("#easiBox").remove();
                            $(".add-box img").attr("src", adddata.ad_image);
                            setTimeout("document.getElementById('picBox').style.display='none'",15000);
                            countPicAds();
                        }
                    }
                }
            }
        })
    }

    function refreshWechat()
    {
        var arrIndex = {};
        // $(".wechat-block").hide();
        $.get(picUrl, function(response) {
            console.log(response);
            let result = response.data;
            if (result.status_code != "200") {
                $(".wechat-block").remove("");
                //   refreshAds();
                $('#btn-video-play').trigger("click");
                countPicAds();
                return;
            }
            console.log(response);
            $(".wechat-block").show();

            $('.wechat-url').attr('src', result.data.img_url)
            $('.wechat_tip').html("<span>"+ result.data.weChatFlag +"</span>");

            wechattimer = setInterval(function() {
                arrIndex['wechat_flag'] = result.data.weChatFlag;
                $.get(checkUrl, arrIndex ,function(response) {
                    let scene = response.data.scene;
                    console.log(response);
                    console.log(scene);
                    if(scene == "gotted")
                    {
                        $(".wechat-block").remove("");
                        arrIndex['catachkey'] = result.data.weChatFlag;
                        $.get(clearUrl, arrIndex);
                        clearInterval(wechattimer);
                        // refreshAds();
                        $('#btn-video-play').trigger("click");
                        countPicAds();
                    }
                })
            }, 2000)
        })
    }

    $("#btn-video-play").click(function(){
        var currentTime = 0;
        var duration = 0;
        var elevideo = document.getElementById("easi");
        $(this).hide();
        duration = Math.round(elevideo.duration);
        if (isNaN(duration))
            duration = 10;

        document.getElementById('timer1').innerHTML = duration;

        $(".add-box video").trigger('play');
        elevideo.addEventListener('play', function () { //播放开始执行的函数
            duration = Math.round(elevideo.duration);
            if (isNaN(duration))
                duration = 10;

            if (elevideo.currentTime != 0){
                duration = Math.round(elevideo.duration - elevideo.currentTime);
            }

            console.log("开始播放");
            //10s后关闭广告视频
            countDown(duration - 1,function(msg) {
                if(msg == '0'){
                    if(document.getElementById('easiBox'))
                        document.getElementById('easiBox').style.display='none';
                }
                document.getElementById('timer1').innerHTML = msg;
            })
        });

        elevideo.addEventListener('pause', function () { //暂停开始执行的函数
            duration = document.getElementById('timer1').innerHTML;
            clearInterval(timer);
            console.log("暂停播放");
        });

        elevideo.addEventListener('ended', function () { //结束
            document.getElementById('easiBox').style.display='none';
            console.log("播放结束");
            // $("#my-iframe").attr('src', $("#play_resource").val());
        }, false);
    });

    function countPicAds()
    {
        if($('.iqp-player #picBox').length > 0)
        {
            //8s后关闭广告图
            document.getElementById('timer1').innerHTML = 10;
            countDown(9, function(msg) {
                if(msg == 0){
                    //if(document.getElementById('picBox'))
                    document.getElementById('picBox').style.display='none';
                }
                console.log(msg);
                document.getElementById('timer1').innerHTML = msg;
            });
        }
    }

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
        if(document.getElementById('picBox'))
            document.getElementById('picBox').style.display='none';

        if(document.getElementById('easiBox'))
        {
            var elevideo = document.getElementById("easi");
            elevideo.pause()
            document.getElementById('easiBox').style.display='none';
        }

    });

    $('.bar-link').click(function(){
        var videoId = "<?= $data['info']['play_video_id']?>";
        var chapterId = "<?= $data['info']['play_chapter_id']?>";
        var sourceId = $(this).attr('data-source-id');

        if(sourceId != undefined && sourceId != null)
        {
            $('#srcTab-'+sourceId).trigger('click');
            if(document.getElementById('chap-'+sourceId +'-'+chapterId))
                $('#chap-'+sourceId +'-'+chapterId).trigger('click');
            else{
                $('#srctab-'+sourceId +' .switch-next-li:first').trigger('click');
            }
        }

    });

    $('#err_feedback').click(function(){
        var feedUrl = "/video/feed-back";
        var feedIndex = {};
        feedIndex['video_id'] = "<?= $data['info']['play_video_id']?>";
        feedIndex['chapter_id'] = "<?= $data['info']['play_chapter_id']?>";
        feedIndex['source_id'] = "<?= $source_id?>";
        $.get(feedUrl, feedIndex ,function(response) {
            var result = response.data;
            alert(result.message);
        });
        console.log(feedIndex);
    })

    //添加播放记录
    $(document).ready(function () {
        //网页关闭时执行的方法
        $(window).bind("beforeunload", function () {
            addwatchlog();
        });
    });
    function addwatchlog(){
        var arrindex = {};
        arrindex['video_id'] = '<?=$data['info']['play_video_id']?>';
        arrindex['chapter_id'] = '<?=$data['info']['play_chapter_id']?>';
        arrindex['watchTime'] = parseInt(dp1.video.currentTime);
        arrindex['totalTime'] = parseInt(dp1.video.duration);
        $.get('/video/add-watchlog',arrindex,function(res){
            console.log(res.data);
        });
    }

    //收藏
    var favor_tab = true;
    $("#id_favors").click(function(){
        var uid = finduser();
        if(!isNaN(uid) && uid!=""){
            if(favor_tab){
                favor_tab = false;
                var that = this;
                var total_favors = parseInt($(that).text());
                var arrindex = {};
                arrindex['videoid'] = '<?=$data['info']['play_video_id']?>';
                console.log('获取我的收藏参数----',arrindex);
                $.get('/video/change-favorite',arrindex,function(res){
                    console.log('获取我的收藏结果----',res);
                    favor_tab = true;
                    if(res.errno==0){
                        $(".rBtn-04").toggleClass("act");
                        if(res.data.status==0){
                            $(that).text(--total_favors);
                        }else{
                            $(that).text(++total_favors);
                        }
                    }
                });
            }
        }else{//弹框登录
            showloggedin();
        }
    });

    //评论区登录
    $("#det_login").click(function(){
        showloggedin();
    });


    //发送
    $("#send_comment").click(function(){
        var uid = finduser();
        if(!isNaN(uid) && uid!=""){
            var ar = {};
            ar['video_id'] = '<?=$data['info']['play_video_id']?>';
            ar['chapter_id'] = '<?=$data['info']['play_chapter_id']?>';
            ar['pid'] = 0;
            var that = this;
            var content = $(this).parent().siblings('textarea').val();
            ar['content'] = content;
            if(content==""){
                $(".alt-title").text("请填写评论");
                $("#alt05").show();
                return false;
            }else{
                console.log('评论参数---------',ar);
                $.get('/video/send-comment',ar,function(res){
                    console.log('评论结果---------',res);
                    if(res.errno==0){
                        if(res.data.display==1){
                            commentNum();//本剧集评论数
                            commentstr(res.data.data);
                            ztBlack();
                            $(".alt-title").text(res.data.message);
                            $("#alt05").show();
                            $(that).parent().siblings('textarea').val("");
                        }else{
                            $(".alt-title").text(res.data.message);
                            $("#alt05").show();
                        }
                    }
                });
            }
        }else{
            //弹框登录
            showloggedin();
        }
    });

    function commentstr(data){
        var html = "";
        var avatarstr = "";
        if(data['avatar']!=""){
            avatarstr = '<img src="'+data['avatar']+'" />';
        }else{
            avatarstr = '<img src="/images/Index/user_c.png" />';
        }
        html = '<div class="div-commentlist">'+
            '<ul class="per-now-box ul-box" name="zt">'+
            '<li class="per-now-h">'+
            '<div class="navTopLogonImg">'+avatarstr+
            // '<a href="/video/other-home?uid='+data['uid']+'">'+avatarstr+'</a>'+
            '</div>'+
            '</li>'+
            '<li>'+
            '<div class="per-now-box-01">'+
            '<div>'+data['nickname']+'</div>'+
            '</div>'+
            '<div class="per-now-box-02" name="zt">'+data['content']+'</div>'+
            '<ul class="per-now-box-03" name="zt">'+
            '<li>'+data['created_time']+'</li>'+
            '<li>'+
            '<input class="per-btn-z" type="button" name="" onclick="addlikes('+data['comment_id']+',this);" value="" />'+
            '<span>'+data['likes_num']+'</span>'+
            '</li>'+
            '<li><input class="per-btn-reply" type="button" name="" onclick="showreply('+data['comment_id']+',this);" value="" /></li>'+
            '</ul>'+
            '</li>'+
            '</ul>'+
            '</div>';
        $("#comment-part").prepend(html);
        $("#comment-part").show();
    }

    //点赞
    function addlikes(id,that){
        var uid = $("#login_id").val();
        if(!isNaN(uid) && uid!=""){
            var arr = {};
            arr['id'] = id;
            if($(that).hasClass("act")){
                arr['cal'] = 'subtract';
            }else{
                arr['cal'] = 'plus';
            }
            $.get('/video/add-likes', arr,function(res){
                $(that).toggleClass("act");
                if(res.errno==0 && res.data>=0){
                    $(that).parent().find("span").html(res.data);
                }else{
                    $(that).parent().find("span").html(0);
                }
            });
        }else{//弹框登录
            showloggedin();
        }
    }
    //回复
    function showreply(id,that){
        var uid = $("#login_id").val();
        if(!isNaN(uid) && uid!=""){
            var black = "";
            if($(that).parent().parent().hasClass("ZT-black")){
                black = "ZT-black";
            }
            var str = '<div id="addreplydiv" class="GNbox-PLsr '+black+'" name="zt">' +
                '<textarea placeholder="在此输入回复内容"></textarea>' +
                '<div class="GNbox-PL-box">' +
                '<input class="GNbox-Btnfs" type="button" name="" onclick="sendreply('+id+');" value="发送" />' +
                '</div>' +
                '</div>';
            $("#addreplydiv").remove();
            $(that).parent().parent().after(str);
        }else{//弹框登录
            showloggedin();
        }
    }

    //提交回复
    function sendreply(pid){
        var ar = {};
        ar['video_id'] = '<?=$data['info']['play_video_id']?>';
        ar['chapter_id'] = '<?=$data['info']['play_chapter_id']?>';
        ar['pid'] = pid;
        var content = $("#addreplydiv").find('textarea').eq(0).val();
        ar['content'] = content;
        if(content==""){
            $(".alt-title").text("请填写评论");
            $("#alt05").show();
            return false;
        }else{
            console.log('回复评论参数----',ar);
            $.get('/video/send-comment',ar,function(res){
                console.log('获取回复评论结果----',res);
                if(res.errno==0){
                    if(res.data.display==1){
                        commentNum();//本剧集评论数
                        var rstr = replystr(res.data.data);
                        if($("#addreplydiv").siblings('.div-reply').length>0){
                            $("#addreplydiv").siblings('.div-reply').prepend(rstr);
                        }else{
                            $("#addreplydiv").after('<div class="div-reply">'+rstr+'</div>');
                        }
                        ztBlack();
                        $(".alt-title").text(res.data.message);
                        $("#alt05").show();
                        $("#addreplydiv").remove();
                    }else{
                        $(".alt-title").text(res.data.message);
                        $("#alt05").show();
                    }
                }
            });
        }
    }

    function replystr(data){
        var html = "";
        var avatarstr = "";
        if(data['avatar']!=""){
            avatarstr = '<img src="'+data['avatar']+'" />';
        }else{
            avatarstr = '<img src="/images/Index/user_c.png" />';
        }
        html = '<ul class="per-now-box ul-box" name="zt">'+
            '<li class="per-now-h">'+
            '<div class="navTopLogonImg">'+avatarstr+
            // '<a href="/video/other-home?uid='+data['uid']+'">'+avatarstr+'</a>'+
            '</div>'+
            '</li>'+
            '<li>'+
            '<div class="per-now-box-01">'+
            '<div>'+data['nickname']+'</div>'+
            '</div>'+
            '<div class="per-now-box-02" name="zt">'+data['content']+'</div>'+
            '<ul class="per-now-box-03" name="zt">'+
            '<li>'+data['created_time']+'</li>'+
            '<li>'+
            '<input class="per-btn-z" type="button" name="" onclick="addlikes('+data['comment_id']+',this);" value="" />'+
            '<span>'+data['likes_num']+'</span>'+
            '</li>'+
            '<li></li>'+
            '</ul>'+
            '</li>'+
            '</ul>';
        return html;
    }
    //查看更多评论
    $("#comment-more").click(function(){
        var page_num = ($("#comment-current").val()!="")?parseInt($("#comment-current").val()):0;
        var total = ($("#comment-total").val()!="")?parseInt($("#comment-total").val()):0;
        var order = $(".per-tab-comment li.act").attr("data-order");
        var ar = {};
        ar['video_id'] = '<?=$data['info']['play_video_id']?>';
        ar['chapter_id'] = '<?=$data['info']['play_chapter_id']?>';
        ar['page_num'] = page_num;
        ar['order'] = order;
        $.get('/video/comment-more',ar,function(res){
            $("#comment-more").before(res);//添加评论列表
            ztBlack();
            if(total==0 || total == page_num+1){
                $("#comment-more").hide();
            }else{
                $("#comment-more").show();
                $("#comment-current").val(++page_num);
            }
        });
    });
    //查看更多回复
    function findmorereply(pid){
        //#reply-more-  .reply-current- .reply-total-
        var page_num = ($("#reply-current-"+pid).val()!="")?parseInt($("#reply-current-"+pid).val()):0;
        var total = ($("#reply-total-"+pid).val()!="")?parseInt($("#reply-total-"+pid).val()):0;
        var ar = {};
        ar['pid'] = pid;
        ar['page_num'] = page_num
        $.get('/video/reply-more',ar,function(res){
            if(res.errno==0 && res.data.length>0){
                var str = replyMorestr(res.data);
                $("#reply-more-"+pid).before(str);//添加评论列表
                ztBlack();
                if(total == page_num+1){
                    $("#reply-more-"+pid).hide();
                }else{
                    $("#reply-more-"+pid).show();
                    $("#reply-current-"+pid).val(++page_num);
                }
            }
        });
    }
    function replyMorestr(data){
        var html = "";
        for(var i=0;i<data.length;i++){var avatarstr = "";
            if(data[i]['avatar']!=""){
                avatarstr = '<img src="'+data[i]['avatar']+'" />';
            }else{
                avatarstr = '<img src="/images/Index/user_c.png" />';
            }
            html += '<ul class="per-now-box ul-box" name="zt">'+
                '<li class="per-now-h">'+
                '<div class="navTopLogonImg">'+
                '<a href="/video/other-home?uid='+data[i]['uid']+'">'+avatarstr+'</a>'+
                '</div>'+
                '</li>'+
                '<li >'+
                '<div class="per-now-box-01">'+
                '<div>'+data[i]['nickname']+'</div>'+
                '</div>'+
                '<div class="per-now-box-02" name="zt">'+data[i]['content']+'</div>'+
                '<ul class="per-now-box-03" name="zt">'+
                '<li>'+data[i]['created_time']+'</li>'+
                '<li>'+
                '<input class="per-btn-z" type="button" name="" onclick="addlikes('+data[i]['comment_id']+',this);" value="" />'+
                '<span>'+data[i]['likes_num']+'</span>'+
                '</li>'+
                '<li></li>'+
                '</ul>'+
                '</li>'+
                '</ul>';
        }
        return html;
    }
    //切换order-tab
    $(".per-tab-comment li").click(function(){
        var that = this;
        var page_num = 0;
        var total = ($("#comment-total").val()!="")?parseInt($("#comment-total").val()):0;
        var order = $(this).attr("data-order");
        var ar = {};
        ar['video_id'] = '<?=$data['info']['play_video_id']?>';
        ar['chapter_id'] = '<?=$data['info']['play_chapter_id']?>';
        ar['page_num'] = page_num;
        ar['order'] = order;
        $.get('/video/comment-more',ar,function(res){
            $("#comment-part .div-commentlist").remove();
            $("#comment-more").before(res);//添加评论列表
            $(that).addClass("act").siblings().removeClass("act");
            ztBlack();
            if(total==0 || total == page_num+1){
                $("#comment-more").hide();
            }else{
                $("#comment-more").show();
                $("#comment-current").val(++page_num);
            }
        });
    });
    //chapterId评论数
    function commentNum(){
        var value = $(".J_comment").text();
        var num = parseInt(value!='' ? value : 0 )+1;
        console.log(num);
        $(".rBtn-01").find('input').val(num);
        $("#GNbox-PL").find('span').html("("+num+")");
    }
</script>
</body>
</html>
