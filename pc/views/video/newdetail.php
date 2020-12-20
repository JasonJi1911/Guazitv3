<?php
use yii\helpers\Url;
use pc\assets\StyleInAsset;

$this->title = '瓜子视频-澳新华人在线视频分享网站';
StyleInAsset::register($this);

$js = <<<JS
$(function(){
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
    });
    
    //播放iframe
    $('.video-play-btn-iframe').click(function() {
        //隐藏封面
        $('.video-play-left-cover').hide();
    });
    
    //5s后关闭封面图
    setTimeout(function() {
        $('.video-play-left-cover').hide();
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
        
        window.location.href = '/video/new-detail?video_id=' + videoId + '&chapter_id=' + chapterId
    });
        
    //切换视频源
    $('.next-source').click(function() {
        var videoId = $(this).attr('data-video-id');
        var chapterId = $(this).attr('data-video-chapter-id');
        var sourceId = $(this).attr('data-source-id');
         window.location.href = "/video/new-detail?video_id="+videoId+"&chapter_id="+chapterId+"&source_id="+sourceId;
    })
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
    </style>
</head>
<body style="background-color:#fff;">
<script src="/js/jquery.js"></script>
<script src="/js/VideoSearch.js"></script>
    <header class="qy-header home2020 aura2">
        <div class="header-wrap">
            <div class="header-inner">
                <div id="nav_logo" class="qy-logo">
                    <a href="/video/new-index" class="logo-link" title="瓜子视频"><img src="/images/NewVideo/logo.png" alt="">
                        瓜子视频 · <?= $channels['list'][$channel_id]['channel_name'] ?></a>
                </div>
                <div class="qy-nav">
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
                    <div class="search-box">
                            <span class="search-box-in">
                                <input id="keywords"
                                       autocomplete="off" placeholder="小猪佩奇" type="text" class="search-box-input">
                                <a href="" class="search-right-entry">
                                    <i class="qy-svgicon qy-svgicon-rank-hot2"></i>热搜榜
                                </a>
                            </span>
                        <span class="search-box-out">
                            <span id="J-search-btn" type="button"
                                  class="search-box-btn">
                                <i class="qy-svgicon qy-svgicon-search"></i>
                                <em class="search-box-btnTxt">搜全网</em>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="qy-header-side">
                    <div class="header-sideItem header-vip">
                        <div class="T-drop-click">
                            <div j-product-type="gold" class="header-sideItemCon header-vip-login J-vip-pay">
                                <div>
                                    <em class="header-vip-icon icon-aura2 icon-aura2__qyrv0"></em>
                                    <span class="header-sideItemTit">VIP</span>
                                </div>
                            </div>
                        </div>
                        <!-- 下拉 -->
                        <div class="qy-header-vip-pop selected gold J-cash-pop">
                            <div class="qy-popup-box">
                                <div class="popup-box-arrow"><span class="popup-box-arrowOut"><i class="popup-box-arrowIn"></i></span></div>
                                <div class="qy-header-vipCon">
                                    <div class="vippop-bottom">
                                        <div class="vippop-top">
                                            <div class="vippop-left">
                                                <ul class="header-vippop header-list-more vippop-home2020">
                                                    <li class="header-vippop-wrap"><a href="" class="header-vippop-item J-pop-item T-pop-item"><i class="qy20-header-icon qy20-header-svg qy20-header-vip-g qy-svgicon qy-svgicon-game">
                                                                <svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-vip-g">
                                                                        <svg id="qy20-header-vip-g" title="了解VIP会员特权 " viewBox="0 0 1024 1024"><path d="M512 51.2c102.4 0 184.32 81.92 184.32 184.32 0 20.48-5.12 40.96-10.24 61.44 0 0 5.12 0 5.12 5.12l5.12-5.12c30.72-46.08 81.92-76.8 138.24-76.8h10.24c97.28 0 179.2 76.8 179.2 179.2 0 71.68-40.96 133.12-102.4 158.72l-5.12 5.12-81.92 281.6c-5.12 20.48-20.48 40.96-40.96 51.2l-5.12 5.12-25.6 15.36c-15.36 0-30.72 5.12-46.08 5.12H302.08c-15.36 0-30.72-5.12-40.96-10.24L235.52 896c-25.6-10.24-40.96-30.72-46.08-56.32l-81.92-281.6-5.12-5.12C46.08 527.36 5.12 471.04 0 404.48v-10.24c0-97.28 76.8-179.2 179.2-179.2 61.44 0 112.64 30.72 148.48 76.8l5.12 5.12c5.12 0 5.12 0 5.12-5.12l-5.12-10.24c0-10.24-5.12-20.48-5.12-35.84v-10.24C327.68 133.12 409.6 51.2 512 51.2zm0 102.4c-46.08 0-81.92 35.84-81.92 81.92 0 15.36 5.12 30.72 15.36 46.08l5.12 5.12c5.12 20.48 5.12 40.96-10.24 56.32-25.6 30.72-56.32 51.2-92.16 56.32h-5.12c-15.36 5.12-30.72 5.12-46.08 10.24-20.48 0-40.96-15.36-51.2-35.84v-10.24c-10.24-25.6-40.96-40.96-66.56-40.96-40.96 0-76.8 30.72-76.8 71.68 0 35.84 25.6 66.56 56.32 71.68h5.12c15.36 5.12 25.6 20.48 30.72 35.84l87.04 307.2 25.6 10.24h409.6l20.48-10.24 87.04-307.2c5.12-15.36 15.36-30.72 30.72-35.84h15.36c30.72-10.24 51.2-35.84 51.2-71.68 0-40.96-35.84-76.8-76.8-76.8-30.72 0-61.44 20.48-71.68 51.2v5.12c-5.12 20.48-25.6 35.84-46.08 35.84-15.36 0-30.72 0-46.08-5.12h-5.12c-35.84-10.24-66.56-30.72-92.16-56.32-15.36-15.36-15.36-40.96-5.12-61.44 10.24-15.36 15.36-30.72 15.36-46.08 0-51.2-35.84-87.04-81.92-87.04zM455.68 512c5.12 0 5.12 0 10.24 5.12L512 578.56l46.08-61.44c0-5.12 5.12-5.12 10.24-5.12h87.04c5.12 0 5.12 0 5.12 5.12v10.24L517.12 716.8h-10.24c-10.24-15.36-35.84-46.08-61.44-81.92l-15.36-20.48c-35.84-46.08-66.56-87.04-71.68-92.16 0 0-5.12-5.12 0-10.24s5.12 0 10.24 0h87.04z" fill="#e2b987"></path></svg>
                                                                    </use></svg>

                                                            </i>了解VIP会员特权 </a></li>
                                                    <li class="header-vippop-wrap"><a href="" class="header-vippop-item J-pop-item T-pop-item"><i class="qy20-header-icon qy20-header-svg qy20-header-gift-g"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-gift-g">
                                                                        <svg id="qy20-header-gift-g" title="领取VIP会员福利" viewBox="0 0 1024 1024"><path d="M714.189 111.002A102.4 102.4 0 0 1 857.6 204.8v76.851c0 8.807-1.126 17.408-3.226 25.6l67.226-.051a51.2 51.2 0 0 1 51.2 51.2v204.8a51.2 51.2 0 0 1-51.2 51.2h-.051l.051 307.2a51.2 51.2 0 0 1-51.2 51.2H153.6a51.2 51.2 0 0 1-51.2-51.2l-.051-307.2-5.94-.358A51.2 51.2 0 0 1 51.2 563.2V358.4a51.2 51.2 0 0 1 51.2-51.2l68.915.051a102.605 102.605 0 0 1-3.225-25.549v-76.85a102.4 102.4 0 0 1 143.41-93.85l184.116 80.435a103.761 103.761 0 0 1 17.306 9.728c5.222-3.738 11.008-7.015 17.203-9.728l184.064-80.435zM819.2 614.4H204.8v256h614.4v-256zm51.2-204.8H153.6V512h716.8V409.6zM270.49 204.8v76.902h175.974l-175.974-76.85zm484.71 0l-175.923 76.902H755.2v-76.85z" fill="#e2b987"></path></svg>
                                                                    </use></svg></i>领取VIP会员福利 </a></li>
                                                    <li class="header-vippop-wrap"><a href="" class="header-vippop-item J-pop-item T-pop-item"><i class="qy20-header-icon qy20-header-svg qy20-header-welfare-g"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-welfare-g">
                                                                        <svg id="qy20-header-welfare-g" title="做任务领奖励" viewBox="0 0 1024 1024"><path d="M921.6 0v766.464c0 29.184-22.938 52.736-51.2 52.736H0V52.736C0 23.552 22.938 0 51.2 0h870.4zM155.648 409.6H102.4v307.2h256V447.078a102.349 102.349 0 0 1-1.74-1.024 273.613 273.613 0 0 1-30.926 26.01 200.653 200.653 0 0 1-87.756 37.53l-12.135 1.69a42.291 42.291 0 0 1-8.14.716c-22.221-1.69-41.114-15.82-47.565-35.635-3.84-7.987-10.957-27.443-14.439-66.765zm497.664 59.034l-1.843 5.017c-8.909 26.522-31.744 41.78-56.576 37.683a248.115 248.115 0 0 1-96-35.942 297.677 297.677 0 0 1-36.506-29.338l-1.587.922V716.8h358.4V409.6H663.706c-2.56 30.618-7.066 48.947-10.445 59.034zm-412.62-173.108l-.462 3.38c-1.433 11.98-2.56 28.108-2.816 48.742l-.05 10.752c0 26.266 1.382 45.824 3.225 59.392l.717 4.864 1.28-.358c9.01-3.072 17.664-7.168 25.907-12.442l8.14-5.632c11.777-8.602 22.477-18.227 32.052-29.082a103.066 103.066 0 0 1 0-33.894 187.904 187.904 0 0 0-23.655-22.016l-9.779-7.168a161.024 161.024 0 0 0-30.31-15.104l-4.199-1.434zm337.1-1.433l-1.229.41c-12.032 4.095-23.398 10.086-34.048 18.124-11.776 8.55-22.477 18.176-32.051 29.03a103.066 103.066 0 0 1 0 33.895c7.322 8.09 15.36 15.514 23.706 22.067l9.779 7.168c9.42 6.042 19.61 11.11 30.361 15.104l3.738 1.28.512-3.481a434.176 434.176 0 0 0 3.072-47.616l.256-11.674c0-26.266-1.382-45.824-3.226-59.392l-.768-4.915zM358.4 102.4h-256v204.8h51.2l1.894.051c2.51-30.669 6.964-48.998 10.394-59.085l1.843-5.017c8.909-26.522 31.744-41.78 56.576-37.683a248.934 248.934 0 0 1 96 35.942 293.882 293.882 0 0 1 36.455 29.338c1.024-.717 2.15-1.332 3.276-1.997A49.152 49.152 0 0 1 358.4 256V102.4zm460.8 0H460.8V256c0 4.403-.512 8.704-1.587 12.8a112.64 112.64 0 0 1 3.328 1.946c9.523-9.319 19.917-18.023 30.925-26.01a200.653 200.653 0 0 1 87.756-37.53l12.135-1.638a42.189 42.189 0 0 1 8.14-.768c22.221 1.69 41.114 15.82 47.565 35.635 3.84 7.987 10.957 27.443 14.439 66.816l2.099-.051h153.6V102.4z" fill="#e2b987"></path></svg>
                                                                    </use></svg></i>做任务，领奖励 </a></li>
                                                    <li id="J-header-interact-wrap" class="header-vippop-wrap"><a href="" class="header-vippop-item J-pop-item"><img src="/images/NewVideo/vip_x.png" class="label-g label-home2020">星钻VIP享新权益 </a></li>
                                                </ul>
                                            </div>
                                            <div class="vippop-right">
                                                <div class="vipqrcode-title vipqrcode-first">
                                                    <span>连续包月超低优惠</span>
                                                </div>
                                                <div class="vipqrcode-title">扫码查看详情</div>
                                                <div class="vipqrcode-mid"><img src="/images/NewVideo/getIMG.jpg" alt="" class="vipqrcode-img"></div>
                                                <div class="vipqrcode-bot">建议微信或支付宝扫码<br>支付后刷新享会员权益</div>
                                            </div>
                                        </div>
                                        <div class="header-pop-button T-vipbtn-login">
                                            <a href="javascript:void(0);" class="qy-button-small J-cash-open">登录</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-sideItem qy-header__game">
                        <div class="T-drop-click">
                            <div class="T-icon-game">
                                <a href="" class="header-sideItemCon">
                                    <i class="qy-svgicon qy-svgicon-game"></i>
                                    <span class="header-sideItemTit">游戏</span>
                                </a>
                            </div>
                        </div>
                        <div class="qy-header-game-pop selected">
                            <div class="qy-popup-box">
                                <div class="popup-box-arrow"><span class="popup-box-arrowOut"><i class="popup-box-arrowIn"></i></span></div>
                                <div class="qy-header-gameCon">
                                    <ul class="header-gamepop">
                                        <li class="header-gamepop-item"><a href="" class="header-pop-link"><img src="/images/NewVideo/img03.jpg" alt="" class="game-img"></a></li>
                                        <li class="header-gamepop-item"><a href="" class="header-pop-link"><img src="/images/NewVideo/img03.jpg" alt="" class="game-img"></a></li>
                                    </ul>
                                    <div class="header-pop-button"><a href="" class="game-more">查看更多</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-sideItem header-upload">
                        <div class="T-drop-click">
                            <div  id="J-header-upload" class="J-header-upload">
                                <a  href="" class="header-sideItemCon">
                                    <i class="qy-svgicon qy-svgicon-upload"></i>
                                    <span class="header-sideItemTit">上传</span>
                                </a>
                            </div>
                        </div>
                        <div class="qy-header-upload-pop selected J-upload-pop">
                            <div class="qy-popup-box">
                                <div class="popup-box-arrow">
                                        <span class="popup-box-arrowOut">
                                            <i class="popup-box-arrowIn"></i>
                                        </span>
                                </div>
                                <div class="qy-header-uploadCon">
                                    <ul id="nav_uploadMenu" class="header-uploadpop J-special-con">
                                        <li class="header-uploadpop-item"><a href="" class="header-uploadpop-list"><i class="qy20-header-icon qy20-header-svg qy20-header-svg-videp"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-videp"><svg id="qy20-header-videp" viewBox="0 0 20 20"><g fill-rule="nonzero"><path d="M2 4v12h16V4H2zM1 2h18a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1z" opacity=".6"></path><path d="M9.844 6.168l.67.743a.5.5 0 0 1-.038.706l-2.972 2.676a.5.5 0 0 1-.706-.037l-.67-.743a.5.5 0 0 1 .037-.706l2.973-2.676a.5.5 0 0 1 .706.037zM10.5 6c.04 0 .08.005.117.014a.498.498 0 0 1 .379.133l2.925 2.728a.5.5 0 0 1 .025.706l-.682.732a.5.5 0 0 1-.707.024L11 8.885V13.5a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5h1z"></path></g></svg></use></svg></i>发布作品 </a></li>
                                        <li class="header-uploadpop-item"><a href="" class="header-uploadpop-list"><i class="qy20-header-icon qy20-header-svg qy20-header-svg-manage"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-manage"><svg id="qy20-header-manage" viewBox="0 0 20 20"><g fill-rule="nonzero"><path d="M19 5a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h18zm-1 2H2v9h16V7zm.5-5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-17a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h17z" opacity=".6"></path><path d="M9.502 13.876c-.476.253-1.088.107-1.366-.327A.846.846 0 0 1 8 13.092V9.908C8 9.407 8.447 9 8.999 9c.177 0 .35.043.503.124l3.002 1.592c.477.252.638.808.36 1.241a.959.959 0 0 1-.36.327l-3.002 1.592z"></path></g></svg></use></svg></i>作品管理 </a></li>
                                        <li class="header-uploadpop-item"><a href="" class="header-uploadpop-list"><i class="qy20-header-icon qy20-header-svg qy20-header-svg-mp"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-mp"><svg id="qy20-header-mp" viewBox="0 0 20 20"><g fill-rule="nonzero"><path d="M19 2a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1v-2h2v1h16V4H2v1H0V3a1 1 0 0 1 1-1h18z" opacity=".6"></path><path d="M1.5 10a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1zm0-3a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 7h1z" opacity=".6"></path><path d="M13.232 7.145l.574.568a.5.5 0 0 1 0 .71l-4.43 4.385a.502.502 0 0 1-.086.068l.064-.055a.5.5 0 0 1-.703 0l-2.503-2.476a.5.5 0 0 1-.003-.707l.003-.004.575-.569a.5.5 0 0 1 .703 0l1.58 1.564 3.523-3.484a.5.5 0 0 1 .703 0z"></path></g></svg></use></svg></i>爱奇艺号 </a></li>
                                        <li class="header-uploadpop-item"><a href="" class="header-uploadpop-list"><i class="qy20-header-icon qy20-header-svg qy20-header-svg-myspace"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-myspace"><svg id="qy20-header-myspace" viewBox="0 0 20 20"><g fill-rule="nonzero"><path d="M9.5 20a9.5 9.5 0 1 1 0-19 9.5 9.5 0 0 1 0 19zm0-2a7.5 7.5 0 1 0 0-15 7.5 7.5 0 0 0 0 15z" opacity=".6"></path><path d="M9.5 5a3.5 3.5 0 0 1 2.078 6.316 6.917 6.917 0 0 1 3.185 2.078.963.963 0 0 1-.11 1.373 1 1 0 0 1-1.395-.109 4.966 4.966 0 0 0-3.766-1.71 4.966 4.966 0 0 0-3.752 1.696 1 1 0 0 1-1.396.103.963.963 0 0 1-.105-1.373 6.93 6.93 0 0 1 3.178-2.062A3.5 3.5 0 0 1 9.5 5zm0 1.75a1.75 1.75 0 1 0 0 3.5 1.75 1.75 0 0 0 0-3.5z"></path></g></svg></use></svg></i>我的空间 </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-sideItem header-download">
                        <div class="T-drop-click">
                            <div class="header-sideItemCon J-download-title">
                                <div>
                                    <i class="qy-svgicon qy-svgicon-pca-dwn"></i>
                                    <span class="header-sideItemTit">客户端</span>
                                </div>
                            </div>
                        </div>
                        <div class="qy-header-download-pop selected J-download-pop">
                            <div class="qy-popup-box">
                                <div class="popup-box-arrow"><span class="popup-box-arrowOut"><i class="popup-box-arrowIn"></i></span></div>
                                <div class="qy-header-dlCon">
                                    <ul class="header-dlpop">
                                        <li class="header-dlpop-item"><a href="" class="header-pop-link J-download-item"><i class="qy20-header-icon qy20-header-svg qy20-header-svg-noad"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-noad"><svg id="qy20-header-noad" viewBox="0 0 20 20"><g fill-rule="nonzero"><path d="M12.5 7c1.38 0 2.5.96 2.5 2.143v.714C15 11.041 13.88 12 12.5 12h-2.083c-.23 0-.417-.16-.417-.357V7.357c0-.197.187-.357.417-.357H12.5zM8.184 7c.062 0 .121.014.173.038l.032.016.016.01a.35.35 0 0 1 .154.186l1.422 4.046c.066.186-.045.386-.246.447l-.73.219c-.201.06-.417-.042-.483-.228l-.169-.481H6.641l-.151.49c-.059.188-.271.297-.475.243l-.737-.195c-.204-.054-.321-.25-.263-.439l1.257-4.055.002-.014A.377.377 0 0 1 6.65 7h1.534zM12.5 8.429l-.834-.001v2.143h.834c.46 0 .833-.32.833-.714v-.714c0-.395-.373-.714-.833-.714zm-5.057.236l-.362 1.17h.774l-.412-1.17z"></path><path d="M10 19v-2.152c1.124 0 2.21-.292 3.2-.848l.8 1.939A8.127 8.127 0 0 1 10 19zm5.234-2L14 15.555A7.54 7.54 0 0 0 16.215 13l1.785.808A9.417 9.417 0 0 1 15.234 17zm3.527-5L17 11.589a7.25 7.25 0 0 0 .023-3.203L18.789 8a9.045 9.045 0 0 1-.028 4zM18 6.21L16.197 7A7.519 7.519 0 0 0 14 4.43L15.256 3A9.39 9.39 0 0 1 18 6.21zM14 2.07L13.196 4A6.508 6.508 0 0 0 10 3.146L10.004 1A8.142 8.142 0 0 1 14 2.069zM7.624 1L8 2.697A7.28 7.28 0 0 0 5.104 4L4 2.63A9.108 9.108 0 0 1 7.624 1zm-4.94 3L4 5.14A7.333 7.333 0 0 0 2.653 8L1 7.579A9.174 9.174 0 0 1 2.684 4zm-1.683 6l1.464.03v.118c0 1.08.184 2.125.535 3.081L1.67 14A11.184 11.184 0 0 1 1 10.148L1.001 10zM3 15.2L4.469 14A7.57 7.57 0 0 0 7 16.242L6.162 18A9.454 9.454 0 0 1 3 15.2zm5 3.53L8.403 17a6.147 6.147 0 0 0 1.597.216L9.994 19A7.68 7.68 0 0 1 8 18.73z" opacity=".6"></path></g></svg></use></svg></i>新用户广告特权 </a></li>
                                        <li class="header-dlpop-item"><a href="" class="header-pop-link J-download-item"><i class="qy20-header-icon qy20-header-svg qy20-header-svg-jisu"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-jisu"><svg id="qy20-header-jisu" viewBox="0 0 20 20"><g fill-rule="nonzero"><path d="M10 17a7 7 0 1 0 0-14 7 7 0 0 0 0 14zm0 2a9 9 0 1 1 0-18 9 9 0 0 1 0 18z" opacity=".6"></path><path d="M12.391 8.37c.43.117.692.591.585 1.06a.907.907 0 0 1-.149.33l-2.835 3.907a.76.76 0 0 1-1.129.145.914.914 0 0 1-.294-.83l.263-1.705-1.153-.198c-.439-.075-.738-.522-.67-.999a.913.913 0 0 1 .166-.409l2.45-3.342a.76.76 0 0 1 1.129-.138.905.905 0 0 1 .302.683v1.133l1.335.363z"></path></g></svg></use></svg></i>极速流畅播放 </a></li>
                                        <li class="header-dlpop-item"><a href="" class="header-pop-link J-download-item"><i class="qy20-header-icon qy20-header-svg qy20-header-svg-1080p"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-1080p"><svg id="qy20-header-1080p" viewBox="0 0 20 20"><g fill-rule="nonzero"><path d="M13.5 7C14.88 7 16 8.151 16 9.571v.858C16 11.849 14.88 13 13.5 13h-2.083a.423.423 0 0 1-.417-.429V7.43c0-.237.187-.429.417-.429H13.5zM5.25 7c.23 0 .417.192.417.429L5.666 9.57h1.667V7.429c0-.237.187-.429.417-.429h.833c.23 0 .417.192.417.429v5.142a.423.423 0 0 1-.417.429H7.75a.423.423 0 0 1-.417-.429v-1.286H5.666v1.286A.423.423 0 0 1 5.25 13h-.833A.423.423 0 0 1 4 12.571V7.43C4 7.192 4.187 7 4.417 7h.833zm8.25 1.714h-.834v2.571h.834c.46 0 .833-.383.833-.856V9.57a.845.845 0 0 0-.833-.857z"></path><path d="M2 5.828V16h12.172L18 14.172V4H5.828L2 5.828zM5.414 2H19a1 1 0 0 1 1 1v11.586a1 1 0 0 1-.293.707l-4.414 2.414a1 1 0 0 1-.707.293H1a1 1 0 0 1-1-1V5.414a1 1 0 0 1 .293-.707l4.414-2.414A1 1 0 0 1 5.414 2z" opacity=".6"></path></g></svg></use></svg></i>畅享4K视频 </a></li>
                                    </ul>
                                    <div class="header-pop-button"><a href="javascript:void(0);" id="J-download-experienceNow" class="qy-button-small">立即体验</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-sideItem header-info">
                        <a href="" class="header-sideItemCon J-message-title">
                            <i class="qy-svgicon qy-svgicon-info"></i>
                            <span class="header-sideItemTit">消息</span>
                        </a>
                        <div class="qy-header-info-pop selected J-message-pop">
                            <div class="qy-popup-box">
                                <div class="popup-box-arrow"><span class="popup-box-arrowOut"><i class="popup-box-arrowIn"></i></span></div>
                                <div class="qy-header-info-inner">
                                    <div class="header-info-tab">
                                        <ul class="header-info-tab-list">
                                            <li class="header-info-tab-item J-tab-title selected T-tab-title-0"><a href="javascript:;" class="header-info-tab-title"> 更新提醒 <em class="header-info-tab-selected"></em></a></li>
                                            <li class="header-info-tab-item J-tab-title T-tab-title-1"><a href="javascript:;" class="header-info-tab-title"> 与我相关 <em class="header-info-tab-selected"></em></a></li>
                                            <li class="header-info-tab-item J-tab-title T-tab-title-2"><a href="javascript:;" class="header-info-tab-title"> 系统通知 <em class="header-info-tab-selected"></em></a></li>
                                        </ul>
                                    </div>
                                    <div class="header-info-main">
                                        <div class="header-info-item header-info-order T-tab-body-0" style="">
                                            <div>
                                                <div class="header-pop-no-wrap has-btn">
                                                    <p class="header-pop-no-tips">追剧更新立即通知，从不错过</p>
                                                    <div class="btn-box">
                                                        <a href="javascript:void(0)" class="qy-button-small info-btn">登录</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="header-related-list"></ul>
                                        </div>
                                        <div class="header-info-item header-info-related T-tab-body-1 dn"></div>
                                        <div class="header-info-item header-info-related T-tab-body-2 dn"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-sideItem header-record">
                        <div class="T-drop-click">
                            <a href="" class="header-sideItemCon T-history-icon">
                                <i class="qy-svgicon qy-svgicon-record"></i>
                                <span class="header-sideItemTit">看过</span>
                            </a>
                        </div>
                        <div class="J-header-play-history-dropdown-wrap qy-header-record-pop-v1 selected">
                            <div class="qy-popup-box">
                                <div class="popup-box-arrow"><span class="popup-box-arrowOut"><i class="popup-box-arrowIn"></i></span></div>
                                <div class="qy-header-record-inner">
                                    <div style="">
                                        <div class="header-record-filter">
                                            过滤短视频
                                            <i id="J-header-play-history-filter-icon" class="switch selected"></i>
                                        </div>
                                        <div class="header-pop-no-wrap header-record-no-item has-btn">
                                            <i class="qy20-header-png icon-home2020 icon-home2020__empty"></i>
                                            <p class="header-pop-no-tips">您还没有观看任何长视频哦</p>
                                            <div class="btn-box T-history-unlogin-null">
                                                <a href="javascript:void(0)" class="qy-button-small record-btn">登录</a>
                                            </div>
                                        </div>
                                        <div class="header-record-main J-header-history-scrollwrap">
                                            <div class="header-pop-button-bottom">
                                                <a class="bottom-link T-history-more-unlogin">登录查看更多</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-sideItem header-user">
                        <div class="T-drop-hover">
                            <div class="T-drop-click">
                                <div class="header-sideItemCon">
                                    <a class="header-userLink"><img src="/images/NewVideo/header-userImg-default-dark.png" alt="" class="header-userImg"></a>
                                    <span class="header-sideItemTit T-icon-txt">登录</span><i class="qy-common-icon qy-common-msgdot"></i>
                                </div>
                            </div>
                            <div class="qy-header-login-pop-v1 selected">
                                <div id="nav_userBox" class="">
                                    <div>
                                        <div class="qy-popup-box">
                                            <div class="popup-box-arrow"><span class="popup-box-arrowOut"><i class="popup-box-arrowIn"></i></span></div>
                                            <div class="login-top">
                                                <div class="img-box"><a href="javascript:void(0);" class="img-link"><img src="/images/NewVideo/header-userImg-default-dark.png" class="avatar-img"></a></div>
                                                <div class="title">
                                                    <a class="user-link">登录</a><i class="slash">/</i>
                                                    <a class="user-link">注册</a><span class="user-txt">后，你可以：</span>
                                                </div>
                                                <div class="right">
                                                    <a href="javascript:void(0)" class="qy-button-small login-btn"> 登录 </a>
                                                </div>
                                            </div>
                                            <ul class="login-top-list">
                                                <li class="login-top-item">
                                                    <a href="" class="login-top-link">
                                                        <div class="item-left">
                                                            <i class="login-pop-icon qy20-header-svg qy20-header-svg-user-record"><svg aria-hidden="true" class="qy20-header-symbol"></svg><svg id="qy20-header-login-record" viewBox="0 0 24 24"><g fill-rule="evenodd"><path d="M5.101 2.183a12.17 12.17 0 0 0-3.053 3.111l1.656 1.122a10.17 10.17 0 0 1 2.551-2.6L5.101 2.184zM.972 7.256c-.58 1.34-.908 2.78-.964 4.26l2 .076a9.841 9.841 0 0 1 .8-3.543L.972 7.256zm-.847 6.44c.213 1.46.695 2.857 1.417 4.132l1.74-.986a9.845 9.845 0 0 1-1.178-3.435l-1.98.288zm2.667 5.934a12.211 12.211 0 0 0 3.351 2.785l.984-1.741a10.211 10.211 0 0 1-2.802-2.329L2.792 19.63zm5.326 3.68a12.33 12.33 0 0 0 4.036.69l.302-.003-.04-2-.258.003a10.326 10.326 0 0 1-3.38-.578l-.66 1.888zm6.502.453c1.363-.271 2.66-.77 3.844-1.47l-1.018-1.72A10.229 10.229 0 0 1 14.23 21.8l.39 1.962zM12.228 0C18.73 0 24 5.274 24 11.779a11.77 11.77 0 0 1-5.392 9.9l-.28.176-1.038-1.71A9.772 9.772 0 0 0 22 11.78C22 6.378 17.625 2 12.228 2c-.967 0-1.915.14-2.82.413l-.247.08-.56.421-1.202-1.599L8.218.7l.147-.05A11.75 11.75 0 0 1 12.228 0z" fill-rule="nonzero"></path><path d="M10.624 6a.637.637 0 0 0-.624.65v5.204c0 .153.051.293.133.404l.014.022 2.643 4.414a.61.61 0 0 0 .86.207l1.056-.69a.664.664 0 0 0 .199-.895l-2.411-4.029V6.65c0-.36-.28-.65-.623-.65h-1.247z"></path></g></svg></i>
                                                        </div>
                                                        <div class="item-right">
                                                            <p class="des-1">多端记录同步</p><p class="des-2">各端尽情看，记录永相随</p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="login-top-item">
                                                    <a href="" class="login-top-link">
                                                        <div class="item-left">
                                                            <i class="login-pop-icon qy20-header-svg qy20-header-svg-user-gift"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-login-gift"><svg id="qy20-header-login-gift" viewBox="0 0 24 24"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10m0 2C5.374 24 0 18.627 0 12S5.374 0 12 0s12 5.373 12 12-5.374 12-12 12m.938-9.995h2.512c.322 0 .582.264.582.59v.792c0 .326-.26.59-.582.59h-2.512v2.433c0 .326.052.59-.27.59H11.59a.585.585 0 0 1-.582-.59v-2.432H8.591a.587.587 0 0 1-.582-.591v-.793c0-.325.261-.589.582-.589h2.417V13H8.591a.585.585 0 0 1-.582-.59v-.778c0-.327.261-.591.582-.591h2.417L7.632 7.659a.596.596 0 0 1 .071-.83l.77-.691a.575.575 0 0 1 .817.072L12 9.468l2.616-3.258a.575.575 0 0 1 .818-.072l.735.565c.244.209.277.58.07.831l-3.301 3.507h2.512c.322 0 .582.264.582.59v.779c0 .327-.26.59-.582.59h-2.512v1.005z" fill-rule="evenodd"></path></svg></use></svg></i>
                                                        </div>
                                                        <div class="item-right">
                                                            <p class="des-1">积分兑换礼品</p><p class="des-2">只要积分够，好礼随便送</p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="login-top-item">
                                                    <a href="" class="login-top-link">
                                                        <div class="item-left">
                                                            <i class="login-pop-icon qy20-header-svg qy20-header-svg-user-barrage"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-login-barrage"><svg id="qy20-header-login-barrage" viewBox="0 0 24 24"><path d="M7 7c-.76 0-1 .224-1 .667v.666C6 8.776 6.24 9 7 9h11c.76 0 1-.224 1-.667v-.666C19 7.224 18.76 7 18 7H7zm0 5c-.775 0-1 .336-1 1 0 .665.225 1 1 1h5c.776 0 1-.335 1-1 0-.664-.224-1-1-1H7zm10 6v2.929L13 18H2V3h20v15h-5zM2 1C.831 1 0 1.829 0 3v16c0 .554.831 1.384 2 1h10l6 4c.894 0 1.419-.415 1-1v-3h3c1.169.384 2-.446 2-1V3c0-1.171-.831-2-2-2H2z" fill-rule="evenodd"></path></svg></use></svg></i>
                                                        </div>
                                                        <div class="item-right">
                                                            <p class="des-1">弹幕 · 评论</p><p class="des-2">分享你的想法</p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="login-top-item">
                                                    <a href="" class="login-top-link">
                                                        <div class="item-left">
                                                            <i class="login-pop-icon qy20-header-svg qy20-header-svg-user-collect"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-login-collect"><svg id="qy20-header-login-collect" viewBox="0 0 24 24"><path d="M2 17h20V3H2v14zM1.301 1C.582 1 0 1.567 0 2.267v15.466C0 18.433.582 19 1.301 19H22.7c.719 0 1.3-.568 1.3-1.267V2.267C24 1.567 23.419 1 22.7 1H1.301zm4.364 20c-.367 0-.665.224-.665.5v1c0 .276.298.5.665.5h12.668c.369 0 .667-.224.667-.5v-1c0-.276-.298-.5-.667-.5H5.665zm3.75-7.32c.139.137.343.164.511.087a.455.455 0 0 0 .153-.1l7.627-6.263a.445.445 0 0 0 0-.636l-.642-.636a.457.457 0 0 0-.642 0L9.74 11.457 7.42 8.475a.459.459 0 0 0-.644 0l-.643.637a.446.446 0 0 0 0 .636l3.282 3.932z" fill-rule="evenodd"></path></svg></use></svg></i>
                                                        </div>
                                                        <div class="item-right">
                                                            <p class="des-1">精彩剧情及时追</p><p class="des-2">追看你的喜爱</p>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                            <div class="c"></div>
                            <div class="player-mnb">
                                <div class="player-mnb-left">
                                    <div class="qy-flash-func qy-flash-func-v1">
<!--                                        <div class="func-item func-comment">-->
<!--                                            <div class="func-inner">-->
<!--                                                <i class="qy-svgicon qy-svgicon-comment-v1"><i class="bubble b1"></i><i class="bubble b2"></i><i class="bubble b3"></i></i>-->
<!--                                                <span class="func-name">9844</span>-->
<!--                                            </div>-->
<!--                                        </div>-->
                                        <div class="func-item func-like-v1">
                                            <div class="func-inner">
                                                <span class="like-icon-box"><i title="" class="qy-svgicon qy-svgicon-dianzan"></i><i title="" class="like-heart-steps"></i></span>
                                                <span class="func-name"><?= $data['info']['total_views']?></span>
                                            </div>
                                        </div>
                                        <div class="func-item func-collect">
                                            <a href="javascript:void(0)" class="qy-func-collect-v1">
                                                <span class="collect">
                                                    <i class="qy-svgicon qy-svgicon-collect"></i>
                                                    <span class="txt">收藏</span>
                                                </span>
                                                <span class="collected" style="display: none;">
                                                    <i class="qy-svgicon qy-svgicon-collected"></i>
                                                    <span class="txt">已收藏</span>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="player-mnb-mid">

                                </div>
                                <div class="player-mnb-right">
                                    <div class="qy-flash-func qy-flash-func-v1">
                                        <div class="func-item func-download">
                                            <div title="下载" class="func-inner"><span class="qy-play-icon func-dwn-icon"></span></div>
                                            <div class="qy-func-toast-v1 qy-func-toast-v2" style="display: none;">
                                                正在检测客户端
                                            </div>
                                        </div>
                                    </div>
                                    <div class="func-item func-more">
                                        <div class="func-inner"><i class="func-more-icon"><i class="more-dot"></i></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="player-sd">
                        <div class="player-sdc">
                            <div class="qy-player-side-loading" style="display: none;">
                                <img src="images/con-loading-black.gif" alt="正在加载" class="loading-img">
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
                                <div class="qy-player-side-body v_scroll_plist_bc" style="height: 655px;">
                                    <div class="body-inner">
                                        <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
                                            <div class="padding-box">
                                                <div class="qy-episode-update">
                                                    <p class="update-tip">
                                                        更新至<?= count($data['info']['videos'])?>集
                                                    </p>
                                                </div>
                                                <div>
                                                    <ul class="qy-episode-num">
                                                        <?php foreach ($data['info']['videos'] as $value) : ?>
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
                                                        <?php endforeach;?>
                                                    </ul>
                                                </div>
                                                <div class="c"></div>
                                            </div>
                                        </div>
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
    <div class="qy-play-container">
        <div class="qy-play-con">
            <div class="play-con-mn">
                <div class="play-con-mnc">
                    <div>
                        <div class="qy-mod-wrap">
                            <div id="comment">
                                <div class="qy-comment-page qy-comment-aura3">
                                    <div class="qycp-wrap">
                                        <div class="csPpFeed_hd">
                                            <h3 class="csPpFeed_hd_tab">
                                                评论<span class="hd_tab_num">（<i >9847</i>）</span>
                                            </h3>
                                            <a href="" class="csPp_square_entry"></a>
                                        </div>
                                        <div class="qycp-bd">
                                            <div class="qycp-loaded">
                                                <div class="qy-comment-form">
                                                    <div class="section-hd">
                                                        <a href="javascript:;" class="section-avatar">
                                                            <img src="images/header-userImg-default.png" class="avatar-img">
                                                        </a>
                                                    </div>
                                                    <div class="comment-form">
                                                        <div class="form-textwrap">
                                                            <textarea cols="1" rows="1" placeholder="来说两句吧~" class="form-textarea" data-commetn-ele="emojiInput" data-comment-ele="pubTxtBox" rseat="80521_comment_input"></textarea>
                                                        </div>
                                                        <div class="form-opt">
                                                            <a href="javascript:;" class="form-pushbtn" data-comment-ele="pubSendBtn">发布</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="feedList">
                                                    <div class="hotWrap">
                                                        <div class="qycp-block__title">
                                                            精彩评论<span class="qycp-block__num qy-comment-num">（<i>51</i>）</span>
                                                        </div>
                                                        <div class="hotFeedList">
                                                            <!-- 一条完整评论 -->
                                                            <div class="qy-comment-con">
                                                                <div class="comment-section">
                                                                    <div class="section-hd">
                                                                        <a href="" class="section-avatar">
                                                                            <img width="54" height="54" class="avatar-img"src="images/passport_1408918274_149277076163127_130_130.jpg">
                                                                            <i class="qy-comment-icons icon-star"></i>
                                                                        </a>
                                                                    </div>
                                                                    <div class="section-bd">
                                                                        <div class="comment-title">
                                                                            <div class="comment-info">
                                                                                <a href="" class="comment-author orange">曾舜晞</a>
                                                                                <span class="comment-label">明星</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="comment-subject">
                                                                            <span>参演《终极笔记》让我学到了很多东西，希望大家看完之后会喜欢这个吴邪哦！</span>
                                                                        </div>
                                                                        <div class="comment-image">
                                                                            <img alt="" class="comment-thumbnail zoomIn" src="images/ppcd_2843377118945921_pp_601_150_150.jpg">
                                                                        </div>
                                                                        <div class="comment-ft comment-ft__normal">
                                                                            <div class="comment-ft__rt">
                                                                                <span class="comment-time">12-10</span>
                                                                                <a href="javascript:;" class="comment-ft-btn " ><i class="qy-svgicon qy-svgicon-dianzan"></i><i class="qy-comment-icons icon-dianzan"></i><span class="comment-ft-text"><em data-comment-agreecnt="4334">4334</em></span></a>
                                                                                <a href="" class="comment-ft-btn ">
                                                                                    <i class="qy-svgicon qy-svgicon-comment"></i><span class="comment-ft-text"><em data-comment-commentcnt="400"></em></span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <!-- 评论列表 start-->
                                                                        <div class="comment-c">
                                                                            <div class="replyListwrap">
                                                                                <!--  -->
                                                                                <div class="comment-c-itemwrap" >
                                                                                    <div class="section-hd">
                                                                                        <a href="" class="section-avatar" >
                                                                                            <img width="32" height="32" src="images/passport_1408918274_149277076163127_130_130.jpg" class="avatar-img">
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="comment-c-item">
                                                                                        <div class="comment-c-subject">
                                                                                            <a href="">三石梦旅</a>
                                                                                            <img class="rank-vip-img" src="images/65cd8fc927d04d628565f2bf6b689589.png">
                                                                                            <span class="comment-c-reply">回复</span>
                                                                                            <a href="javascript:;" class="comment-c-replyer">meng9307112011</a>
                                                                                            <span class="comment-c-text">：
                                                                                                    <span>看了第一部，第二部没看，本来想养养再看，结果忘了。重启还真没失望，全是演技在线的明星演的。朱一龙，毛晓彤，陈明昊，胡军，乔振宇。怎么可能会有失望？可能重启应该算是网剧当中明星阵容最豪华的一部的话。</span>
                                                                                                </span>
                                                                                        </div>
                                                                                        <div class="comment-ft comment-ft__medium comment-ft__normal">
                                                                                            <div class="comment-ft__lt">
                                                                                                <span class="comment-ft__time comment-ft-text">6分钟前</span>
                                                                                            </div>
                                                                                            <div class="comment-ft__rt">
                                                                                                <a href="javascript:;" class="comment-ft-btn  ">
                                                                                                    <i class="qy-svgicon qy-svgicon-dianzan"></i>
                                                                                                    <i class="qy-comment-icons icon-dianzan"></i>
                                                                                                    <span class="comment-ft-text"><em></em></span>
                                                                                                </a>
                                                                                                <a href="javascript:;" class="comment-ft-btn " data-reply-ele="replyBtn">
                                                                                                    <i class="qy-svgicon qy-svgicon-comment"></i>
                                                                                                    <span class="comment-ft-text 6分钟前"><em></em></span>
                                                                                                </a>
                                                                                                <a href="javascript:;" class="comment-ft-btn comment-ft-btn__dn"><i class="qy-svgicon qy-svgicon-report"></i><span class="comment-ft-text">举报</span></a>
                                                                                                <a href="javascript:;" class="comment-ft-btn comment-ft-btn__dn dn"><i class="qy-svgicon qy-svgicon-trashcan"></i><span class="comment-ft-text">删除</span></a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="qy-comment-input small dn"></div>
                                                                                    </div>
                                                                                </div>
                                                                                <!--  -->
                                                                                <!--  -->
                                                                                <div class="comment-c-itemwrap" >
                                                                                    <div class="section-hd">
                                                                                        <a href="" class="section-avatar" >
                                                                                            <img width="32" height="32" src="images/passport_1408918274_149277076163127_130_130.jpg" class="avatar-img">
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="comment-c-item">
                                                                                        <div class="comment-c-subject">
                                                                                            <a href="">三石梦旅</a>
                                                                                            <img class="rank-vip-img" src="images/65cd8fc927d04d628565f2bf6b689589.png">
                                                                                            <span class="comment-c-reply">回复</span>
                                                                                            <a href="javascript:;" class="comment-c-replyer">meng9307112011</a>
                                                                                            <span class="comment-c-text">：
                                                                                                    <span>看了第一部，第二部没看，本来想养养再看，结果忘了。重启还真没失望，全是演技在线的明星演的。朱一龙，毛晓彤，陈明昊，胡军，乔振宇。怎么可能会有失望？可能重启应该算是网剧当中明星阵容最豪华的一部的话。</span>
                                                                                                </span>
                                                                                        </div>
                                                                                        <div class="comment-ft comment-ft__medium comment-ft__normal">
                                                                                            <div class="comment-ft__lt">
                                                                                                <span class="comment-ft__time comment-ft-text">6分钟前</span>
                                                                                            </div>
                                                                                            <div class="comment-ft__rt">
                                                                                                <a href="javascript:;" class="comment-ft-btn  ">
                                                                                                    <i class="qy-svgicon qy-svgicon-dianzan"></i>
                                                                                                    <i class="qy-comment-icons icon-dianzan"></i>
                                                                                                    <span class="comment-ft-text"><em></em></span>
                                                                                                </a>
                                                                                                <a href="javascript:;" class="comment-ft-btn " data-reply-ele="replyBtn">
                                                                                                    <i class="qy-svgicon qy-svgicon-comment"></i>
                                                                                                    <span class="comment-ft-text 6分钟前"><em></em></span>
                                                                                                </a>
                                                                                                <a href="javascript:;" class="comment-ft-btn comment-ft-btn__dn"><i class="qy-svgicon qy-svgicon-report"></i><span class="comment-ft-text">举报</span></a>
                                                                                                <a href="javascript:;" class="comment-ft-btn comment-ft-btn__dn dn"><i class="qy-svgicon qy-svgicon-trashcan"></i><span class="comment-ft-text">删除</span></a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="qy-comment-input small dn"></div>
                                                                                    </div>
                                                                                </div>
                                                                                <!--  -->
                                                                                <div class="comment-c-itemwrap comment-c-fold">
                                                                                    <div class="comment-c-item">
                                                                                        剩余<em>403</em>条回复，<a href="javascript:;" class="fold">点击查看</a>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- 评论列表 end-->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- 一条完整评论 -->
                                                            <!-- 一条完整评论 -->
                                                            <div class="qy-comment-con">
                                                                <div class="comment-section">
                                                                    <div class="section-hd">
                                                                        <a href="" class="section-avatar">
                                                                            <img width="54" height="54" class="avatar-img"src="images/passport_1408918274_149277076163127_130_130.jpg">
                                                                            <i class="qy-comment-icons icon-star"></i>
                                                                        </a>
                                                                    </div>
                                                                    <div class="section-bd">
                                                                        <div class="comment-title">
                                                                            <div class="comment-info">
                                                                                <a href="" class="comment-author orange">曾舜晞</a>
                                                                                <span class="comment-label">明星</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="comment-subject">
                                                                            <span>参演《终极笔记》让我学到了很多东西，希望大家看完之后会喜欢这个吴邪哦！</span>
                                                                        </div>
                                                                        <div class="comment-image">
                                                                            <img alt="" class="comment-thumbnail zoomIn" src="images/ppcd_2843377118945921_pp_601_150_150.jpg">
                                                                        </div>
                                                                        <div class="comment-ft comment-ft__normal">
                                                                            <div class="comment-ft__rt">
                                                                                <span class="comment-time">12-10</span>
                                                                                <a href="javascript:;" class="comment-ft-btn " ><i class="qy-svgicon qy-svgicon-dianzan"></i><i class="qy-comment-icons icon-dianzan"></i><span class="comment-ft-text"><em data-comment-agreecnt="4334">4334</em></span></a>
                                                                                <a href="" class="comment-ft-btn ">
                                                                                    <i class="qy-svgicon qy-svgicon-comment"></i><span class="comment-ft-text"><em data-comment-commentcnt="400"></em></span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <!-- 评论列表 start-->
                                                                        <div class="comment-c">
                                                                            <div class="replyListwrap">
                                                                                <!--  -->
                                                                                <div class="comment-c-itemwrap" >
                                                                                    <div class="section-hd">
                                                                                        <a href="" class="section-avatar" >
                                                                                            <img width="32" height="32" src="images/passport_1408918274_149277076163127_130_130.jpg" class="avatar-img">
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="comment-c-item">
                                                                                        <div class="comment-c-subject">
                                                                                            <a href="">三石梦旅</a>
                                                                                            <img class="rank-vip-img" src="images/65cd8fc927d04d628565f2bf6b689589.png">
                                                                                            <span class="comment-c-reply">回复</span>
                                                                                            <a href="javascript:;" class="comment-c-replyer">meng9307112011</a>
                                                                                            <span class="comment-c-text">：
                                                                                                    <span>看了第一部，第二部没看，本来想养养再看，结果忘了。重启还真没失望，全是演技在线的明星演的。朱一龙，毛晓彤，陈明昊，胡军，乔振宇。怎么可能会有失望？可能重启应该算是网剧当中明星阵容最豪华的一部的话。</span>
                                                                                                </span>
                                                                                        </div>
                                                                                        <div class="comment-ft comment-ft__medium comment-ft__normal">
                                                                                            <div class="comment-ft__lt">
                                                                                                <span class="comment-ft__time comment-ft-text">6分钟前</span>
                                                                                            </div>
                                                                                            <div class="comment-ft__rt">
                                                                                                <a href="javascript:;" class="comment-ft-btn  ">
                                                                                                    <i class="qy-svgicon qy-svgicon-dianzan"></i>
                                                                                                    <i class="qy-comment-icons icon-dianzan"></i>
                                                                                                    <span class="comment-ft-text"><em></em></span>
                                                                                                </a>
                                                                                                <a href="javascript:;" class="comment-ft-btn " data-reply-ele="replyBtn">
                                                                                                    <i class="qy-svgicon qy-svgicon-comment"></i>
                                                                                                    <span class="comment-ft-text 6分钟前"><em></em></span>
                                                                                                </a>
                                                                                                <a href="javascript:;" class="comment-ft-btn comment-ft-btn__dn"><i class="qy-svgicon qy-svgicon-report"></i><span class="comment-ft-text">举报</span></a>
                                                                                                <a href="javascript:;" class="comment-ft-btn comment-ft-btn__dn dn"><i class="qy-svgicon qy-svgicon-trashcan"></i><span class="comment-ft-text">删除</span></a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="qy-comment-input small dn"></div>
                                                                                    </div>
                                                                                </div>
                                                                                <!--  -->
                                                                                <!--  -->
                                                                                <div class="comment-c-itemwrap" >
                                                                                    <div class="section-hd">
                                                                                        <a href="" class="section-avatar" >
                                                                                            <img width="32" height="32" src="images/passport_1408918274_149277076163127_130_130.jpg" class="avatar-img">
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="comment-c-item">
                                                                                        <div class="comment-c-subject">
                                                                                            <a href="">三石梦旅</a>
                                                                                            <img class="rank-vip-img" src="images/65cd8fc927d04d628565f2bf6b689589.png">
                                                                                            <span class="comment-c-reply">回复</span>
                                                                                            <a href="javascript:;" class="comment-c-replyer">meng9307112011</a>
                                                                                            <span class="comment-c-text">：
                                                                                                    <span>看了第一部，第二部没看，本来想养养再看，结果忘了。重启还真没失望，全是演技在线的明星演的。朱一龙，毛晓彤，陈明昊，胡军，乔振宇。怎么可能会有失望？可能重启应该算是网剧当中明星阵容最豪华的一部的话。</span>
                                                                                                </span>
                                                                                        </div>
                                                                                        <div class="comment-ft comment-ft__medium comment-ft__normal">
                                                                                            <div class="comment-ft__lt">
                                                                                                <span class="comment-ft__time comment-ft-text">6分钟前</span>
                                                                                            </div>
                                                                                            <div class="comment-ft__rt">
                                                                                                <a href="javascript:;" class="comment-ft-btn  ">
                                                                                                    <i class="qy-svgicon qy-svgicon-dianzan"></i>
                                                                                                    <i class="qy-comment-icons icon-dianzan"></i>
                                                                                                    <span class="comment-ft-text"><em></em></span>
                                                                                                </a>
                                                                                                <a href="javascript:;" class="comment-ft-btn " data-reply-ele="replyBtn">
                                                                                                    <i class="qy-svgicon qy-svgicon-comment"></i>
                                                                                                    <span class="comment-ft-text 6分钟前"><em></em></span>
                                                                                                </a>
                                                                                                <a href="javascript:;" class="comment-ft-btn comment-ft-btn__dn"><i class="qy-svgicon qy-svgicon-report"></i><span class="comment-ft-text">举报</span></a>
                                                                                                <a href="javascript:;" class="comment-ft-btn comment-ft-btn__dn dn"><i class="qy-svgicon qy-svgicon-trashcan"></i><span class="comment-ft-text">删除</span></a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="qy-comment-input small dn"></div>
                                                                                    </div>
                                                                                </div>
                                                                                <!--  -->
                                                                                <div class="comment-c-itemwrap comment-c-fold">
                                                                                    <div class="comment-c-item">
                                                                                        剩余<em>403</em>条回复，<a href="javascript:;" class="fold">点击查看</a>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- 评论列表 end-->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- 一条完整评论 -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="qycp-form-fixed">
                                        <div class="comment-btn-fixed">
                                                <span class="btn-fixed">
                                                    <i class="qy-comment-icons icon-comment-fixed"></i>写评论
                                                </span>
                                        </div>
                                        <div>
                                            <div class="qy-comment-form noHd fixed">
                                                <div class="comment-form">
                                                    <div class="form-textwrap">
                                                        <textarea placeholder="来说两句吧~" class="form-textarea"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-opt">
                                                    <a href="javascript:;" class="form-pushbtn" data-comment-ele="pubSendBtn">发布</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                        <a href="<?= Url::to(['/video/new-detail', 'video_id' => $list['video_id']])?>" class="rank-item-link">
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
    <div class="qy-scroll-anchor">
        <ul class="scroll-anchor">
            <li class="anchor-list anchor-integral">
                <div class="qy-scroll-integral popBox dn">
                    <span class="tianjia-arrow"></span>
                    <img src="images/ewm.png" alt="">
                </div>
                <a href="javascript:;" class="anchor-item j-pannel"><i class="qy-svgicon qy-svgicon-anchorIntegral j-pannel"></i><i class="dot j-pannel"></i></a>
            </li>
            <li class="anchor-list anchor-tianjia">
                <div class="qy-scroll-tianjia popBox dn">
                    <span class="tianjia-arrow"></span>
                    <div class="tianjia-con">
                        <p class="tianjia-text">添加
                            <span class="tianjia-link">“爱奇艺网页应用”</span>
                            <br>硬核内容全网独播~
                        </p>
                        <a href="javascript:;" class="tianjia-btn">立即添加</a>
                    </div>
                </div>
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
