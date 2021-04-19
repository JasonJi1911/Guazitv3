<?php

use yii\helpers\Url;
use pc\assets\StyleInAsset;

$channelName = '';
if(isset($channel_id))
{
    foreach ($channels['list'] as $s_k => $s_v) {
        if($s_v['channel_id'] == $channel_id) {
            $channelName = $s_v['channel_name'];
        }
    }
}

$this->title = ($channelName == ''?'':$channelName.'-').'瓜子TV|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv - guazitv.tv';
//$this->metaTags['keywords'] = '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片']);
StyleInAsset::register($this);

$js = <<<SCRIPT
$(function(){
	$('.qy-header.home2020 .qy-search .search-box').hover(function() {
        $(this).toggleClass('search-box-hover');
    });
    
    // 评分
    $('[role="star"]').each(function(index, el) {
        var link = $(this).find('a'),
            input = $(this).find('.defei');
            link.each(function(index, el) {
                link.click(function(event) {
                    var _sc = $(this).data('val');
                    var at = _sc-1;
                    input.text(_sc + '分');
                    link.removeClass('active');
                    link.eq(at).addClass('active');
                });
            });
    });
    
    $('.banner-in .slider').slick({
        dots: true,
        arrows: true,
        infinite: false,
        speed: 300,
    });
    var swiper = new Swiper('#section1 .swiper-container1', {
        slidesPerView: 8,
        slidesPerColumn: 1,
        spaceBetween: 5,
        navigation: {
            nextEl: '#section1 .swiper-button-next',
            prevEl: '#section1 .swiper-button-prev',
        },
        breakpoints: {
            1024: {
                slidesPerView: 6,
            },
            1440: {
                slidesPerView: 6,
            },
            1550: {
                slidesPerView: 7,
            },
        }
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
});
SCRIPT;

$this->registerJs($js);
?>
<style>
    .rank_smmenu {
        text-align: center;
        /*margin-bottom: 20px;*/
        margin-top: 40px;
    }

    .rank_qrcode{
        /*margin-top:30px;*/
        text-align:center;
        padding:25px 25px 0px 25px;
    }

    .img_qrcode{
        width:160px;
        height:160px;
    }

    .rank_content{
        text-align:center;
        padding:25px;
        font-size:20px;
        font-weight:bold;
        margin-bottom:50px;
    }

    .rank_smmenu .lk.cur {
        font-weight: bold;
        font-size: 16px;
        color: #FF556E;
    }

    .rank_smmenu .lk {
        display: inline-block;
        vertical-align: middle;
        font-size: 14px;
        color: #666666;
        line-height: 40px;
        margin: 0 25px;
        position: relative;
        text-decoration: none;
    }

    .rank_smmenu .lk.cur:after, .rank_smmenu .lk:hover:after {
        width: 14px;
        margin-left: -7px;
    }

    .rank_smmenu .lk:after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        width: 0;
        height: 3px;
        background: #FF556E;
        border-radius: 4px;
        transition: all .3s;
    }
</style>

<body class="classBody">
<div class="c"></div>

<div class="channel-page">
    <div class="qy-channel-page">
        <!-- banner -->
        <div class="banner-in">
            <div class="slider">
                <?php if(!empty($data['banner'])) : ?>
                    <?php foreach ($data['banner'] as $banner): ?>
                        <div class="item-slide">
                            <a href="<?= str_replace("/detail","/detail",$banner['content'])?>" style="background-image: url(<?= $banner['image']?>)">
                                <div class="txt">
                                    <i class="qy-channel-icon focus-playBtn-icon" ></i>
                                    <div class="caption" ><?= $banner['title']?></div>
                                    <!--                                    <p class="desc">逆战时空真炸飞机</p>-->
                                </div>
                            </a>
                        </div>
                    <?php endforeach ?>
                <?php endif;?>
            </div>
        </div>
        <!-- banner end -->
        <div class="c"></div>
        <div class="qy-channel-content">
            <div class="rank_smmenu">
                <a href="#" class="lk cur">商务合作/商务洽谈</a>
            </div>
            <div class="rank_qrcode">
                <img src="/images/NewVideo/collab_qr.png" class="img_qrcode">
            </div>
            <div  class="rank_content">
                <div>我们将提供一流、用心的服务，期待与您的进一步沟通！ 顺颂商祺！</div>
                <br/>
                <div>联系方式：guazitv@163.com </div>
            </div>
        </div>
    </div>
</div>
<div class="c"></div>

</body>