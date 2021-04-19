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

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = ($channelName == ''?'':$channelName.'-').'瓜子TV - 澳新华人在线视频分享平台,海量高清视频在线观看';
// $this->metaTags['keywords'] = '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子tv,澳洲瓜子tv,新西兰瓜子tv,澳新瓜子tv,瓜子视频,瓜子影视,电影,电视剧,榜单,综艺,动画,记录片']);
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
    
    $(window).load(function(){
	    var arrIndex = {};
        arrIndex['page'] = "home";
        var advertKey = 0;
        $.get('/video/advert', arrIndex, function(res) {
            if(res.data.hasOwnProperty("city"))
                $("#head-city").text(res.data.city);
                    
            $(".video-add-column").each(function(index){
                if(!res.data.hasOwnProperty("advert"))
                    return false;
                    
                if(!res.data.advert.hasOwnProperty(index)){  
                    advertKey = 0;
                }

                var addata = res.data.advert[advertKey];
                if (addata.hasOwnProperty("ad_skip_url")) {
                    $(this).html("");
                    $(this).html(refreshAdvert(addata));
                }
                advertKey++;
            });
        })
	});
	
	function refreshAdvert(addata)
	{
	    var content = '';
	    content += "<a href='" + addata.ad_skip_url + "'>" + 
                            "<img src='"+ addata.ad_image + "' alt='new'>" +
                    "</a>";
        return content;
	}
});
SCRIPT;

$this->registerJs($js);
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
    <style>
        .classes-item:hover
        {
            color: rgb(255, 85, 110);
        }
    </style>
</head>
<body class="classBody">
<input type="hidden" value="<?= $channel_id?>">
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
        <div class="qy-classes-logo j_pingback_view">
            <div class="classes-logo-inner">
                <div class="mod-classes-blcoks">
                    <?php foreach ($info['search_box'] as $cates): ?>
                        <?php if($cates['label'] == '地区') : ?>
                            <div class="classes-blcoks_dq">
                                <dl class="classes-blcoks">
                                    <dt>
                                        <h4 class="classes-title">
                                            地区
                                        </h4>
                                    </dt>
                                    <dd>
                                        <?php foreach ($cates['list'] as $key => $cate): ?>
                                            <a class="classes-item"
                                               href="<?= Url::to(['list', 'channel_id' => $channel_id, $cates['field'] => $cate['value']])?>">
                                                <?= $cate['display']?></a>
                                        <?php endforeach;?>
                                    </dd>
                                </dl>
                            </div>
                        <?php  elseif($cates['label'] == '类型'): ?>
                            <div class="classes-blcoks_fl">
                                <dl class="classes-blcoks">
                                    <dt>
                                        <h4 class="classes-title">
                                            分类
                                        </h4>
                                    </dt>
                                    <dd>
                                        <?php foreach ($cates['list'] as $key => $cate): ?>
                                            <a class="classes-item"
                                               href="<?= Url::to(['list', 'channel_id' => $channel_id, $cates['field'] => $cate['value']])?>">
                                                <?= $cate['display']?></a>
                                        <?php endforeach;?>
                                    </dd>
                                </dl>
                            </div>
                        <?php  elseif($cates['label'] == '年代'): ?>
                            <div class="classes-blcoks_pk">
                                <dl class="classes-blcoks">
                                    <dt>
                                        <h4 class="classes-title">
                                            年份
                                        </h4>
                                    </dt>
                                    <dd>
                                        <?php foreach ($cates['list'] as $key => $cate): ?>
                                            <a class="classes-item"
                                               href="<?= Url::to(['list', 'channel_id' => $channel_id, $cates['field'] => $cate['value']])?>">
                                                <?= $cate['display']?></a>
                                        <?php endforeach;?>
                                    </dd>
                                </dl>
                            </div>
                        <?php  elseif($cates['label'] == '排序'): ?>
                            <div class="classes-blcoks_dq">
                                <dl class="classes-blcoks">
                                    <dt>
                                        <h4 class="classes-title">
                                            排序
                                        </h4>
                                    </dt>
                                    <dd>
                                        <div class="qy-mod-nav-tab">
                                            <ul class="qy-mod-nav-list TAB" id=".tabCont">
                                                <?php foreach ($cates['list'] as $key => $cate): ?>
                                                    <li class="mod-nav-item">
                                                        <div class="crumb-btn j_movie_tab_title selected">
                                                            <a class="txt-link"
                                                               href="<?= Url::to(['list', 'channel_id' => $channel_id, $cates['field'] => $cate['value']])?>">
                                                                <?= $cate['display']?></a>
                                                        </div>
                                                    </li>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
        <div class="c"></div>
        <div class="qy-channel-content">
            <?php if (!empty($data['label'])) :?>
                <?php foreach ($data['label'] as  $labels): ?>
                    <?php if (!isset($labels['advert_id'])) : ?>
                        <?php
                        $tag = '';
                        $channel = '';
                        foreach ($labels['search'] as $s_k => $s_v) {
                            if($s_v['field'] == 'channel_id') {
                                $channel = $s_v['value'];
                            }
                            if($s_v['field'] == 'tag') {
                                $tag = $s_v['value'];
                            }
                        }
                        ?>
                        <a class="anchor" id="section<?= $channel?>"></a>
                        <div class="qy-left-video pr j_movie_tab j_pingback_view">
                            <div class="qy-mod-header">
                                <h2 class="qy-mod-title">
                                    <a class="link-txt j_movie_tab_header"
                                       href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag])?>">
                                        <span class="qy-mod-text"><?= $labels['title']?></span>
                                    </a>
                                </h2>
                            </div>
                            <div class="left-video-wrap j_movie_tab_body">
                                <!-- 电影 -->
                                <div class="qy-mod-wrap-side" id="section1">
                                    <div class="listBox">
                                        <div class="qy-mod-list swiper-container swiper-container1">
                                            <div class="qy-mod-ul swiper-wrapper">
                                                <?php foreach ($labels['list'] as $key => $list): ?>
                                                    <?php if($key < 100) :?>
                                                        <div class="qy-mod-li swiper-slide">
                                                            <div class="qy-mod-img vertical">
                                                                <div class="qy-mod-link-wrap">
                                                                    <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"
                                                                       class="qy-mod-link">
                                                                        <div style="height:100%;overflow:hidden;">
                                                                            <img src="<?= $list['cover']?>" class="qy-mod-cover">
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                                <div class="title-wrap">
                                                                    <p class="main score">
                                                                        <span class="text-score"><?= $list['score']?></span>
                                                                        <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"
                                                                           class="link-txt" ><span ><?= $list['video_name']?></span></a></p>
                                                                    <p class="sub"><?= $list['play_times']?></p>
                                                                </div>
                                                            </div>
                                                            <div class="qy-video-card-small qy-video-info-tips j_hover_detail typs-m">
                                                                <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"
                                                                   class="movie_tipLink">
                                                                    <div class="movie_tipHd">
                                                                        <div class="movie_tipImg">
                                                                            <img src="<?= $list['horizontal_cover']?>"><span class="icon_hover"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="movie_tipCon">
                                                                        <div class="movie_tipTitle" style="width:225px">
                                                                            <p class="movie_tipScore"><?= $list['score']?></p>
                                                                            <p class="movie_tipName"><?= $list['video_name']?></p>
                                                                        </div>
                                                                        <div class="tipLableBox">
                                                                            <p class="tipLable_inner">
                                                                                <span class="tipLable_title">标签：</span>
                                                                                <span class="tipLable"><span class="label"><?= $list['category']?></span></span>
<!--                                                                                <span class="tipLable">华语</span>-->
<!--                                                                                <span class="tipLable">院线</span>-->
                                                                            </p>
                                                                            <p class="movie_tipTime"><?= $list['year']?></p>
                                                                        </div>
                                                                        <div class="tip_starring" >
                                                                            主演：
                                                                            <?php if (!empty($list['actors'])) :?>
                                                                                <?php foreach ($list['actors'] as $key => $actor): ?>
                                                                                    <span class="starring_link"><?= $actor['actor_name']?></span>/
                                                                                <?php endforeach;?>
                                                                            <?php endif;?>
                                                                        </div>
                                                                        <div class="tip_des four_line"><?= $list['intro']?></div>
                                                                    </div>
                                                                </a>
                                                                <div class="movie_tipBd">
                                                                    <div class="tipScore_box">
                                                                        <div class="tipScore_wrap">
                                                                            <div class="tipScore_outer">
                                                                                <div class="tipScore_in">
                                                                                    <div class="star_score" role="star">
			            												<span class="commstar" >
			            												   <a href="javascript:;" class="star1 active" data-val="1"></a>
			            												   <a href="javascript:;" class="star2" data-val="2"></a>
			            												   <a href="javascript:;" class="star3" data-val="3"></a>
			            												   <a href="javascript:;" class="star4" data-val="4"></a>
			            												   <a href="javascript:;" class="star5" data-val="5"></a>
			            												</span>
                                                                                        <span class="defei"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <span class="tipScore_tx dn"></span>
                                                                        </div>
                                                                        <a href="javascript:;" class="handle-link">收藏</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php  else: ?>
                        <div class="video-add-column">
                            <a href="">
                                <img src="" alt="">
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach;?>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="c"></div>

<div class="c"></div>
</body>