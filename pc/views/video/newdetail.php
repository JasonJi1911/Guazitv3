<?php
use yii\helpers\Url;
use pc\assets\StyleInAsset;

$this->title = '瓜子TV-澳新华人在线视频分享网站';
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
        //dp.play();
    });
    
    //5s后关闭封面图
    setTimeout(function() {
        $('.video-play-left-cover').hide();
        //dp.play();
    },5000);
    
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
        var sourceId = $('#video-source').val();
        var type = $(this).attr('data-type');
        
        window.location.href = '/video/detail?video_id=' + videoId + '&chapter_id=' + chapterId
    });
        
    //切换视频源
    $('.next-source').click(function() {
        var videoId = $(this).attr('data-video-id');
        var chapterId = $(this).attr('data-video-chapter-id');
        var sourceId = $(this).attr('data-source-id');
         window.location.href = "/video/detail?video_id="+videoId+"&chapter_id="+chapterId+"&source_id="+sourceId;
    });
    
//    window.onload = function(){
//        window.setInterval(showalert, 1000); 
//        function showalert() 
//        {
//            var time = $("#my-iframe").contents().find(".yzmplayer-ptime").text();
//            var dTime = $("#my-iframe").contents().find('.yzmplayer-dtime').text();
//
//            if (time == "" || dTime == "")
//                return ;
//            
//            var videoId = $('.switch-next selected').attr('data-video-id');
//            var chapterId = $('#next_chapter').val();
//            var sourceId = $('.next-source selected').attr('data-source-id');
//             if (time == dTime)
//             {
//                 window.location.href = "/video/detail?video_id="+videoId+"&chapter_id="+chapterId+"&source_id="+sourceId;
//             }
//        }
//    }
    
});
JS;

$this->registerJs($js);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <style>
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
    </style>
</head>
<body style="background-color:#fff;">
<script src="/js/jquery.js"></script>
<script src="/js/VideoSearch.js"></script>
<?php
    $channelName = '';
        foreach ($channels['list'] as $s_k => $s_v) {
            if($s_v['channel_id'] == $data['channel_id']) {
                $channelName = $s_v['channel_name'];
            }
        }
    ?>
    <header class="qy-header home2020 aura2">
        <div class="header-wrap">
            <div class="header-inner">
                <div id="nav_logo" class="qy-logo">
                    <a href="/video/index" class="logo-link" title="瓜子TV"><img src="/images/NewVideo/logo.png" alt="">
                        瓜子TV · <?= $channelName?></a>
                </div>
                <div class="qy-nav">
                    <div class="nav-channel">
                        <a href="<?= Url::to(['/video/channel', 'channel_id' => '2'])?>"
                           class="nav-link nav-index J-nav-channel">电视剧</a>
                        <a href="<?= Url::to(['/video/channel', 'channel_id' => '1'])?>"
                           class="nav-link nav-index J-nav-channel">电影</a>
                        <a href="<?= Url::to(['/video/channel', 'channel_id' => '3'])?>"
                           class="nav-link nav-index J-nav-channel">综艺</a>
                        <a href="<?= Url::to(['/video/channel', 'channel_id' => '4'])?>"
                           class="nav-link nav-index J-nav-channel">动漫</a>
                    </div>
                    <div class="T-drop-hover nav-guide nav-link" id="dhBtn">
                        <div class="T-drop-click">
                                <span class="J-nav-title">
                                    <span class="show920">
                                        导航
                                        <i class="qy20-header-svg qy20-header-svg-guide-narrow"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-guide-narrow"></use></svg></i>
                                    </span>
                                    <span class="hidden920">全部<i class="qy20-header-svg qy20-header-svg-guide-narrow"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-guide-narrow"><svg id="qy20-header-guide-narrow" viewBox="0 0 9 9"><path d="M.257 3.793a1 1 0 0 1 1.327-.078l.088.078L4.5 6.62l2.828-2.828a1 1 0 0 1 1.327-.078l.088.078A1 1 0 0 1 8.82 5.12l-.077.087-3.536 3.536a1 1 0 0 1-1.327.077l-.087-.077L.257 5.207a1 1 0 0 1 0-1.414z"></path></svg></use></svg></i></span>
                                </span>
                        </div>
                        <div class="qy-nav-panel qy-nav-pop J-nav-body" style="display:none;">
                            <div class="qy-nav-sub-v3 qy-nav-pop J-nav-pop-wrap">
                                <div class="qy-nav-inner qy20-nav-wide">
                                    <?php if(!empty($channels)) :?>
                                        <?php foreach ($channels['list'] as $channel) :?>
                                            <div class="qy20-nav-list">
                                                <a href="<?= Url::to(['/video/channel', 'channel_id' => $channel['channel_id']])?>"
                                                   class="qy20-nav-link">
                                                    <span class="nav-en">MOVIES</span>
                                                    <span class="nav-name"><?= $channel['channel_name']?></span></a>
                                            </div>
                                            <i class="qy20-nav-line"></i>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="qy-search">
                    <?php foreach ($hot['tab'] as $key => $tab): ?>
                        <?php if($tab['title'] == '热搜') :?>
                            <div class="search-box">
                                <span class="search-box-in">
                                     <input id="keywords" autocomplete="off"
                                            placeholder="<?= empty($tab['list'][0]['video_name']) ? '': $tab['list'][0]['video_name']?>"
                                            type="text" class="search-box-input"></a>
                                </span>
                                <span class="search-box-out">
                                    <span id="J-search-btn" type="button"
                                          class="search-box-btn">
                                        <i class="qy-svgicon qy-svgicon-search"></i>
                                        <em class="search-box-btnTxt">搜索</em>
                                    </span>
                                </span>
                            </div>
                            <div id="J-search-result-wrap" class="search-result" style="">
                                <div class="search-result-con">
                                    <div id="J-search-result-hot" class="search-result-hot" style="">
                                        <div class="search-result-title">热门搜索</div>
                                        <?php foreach ($tab['list'] as $key => $list): ?>
                                            <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"
                                               class="search-result-item">
                                                <div class="search-result-simple">
                                                    <em class="search-result-num search-result-num1"><?= $key + 1?></em>
                                                    <span class="search-result-text"><?= $list['video_name']?></span>
                                                </div>
                                            </a>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </header>
    <div class="c"></div>
    <div class="qy-play-top">
        <div class="play-top-flash">
            <div class="qy-play-container">
                <div class="qy-player-wrap">
                    <div class="player-mn">
                        <div class="player-mnc">
                            <div class="qy-flash-box">
                                <div class="flash-box">
                                    <div class="iqp-player">
                                        <input type="hidden" id="next_chapter" value="<?= $data['info']['next_chapter'] ?>">
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
                                            <div class="video-play-left-cover">
                                                <img src="<?= $data['info']['horizontal_cover'] ?>"
                                                     onerror="this.src='/images/video/default-cover-ver.png'"
                                                     id="video-cover" class="video-play-btn-iframe">
                                            </div>
                                            <iframe name="my-iframe" id="my-iframe" src="<?= $data['info']['resource_url']?>"
                                                    allowfullscreen="true" allowtransparency="true"
                                                    frameborder="0" scrolling="no" width="100%"
                                                    height="100%" scrolling="no"></iframe>
<!--                                            <div class="box" id="player1"-->
<!--                                                data-src="--><?//= $data['info']['resource_url']?><!--"></div>-->
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                            <div class="c"></div>
                            <div class="player-mnb">
                                <!--<div class="player-mnb-left">-->
                                <!--    <div class="qy-flash-func qy-flash-func-v1">-->
                                <!--        <div class="func-item func-comment">-->
                                <!--            <div class="func-inner">-->
                                <!--                <i class="qy-svgicon qy-svgicon-comment-v1"><i class="bubble b1"></i><i class="bubble b2"></i><i class="bubble b3"></i></i>-->
                                <!--                <span class="func-name">9844</span>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--        <div class="func-item func-like-v1">-->
                                <!--            <div class="func-inner">-->
                                <!--                <span class="like-icon-box"><i title="" class="qy-svgicon qy-svgicon-dianzan"></i><i title="" class="like-heart-steps"></i></span>-->
                                <!--                <span class="func-name"><?= $data['info']['total_views']?></span>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--        <div class="func-item func-collect">-->
                                <!--            <a href="javascript:void(0)" class="qy-func-collect-v1">-->
                                <!--                <span class="collect">-->
                                <!--                    <i class="qy-svgicon qy-svgicon-collect"></i>-->
                                <!--                    <span class="txt">收藏</span>-->
                                <!--                </span>-->
                                <!--                <span class="collected" style="display: none;">-->
                                <!--                    <i class="qy-svgicon qy-svgicon-collected"></i>-->
                                <!--                    <span class="txt">已收藏</span>-->
                                <!--                </span>-->
                                <!--            </a>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <div class="player-mnb-mid">
                                    <?php foreach ($data['info']['source'] as $key => $source): ?>
                                        <div class="qy-func-collect-v1" style="margin-left: 20px; cursor: pointer">
                                            <div class="<?= (empty($source_id) && $key == 0) ? 'on' : ''?> <?= $source['source_id'] == $source_id ? 'on' : ''?> collect">
                                                <span class="tag-item">
                                                    <span class="next-source txt"
                                                          data-video-id="<?= $data['info']['video_id']?>"
                                                          data-video-chapter-id="<?= $data['info']['play_chapter_id']?>"
                                                          data-source-id="<?= $source['source_id']?>">
                                                        <?= $source['name']?>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endforeach;?>
                                </div>
                                <!--<div class="player-mnb-right">-->
                                <!--    <div class="qy-flash-func qy-flash-func-v1">-->
                                <!--        <div class="func-item func-download">-->
                                <!--            <div title="下载" class="func-inner"><span class="qy-play-icon func-dwn-icon"></span></div>-->
                                <!--            <div class="qy-func-toast-v1 qy-func-toast-v2" style="display: none;">-->
                                <!--                正在检测客户端-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--    <div class="func-item func-more">-->
                                <!--        <div class="func-inner"><i class="func-more-icon"><i class="more-dot"></i></i></div>-->
                                <!--    </div>-->
                                <!--</div>-->
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
                                        </h2>
                                    </div>
                                </div>
                                <div class="qy-player-side-body v_scroll_plist_bc qy-advunder-show" style="height: 100%;">
                                    <div class="body-inner">
                                        <?php if($data['channel_id'] == '2'){?>
                                            <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
                                                <div class="padding-box">
                                                    <div class="qy-episode-update">
                                                        <p class="update-tip">
                                                            更新至<?= count($data['info']['videos'])?>集
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <?php
                                                        $page = ceil(count($data['info']['videos'])/30);
                                                        $count = count($data['info']['videos']);
                                                        ?>
                                                        <div class="qy-episode-tab">
                                                            <ul class="tab-bar TAB_CLICK" id=".tabShow">
                                                                <?php for($k=0; $k<$page; $k++){?>
                                                                    <li class="bar-li <?= $k == 0? 'hover': ''?>">
                                                                        <a href="javascript:void(0);" class="bar-link">
                                                                            <?= $k*30 + 1?>-<?= ($k == ($page -1))? $count:$k*30 + 30?></a>
                                                                    </li>
                                                                <?php }?>
                                                            </ul>
                                                        </div>
                                                        <div class="c"></div>
                                                        <?php for($i=0; $i<$page; $i++){?>
                                                            <ul class="qy-episode-num tabShow  <?= $i > 0? 'dn': ''?>">
                                                                <?php foreach ($data['info']['videos'] as $index => $value) : ?>
                                                                    <?php if($index>=$i*30 && $index < ($i*30+30)){?>
                                                                    <li class="select-item switch-next-li switch-next <?= $data['info']['play_chapter_id'] == $value['chapter_id'] ? 'selected' : ''?>"
                                                                        data-video-id="<?= $value['video_id']?>"
                                                                        data-chapter-id="<?= $value['chapter_id']?>"
                                                                        data-type="<?= $data['info']['catalog_style']?>">
                                                                        <div class="select-link">
                                                                            <?= $value['title']?>
                                                                        </div>
                                                                        <!--                                                                <div rseat="80521_listbox_positive" class="icon-tr">-->
                                                                        <!--                                                                    <img src="images/s-new-12.png" alt="">-->
                                                                        <!--                                                                </div>-->
                                                                    </li>
                                                                    <?php }?>
                                                                <?php endforeach;?>
                                                            </ul>
                                                        <?php }?>
                                                    </div>
                                                    <div class="c"></div>
                                                </div>
                                            </div>
                                        <?php } elseif($data['channel_id'] == '1'){?>
                                            <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
                                                <ul class="qy-play-list" style="margin-bottom: 100px;">
                                                    <?php foreach ($data['info']['videos'] as $value) : ?>
                                                        <li class="play-list-item switch-next-li switch-next <?= $data['info']['play_chapter_id'] == $value['chapter_id'] ? 'selected' : ''?>"
                                                            data-video-id="<?= $value['video_id']?>"
                                                            data-chapter-id="<?= $value['chapter_id']?>"
                                                            data-type="<?= $data['info']['catalog_style']?>">
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
                                            </div>
                                        <?php } elseif($data['channel_id'] == '3'){?>
                                            <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
                                                <div class="qy-episode-update">
                                                    <p class="update-tip">
                                                        更新至<?= $data['info']['videos'][count($data['info']['videos'])-1]['title']?>
                                                    </p>
                                                </div>
                                                <div class="qy-episode-tab">
                                                    <ul class="tab-bar TAB_CLICK" id=".tabShow">
                                                        <li class="bar-li hover"><a href="javascript:void(0);" class="bar-link">正片</a></li>
<!--                                                        <li class="bar-li"><a href="javascript:void(0);" class="bar-link">看点</a></li>-->
                                                    </ul>
                                                </div>
                                                <div class="h20"></div>
                                                <div class="qy-player-side-body v_scroll_plist_bc" style="height: 100%;">
                                                    <div class="body-inner">
                                                        <div class="side-content v_scroll_plist_content">
                                                            <div class="">
                                                                <div class="qy-player-side-list qy-advunder-show">
                                                                    <ul class="qy-play-list" style="margin-bottom: 100px;">
                                                                        <?php foreach ($data['info']['videos'] as $value) : ?>
                                                                            <li class="play-list-item switch-next-li switch-next <?= $data['info']['play_chapter_id'] == $value['chapter_id'] ? 'selected' : ''?>"
                                                                                data-video-id="<?= $value['video_id']?>"
                                                                                data-chapter-id="<?= $value['chapter_id']?>"
                                                                                data-type="<?= $data['info']['catalog_style']?>">
                                                                                <div class="mod-left">
                                                                                    <div class="mod-img-link">
                                                                                        <img src="<?= $value['cover']?>" class="mod-img">
<!--                                                                                        <div class="icon-tr"><img src="images/s-new-12.png"></div>-->
                                                                                        <div class="icon-b">
                                                                                            <i class="playing-icon" style="display: none;"></i>
                                                                                            <span class="qy-mod-label"><?= $value['title']?></span>
                                                                                        </div>
                                                                                        <i class="img-border"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="mod-right">
                                                                                    <h3 class="main-title">
                                                                                        <span href="" class="title-link"><?= $value['title']?></span>
                                                                                    </h3>
                                                                                    <div class="sub-title" style="">
                                                                                        <i class="qy-svgicon qy-svgicon-hot"></i>
                                                                                        <span class="count"><?= $data['info']['total_views']?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                        <?php endforeach;?>
                                                                    </ul>
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
                                                <ul class="qy-episode-txt" style="margin-bottom: 100px;">
                                                    <?php foreach ($data['info']['videos'] as $key => $value) : ?>
                                                        <li class="select-item switch-next-li switch-next <?= $data['info']['play_chapter_id'] == $value['chapter_id'] ? 'selected' : ''?>"
                                                            data-video-id="<?= $value['video_id']?>"
                                                            data-chapter-id="<?= $value['chapter_id']?>"
                                                            data-type="<?= $data['info']['catalog_style']?>">
                                                            <div class="select-inline">
                                                                <div class="select-title">
                                                                    <span class="select-pre"><?= $key+1?></span>
                                                                    <div href="" class="select-link"><?= $value['title']?></div>
                                                                </div>
                                                            </div>
                                                            <i class="playon-icon"></i>
                                                        </li>
                                                    <?php endforeach;?>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="side-scrollbar">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="qy-player-side-ear"></div>
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
                                                    <div class="qy-player-tag" style="">
                                                        <?php foreach (explode('|',$data['info']['category']) as $cate) : ?>
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
                                    <div class="title-wrap">
                                        <p class="main">
                                            <spa class="link-txt">
                                                <?= $data['info']['video_name']?>
                                            </spa>
                                        </p>
                                    </div>
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
    <div class="qy-play-container" style="display: none">
        <div class="qy-play-con">
            <div class="play-con-mn">
                <div class="play-con-mnc">
                    <div>
                        <div class="qy-mod-wrap">
                            
                        </div>
                    </div>
                </div>
            </div>
            <aside class="play-con-sd">
                <div class="qy-mod-wrap side-wrap">
                    <div class="qy-mod-title"><h3 class="mod-title">猜你喜欢</h3></div>
                    <div class="qy-play-fav-list">
                        <ul class="rank-list">
                            <?php foreach ($data['guess_like'] as $key => $list) :?>
                                <?php if($key < 6) :?>
                                    <li class="rank-item">
                                        <a href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>" class="rank-item-link">
                                            <div class="mod-left">
                                                <div class="mod-img-link">
                                                    <img class="mod-img" src="<?= $list['cover']?>">
                                                    <div class="icon-b">
                                                        <span class="qy-mod-label">
                                                            <?= $list['flag']?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mod-right">
                                                <h3 class="main-title"><p class="title-link"><?= $list['video_name']?></p></h3>
                                                <div class="sub-box"><p class="sub-des"><?= $list['intro']?></p></div>
                                                <div class="sub-title">
                                                    <i class="qy-svgicon qy-svgicon-hot"></i>
                                                    <span class="count"><?= $list['play_times']?></span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php endif;?>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </aside>
        </div>
    </div>
    <div class="c"></div>

    <div class="c"></div>
    <footer class="qy-footer">
        <div class="wp">
            <p>本网站为非赢利性站点，所有内容均由机器人采集于互联网，或者网友上传，本站只提供WEB页面服务，本站不存储、不制作任何视频，不承担任何由于内容的合法性及健康性所引起的争议和法律责任。<br />若本站收录内容侵犯了您的权益，请附说明联系邮箱，本站将第一时间处理。站长邮箱：guazitv@163.com</p>
        </div>
    </footer>
    <div class="qy-scroll-anchor qy-aura3">
        <ul class="scroll-anchor">
            <li class="anchor-list anchor-integral">
                <div class="qy-scroll-integral popBox dn">
                    <span class="tianjia-arrow"></span>
                    <img src="/images/NewVideo/client_wechat.jpg" alt="">
                </div>
                <a href="javascript:;" class="anchor-item j-pannel"><i class="qy-svgicon qy-svgicon-anchorIntegral j-pannel"></i><i class="dot j-pannel"></i></a>
            </li>
            <li class="anchor-list anchor-tianjia">
                <!--<div class="qy-scroll-tianjia popBox dn">-->
                <!--    <span class="tianjia-arrow"></span>-->
                <!--    <div class="tianjia-con">-->
                <!--        <p class="tianjia-text">添加-->
                <!--            <span class="tianjia-link">“爱奇艺网页应用”</span>-->
                <!--            <br>硬核内容全网独播~-->
                <!--        </p>-->
                <!--        <a href="javascript:;" class="tianjia-btn">立即添加</a>-->
                <!--    </div>-->
                <!--</div>-->
                <a href="javascript:;" class="anchor-item"><i class="qy-svgicon qy-svgicon-tianjia"></i></a>
            </li>
            <li class="anchor-list">
                <a href="" class="anchor-item"><i class="qy-svgicon qy-svgicon-anchorHelp"></i><span class="anchor-txt">帮助反馈</span></a>
            </li>
            <li class="anchor-list dn">
                <a href="javascript:;"  class="anchor-item backToTop"><i class="qy-svgicon qy-svgicon-anchorTop"></i><span class="anchor-txt">回到顶部</span></a>
            </li>
        </ul>
    </div>
    <script src="/js/jquery.js"></script>
    <script src="/js/video.js?v=1.5"></script>
    <script src="/js/VideoSearch.js"></script>
</body>
</html>
