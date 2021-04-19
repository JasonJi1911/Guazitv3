<?php
use yii\helpers\Url;
use pc\assets\StyleInAsset;

$this->title = '瓜子TV - 澳新华人在线视频分享平台,海量高清视频在线观看';
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
<div class="qy-scroll-anchor qy-aura3">
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
