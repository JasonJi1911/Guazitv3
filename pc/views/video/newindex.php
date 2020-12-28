<?php
use yii\helpers\Url;
use pc\assets\StyleAsset;

$this->title = '瓜子TV-澳新华人在线视频分享网站';
StyleAsset::register($this);

$js = <<<SCRIPT
$(function(){
	$(window).resize(function(event) {
		var _width = $(window).width();
		if(_width > 1796){
			$( ".qy-mod-wrap-side" ).each(function( index ) {
                var id = $(this).attr("id");
                var swiper = new Swiper('#'+id+' .swiper-container', {
                    slidesPerView: 6,
                    slidesPerColumn: 2,
                    navigation: {
                      nextEl: '#'+id+' .swiper-button-next',
                      prevEl: '#'+id+' .swiper-button-prev',
                    },
                });
            });
		}
		else if(_width < 1795){
			$( ".qy-mod-wrap-side" ).each(function( index ) {
                var id = $(this).attr("id");
                var swiper = new Swiper('#'+id+' .swiper-container', {
                    slidesPerView: 5,
                    slidesPerColumn: 2,
                    navigation: {
                      nextEl: '#'+id+' .swiper-button-next',
                      prevEl: '#'+id+' .swiper-button-prev',
                    },
                });
            });
		}
		else if(_width < 1366){
			$( ".qy-mod-wrap-side" ).each(function( index ) {
                var id = $(this).attr("id");
                var swiper = new Swiper('#'+id+' .swiper-container', {
                    slidesPerView: 4,
                    slidesPerColumn: 2,
                    navigation: {
                      nextEl: '#'+id+' .swiper-button-next',
                      prevEl: '#'+id+' .swiper-button-prev',
                    },
                });
            });
		}
	}).resize();
	
	$('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav',
        autoplay:true
    });
	
    $('.slider-nav').slick({
        slidesToShow: 10,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        focusOnSelect: true,
        arrows:false,
        vertical:true,
        autoplay:true
    });
	
    $('.qy20-h-carousel__voice-off').click(function(event) {
        $(this).hide();
        $('.qy20-h-carousel__voice-on').show();
    });
    $('.qy20-h-carousel__voice-on').click(function(event) {
        $(this).hide();
        $('.qy20-h-carousel__voice-off').show();
    });
    $('.moreBtn').hover(function() {
        $('.qy20-more-pop').show();
    });
    $('.qy20-more-pop').mouseleave(function(event) {
        $('.qy20-more-pop').hide();
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
	
    $('.panel-item').hover(function() {
        $('.panel-item').removeClass('slick-current');
        $(this).addClass('slick-current');
        var _index = $(this).attr('data-slick-index');
        $('.slider-for .slick-slide').removeClass('slick-current slick-active');
        $('.slider-for .slick-slide').attr('aria-hidden','true');
        $('.slider-for .slick-slide').css('opacity','0');
        $('.slider-for .slick-slide').eq(_index).addClass('slick-current slick-active');
        $('.slider-for .slick-slide').eq(_index).attr('aria-hidden','false');
        $('.slider-for .slick-slide').eq(_index).css('opacity','1');
    });
	
	$('.qy20-nav-channel').each(function(index, el) {
        	$(this).find('.nav-name').hover(function() {
        		$('.qy-nav-panel-popup').hide();
        		$(this).parents('.qy20-nav-channel').find('.qy-nav-panel-popup').show();
        	});
        });
        $('.qy-nav-panel-popup').mouseleave(function(event) {
        	$('.qy-nav-panel-popup').hide();
	});
	
	$("#det-nav:first").sticky({
		topSpacing: 400,
		zIndex:2,
		stopper: ".qy-footer"
	});
	
	$('#det-nav:first a').on('click', function () {
	  var scrollAnchor = $(this).attr('src'),
		scrollPoint = $($(this).attr('href')).offset().top;

		  $('body,html').animate({
			  scrollTop: scrollPoint
		  }, 500);

		  return false;

	});
	  
	$(window).scroll(function(){
		
		var y = $(window).scrollTop();
		$('#det-nav:first a[href^=#]').each(function (event) {
			 if (y >= $($(this).attr('href')).offset().top - 60) {
				 $('#det-nav:first a').not(this).removeClass('active');
				 $(this).addClass('active');
			 }
		 });
	 
		if( y + $(window).height() == $(document).height()) {
			 $('#det-nav:first a').removeClass('active');
			 $('#det-nav:first a:last').addClass('active');
		}

	});
	
	$("img").delayLoading({
		defaultImg: "images/loading.jpg",           // 预加载前显示的图片
		errorImg: "",                        // 读取图片错误时替换图片(默认：与defaultImg一样)
		imgSrcAttr: "originalSrc",           // 记录图片路径的属性(默认：originalSrc，页面img的src属性也要替换为originalSrc)
		beforehand: 0,                       // 预先提前多少像素加载图片(默认：0)
		event: "scroll",                     // 触发加载图片事件(默认：scroll)
		duration: "normal",                  // 三种预定淡出(入)速度之一的字符串("slow", "normal", or "fast")或表示动画时长的毫秒数值(如：1000),默认:"normal"
		container: window,                   // 对象加载的位置容器(默认：window)
		success: function (imgObj) { },      // 加载图片成功后的回调函数(默认：不执行任何操作)
		error: function (imgObj) { }         // 加载图片失败后的回调函数(默认：不执行任何操作)
	});
});
SCRIPT;

$this->registerJs($js);
?>
<header class="qy-header home2020 qy-header--absolute ">
    <div class="header-wrap">
        <div class="header-inner">
            <div id="nav_logo" class="qy-logo">
                <a href="/video/index" class="logo-link" title="瓜子TV"><img src="/images/NewVideo/logo.png" alt="">瓜子TV</a>
            </div>
            <div class="qy-nav">
                <div class="nav-channel" style="display: inline-block">
                    <a href="<?= Url::to(['/video/channel', 'channel_id' => '2'])?>"
                       class="nav-link nav-index J-nav-channel">电视剧</a>
                    <a href="<?= Url::to(['/video/channel', 'channel_id' => '1'])?>"
                       class="nav-link nav-index J-nav-channel">电影</a>
                    <a href="<?= Url::to(['/video/channel', 'channel_id' => '3'])?>"
                       class="nav-link nav-index J-nav-channel">综艺</a>
                    <a href="<?= Url::to(['/video/channel', 'channel_id' => '4'])?>"
                       class="nav-link nav-index J-nav-channel">动漫</a>
                </div>
                <div class="T-drop-hover nav-guide nav-link" id="dhBtn" style="display: inline-block">
                    <div class="T-drop-click">
							<span class="J-nav-title">
							    <span class="show920">
									导航
									<i class="qy20-header-svg qy20-header-svg-guide-narrow"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-guide-narrow"></use></svg></i>
									<i class="qy-svgicon qy-svgicon-guide-narrow-up"></i>
								</span>
								<span class="hidden920">全部<i class="qy20-header-svg qy20-header-svg-guide-narrow"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-guide-narrow"><svg id="qy20-header-guide-narrow" viewBox="0 0 9 9"><path d="M.257 3.793a1 1 0 0 1 1.327-.078l.088.078L4.5 6.62l2.828-2.828a1 1 0 0 1 1.327-.078l.088.078A1 1 0 0 1 8.82 5.12l-.077.087-3.536 3.536a1 1 0 0 1-1.327.077l-.087-.077L.257 5.207a1 1 0 0 1 0-1.414z"></path></svg></use></svg></i><i class="qy-svgicon qy-svgicon-guide-narrow-up"></i></span>
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
            <div class="qy-header-side">
                <div class="qy-search">
                    <div class="search-box">
						<span class="search-box-in">
							<input placeholder="<?= empty($hotword['tab'][0]['list'][0]['video_name']) ? '': $hotword['tab'][0]['list'][0]['video_name']?>"
                                   type="text" value="" class="search-box-input" id="keywords">
							<!--<a href="" class="search-right-entry">-->
							<!--	<i class="qy20-header-svg qy20-header-svg-rank-hot">-->
							<!--		<svg viewBox="0 0 10 13" aria-hidden="true" class="qy20-header-symbol"><linearGradient x1="79.5857988%" y1="17.1508789%" x2="20.4142012%" y2="90.2275473%" id="__gradient_header_rank-hot"><stop offset="0%" class="symbol-stop1-rank-hot"></stop><stop offset="100%" class="symbol-stop2-rank-hot"></stop></linearGradient><path d="M2.114 3.596c-.634.7-1.178 1.298-1.54 1.997-.907 1.798-.726 3.996.452 5.593.635.8 1.541 1.399 2.448 1.699.362.1 1.631.2 2.357 0C7.099 12.585 10 11.386 10 8.19c0-1.298-.272-2.197-.816-2.996-.09 0-.362.2-.816.599-.271.4-.634.4-.906.3-.181-.2-.363-.5-.272-.8C7.462 2.698 6.102 1.499 4.561.1l-.18-.1c-.273 1.598-1.27 2.597-2.267 3.596z" fill="#FFFFFF" fill-opacity="0.3"></path></svg>-->
							<!--	</i>热搜榜-->
							<!--</a>-->
						</span>
                        <span class="search-box-out">
							<span type="button" rseat="tj_serch" class="search-box-btn">
								<i class="qy20-header-svg qy20-header-svg-search">
									<svg viewBox="0 0 26 26" aria-hidden="true" class="qy20-header-symbol"><linearGradient x1="0%" y1="99.189%" x2="97.403%" y2="-15.586%" id="__gradient_header_search"><stop offset="0%" class="symbol-stop1-search"></stop><stop offset="100%" class="symbol-stop2-search"></stop></linearGradient><path d="M12.5 4a8.5 8.5 0 0 1 6.66 13.782l2.716 2.533a1 1 0 1 1-1.364 1.462l-2.772-2.584A8.5 8.5 0 1 1 12.5 4zm0 2a6.5 6.5 0 1 0 0 13 6.5 6.5 0 0 0 0-13z" fill="#FF556E"></path></svg>
								</i>
								<em class="search-box-btnTxt">搜索</em>
							</span>
						</span>
                    </div>
                    <div id="J-search-result-wrap" class="search-result" style="">
						<div class="search-result-con">
							<div id="J-search-result-hot" class="search-result-hot" style="">
								<div class="search-result-title">热门搜索</div>
								<?php foreach ($hotword['tab'] as $key => $tab): ?>
                                    <?php if($key == 0) :?>
                                        <?php foreach ($tab['list'] as $key => $list): ?>
                                            <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"
                                               class="search-result-item">
                                                <div class="search-result-simple">
                                                    <em class="search-result-num search-result-num1"><?= $key + 1?></em>
                                                    <span class="search-result-text"><?= $list['video_name']?></span>
                                                </div>
                                            </a>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                <?php endforeach;?>
							</div>
						</div>
					</div>
                </div>
        <!--        <div class="header-sideItem header-vip">-->
        <!--            <div class="T-drop-click">-->
        <!--                <div j-product-type="gold" class="header-sideItemCon header-vip-login J-vip-pay">-->
        <!--                    <div>-->
        <!--                        <i class="header-sideItemIcon qy20-header-svg qy20-header-svg-vip">-->
        <!--                            <svg viewBox="0 0 26 26" aria-hidden="true" class="qy20-header-symbol"><linearGradient x1="27.794%" y1="81.337%" x2="72.206%" y2="18.663%" id="__gradient_header_vip"><stop offset="0%" class="symbol-stop1"></stop><stop offset="100%" class="symbol-stop2"></stop></linearGradient><path d="M13 3c1.965.1 3.556 1.665 4 4-.444.53-.823 1.376-1 2 .187.605 1.03.98 2 1 .312-.02.643-.085 1 0-.073-2.102 1.254-3.406 3-3 1.528-.406 2.855.898 3 3-.145 1.509-1.285 2.76-3 3 .24-.04-1.115 6.817-1 7-.405.984-1.423 1.8-3 2 .41-.2-10.413-.2-10 0-1.58-.2-2.598-1.016-3-2 .111-.183-1.245-7.041-1-7-1.716-.243-2.855-1.493-3-3 .145-2.102 1.472-3.406 3-3 1.746-.406 3.073.898 3 3 .357-.085.688-.02 1 0 .97-.02 1.813-.395 2-1-.176-.624-.556-1.47-1-2 .444-2.335 2.036-3.9 4-4zm-3 10c-.595-.298-.726.16-1 1 .465-.473 3.246 4.838 3 5 .255.105.383.364 1 1-.01-.294.446-.434 1-1-.357.187 2.504-5.295 3-5-.299-.674-.434-1.147-1-1-.162-.557-.617-.417-1 0 .185-.039-2 4-2 4s-2.253-4.193-2-4c-.444-.56-.887-.696-1 0z"   fill="#e2b987"></path></svg>-->
        <!--                        </i>-->
        <!--                        <span class="header-sideItemTit">VIP</span>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
                    <!-- 下拉 -->
        <!--            <div class="qy-header-vip-pop selected gold J-cash-pop">-->
        <!--                <div class="qy-popup-box">-->
        <!--                    <div class="popup-box-arrow"><span class="popup-box-arrowOut"><i class="popup-box-arrowIn"></i></span></div>-->
        <!--                    <div class="qy-header-vipCon">-->
        <!--                        <div class="vippop-bottom">-->
        <!--                            <div class="vippop-top">-->
        <!--                                <div class="vippop-left">-->
        <!--                                    <ul class="header-vippop header-list-more vippop-home2020">-->
        <!--                                        <li class="header-vippop-wrap"><a href="" class="header-vippop-item J-pop-item T-pop-item"><i class="qy20-header-icon qy20-header-svg qy20-header-vip-g">-->
        <!--                                                    <svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-vip-g">-->
        <!--                                                            <svg id="qy20-header-vip-g" title="了解VIP会员特权 " viewBox="0 0 1024 1024"><path d="M512 51.2c102.4 0 184.32 81.92 184.32 184.32 0 20.48-5.12 40.96-10.24 61.44 0 0 5.12 0 5.12 5.12l5.12-5.12c30.72-46.08 81.92-76.8 138.24-76.8h10.24c97.28 0 179.2 76.8 179.2 179.2 0 71.68-40.96 133.12-102.4 158.72l-5.12 5.12-81.92 281.6c-5.12 20.48-20.48 40.96-40.96 51.2l-5.12 5.12-25.6 15.36c-15.36 0-30.72 5.12-46.08 5.12H302.08c-15.36 0-30.72-5.12-40.96-10.24L235.52 896c-25.6-10.24-40.96-30.72-46.08-56.32l-81.92-281.6-5.12-5.12C46.08 527.36 5.12 471.04 0 404.48v-10.24c0-97.28 76.8-179.2 179.2-179.2 61.44 0 112.64 30.72 148.48 76.8l5.12 5.12c5.12 0 5.12 0 5.12-5.12l-5.12-10.24c0-10.24-5.12-20.48-5.12-35.84v-10.24C327.68 133.12 409.6 51.2 512 51.2zm0 102.4c-46.08 0-81.92 35.84-81.92 81.92 0 15.36 5.12 30.72 15.36 46.08l5.12 5.12c5.12 20.48 5.12 40.96-10.24 56.32-25.6 30.72-56.32 51.2-92.16 56.32h-5.12c-15.36 5.12-30.72 5.12-46.08 10.24-20.48 0-40.96-15.36-51.2-35.84v-10.24c-10.24-25.6-40.96-40.96-66.56-40.96-40.96 0-76.8 30.72-76.8 71.68 0 35.84 25.6 66.56 56.32 71.68h5.12c15.36 5.12 25.6 20.48 30.72 35.84l87.04 307.2 25.6 10.24h409.6l20.48-10.24 87.04-307.2c5.12-15.36 15.36-30.72 30.72-35.84h15.36c30.72-10.24 51.2-35.84 51.2-71.68 0-40.96-35.84-76.8-76.8-76.8-30.72 0-61.44 20.48-71.68 51.2v5.12c-5.12 20.48-25.6 35.84-46.08 35.84-15.36 0-30.72 0-46.08-5.12h-5.12c-35.84-10.24-66.56-30.72-92.16-56.32-15.36-15.36-15.36-40.96-5.12-61.44 10.24-15.36 15.36-30.72 15.36-46.08 0-51.2-35.84-87.04-81.92-87.04zM455.68 512c5.12 0 5.12 0 10.24 5.12L512 578.56l46.08-61.44c0-5.12 5.12-5.12 10.24-5.12h87.04c5.12 0 5.12 0 5.12 5.12v10.24L517.12 716.8h-10.24c-10.24-15.36-35.84-46.08-61.44-81.92l-15.36-20.48c-35.84-46.08-66.56-87.04-71.68-92.16 0 0-5.12-5.12 0-10.24s5.12 0 10.24 0h87.04z" fill="#e2b987"></path></svg>-->
        <!--                                                        </use></svg>-->

        <!--                                                </i>了解VIP会员特权 </a></li>-->
        <!--                                        <li class="header-vippop-wrap"><a href="" class="header-vippop-item J-pop-item T-pop-item"><i class="qy20-header-icon qy20-header-svg qy20-header-gift-g"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-gift-g">-->
        <!--                                                            <svg id="qy20-header-gift-g" title="领取VIP会员福利" viewBox="0 0 1024 1024"><path d="M714.189 111.002A102.4 102.4 0 0 1 857.6 204.8v76.851c0 8.807-1.126 17.408-3.226 25.6l67.226-.051a51.2 51.2 0 0 1 51.2 51.2v204.8a51.2 51.2 0 0 1-51.2 51.2h-.051l.051 307.2a51.2 51.2 0 0 1-51.2 51.2H153.6a51.2 51.2 0 0 1-51.2-51.2l-.051-307.2-5.94-.358A51.2 51.2 0 0 1 51.2 563.2V358.4a51.2 51.2 0 0 1 51.2-51.2l68.915.051a102.605 102.605 0 0 1-3.225-25.549v-76.85a102.4 102.4 0 0 1 143.41-93.85l184.116 80.435a103.761 103.761 0 0 1 17.306 9.728c5.222-3.738 11.008-7.015 17.203-9.728l184.064-80.435zM819.2 614.4H204.8v256h614.4v-256zm51.2-204.8H153.6V512h716.8V409.6zM270.49 204.8v76.902h175.974l-175.974-76.85zm484.71 0l-175.923 76.902H755.2v-76.85z" fill="#e2b987"></path></svg>-->
        <!--                                                        </use></svg></i>领取VIP会员福利 </a></li>-->
        <!--                                        <li class="header-vippop-wrap"><a href="" class="header-vippop-item J-pop-item T-pop-item"><i class="qy20-header-icon qy20-header-svg qy20-header-welfare-g"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-welfare-g">-->
        <!--                                                            <svg id="qy20-header-welfare-g" title="做任务领奖励" viewBox="0 0 1024 1024"><path d="M921.6 0v766.464c0 29.184-22.938 52.736-51.2 52.736H0V52.736C0 23.552 22.938 0 51.2 0h870.4zM155.648 409.6H102.4v307.2h256V447.078a102.349 102.349 0 0 1-1.74-1.024 273.613 273.613 0 0 1-30.926 26.01 200.653 200.653 0 0 1-87.756 37.53l-12.135 1.69a42.291 42.291 0 0 1-8.14.716c-22.221-1.69-41.114-15.82-47.565-35.635-3.84-7.987-10.957-27.443-14.439-66.765zm497.664 59.034l-1.843 5.017c-8.909 26.522-31.744 41.78-56.576 37.683a248.115 248.115 0 0 1-96-35.942 297.677 297.677 0 0 1-36.506-29.338l-1.587.922V716.8h358.4V409.6H663.706c-2.56 30.618-7.066 48.947-10.445 59.034zm-412.62-173.108l-.462 3.38c-1.433 11.98-2.56 28.108-2.816 48.742l-.05 10.752c0 26.266 1.382 45.824 3.225 59.392l.717 4.864 1.28-.358c9.01-3.072 17.664-7.168 25.907-12.442l8.14-5.632c11.777-8.602 22.477-18.227 32.052-29.082a103.066 103.066 0 0 1 0-33.894 187.904 187.904 0 0 0-23.655-22.016l-9.779-7.168a161.024 161.024 0 0 0-30.31-15.104l-4.199-1.434zm337.1-1.433l-1.229.41c-12.032 4.095-23.398 10.086-34.048 18.124-11.776 8.55-22.477 18.176-32.051 29.03a103.066 103.066 0 0 1 0 33.895c7.322 8.09 15.36 15.514 23.706 22.067l9.779 7.168c9.42 6.042 19.61 11.11 30.361 15.104l3.738 1.28.512-3.481a434.176 434.176 0 0 0 3.072-47.616l.256-11.674c0-26.266-1.382-45.824-3.226-59.392l-.768-4.915zM358.4 102.4h-256v204.8h51.2l1.894.051c2.51-30.669 6.964-48.998 10.394-59.085l1.843-5.017c8.909-26.522 31.744-41.78 56.576-37.683a248.934 248.934 0 0 1 96 35.942 293.882 293.882 0 0 1 36.455 29.338c1.024-.717 2.15-1.332 3.276-1.997A49.152 49.152 0 0 1 358.4 256V102.4zm460.8 0H460.8V256c0 4.403-.512 8.704-1.587 12.8a112.64 112.64 0 0 1 3.328 1.946c9.523-9.319 19.917-18.023 30.925-26.01a200.653 200.653 0 0 1 87.756-37.53l12.135-1.638a42.189 42.189 0 0 1 8.14-.768c22.221 1.69 41.114 15.82 47.565 35.635 3.84 7.987 10.957 27.443 14.439 66.816l2.099-.051h153.6V102.4z" fill="#e2b987"></path></svg>-->
        <!--                                                        </use></svg></i>做任务，领奖励 </a></li>-->
        <!--                                        <li id="J-header-interact-wrap" class="header-vippop-wrap"><a href="" class="header-vippop-item J-pop-item"><img src="/images/NewVideo/vip_x.png" class="label-g label-home2020">星钻VIP享新权益 </a></li>-->
        <!--                                    </ul>-->
        <!--                                </div>-->
        <!--                                <div class="vippop-right">-->
        <!--                                    <div class="vipqrcode-title vipqrcode-first">-->
        <!--                                        <span>连续包月超低优惠</span>-->
        <!--                                    </div>-->
        <!--                                    <div class="vipqrcode-title">扫码查看详情</div>-->
        <!--                                    <div class="vipqrcode-mid"><img src="/images/NewVideo/getIMG.jpg" alt="" class="vipqrcode-img"></div>-->
        <!--                                    <div class="vipqrcode-bot">建议微信或支付宝扫码<br>支付后刷新享会员权益</div>-->
        <!--                                </div>-->
        <!--                            </div>-->
        <!--                            <div class="header-pop-button T-vipbtn-login">-->
        <!--                                <a href="javascript:void(0);" class="qy-button-small J-cash-open">登录</a></div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="header-sideItem qy-header__game">-->
        <!--            <div class="T-drop-click">-->
        <!--                <div class="T-icon-game">-->
        <!--                    <a href="" class="header-sideItemCon">-->
        <!--                        <i class="header-sideItemIcon qy20-header-svg qy20-header-svg-game">-->
        <!--                            <svg aria-hidden="true" viewBox="0 0 26 26" class="qy20-header-symbol"><linearGradient id="__gradient_header_game"><stop offset="0%" class="symbol-stop1"></stop><stop offset="100%" class="symbol-stop2"></stop></linearGradient><path d="M17 5c1.967-.001 3.534.423 4.733 1.652.732.75 1.328 1.8 1.794 3.237 1.23 3.797 3.628 10.134 1.823 11.717-1.665 1.46-5.578-.617-8.151-2.197a4.726 4.726 0 0 0-1.763-.653c-.6-.1-3.267-.098-3.865.001a4.727 4.727 0 0 0-1.768.657c-2.576 1.581-6.492 3.662-8.155 2.205a1.347 1.347 0 0 1-.087-.082c-1.636-1.678.708-7.903 1.92-11.637 1.235-3.795 3.365-4.895 6.533-4.896L15.917 5zM9 9a1 1 0 0 0-1 1v1H7a1 1 0 0 0 0 2h1v1a1 1 0 1 0 2 0v-1h1a1 1 0 0 0 0-2h-1v-1a1 1 0 0 0-1-1zm10 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"  ></path></svg>-->
        <!--                        </i>-->
        <!--                        <span class="header-sideItemTit">游戏</span>-->
        <!--                    </a>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="qy-header-game-pop selected">-->
        <!--                <div class="qy-popup-box">-->
        <!--                    <div class="popup-box-arrow"><span class="popup-box-arrowOut"><i class="popup-box-arrowIn"></i></span></div>-->
        <!--                    <div class="qy-header-gameCon">-->
        <!--                        <ul class="header-gamepop">-->
        <!--                            <li class="header-gamepop-item"><a href="" class="header-pop-link"><img src="/images/NewVideo/img03.jpg" alt="" class="game-img"></a></li>-->
        <!--                            <li class="header-gamepop-item"><a href="" class="header-pop-link"><img src="/images/NewVideo/img03.jpg" alt="" class="game-img"></a></li>-->
        <!--                        </ul>-->
        <!--                        <div class="header-pop-button"><a href="" class="game-more">查看更多</a></div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="header-sideItem header-upload">-->
        <!--            <div class="T-drop-click">-->
        <!--                <div  id="J-header-upload" class="J-header-upload">-->
        <!--                    <a  href="" class="header-sideItemCon">-->
        <!--                        <i class="header-sideItemIcon qy20-header-svg qy20-header-svg-upload">-->
        <!--                            <svg viewBox="0 0 26 26" aria-hidden="true" class="qy20-header-symbol"><linearGradient id="__gradient_header_upload"><stop offset="0%" class="symbol-stop1"></stop><stop offset="100%" class="symbol-stop2"></stop></linearGradient><path d="M13.806 17.976h2.211c.618 0 .843-.402.502-.901l-3.422-5.006c-.227-.331-.596-.329-.821 0l-3.422 5.006c-.34.498-.112.901.502.901h2.211V22H5.97C2.656 21.902 0 19.28 0 16.06c0-3.28 2.756-5.94 6.157-5.94.063 0 .126 0 .19.003a5.847 5.847 0 0 1-.004-.183C6.343 6.66 9.1 4 12.5 4s6.157 2.66 6.157 5.94l-.003.183a6.51 6.51 0 0 1 .19-.003c3.4 0 6.156 2.66 6.156 5.94 0 3.22-2.656 5.842-5.97 5.937L13.806 22v-4.024z"></path></svg>-->
        <!--                        </i>-->
        <!--                        <span class="header-sideItemTit">上传</span>-->
        <!--                    </a>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="qy-header-upload-pop selected J-upload-pop">-->
        <!--                <div class="qy-popup-box">-->
        <!--                    <div class="popup-box-arrow">-->
								<!--<span class="popup-box-arrowOut">-->
								<!--	<i class="popup-box-arrowIn"></i>-->
								<!--</span>-->
        <!--                    </div>-->
        <!--                    <div class="qy-header-uploadCon">-->
        <!--                        <ul id="nav_uploadMenu" class="header-uploadpop J-special-con">-->
        <!--                            <li class="header-uploadpop-item"><a href="" class="header-uploadpop-list"><i class="qy20-header-icon qy20-header-svg qy20-header-svg-videp"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-videp"><svg id="qy20-header-videp" viewBox="0 0 20 20"><g fill-rule="nonzero"><path d="M2 4v12h16V4H2zM1 2h18a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1z" opacity=".6"></path><path d="M9.844 6.168l.67.743a.5.5 0 0 1-.038.706l-2.972 2.676a.5.5 0 0 1-.706-.037l-.67-.743a.5.5 0 0 1 .037-.706l2.973-2.676a.5.5 0 0 1 .706.037zM10.5 6c.04 0 .08.005.117.014a.498.498 0 0 1 .379.133l2.925 2.728a.5.5 0 0 1 .025.706l-.682.732a.5.5 0 0 1-.707.024L11 8.885V13.5a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5h1z"></path></g></svg></use></svg></i>发布作品 </a></li>-->
        <!--                            <li class="header-uploadpop-item"><a href="" class="header-uploadpop-list"><i class="qy20-header-icon qy20-header-svg qy20-header-svg-manage"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-manage"><svg id="qy20-header-manage" viewBox="0 0 20 20"><g fill-rule="nonzero"><path d="M19 5a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h18zm-1 2H2v9h16V7zm.5-5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-17a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h17z" opacity=".6"></path><path d="M9.502 13.876c-.476.253-1.088.107-1.366-.327A.846.846 0 0 1 8 13.092V9.908C8 9.407 8.447 9 8.999 9c.177 0 .35.043.503.124l3.002 1.592c.477.252.638.808.36 1.241a.959.959 0 0 1-.36.327l-3.002 1.592z"></path></g></svg></use></svg></i>作品管理 </a></li>-->
        <!--                            <li class="header-uploadpop-item"><a href="" class="header-uploadpop-list"><i class="qy20-header-icon qy20-header-svg qy20-header-svg-mp"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-mp"><svg id="qy20-header-mp" viewBox="0 0 20 20"><g fill-rule="nonzero"><path d="M19 2a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1v-2h2v1h16V4H2v1H0V3a1 1 0 0 1 1-1h18z" opacity=".6"></path><path d="M1.5 10a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1zm0-3a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 7h1z" opacity=".6"></path><path d="M13.232 7.145l.574.568a.5.5 0 0 1 0 .71l-4.43 4.385a.502.502 0 0 1-.086.068l.064-.055a.5.5 0 0 1-.703 0l-2.503-2.476a.5.5 0 0 1-.003-.707l.003-.004.575-.569a.5.5 0 0 1 .703 0l1.58 1.564 3.523-3.484a.5.5 0 0 1 .703 0z"></path></g></svg></use></svg></i>爱奇艺号 </a></li>-->
        <!--                            <li class="header-uploadpop-item"><a href="" class="header-uploadpop-list"><i class="qy20-header-icon qy20-header-svg qy20-header-svg-myspace"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-myspace"><svg id="qy20-header-myspace" viewBox="0 0 20 20"><g fill-rule="nonzero"><path d="M9.5 20a9.5 9.5 0 1 1 0-19 9.5 9.5 0 0 1 0 19zm0-2a7.5 7.5 0 1 0 0-15 7.5 7.5 0 0 0 0 15z" opacity=".6"></path><path d="M9.5 5a3.5 3.5 0 0 1 2.078 6.316 6.917 6.917 0 0 1 3.185 2.078.963.963 0 0 1-.11 1.373 1 1 0 0 1-1.395-.109 4.966 4.966 0 0 0-3.766-1.71 4.966 4.966 0 0 0-3.752 1.696 1 1 0 0 1-1.396.103.963.963 0 0 1-.105-1.373 6.93 6.93 0 0 1 3.178-2.062A3.5 3.5 0 0 1 9.5 5zm0 1.75a1.75 1.75 0 1 0 0 3.5 1.75 1.75 0 0 0 0-3.5z"></path></g></svg></use></svg></i>我的空间 </a></li>-->
        <!--                        </ul>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="header-sideItem header-download">-->
        <!--            <div class="T-drop-click">-->
        <!--                <div class="header-sideItemCon J-download-title">-->
        <!--                    <div>-->
        <!--                        <i class="header-sideItemIcon qy20-header-svg qy20-header-svg-pca-dwn">-->
        <!--                            <svg viewBox="0 0 26 26" aria-hidden="true" class="qy20-header-symbol"><linearGradient id="__gradient_header_pca-dwn"><stop offset="0%" class="symbol-stop1"></stop><stop offset="100%" class="symbol-stop2"></stop></linearGradient><path d="M17.412 21c.325 0 .588.263.588.588v.824a.588.588 0 0 1-.588.588H9.588A.588.588 0 0 1 9 22.412v-.824c0-.325.263-.588.588-.588h7.824zm5.366-17C23.453 4 24 4.512 24 5.143v12.714c0 .631-.547 1.143-1.222 1.143H4.222C3.547 19 3 18.488 3 17.857V5.143C3 4.512 3.547 4 4.222 4h18.556zM11.335 8.147a1 1 0 0 0-.168.555v5.596a1 1 0 0 0 1.554.832l4.198-2.798a1 1 0 0 0 0-1.664L12.72 7.87a1 1 0 0 0-1.386.277z" fill="#FFFFFF" fill-opacity="0.3"></path></svg>-->
        <!--                        </i>-->
        <!--                        <span class="header-sideItemTit">客户端</span>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="qy-header-download-pop selected J-download-pop">-->
        <!--                <div class="qy-popup-box">-->
        <!--                    <div class="popup-box-arrow"><span class="popup-box-arrowOut"><i class="popup-box-arrowIn"></i></span></div>-->
        <!--                    <div class="qy-header-dlCon">-->
        <!--                        <ul class="header-dlpop">-->
        <!--                            <li class="header-dlpop-item"><a href="" class="header-pop-link J-download-item"><i class="qy20-header-icon qy20-header-svg qy20-header-svg-noad"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-noad"><svg id="qy20-header-noad" viewBox="0 0 20 20"><g fill-rule="nonzero"><path d="M12.5 7c1.38 0 2.5.96 2.5 2.143v.714C15 11.041 13.88 12 12.5 12h-2.083c-.23 0-.417-.16-.417-.357V7.357c0-.197.187-.357.417-.357H12.5zM8.184 7c.062 0 .121.014.173.038l.032.016.016.01a.35.35 0 0 1 .154.186l1.422 4.046c.066.186-.045.386-.246.447l-.73.219c-.201.06-.417-.042-.483-.228l-.169-.481H6.641l-.151.49c-.059.188-.271.297-.475.243l-.737-.195c-.204-.054-.321-.25-.263-.439l1.257-4.055.002-.014A.377.377 0 0 1 6.65 7h1.534zM12.5 8.429l-.834-.001v2.143h.834c.46 0 .833-.32.833-.714v-.714c0-.395-.373-.714-.833-.714zm-5.057.236l-.362 1.17h.774l-.412-1.17z"></path><path d="M10 19v-2.152c1.124 0 2.21-.292 3.2-.848l.8 1.939A8.127 8.127 0 0 1 10 19zm5.234-2L14 15.555A7.54 7.54 0 0 0 16.215 13l1.785.808A9.417 9.417 0 0 1 15.234 17zm3.527-5L17 11.589a7.25 7.25 0 0 0 .023-3.203L18.789 8a9.045 9.045 0 0 1-.028 4zM18 6.21L16.197 7A7.519 7.519 0 0 0 14 4.43L15.256 3A9.39 9.39 0 0 1 18 6.21zM14 2.07L13.196 4A6.508 6.508 0 0 0 10 3.146L10.004 1A8.142 8.142 0 0 1 14 2.069zM7.624 1L8 2.697A7.28 7.28 0 0 0 5.104 4L4 2.63A9.108 9.108 0 0 1 7.624 1zm-4.94 3L4 5.14A7.333 7.333 0 0 0 2.653 8L1 7.579A9.174 9.174 0 0 1 2.684 4zm-1.683 6l1.464.03v.118c0 1.08.184 2.125.535 3.081L1.67 14A11.184 11.184 0 0 1 1 10.148L1.001 10zM3 15.2L4.469 14A7.57 7.57 0 0 0 7 16.242L6.162 18A9.454 9.454 0 0 1 3 15.2zm5 3.53L8.403 17a6.147 6.147 0 0 0 1.597.216L9.994 19A7.68 7.68 0 0 1 8 18.73z" opacity=".6"></path></g></svg></use></svg></i>新用户广告特权 </a></li>-->
        <!--                            <li class="header-dlpop-item"><a href="" class="header-pop-link J-download-item"><i class="qy20-header-icon qy20-header-svg qy20-header-svg-jisu"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-jisu"><svg id="qy20-header-jisu" viewBox="0 0 20 20"><g fill-rule="nonzero"><path d="M10 17a7 7 0 1 0 0-14 7 7 0 0 0 0 14zm0 2a9 9 0 1 1 0-18 9 9 0 0 1 0 18z" opacity=".6"></path><path d="M12.391 8.37c.43.117.692.591.585 1.06a.907.907 0 0 1-.149.33l-2.835 3.907a.76.76 0 0 1-1.129.145.914.914 0 0 1-.294-.83l.263-1.705-1.153-.198c-.439-.075-.738-.522-.67-.999a.913.913 0 0 1 .166-.409l2.45-3.342a.76.76 0 0 1 1.129-.138.905.905 0 0 1 .302.683v1.133l1.335.363z"></path></g></svg></use></svg></i>极速流畅播放 </a></li>-->
        <!--                            <li class="header-dlpop-item"><a href="" class="header-pop-link J-download-item"><i class="qy20-header-icon qy20-header-svg qy20-header-svg-1080p"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-1080p"><svg id="qy20-header-1080p" viewBox="0 0 20 20"><g fill-rule="nonzero"><path d="M13.5 7C14.88 7 16 8.151 16 9.571v.858C16 11.849 14.88 13 13.5 13h-2.083a.423.423 0 0 1-.417-.429V7.43c0-.237.187-.429.417-.429H13.5zM5.25 7c.23 0 .417.192.417.429L5.666 9.57h1.667V7.429c0-.237.187-.429.417-.429h.833c.23 0 .417.192.417.429v5.142a.423.423 0 0 1-.417.429H7.75a.423.423 0 0 1-.417-.429v-1.286H5.666v1.286A.423.423 0 0 1 5.25 13h-.833A.423.423 0 0 1 4 12.571V7.43C4 7.192 4.187 7 4.417 7h.833zm8.25 1.714h-.834v2.571h.834c.46 0 .833-.383.833-.856V9.57a.845.845 0 0 0-.833-.857z"></path><path d="M2 5.828V16h12.172L18 14.172V4H5.828L2 5.828zM5.414 2H19a1 1 0 0 1 1 1v11.586a1 1 0 0 1-.293.707l-4.414 2.414a1 1 0 0 1-.707.293H1a1 1 0 0 1-1-1V5.414a1 1 0 0 1 .293-.707l4.414-2.414A1 1 0 0 1 5.414 2z" opacity=".6"></path></g></svg></use></svg></i>畅享4K视频 </a></li>-->
        <!--                        </ul>-->
        <!--                        <div class="header-pop-button"><a href="javascript:void(0);" id="J-download-experienceNow" class="qy-button-small">立即体验</a></div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="header-sideItem header-info">-->
        <!--            <a href="" class="header-sideItemCon J-message-title">-->
        <!--                <i class="header-sideItemIcon qy20-header-svg qy20-header-svg-info">-->
        <!--                    <svg viewBox="0 0 26 26" aria-hidden="true" class="qy20-header-symbol"><linearGradient id="__gradient_header_info"><stop offset="0%" class="symbol-stop1"></stop><stop offset="100%" class="symbol-stop2"></stop></linearGradient><path d="M15 21h-5c0 1.657 1.119 3 2.5 3s2.5-1.343 2.5-3zm6.624-4.698c.243.296.376.672.376 1.06 0 .905-.708 1.638-1.581 1.638H4.58c-.375 0-.737-.138-1.023-.39a1.68 1.68 0 0 1-.182-2.308l2.144-2.618V9.848C5.52 6.065 8.675 3 12.5 3c3.825 0 6.98 3.065 6.98 6.848v3.836l2.144 2.618z" fill="#FFFFFF" fill-opacity="0.3"></path></svg>-->
        <!--                </i>-->
        <!--                <span class="header-sideItemTit">消息</span>-->
        <!--            </a>-->
        <!--            <div class="qy-header-info-pop selected J-message-pop">-->
        <!--                <div class="qy-popup-box">-->
        <!--                    <div class="popup-box-arrow"><span class="popup-box-arrowOut"><i class="popup-box-arrowIn"></i></span></div>-->
        <!--                    <div class="qy-header-info-inner">-->
        <!--                        <div class="header-info-tab">-->
        <!--                            <ul class="header-info-tab-list">-->
        <!--                                <li class="header-info-tab-item J-tab-title selected T-tab-title-0"><a href="javascript:;" class="header-info-tab-title"> 更新提醒 <em class="header-info-tab-selected"></em></a></li>-->
        <!--                                <li class="header-info-tab-item J-tab-title T-tab-title-1"><a href="javascript:;" class="header-info-tab-title"> 与我相关 <em class="header-info-tab-selected"></em></a></li>-->
        <!--                                <li class="header-info-tab-item J-tab-title T-tab-title-2"><a href="javascript:;" class="header-info-tab-title"> 系统通知 <em class="header-info-tab-selected"></em></a></li>-->
        <!--                            </ul>-->
        <!--                        </div>-->
        <!--                        <div class="header-info-main">-->
        <!--                            <div class="header-info-item header-info-order T-tab-body-0" style="">-->
        <!--                                <div>-->
        <!--                                    <div class="header-pop-no-wrap has-btn">-->
        <!--                                        <p class="header-pop-no-tips">追剧更新立即通知，从不错过</p>-->
        <!--                                        <div class="btn-box">-->
        <!--                                            <a href="javascript:void(0)" class="qy-button-small info-btn">登录</a>-->
        <!--                                        </div>-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                                <ul class="header-related-list"></ul>-->
        <!--                            </div>-->
        <!--                            <div class="header-info-item header-info-related T-tab-body-1 dn"></div>-->
        <!--                            <div class="header-info-item header-info-related T-tab-body-2 dn"></div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="header-sideItem header-record">-->
        <!--            <div class="T-drop-click">-->
        <!--                <a href="" class="header-sideItemCon T-history-icon">-->
        <!--                    <i class="header-sideItemIcon qy20-header-svg qy20-header-svg-record">-->
        <!--                        <svg viewBox="0 0 26 26" aria-hidden="true" class="qy20-header-symbol"><linearGradient id="__gradient_header_record"><stop offset="0%" class="symbol-stop1"></stop><stop offset="100%" class="symbol-stop2"></stop></linearGradient><path d="M13 3c5.523 0 10 4.477 10 10s-4.477 10-10 10a9.989 9.989 0 0 1-8.398-4.569A9.945 9.945 0 0 1 3 13c0-2.034.607-3.973 1.725-5.617a10.057 10.057 0 0 1 3.413-3.124A9.947 9.947 0 0 1 13 3zm4.4 11c.331 0 .6-.224.6-.5v-1c0-.276-.269-.5-.6-.5l-3.401-.001L14 7.7c0-.348-.181-.637-.419-.69L13.5 7h-1c-.276 0-.5.313-.5.7v5.8c0 .17.1.319.255.41.072.057.156.09.245.09z"></path></svg>-->
        <!--                    </i>-->
        <!--                    <span class="header-sideItemTit">看过</span>-->
        <!--                </a>-->
        <!--            </div>-->
        <!--            <div class="J-header-play-history-dropdown-wrap qy-header-record-pop-v1 selected">-->
        <!--                <div class="qy-popup-box">-->
        <!--                    <div class="popup-box-arrow"><span class="popup-box-arrowOut"><i class="popup-box-arrowIn"></i></span></div>-->
        <!--                    <div class="qy-header-record-inner">-->
        <!--                        <div style="">-->
        <!--                            <div class="header-record-filter">-->
        <!--                                过滤短视频-->
        <!--                                <i id="J-header-play-history-filter-icon" class="switch selected"></i>-->
        <!--                            </div>-->
        <!--                            <div class="header-pop-no-wrap header-record-no-item has-btn">-->
        <!--                                <i class="qy20-header-png icon-home2020 icon-home2020__empty"></i>-->
        <!--                                <p class="header-pop-no-tips">您还没有观看任何长视频哦</p>-->
        <!--                                <div class="btn-box T-history-unlogin-null">-->
        <!--                                    <a href="javascript:void(0)" class="qy-button-small record-btn">登录</a>-->
        <!--                                </div>-->
        <!--                            </div>-->
        <!--                            <div class="header-record-main J-header-history-scrollwrap">-->
        <!--                                <div class="header-pop-button-bottom">-->
        <!--                                    <a class="bottom-link T-history-more-unlogin">登录查看更多</a>-->
        <!--                                </div>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="header-sideItem header-user">-->
        <!--            <div class="T-drop-hover">-->
        <!--                <div class="T-drop-click">-->
        <!--                    <div class="header-sideItemCon">-->
        <!--                        <a class="header-userLink"><img src="/images/NewVideo/header-userImg-default-dark.png" alt="" class="header-userImg"></a>-->
        <!--                        <span class="header-sideItemTit T-icon-txt">登录</span><i class="qy-common-icon qy-common-msgdot"></i>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--                <div class="qy-header-login-pop-v1 selected">-->
        <!--                    <div id="nav_userBox" class="">-->
        <!--                        <div>-->
        <!--                            <div class="qy-popup-box">-->
        <!--                                <div class="popup-box-arrow"><span class="popup-box-arrowOut"><i class="popup-box-arrowIn"></i></span></div>-->
        <!--                                <div class="login-top">-->
        <!--                                    <div class="img-box"><a href="javascript:void(0);" class="img-link"><img src="/images/NewVideo/header-userImg-default-dark.png" class="avatar-img"></a></div>-->
        <!--                                    <div class="title">-->
        <!--                                        <a class="user-link">登录</a><i class="slash">/</i>-->
        <!--                                        <a class="user-link">注册</a><span class="user-txt">后，你可以：</span>-->
        <!--                                    </div>-->
        <!--                                    <div class="right">-->
        <!--                                        <a href="javascript:void(0)" class="qy-button-small login-btn"> 登录 </a>-->
        <!--                                    </div>-->
        <!--                                </div>-->
        <!--                                <ul class="login-top-list">-->
        <!--                                    <li class="login-top-item">-->
        <!--                                        <a href="" class="login-top-link">-->
        <!--                                            <div class="item-left">-->
        <!--                                                <i class="login-pop-icon qy20-header-svg qy20-header-svg-user-record"><svg aria-hidden="true" class="qy20-header-symbol"></svg><svg id="qy20-header-login-record" viewBox="0 0 24 24"><g fill-rule="evenodd"><path d="M5.101 2.183a12.17 12.17 0 0 0-3.053 3.111l1.656 1.122a10.17 10.17 0 0 1 2.551-2.6L5.101 2.184zM.972 7.256c-.58 1.34-.908 2.78-.964 4.26l2 .076a9.841 9.841 0 0 1 .8-3.543L.972 7.256zm-.847 6.44c.213 1.46.695 2.857 1.417 4.132l1.74-.986a9.845 9.845 0 0 1-1.178-3.435l-1.98.288zm2.667 5.934a12.211 12.211 0 0 0 3.351 2.785l.984-1.741a10.211 10.211 0 0 1-2.802-2.329L2.792 19.63zm5.326 3.68a12.33 12.33 0 0 0 4.036.69l.302-.003-.04-2-.258.003a10.326 10.326 0 0 1-3.38-.578l-.66 1.888zm6.502.453c1.363-.271 2.66-.77 3.844-1.47l-1.018-1.72A10.229 10.229 0 0 1 14.23 21.8l.39 1.962zM12.228 0C18.73 0 24 5.274 24 11.779a11.77 11.77 0 0 1-5.392 9.9l-.28.176-1.038-1.71A9.772 9.772 0 0 0 22 11.78C22 6.378 17.625 2 12.228 2c-.967 0-1.915.14-2.82.413l-.247.08-.56.421-1.202-1.599L8.218.7l.147-.05A11.75 11.75 0 0 1 12.228 0z" fill-rule="nonzero"></path><path d="M10.624 6a.637.637 0 0 0-.624.65v5.204c0 .153.051.293.133.404l.014.022 2.643 4.414a.61.61 0 0 0 .86.207l1.056-.69a.664.664 0 0 0 .199-.895l-2.411-4.029V6.65c0-.36-.28-.65-.623-.65h-1.247z"></path></g></svg></i>-->
        <!--                                            </div>-->
        <!--                                            <div class="item-right">-->
        <!--                                                <p class="des-1">多端记录同步</p><p class="des-2">各端尽情看，记录永相随</p>-->
        <!--                                            </div>-->
        <!--                                        </a>-->
        <!--                                    </li>-->
        <!--                                    <li class="login-top-item">-->
        <!--                                        <a href="" class="login-top-link">-->
        <!--                                            <div class="item-left">-->
        <!--                                                <i class="login-pop-icon qy20-header-svg qy20-header-svg-user-gift"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-login-gift"><svg id="qy20-header-login-gift" viewBox="0 0 24 24"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10m0 2C5.374 24 0 18.627 0 12S5.374 0 12 0s12 5.373 12 12-5.374 12-12 12m.938-9.995h2.512c.322 0 .582.264.582.59v.792c0 .326-.26.59-.582.59h-2.512v2.433c0 .326.052.59-.27.59H11.59a.585.585 0 0 1-.582-.59v-2.432H8.591a.587.587 0 0 1-.582-.591v-.793c0-.325.261-.589.582-.589h2.417V13H8.591a.585.585 0 0 1-.582-.59v-.778c0-.327.261-.591.582-.591h2.417L7.632 7.659a.596.596 0 0 1 .071-.83l.77-.691a.575.575 0 0 1 .817.072L12 9.468l2.616-3.258a.575.575 0 0 1 .818-.072l.735.565c.244.209.277.58.07.831l-3.301 3.507h2.512c.322 0 .582.264.582.59v.779c0 .327-.26.59-.582.59h-2.512v1.005z" fill-rule="evenodd"></path></svg></use></svg></i>-->
        <!--                                            </div>-->
        <!--                                            <div class="item-right">-->
        <!--                                                <p class="des-1">积分兑换礼品</p><p class="des-2">只要积分够，好礼随便送</p>-->
        <!--                                            </div>-->
        <!--                                        </a>-->
        <!--                                    </li>-->
        <!--                                    <li class="login-top-item">-->
        <!--                                        <a href="" class="login-top-link">-->
        <!--                                            <div class="item-left">-->
        <!--                                                <i class="login-pop-icon qy20-header-svg qy20-header-svg-user-barrage"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-login-barrage"><svg id="qy20-header-login-barrage" viewBox="0 0 24 24"><path d="M7 7c-.76 0-1 .224-1 .667v.666C6 8.776 6.24 9 7 9h11c.76 0 1-.224 1-.667v-.666C19 7.224 18.76 7 18 7H7zm0 5c-.775 0-1 .336-1 1 0 .665.225 1 1 1h5c.776 0 1-.335 1-1 0-.664-.224-1-1-1H7zm10 6v2.929L13 18H2V3h20v15h-5zM2 1C.831 1 0 1.829 0 3v16c0 .554.831 1.384 2 1h10l6 4c.894 0 1.419-.415 1-1v-3h3c1.169.384 2-.446 2-1V3c0-1.171-.831-2-2-2H2z" fill-rule="evenodd"></path></svg></use></svg></i>-->
        <!--                                            </div>-->
        <!--                                            <div class="item-right">-->
        <!--                                                <p class="des-1">弹幕 · 评论</p><p class="des-2">分享你的想法</p>-->
        <!--                                            </div>-->
        <!--                                        </a>-->
        <!--                                    </li>-->
        <!--                                    <li class="login-top-item">-->
        <!--                                        <a href="" class="login-top-link">-->
        <!--                                            <div class="item-left">-->
        <!--                                                <i class="login-pop-icon qy20-header-svg qy20-header-svg-user-collect"><svg aria-hidden="true" class="qy20-header-symbol"><use xlink:href="#qy20-header-login-collect"><svg id="qy20-header-login-collect" viewBox="0 0 24 24"><path d="M2 17h20V3H2v14zM1.301 1C.582 1 0 1.567 0 2.267v15.466C0 18.433.582 19 1.301 19H22.7c.719 0 1.3-.568 1.3-1.267V2.267C24 1.567 23.419 1 22.7 1H1.301zm4.364 20c-.367 0-.665.224-.665.5v1c0 .276.298.5.665.5h12.668c.369 0 .667-.224.667-.5v-1c0-.276-.298-.5-.667-.5H5.665zm3.75-7.32c.139.137.343.164.511.087a.455.455 0 0 0 .153-.1l7.627-6.263a.445.445 0 0 0 0-.636l-.642-.636a.457.457 0 0 0-.642 0L9.74 11.457 7.42 8.475a.459.459 0 0 0-.644 0l-.643.637a.446.446 0 0 0 0 .636l3.282 3.932z" fill-rule="evenodd"></path></svg></use></svg></i>-->
        <!--                                            </div>-->
        <!--                                            <div class="item-right">-->
        <!--                                                <p class="des-1">精彩剧情及时追</p><p class="des-2">追看你的喜爱</p>-->
        <!--                                            </div>-->
        <!--                                        </a>-->
        <!--                                    </li>-->
        <!--                                </ul>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
            </div>
        </div>
    </div>
</header>
<div class="c"></div>

<!-- banner -->
<div class="banner">
    <i class="qy20-h-carousel__voice" style="display:none" data-v-10a61a8c="">
        <svg viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg" width="40" height="40" class="qy20-h-carousel__voice-off"><path d="M20.854 12c.575 0 1.075.37 1.14 1.027l.006.146v14.646A1.14 1.14 0 0 1 20.838 29c-.232 0-.479-.063-.72-.202l-.143-.092-4.32-3.357h-3.397c-.577 0-1.183-.496-1.252-1.014L11 24.231v-7.446c-.013-.655.541-1.04 1.138-1.103l.12-.008h3.397l4.317-3.382c.283-.198.592-.292.882-.292zM20 14.81l-3.655 2.864L13 17.673l-.001 5.675h3.342L20 26.194V14.81zm4.64 2.47l1.859 1.86 1.86-1.86a.965.965 0 0 1 1.27-.08l.09.08c.345.346.372.894.08 1.27l-.08.09-1.86 1.86 1.86 1.86a.966.966 0 0 1 0 1.36.964.964 0 0 1-1.359 0l-1.861-1.861-1.86 1.86a.965.965 0 0 1-1.269.08l-.09-.08a.967.967 0 0 1-.08-1.27l.08-.09 1.859-1.86-1.859-1.858a.966.966 0 0 1 0-1.36.964.964 0 0 1 1.36 0z" opacity=".9" fill="#ffffff"></path></svg>
        <svg viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg" width="40" height="40" class="qy20-h-carousel__voice-on" style="display:none;"><path d="M20.854 12c.575 0 1.075.37 1.14 1.027l.006.146v14.646A1.14 1.14 0 0 1 20.838 29c-.232 0-.479-.063-.72-.202l-.143-.092-4.32-3.357h-3.397c-.577 0-1.183-.496-1.252-1.014L11 24.231v-7.446c-.013-.655.541-1.04 1.138-1.103l.12-.008h3.397l4.317-3.382c.283-.198.592-.292.882-.292zm4.676 1.56a.65.65 0 0 1 .54.257 8.246 8.246 0 0 1 3.713 6.892 8.243 8.243 0 0 1-3.714 6.893l-.009-.008a.65.65 0 0 1-.954-.841l-.015-.014.041-.025c.11-.17.3-.284.518-.291l-.086.01a6.992 6.992 0 0 0 2.969-5.724 6.995 6.995 0 0 0-3.233-5.9.634.634 0 0 1-.166-.101 1.6 1.6 0 0 0-.084-.052l.017-.014a.65.65 0 0 1 .463-1.082zM20 14.81l-3.655 2.864L13 17.673l-.001 5.675h3.342L20 26.194V14.81zM23.75 17c.23 0 .437.104.574.268l.002-.003A4.984 4.984 0 0 1 25.79 20.8c0 1.38-.56 2.63-1.464 3.535a.762.762 0 0 1-.576.265.75.75 0 0 1-.483-1.324l-.002-.001A3.489 3.489 0 0 0 24.29 20.8c0-.966-.391-1.84-1.024-2.474A.76.76 0 0 1 23 17.75a.75.75 0 0 1 .75-.75z" opacity=".9" fill="#ffffff"></path></svg></i>
    <div class="qy20-h-carousel__masktop">
        <div class="qy20-h-carousel__masktop1" style="background-image: linear-gradient(rgba(25, 26, 32, 0.9), rgba(25, 26, 32, 0.7));"></div>
        <div class="qy20-h-carousel__masktop2" style="background-image: linear-gradient(rgba(25, 26, 32, 0.7), rgba(25, 26, 32, 0));"></div>
    </div>
    <div class="qy20-h-carousel__maskbottom"></div>
    <div class="slider slider-for">
        <?php if(!empty($data['banner'])) : ?>
            <?php foreach ($data['banner'] as $banner): ?>
                <div>
                    <a href="<?= str_replace("/detail","/detail",$banner['content'])?>"
                       style="background-image: url(<?= $banner['image']?>)">
                        <img src="<?= $banner['image']?>" alt="">
                    </a>
                </div>
            <?php endforeach ?>
        <?php endif;?>
    </div>
    <div class="slider slider-nav qy20-h-carousel_panel-list">
        <?php if(!empty($data['banner'])) : ?>
            <?php foreach ($data['banner'] as $banner): ?>
                <div class="panel-item">
                    <a href="<?= str_replace("/detail","/detail",$banner['content'])?>" class="panel-item-link">
                        <p class="panel-item-title">
                            <span class="panel-ico">
                                <img src="/images/NewVideo/83cdbeafb78647f2b7b141e6cb87733a.svg" alt="角标" class="panel-img">
                            </span>
                            <span class="title-main"><?= $banner['title']?></span>
                        </p>
                        <!--                        <p class="panel-item-dec"></p>-->
                    </a>
                </div>
            <?php endforeach ?>
        <?php endif;?>
    </div>
</div>
<!-- banner end -->
<div class="qy20-h-carousel-wrap">
    <div class="qy20-h-carousel">
        <div class="qy20-h-carousel__fixed">
            <div class="qy20-h-carousel__inner">
                <div class="qy20-nav-focus focus-gray">
                    <div class="qy-nav-inner">
                        <div class="qy-nav-wrap">
                            <!--  -->
                            <div class="qy20-nav-channel-box">
                                <?php if(!empty($channels)) : ?>
                                    <?php foreach ($channels['list'] as $key => $channel): ?>
                                        <div class="qy20-nav-list qy20-nav-channel">
                                            <div class="nav-channel-box">
                                                <div class="channel-box-inner">
                                                    <a href="<?= Url::to(['video/channel', 'channel_id' => $channel['channel_id']])?>"
                                                       class="qy20-nav-link channel-link">
                                                        <span class="nav-en">WATCH ME</span>
                                                        <span class="nav-name"><?= $channel['channel_name']?></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php foreach ($hotword['tab'] as $key => $tab): ?>
                                            <?php if($tab['title'] == $channel['channel_name'] && count($tab['list']) > 0) :?>
                                            <div class="qy-nav-panel-popup" style="display: none;">
                                                <span class="popup-box-arrow"></span>
                                                <div class="panel-wrap-inner">
                                                    <h2 class="panel-wrap-title">
                                                        <a href="<?= Url::to(['video/channel', 'channel_id' => $channel['channel_id']])?>">
                                                            全部<?= $channel['channel_name']?> &gt;</a></h2>
                                                    <div class="panel-title-txt">
                                                    </div>
                                                    <ul class="panel-wrap-list">
                                                        <?php foreach ($tab['list'] as $key2 => $list): ?>
                                                            <?php if($key2 < 4){?>
                                                                <li class="panel-item">
                                                                    <div class="item-pic">
                                                                        <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>" class="item-link">
                                                                            <img src="<?= $list['cover']?>" alt="<?= $list['video_name']?>" style="height:150px">
                                                                            <div title="<?= $list['video_name']?>" class="panel-title-txt">
                                                                                <?= $list['video_name']?>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </li>
                                                            <?php }?>
                                                        <?php endforeach;?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php endif;?>
                                            <?php endforeach;?>
                                        </div>
                                    <?php endforeach ?>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="c"></div>

<div class="qy20-content-wrap">
    <div class="wp">
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
                    <div class="qy-mod-wrap-side" id="mod-wrap<?= $channel?>">
                        <div class="mod-left right-col-1">
                            <div class="qy-mod-header">
                                <h2 class="qy-mod-title">
                                    <a class="link-txt" href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag])?>">
                                        <span class="qy-mod-text"><?= $labels['title']?></span></a>
                                </h2>
                                <div class="qy-mod-nav-link">
                                    <ul class="qy-mod-crumb hasTurnBtn">
                                        <!--<li><a href="">内地</a><em>|</em></li>
                                        <li><a href="">自制剧</a><em>|</em></li>
                                        <li><a href="">网络剧</a><em>|</em></li>
                                        <li><a href="">迷雾剧场</a><em>|</em></li>
                                        <li><a href="">哎青春剧场</a><em>|</em></li>
                                        <li><a href="">神剧亮了</a><em>|</em></li>-->
                                        <li><a href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag])?>">
                                                更多 ></a></li>
                                    </ul>
                                </div>
                                <!-- Add Arrows -->
                                <div class="swiper-button-next"><span rseat="712211_dianshiju_right" class="turn turn-right" data-v-74838658="" data-v-11eb7ce2=""><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="rightarrow_cu" data-v-74838658="" data-v-11eb7ce2=""><path d="M10 0C4.477 0 0 4.477 0 10s4.477 10 10 10 10-4.477 10-10S15.523 0 10 0zM7.561 4.95a1.429 1.429 0 0 1 2.02 0L14.633 10l-5.05 5.05-.125.112a1.429 1.429 0 0 1-1.896-.111l-.11-.125a1.429 1.429 0 0 1 .11-1.896l3.03-3.03-3.03-3.03-.11-.125a1.429 1.429 0 0 1 .11-1.896z" ></path></svg></span></div>
                                <div class="swiper-button-prev"><span rseat="712211_dianshiju_left" class="turn turn-left" data-v-74838658="" data-v-11eb7ce2=""><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="leftarrow_cu" data-v-74838658="" data-v-11eb7ce2=""><path d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10 4.477 0 10 0zm2.439 4.95a1.429 1.429 0 0 0-2.02 0L5.367 10l5.05 5.05.125.112c.56.444 1.378.407 1.896-.111l.11-.125a1.429 1.429 0 0 0-.11-1.896L9.409 10l3.03-3.03.11-.125a1.429 1.429 0 0 0-.11-1.896z"></path></svg></span></div>
                            </div>
                            <div class="c"></div>
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
<!--                                                            <div class="icon-tr">
                                                                <img src="images/VIP.png">
                                                            </div>-->
                                                            <div class="icon-br icon-b">
                                                                <span class="qy-mod-label">
                                                                    <?= $list['flag']?>
                                                                </span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="title-wrap">
                                                        <p class="main">
                                                            <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>" class="link-txt" >
                                                                <span ><?= $list['video_name']?></span>
                                                            </a>
                                                        </p>
                                                        <p class="sub"><?= $list['summary']?></p>
                                                    </div>
                                                </div>
                                                <div class="qy-video-card-small type-vertical">
                                                    <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"
                                                       class="qy-vc-small_link">
                                                        <div class="qy-vc-small_video">
                                                            <img src="<?= $list['horizontal_cover']?>" alt="" class="qy-vc-small_img">
                                                            <span class="qy-vc-small_play">
												                <svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="200" height="200" class="vc-play-svg"><path d="M884.622222 440.888889L216.177778 25.6C159.288889-11.377778 85.333333 31.288889 85.333333 96.711111v830.577778c0 68.266667 73.955556 108.088889 130.844445 71.111111l671.288889-415.288889c51.2-31.288889 51.2-110.933333-2.844445-142.222222z"></path></svg>
                                                            </span>
                                                            <span class="qy-vc-small-collect" style="display: none">
												                <span class="qy-vc-small_collected-text">收藏</span>
                                                                <svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="200" height="200" class="vc-collect-svg collect-svg"><path d="M767.748389 673.645714a130.925714 130.925714 0 0 1 27.209142-84.845714l145.334858-187.757714-225.865143-65.243429a129.828571 129.828571 0 0 1-72.045715-52.955428L512.187246 86.820571l-130.194286 196.022858c-16.969143 25.6-42.496 44.397714-72.045714 52.955428l-225.865143 65.243429L229.343817 588.8c18.724571 24.210286 28.379429 54.272 27.282286 84.845714l-8.484572 237.421715 219.209143-81.188572c28.964571-10.678857 60.708571-10.678857 89.673143 0l219.209143 81.188572-8.484571-237.421715z m-275.017143 224.841143l-242.541715 89.819429a56.393143 56.393143 0 0 1-72.630857-34.157715 58.002286 58.002286 0 0 1-3.364571-21.796571l9.362286-261.339429a57.782857 57.782857 0 0 0-11.995429-37.449142L12.255817 427.739429a57.782857 57.782857 0 0 1 9.654857-80.457143 56.32 56.32 0 0 1 19.382857-10.020572l248.32-71.753143a56.685714 56.685714 0 0 0 31.451429-23.113142L465.156389 25.307429a56.173714 56.173714 0 0 1 93.988571 0l144.091429 217.088a56.685714 56.685714 0 0 0 31.451428 23.113142l248.393143 71.68a57.417143 57.417143 0 0 1 29.037714 90.550858l-159.305143 205.824a57.782857 57.782857 0 0 0-11.995428 37.449142l9.362286 261.339429a57.051429 57.051429 0 0 1-54.491429 59.392 55.954286 55.954286 0 0 1-21.504-3.437714l-242.541714-89.819429a55.954286 55.954286 0 0 0-38.912 0z"></path></svg>
											                </span>
                                                        </div>
                                                    </a>
                                                    <div class="qy-vc-small_content">
                                                        <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>" class="qy-vc-small_title"><?= $list['video_name']?></a>
                                                        <div class="qy-vc-small_type">
                                                            <label class="label-type">类型：</label>
                                                            <span class="label-con">
                                                                <span class="label"><?= $list['category']?></span>
											                </span>
                                                        </div>
                                                        <div>
                                                            <div class="qy-vc-small_type">
                                                                <label class="label-type">主演：</label>
                                                                <span class="label-con">
                                                                    <?php if (!empty($list['actors'])) :?>
                                                                        <?php foreach ($list['actors'] as $key => $actor): ?>
                                                                            <span class="label"><?= $actor['actor_name']?></span>
                                                                        <?php endforeach;?>
                                                                    <?php endif;?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="qy-vc-small_desc"><?= $list['intro']?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                        <div class="mod-right qy-col-1">
							<?php
								$channelName = '';
								foreach ($channels['list'] as $s_k => $s_v) {
									if($s_v['channel_id'] == $channel) {
										$channelName = $s_v['channel_name'];
									}
								}
							?>
							<div class="qy-mod-header">
                                <h2 class="qy-mod-title">
                                    <a class="link-txt" href=""><span class="qy-mod-text">推荐榜</span></a>
                                    <div class="qy-mod-nav-link">
                                        <ul class="qy-mod-crumb">
                                            <li class="crumb-li"><a href=""></a></li>
                                        </ul>
                                    </div>
                                </h2>
                            </div>   						
                            <div class="qy-rank-index">
                                <ul class="qy-rank-list">
									<?php foreach ($hotword['tab'] as $key => $tab): ?>
										<?php if($tab['title'] == $channelName) :?>
											<?php foreach ($tab['list'] as $key => $list): ?>
												<li class="qy-rank-item qy-rank-<?= $key+1?>">
													<a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>" class="qy-rank-img-link">
														<span class="qy-rank-no">NO</span>
														<div class="qy-rank-num"><?= $key+1?></div>
														<div class="qy-rank-content">
															<div class="qy-rank-title"><?= $list['video_name']?></div>
															<div class="qy-rank-detail">
														<span class="qy-rank-hot">
															<svg width="9px" height="12px" viewBox="0 0 9 12" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M3.9421478,-6.66133815e-16 L4.1052901,0.092246338 L4.55975388,0.517703424 C5.74598595,1.64483368 6.68865412,2.75575744 6.47111799,4.88653712 C6.38953215,5.16307536 6.55268914,5.43966836 6.71584614,5.62417928 C6.96057429,5.71637086 7.28688828,5.71637086 7.53161643,5.34742202 L7.77936845,5.12890809 C8.0402125,4.90584563 8.20235664,4.79432728 8.26580086,4.79432728 C8.75527185,5.53191469 9,6.36165718 9,7.56034851 C9,10.5104791 6.38953215,11.6168146 5.24746257,11.8934076 C4.59484928,12.0779185 3.45267681,11.985873 3.12637752,11.8934076 C2.31060723,11.6168146 1.49483695,11.0638294 0.923794809,10.3259864 C-0.136703622,8.85112192 -0.299845921,6.82248732 0.515909666,5.16307536 C0.84222366,4.51778904 1.33167995,3.96469431 1.90272209,3.31920722 L2.40317485,2.79700735 C3.05897374,2.09098319 3.64594387,1.32649007 3.88877021,0.270268152 L3.9421478,-6.66133815e-16 Z M7.78806257,6.45966305 C7.40290132,6.68693621 6.95546408,6.73209791 6.52415274,6.61251383 L6.36332002,6.55998126 L6.13110127,6.47250209 L5.96672022,6.28660691 C5.58613535,5.85621122 5.36171944,5.34118153 5.47313971,4.76284973 L5.481,4.731 L5.49439334,4.57127216 C5.56830571,3.45646298 5.27635777,2.72874729 4.44785317,1.82437353 L4.406,1.781 L4.35405123,1.88092288 C4.02933909,2.46526132 3.56195951,3.03069776 2.88515022,3.73986713 L2.65169888,3.98180345 L2.08785557,4.63095648 C2.02217858,4.70991277 1.96421364,4.781918 1.90430615,4.85847247 C1.68748527,5.13554318 1.52846336,5.37671649 1.41333429,5.60424317 C0.760633722,6.93196823 0.890432522,8.56666025 1.71461765,9.71394133 C2.14680536,10.2723706 2.78785928,10.7227138 3.39901802,10.9312916 C3.67277305,11.0088672 4.60721156,11.0352246 5.01208146,10.9215045 C6.67582033,10.5185706 8,9.38659986 8,7.56034851 C8,7.20547479 7.97667435,6.89396702 7.92818517,6.61287895 L7.884,6.396 L7.78806257,6.45966305 Z" id="Shape-sp-126-1-2" fill="#FF1D1D" fill-opacity=""></path></svg>
															<span class="qy-rank__hotscore"><?= $list['play_times']?></span>
														</span>
															</div>
														</div>
													</a>
												</li>
											<?php endforeach;?>
										<?php endif;?>
									<?php endforeach;?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php  else: ?>
                    <div class="video-add-column">
                        <a href="<?= $labels['ad_skip_url']?>">
                            <img src="<?= $labels['ad_image']?>" alt="">
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach;?>
        <?php endif; ?>
    </div>
</div>
<div class="c"></div>
<footer class="qy-footer">
	<div class="wp">
		<p>本网站为非赢利性站点，所有内容均由机器人采集于互联网，或者网友上传，本站只提供WEB页面服务，本站不存储、不制作任何视频，不承担任何由于内容的合法性及健康性所引起的争议和法律责任。<br />若本站收录内容侵犯了您的权益，请附说明联系邮箱，本站将第一时间处理。站长邮箱：guazitv@163.com</p>
	</div>
</footer>
<div class="qy-float-anchor det-nav" style="" id="det-nav">
	<ul class="anchor-list">
		<?php if(!empty($channels)) : ?>
			<?php foreach ($channels['list'] as $key => $channel): ?>
				<?php if($channel['channel_id'] != 0) : ?>
					<li class="list-item"><a href="#section<?= $channel['channel_id']?>" class="list-link"><?= $channel['channel_name']?></a></li>
				<?php endif;?>				
			<?php endforeach ?>
		<?php endif;?>
		<li class="list-item"><a href="javascript:void(0)" class="list-link backToTop"><svg class="back-top-svg" viewBox="0 0 20 12" xmlns="http://www.w3.org/2000/svg"><path d="M10.784 2.305l6.91 6.911a1.045 1.045 0 1 1-1.477 1.478L10 4.477l-6.217 6.217a1.045 1.045 0 0 1-1.478-1.478l6.911-6.91c.189-.189.43-.29.677-.305h.214c.246.014.488.116.677.304z"></path></svg>顶部</a></li>
	</ul>
</div>
<script src="/js/jquery.js"></script>
<script src="/js/VideoSearch.js"></script>