<?php
use yii\helpers\Url;

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = '瓜子TV|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv - m.guazitv.tv';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子|tv|瓜子tv|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv|爱影视|澳洲爱影视|澳洲同城影视网|体育直播|澳洲足球直播|澳洲体育直播|美剧|电影|综艺||看tv|kantv']);

header('X-Frame-Options:Deny');
?>
<script src="/js/jquery.min.js"></script>
<script>
    $(document).ready(function(){
		var mobile_flag = isMobile();

		if(mobile_flag == false){
			window.location = "<?=PC_HOST_PATH?>";
		}
		
		// if ($("#jBox1").length > 0) {
        //     $(".flashCount").text("关闭")
        //     $(".bgcover").fadeIn();
		// }
		
		$(".jBox-closeButton, #jBox1").click(function(){
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
        right: 20px;
        /*width: 46px;*/
        /*height: 24px;*/
        background: transparent;
        z-index: 10001;
        position: absolute;
        color: #fff;
        padding: 10px 0 0 10px;
        font-size: 16px;
    }
    .a-small{
        width: 50%;
        padding:0 7.5px;
    }
    .img-small{
        width: 100%;
    }
</style>

<header class="video-header">
    <div class="video-header-top clearfix">
        <a class="logo fl">瓜子TV</a>
        <div class="search-cont fr">
            <div class="search-notice"><?php if(!empty($channels['hot_word'])) : ?><?= $channels['hot_word'][0]?><?php endif;?></div>
        </div>
    </div>
    <input type="hidden" id="swiper-type" value="index">
    <div class="video-top-nav swiper-container" id="topNav">
        <ul class="swiper-wrapper">
            <?php if(!empty($channels)) : ?>
                <?php foreach ($channels['list'] as $key => $channel): ?>
                    <li class="swiper-slide swiper-slide-li <?= $channel['channel_id'] == $channel_id ? 'on' : ''?>">
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
            <?php foreach ($data['tags'] as $key=>$li): ?>
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
                <?php if($key<4):?>
                <li class="swiper-slide on"><a href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag])?>"><?= $li['name']?></a></li>
                <?php endif;?>
            <?php endforeach ?>
        <?php endif;?>
    </ul>
</div>
<!--今日热点-->
<div class="video-index-column mt15 today-hot-div" style="display:none;">
    <h3 class="video-index-title">今日热点</h3>
    <div id="today-hot" class="video-list-box clearfix swiper-container " style="margin:20px 7.5px 0;padding:0;"><!-- more-change-10 -->
        <div class="row-div swiper-wrapper cate-list-scroll">
            <a class="a-small swiper-slide swiper-slide-li" href="#" >
                <img src="/images/video/hot-2.jpg" class="img-small">
                <h5 class="video-item-name text-left" >攀登：可复制的领导力</h5>
            </a>
            <a class="a-small swiper-slide swiper-slide-li" href="#" >
                <img src="/images/video/hot-2.jpg" class="img-small">
                <h5 class="video-item-name text-left" >攀登：可复制的领导力</h5>
            </a>
            <a class="a-small swiper-slide swiper-slide-li" href="#" >
                <img src="/images/video/hot-2.jpg" class="img-small">
                <h5 class="video-item-name text-left" >攀登：可复制的领导力</h5>
            </a>
            <a class="a-small swiper-slide swiper-slide-li" href="#" >
                <img src="/images/video/hot-2.jpg" class="img-small">
                <h5 class="video-item-name text-left" >攀登：可复制的领导力</h5>
            </a>
        </div>
    </div>
</div>
<div class="video-other-more clearfix" style="display:none;">
    <a href="#" class="fl more-item ">
        <span>查看更多</span>
    </a>
    <a href="#" class="fl more-item"><!-- more-change -->
        <span class="change">换一换</span>
    </a>
</div>

<?php if (!empty($data['label'])) :?>
    <?php foreach ($data['label'] as  $i=>$labels): ?>
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
            <!-- 类目页去除第一个 -->
            <?php if (!($channel_id!=0 && $i==0)) : ?>
            <div class="video-index-column <?= $key == 0 ? 'mt20' : 'mt15';?>">
                <h3 class="video-index-title"><?= $labels['title']?></h3>
                <dl class="video-list-box clearfix <?= 'more-change-'.$labels['recommend_id'] ?>">
                    <?php foreach ($labels['list'] as $key => $list): ?>
                        <?php if($key < 9) :?>
                        <dd>
                            <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                                <div class="video-item-top">
                                    <img originalSrc="<?= $list['cover']?>" src="/images/default-cover.jpg">
                                    <div class="mark-box">
                                        <p class="mark">
                                            <?php if(mb_strlen($list['flag']) > 11){
                                                echo mb_substr($list['flag'],0,11,'utf-8');
                                            }else{
                                                echo $list['flag'];
                                            } ?>
                                        </p>

                                    </div>
                                </div>
                                <h5 class="video-item-name"><?= $list['video_name']?></h5>
                                <p class="video-item-play">
                                    <?php if($channel_id==0 && $channel==2):?>
                                        <?= $list['summary']?>
                                    <?php else:?>
                                        <?= $list['play_times']?>
                                    <?php endif;?>
                                </p>
                            </a>
                        </dd>
                        <?php endif;?>
                    <?php endforeach;?>
                </dl>
            </div>
            <div class="video-other-more clearfix">
                <a href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag])?>" class="fl more-item ">
                    <span>查看更多</span>
                </a>
                <a href="javascript:;" class="fl more-item more-change" data-recommend="<?= $labels['recommend_id'] ?>">
                    <span class="change">换一换</span>
                </a>
            </div>
            <?php endif; ?>
<!--        --><?php // else: ?>
<!--            <div class="video-add-column">-->
<!--                <a href="">-->
<!--                    <img src="" alt="">-->
<!--                </a>-->
<!--            </div>-->
        <?php endif; ?>
    <?php endforeach;?>
<?php endif; ?>

<!--新片预告-->
<?php if($data['trailer']):?>
    <?php foreach ($data['trailer'] as $i=>$trailer):?>
    <div class="video-index-column mt15"><!--  trailer-div -->
        <h3 class="video-index-title"><?=$trailer['trailer_title']['title']?></h3>
<!--        <div id="trailer--><?//=$i?><!--" class="trailer-swiper">-->
<!--            <img class="trailer-arrow trailer-left" src="/images/video/xleft.png" />-->
<!--            <img class="trailer-arrow trailer-right" src="/images/video/xright.png" />-->
            <dl class="video-list-box clearfix ">
                <?php if($trailer['trailer']):?>
                    <?php foreach ($trailer['trailer'] as $key=>$list): ?>
                        <?php if($key < 6) :?>
                            <dd data-video-id="<?=$list['video_id']?>">
                                <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                                    <div class="video-item-top">
                                        <img originalSrc="<?= $list['cover']?>" src="/images/default-cover.jpg">
                                        <div class="mark-box">
                                            <p class="mark">
                                                <?php if(mb_strlen($list['flag']) > 11){
                                                    echo mb_substr($list['flag'],0,11,'utf-8');
                                                }else{
                                                    echo $list['flag'];
                                                } ?>
                                            </p>
                                        </div>
                                    </div>
                                    <h5 class="video-item-name"><?= $list['video_name']?></h5>
                                    <p class="video-item-play"><?= $list['title']?></p>
                                </a>
                            </dd>
                        <?php endif;?>
                    <?php endforeach ?>
                <?php endif;?>
            </dl>
        </div>
<!--    </div>-->
    <?php endforeach; ?>
<?php endif;?>
<div class="addtohomescreen" style="position: fixed;bottom: 1rem;left: 50%;transform: translateX(-50%);width: 75%;max-width: 75%;z-index: 2;display: none;">
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
<div style="width:100%;height:1rem;"></div>
<!--<div class="video-footer">
    <ul class="clearfix footer-top">
        <li><a href="#">关于我们</a></li>
        <li><a href="#">常见问题</a></li>
        <li><a href="#">免责声明</a></li>
    </ul>
    <p class="footer-bottom">Copyright&copy;优酷 youku.com 版权所有</p>
</div>-->
<!--底部导航-->
<div class="bottom-navi">
    <?php echo $this->render('/video/bottom',[
        'tab' =>    'home'
    ]);?>
</div>

<?php //if (!empty($data['flash'])) : ?>
<div class="bgcover" style="display: none;">
    <div id="jBox1" class="jBox-wrapper jBox-Modal jBox-Default jBox-closeButton-box" style="width:100%;">
        <div style="width:auto;font-size:15px;text-align:center"></div>
        <a href="" target="_blank">
            <img src="" style="border: 0px;max-width: 100%;max-height: 100%;margin: 0 auto;">
        </a>
        <div class="jBox-closeButton jBox-noDrag">
            <span class="flashCount"></span>
        </div>
    </div>
</div>
<?php //endif; ?>
<script src="/js/video/jquery.min.1.11.1.js"></script>
<script src="/js/video/swiper.min.js"></script>
<!--<script src="/js/video/video.js?v=1.2"></script>-->
<script src="/js/video/mtop.js"></script>
<script src="/js/video/searchHistory.js"></script>
<script>
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
        // $.get('/video/advert', arrIndex, function(res) {
        //
        //     $(".video-add-column").each(function(index){
        //         if(!res.data.hasOwnProperty("advert"))
        //             return false;
        //
        //         if(!res.data.advert.hasOwnProperty(index)){
        //             advertKey = 0;
        //         }
        //
        //         var addata = res.data.advert[advertKey];
        //         if (addata.hasOwnProperty("ad_skip_url")) {
        //             $(this).html("");
        //             $(this).html(refreshAdvert(addata));
        //         }
        //         advertKey++;
        //     });
        // })

        //新片预告trailer 滑动
<!--        --><?php //if($data['trailer']):?>
<!--            --><?php //foreach ($data['trailer'] as $i=>$trailer):?>
//                var mytrailer<?//=$i?>// = new Swiper ('#trailer<?//=$i?>//', {
//                    slidesPerView:'auto',
//                });
//                mytrailer<?//=$i?>//.on('tap', function (swiper, e) {
//                    var videoid = $("#trailer<?//=$i?>// .swiper-slide").eq(this.clickedIndex).attr('data-video-id');
//                    window.location.href = '/video/detail?video_id='+videoid;
//                });
//            <?php //endforeach; ?>
<!--        --><?php //endif;?>

        //今日热点滑动
        var todayhot = new Swiper ('#today-hot', {
            slidesPerView:'auto',
        });

        if(channel_id==0){
            //按城市加载广告
            var req = new XMLHttpRequest();
            req.open('GET', '/images/video/icon-gx.png', false);
            req.send(null);
            var cf_ray = req.getResponseHeader('cf-Ray');//指定cf-Ray的值
            var cf_cache_status = req.getResponseHeader('cf-cache-status');//指定cf-cache-status的值
            var citycode = '';
            if(cf_cache_status == 'HIT'){
                citycode = cf_ray.substring(cf_ray.length-3);
            }else{
                req.open('GET', document.location, false);
                req.send(null);
                cf_ray = req.getResponseHeader('cf-Ray');//指定cf-Ray的值
                if(cf_ray && cf_ray.length>3){
                    citycode = cf_ray.substring(cf_ray.length-3);
                }
            }
            // console.log(citycode);
            var arrIndex = {};
            arrIndex['citycode'] = citycode;
            arrIndex['page'] = 'home';
            arrIndex['chapterId'] = 0;
            $.ajax({
                url: '/video/advert-info',
                data: arrIndex,
                type:'get',
                cache:false,
                dataType:'json',
                success:function(res) {
                    if(res.errno==0){
                        //首页
                        var dataar = res.data.advert;
                        if(dataar.length>0){
                            for(var i=0;i<dataar.length;i++){
                                //今日热点和连续剧前不加广告
                                $(".video-index-column").eq(i+2).before('<div class="video-add-column"><a href="'+dataar[i].ad_skip_url+'"  target="_blank" > <img src="'+dataar[i].ad_image+'" alt=""></a></div>');
                            }
                        }
                        //首页弹窗
                        dataar = res.data.flash;
                        var flashtime = getCookie("wapgzflash");
                        if(flashtime!=1 && dataar.advert_id && dataar.advert_id!="underfined" && typeof (dataar.advert_id) != "undefined"){
                            $("#jBox1 a").attr("href",dataar.ad_skip_url);
                            $("#jBox1 a img").attr("src",dataar.ad_image);
                            $(".flashCount").text("关闭")
                            $(".bgcover").fadeIn();
                            setCookie("wapgzflash",1,(1/3));//有效时间8小时
                        }
                    }
                },
                error : function() {
                    console.log("广告加载失败");
                }
            });
        }

        //检验用户信息
        var uid = finduser();
        var arrIndex = {};
        arrIndex['uid'] = uid;
        var uid2 = '<?=Yii::$app->user->id?>';
        if(uid2=='' && (!isNaN(uid) && uid!="")){
            // console.log(arrIndex);
            $.ajax({
                url:'/video/login-uid',
                data:arrIndex,
                type:'get',
                cache:false,
                dataType:'json',
                success:function(res) {
                    // console.log(res);
                    saveuser(res.data.uid);
                },
                error : function() {
                    console.log("用户信息获取失败");
                }
            });
        }
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
