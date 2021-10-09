<?php
use yii\helpers\Url;

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = '吉祥视频';
$this->registerMetaTag(['name' => 'keywords', 'content' => '吉祥|视频|吉祥视频|澳洲吉祥视频|澳新吉祥|澳新视频|澳新吉祥视频|爱影视|澳洲爱影视|澳洲同城影视网|体育直播|澳洲足球直播|澳洲体育直播|美剧|电影|综艺']);//|看tv|kantv

header('X-Frame-Options:Deny');
?>
<script src="/js/jquery.min.js"></script>
<script>
    $(document).ready(function(){
		var mobile_flag = isMobile();

		if(mobile_flag == false){
			window.location = "<?=PC_HOST_PATH?>";
		}
		
		if ($("#jBox1").length > 0) {
            $(".flashCount").text("关闭")
            $(".bgcover").fadeIn();
		}
		
		$(".jBox-closeButton").click(function(){
            // $("#jBox1-overlay").hide();
            $(".bgcover").fadeOut();
        });
        
        function countDown(maxtime,fn){
            var timer = setInterval(function() { 
                if(!!maxtime ){  
                fn(Math.floor(maxtime%60)); 
                --maxtime;  
            } else {  
                clearInterval(timer ); 
                fn(0);
            }  
            },1000); 
        }
        //9s后关闭封
        countDown(9,function(msg) { 
            if(msg == '0'){
                $(".bgcover").fadeOut();
            }
            // document.getElementById('closeAd').innerHTML = msg+"秒后自动关闭"; 
        })
	});
	
	function isMobile() {
		var userAgentInfo = navigator.userAgent;

		var mobileAgents = [ "Android", "iPhone", "SymbianOS", "Windows Phone", "iPad","iPod"];

		var mobile_flag = false;

		//根据userAgent判断是否是手机
		for (var v = 0; v < mobileAgents.length; v++) {
			if (userAgentInfo.indexOf(mobileAgents[v]) > 0) {
				mobile_flag = true;
				break;
			}
		}

		 var screen_width = window.screen.width;
		 var screen_height = window.screen.height;    

		 //根据屏幕分辨率判断是否是手机
		 if(screen_width < 500 && screen_height < 800){
			 mobile_flag = true;
		 }

		 return mobile_flag;
	}
</script>
<style>
    .nav-show {
        display: flex;
        justify-content: space-around;
    }
    .nav-no-show {
        display: none;
    }
    .line_show {
        display: block !important;
    }
    .video-header {
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 99;
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
    
    .jBox-wrapper{
        position: fixed;
        opacity: 1;
        z-index: 10000;
        /*inset: 0px auto;*/
        width: 300px;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%,-50%);
        transform: translate(-50%,-50%);
    }

    .bgcover
    {
        background-color: hsla(0,0%,100%,.54);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 999;
    }
    
    .jBox-closeButton-box .jBox-closeButton {
        top: 0;
        right: 0;
        width: 46px;
        height: 24px;
        background: transparent;
        z-index: 10001;
        position: absolute;
        color: #fff;
        padding: 10px 0 0 10px;
    }
</style>

<header class="video-header">
    <div class="video-header-top clearfix">
        <a class="logo fl">吉祥视频</a>
        <div class="search-cont fr">
            <div class="search-notice"><?php if(!empty($channels['hot_word'])) : ?><?= $channels['hot_word'][0]?><?php endif;?></div>
        </div>
    </div>
    <input type="hidden" id="swiper-type" value="index">
    <div class="video-top-nav swiper-container" id="topNav">
        <ul class="swiper-wrapper">
            <?php if(!empty($channels)) : ?>
                <?php foreach ($channels['list'] as $key => $channel): ?>
                    <li class="swiper-slide on swiper-slide-li">
                        <a href="<?= Url::to(['/video/index', 'channel_id' => $channel['channel_id']])?>"><?= $channel['channel_name']?></a>
                        <span class="line <?= $channel['channel_id'] == $channel_id ? 'line_show' : ''?>"></span>
                        <?php if ($channel['channel_id'] == $channel_id) : ?>
                            <input type="hidden" value="<?= $key ?>" id="nav-channel">
                        <?php endif;?>
                    </li>
                <?php endforeach ?>
            <?php endif;?>
        </ul>
    </div>
</header>
<input id="v_channelid" type="hidden" value="<?=$channel_id?>" />
<div class="video-banner swiper-container video-banner-caroul alter-banner" id="video-list-banner">
    <ul class="swiper-wrapper clearfix">
        <?php if(!empty($data['banner'])) : ?>
            <?php foreach ($data['banner'] as $banner): ?>
                <li class="swiper-slide" data-link="<?= $banner['content']?>">
                    <div class="piclist-img" style="height: 3.75rem">
                        <span class="piclist-link" style="background-image:url(<?= $banner['image']?>);">
                            <div class="video-banner-title">
                                <p class="title"><?= $banner['title']?></p>
                            </div>
                        </span>
                    </div>
                </li>
            <?php endforeach ?>
        <?php endif;?>
    </ul>
    <div class="swiper-pagination"></div>
</div>

<ul class="video-other-nav <?= $channel_id == 0 ? 'nav-show' : 'nav-no-show'?>">
    <?php if($channel_id == 0 && !empty($data['king_kong'])) : ?>
        <?php foreach ($data['king_kong'] as $key => $li): ?>
            <?php
                foreach ($li['search'] as $s_k => $s_v) {
                    if($s_v['field'] == 'channel_id') {
                        $channel = $s_v['value'];
                    }
                }
            ?>
            <li>
                <a href="<?= Url::to(['list', 'channel_id' => $channel])?>">
                    <img src="<?= $li['icon']?>" alt="">
                    <p><?= $li['title']?></p>
                </a>
            </li>
        <?php endforeach ?>
    <?php endif;?>
</ul>

<div class="video-detail-series-bottom video-index-other-nav">
    <ul class=" clearfix <?= $channel_id != 0 ? 'nav-show' : 'nav-no-show'?>">
        <?php if($channel_id != 0 && !empty($data['tags'])) : ?>
            <?php foreach ($data['tags'] as $li): ?>
                <?php
                foreach ($li['search'] as $s_k => $s_v) {
                    if($s_v['field'] == 'tag') {
                        $tag = $s_v['value'];
                    }
                    if($s_v['field'] == 'channel_id') {
                        $channel = $s_v['value'];
                    }
                }
                ?>
                <li class="swiper-slide on"><a href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag])?>"><?= $li['name']?></a></li>
            <?php endforeach ?>
        <?php endif;?>
    </ul>
</div>

<?php if (!empty($data['label'])) :?>
    <?php foreach ($data['label'] as  $labels): ?>
        <?php if (!isset($labels['advert_id'])) : ?>
                <div class="video-index-column <?= $key == 0 ? 'mt20' : 'mt15';?>">
                    <h3 class="video-index-title"><?= $labels['title']?></h3>
                    <dl class="video-list-box clearfix <?= 'more-change-'.$labels['recommend_id'] ?>">
                        <?php foreach ($labels['list'] as $key => $list): ?>
                            <?php if($key < 9) :?>
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
            <div class="video-other-more clearfix">
                <a href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag])?>" class="fl more-item ">
                    <span>查看更多</span>
                </a>
                <a href="javascript:;" class="fl more-item more-change" data-recommend="<?= $labels['recommend_id'] ?>">
                    <span class="change">换一换</span>
                </a>
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
<div class="addtohomescreen" style="position: fixed;bottom: 1px;left: 50%;transform: translateX(-50%);width: 75%;max-width: 75%;display: block;">
    <img src="/images/video/addtohomescreen.png" alt="" style="width: 100%;">
  </div>
<div class="video-index-notice">
     <p style="padding-bottom: 5px;text-align: center;">
        <a class="browser browser1" href="<?= Url::to(['map'])?>">网站地图</a>
        <a class="browser browser1" href="<?=WAP_HOST_PATH?>">手机端</a>
        <a class="browser " href="<?=PC_HOST_PATH?>">电脑端</a>
<!--        <a class="browser" href="--><?//= Url::to(['site/share-down'])?><!--">APP下载</a>-->
     </p>
    <p>版权声明：如果来函说明本网站提供内容本人或法人版权所有。本网站在核实后，有权先行撤除，以保护版权拥有者的权益。
        &nbsp; 邮箱地址： <?=EMAIL_NAME?>
    </p>
    <p style="text-align:center;">Copyright 2020-2021 <?=PC_HOST_NAME?> Allrights Reserved.</p>
</div>
<!--<div class="video-footer">
    <ul class="clearfix footer-top">
        <li><a href="#">关于我们</a></li>
        <li><a href="#">常见问题</a></li>
        <li><a href="#">免责声明</a></li>
    </ul>
    <p class="footer-bottom">Copyright&copy;优酷 youku.com 版权所有</p>
</div>-->

<script src="/js/video/jquery.min.1.11.1.js"></script>
<script src="/js/video/swiper.min.js"></script>
<!--<script src="/js/video/video.js?v=1.2"></script>-->
<script src="/js/video/mtop.js"></script>
<script>
    //导航选中项处于中间位置
    $(function () {
        var index = $('#nav-channel').val();

        $(".video-top-nav li").eq(index).addClass("on").siblings().removeClass("on");
        var $cur = $("#topNav .on");
        var index = $cur.index();
        slideLeft1 = $cur.offset().left-20;
        slideWidth1 = $cur.outerWidth(true);
        slideCenter1 = slideLeft1 + slideWidth1 / 2;
        if (slideCenter1 < swiperWidth / 2) {
            mySwiper.setTranslate(0);
        } else if (slideCenter1 > maxWidth) {
            mySwiper.setTranslate(maxTranslate);
        } else {
            nowTlanslate = slideCenter1 - swiperWidth / 2;
            mySwiper.setTranslate(-nowTlanslate);
        }
    });

    $('.addtohomescreen').on('click', function () {
        $('.addtohomescreen').hide();
    })
    //设置banner距离顶部距离
    $('.video-banner').css('margin-top',$('.video-header').css('height'))
    
    $(window).load(function(){
	    var arrIndex = {};
	    var channel_id = $("#v_channelid").val();
		arrIndex['channel_id']= channel_id;
		
		$.get('/video/index-banner', arrIndex, function(res) {
            $('.alter-banner').html(res); // 更新内容
        })
        
        arrIndex['page'] = "home";
        var advertKey = 0;
        $.get('/video/advert', arrIndex, function(res) {
                    
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
</script>

<?php if (!empty($data['flash'])) : ?>
<div class="bgcover" style="display: none;">
    <div id="jBox1" class="jBox-wrapper jBox-Modal jBox-Default jBox-closeButton-box">
        <div style="width:auto;font-size:15px;text-align:center"></div>
        <a href="<?= $data['flash']['ad_skip_url']?>" target="_blank">
            <img src="<?= $data['flash']['ad_image']?>" style="border: 0px;width:100%;height:100%">
        </a>
        <div class="jBox-closeButton jBox-noDrag">
            <span class="flashCount"></span>
        </div>
    </div>
</div>
<?php endif; ?>
