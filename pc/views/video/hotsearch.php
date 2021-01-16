<?php
use yii\helpers\Url;
use pc\assets\StyleInAsset;

$this->title = '瓜子TV-澳新华人在线视频分享网站';
StyleInAsset::register($this);

$js = <<<JS
$(function(){
    
    $('.category-class').each(function(index, el) {
        $(this).find('.category-more').click(function(event) {
            var _txt = $(this).find('em').text();
            if( _txt == '更多'){
                $(this).find('em').text('收起');
                $(this).find('.qy-svgicon-guide-narrow-up').show();
                $(this).find('.qy-svgicon-guide-narrow').hide();
            }else{
                $(this).find('em').text('更多');
                $(this).find('.qy-svgicon-guide-narrow-up').hide();
                $(this).find('.qy-svgicon-guide-narrow').show();
            }
            $(this).parents('.qy-list-category .category-class').toggleClass('actived');
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
    
    $('.qy-mod-li').each(function() {
        $(this).find('.qy-mod-link-wrap').hover(function() {
            
            $('.qy-mod-li').find('.qy-video-card-small').removeClass('card-hover')
            var card = $(this).parents('.qy-mod-li').find('.qy-video-card-small')
            card.toggleClass('card-hover');
            return false;
        });
    });
    $('.qy-mod-li').mouseleave(function(event) {
        $('.qy-mod-li').find('.qy-video-card-small').removeClass('card-hover')
    });
    $('.backToTop').click(function() {
        $('html,body').stop(true, false).animate({
            scrollTop: 0
        })
    });
    
    $('.anchor-list').each(function(index, el) {
        $(this).hover(function() {
            $(this).find('.popBox').show();
        }, function() {
            $(this).find('.popBox').hide();
        });
    });
});
JS;

$this->registerJs($js);
?>

<head>
    <meta charset="UTF-8">
    <title>热搜榜</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
</head>
<body style="background-color:#fff;" class="classBody">
<header class="qy-header home2020 aura2">
    <div class="header-wrap">
        <div class="header-inner">
            <div id="nav_logo" class="qy-logo">
                <a href="/video/index" class="logo-link" title="瓜子视频">
                    <img src="/images/NewVideo/logo.png" alt="">瓜子视频</a>
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
                <?php foreach ($data['tab'] as $key => $tab): ?>
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
<div class="qy-list-page">
    <div class="qy-top-page">
        <div class="ban" style="background-image: url(../images/NewVideo//ban1.png);"></div>
        <div class="container">
            <div class="qy-top-tab-box">
                <ul class="qy-top-tab">
                    <li class="tab-item">
                        <a href="<?= Url::to(['hot-play'])?>" title="热播榜" class="tab-link">热播榜</a>
                    </li>
                    <li class="tab-item">
                        <a href="<?= Url::to(['hot-search'])?>" title="热搜榜" class="tab-link selected">热搜榜</a>
                    </li>
                </ul>
                <div class="tab-right-box"><a href="" class="qy-top-sprite zhishu-link"></a></div>
            </div>

            <div class="row-so">
                <?php foreach ($data['tab'] as $key => $tab): ?>
                    <div class="col-l">
                        <div class="item">
                            <div class="m-t1">
                                <h3><i class="ico ico1"></i><?= $tab['title']?></h3>
<!--                                <a href="" class="huan">换一换</a>-->
                            </div>
                            <ul class="m-list1">
                                <?php foreach ($tab['list'] as $key => $list): ?>
                                    <li class="i<?= $key+1?>">
                                        <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>" class="con">
                                            <span class="num"><?= $key+1?></span>
                                            <h3><?= $list['video_name']?></h3>
                                            <i class="trend-icon <?= $key< 4? "up": "hold"?>"></i>
                                        </a>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>

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
                <img src="/images/NewVideo/client_wechat.jpg" alt="">
            </div>
            <a href="javascript:;" class="anchor-item j-pannel"><i class="qy-svgicon qy-svgicon-anchorIntegral j-pannel"></i><i class="dot j-pannel"></i></a>
        </li>
        <li class="anchor-list">
            <a href="" class="anchor-item qy-aura3"><i class="qy-svgicon qy-svgicon-anchorHelp"></i><span class="anchor-txt">帮助反馈</span></a>
        </li>
        <li class="anchor-list dn">
            <a href="javascript:;"  class="anchor-item backToTop">
                <i class="qy-svgicon qy-svgicon-anchorTop"></i>
                <span class="anchor-txt">回到顶部</span>
            </a>
        </li>
    </ul>
</div>
<script src="/js/jquery.js"></script>
<script src="/js/VideoSearch.js"></script>
