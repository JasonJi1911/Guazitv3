<?php
use yii\helpers\Url;

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = '热搜-瓜子TV|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv - m.guazitv.tv';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片']);

$js = <<<JS
$(function(){
    
        //监听输入框输入内容变化，展示搜索按钮内容
        $('#keyword').on('input propertychange', function() {
            if($('#keyword').val()) {
                $('.search-btn-cancel').hide();
                $('.search-btn-search').show();
                return true;
            }
            $('.search-btn-cancel').show();
            $('.search-btn-search').hide();
        });
        
        //搜索信息
        $('.search-btn-search').on('click', function() {
            //写入缓存
            setSearchStore($('#keyword').val());
            //跳转道搜索结果页
            window.location.href = 'search-result?keyword='+$('#keyword').val();
        });
        
        
        //搜索功能
        $('#keyword').keyup(function(e) {
            if ($(this).val().length == 0) {
                return false;
            }
            
            if (e.keyCode == 13) {
                //写入缓存
                setSearchStore($('#keyword').val());
                //跳转道搜索结果页
                window.location.href = 'search-result?keyword='+$('#keyword').val();
            }
        });
        
         //搜索历史
        keywords = JSON.parse(localStorage.getItem('novelKeywords'));
        var html = '';
        if(keywords != null) {
            keywords = noRepeat(keywords);
        }
        
        $.each(keywords, function(i, v) {
            html = html + "<li><a href='search-result?keyword="+v+"'>" + v + "</a></li>";
        });
    
        if(keywords == null) {
            $('.video-history-search').hide();
        }
        
        $('.search-histoty-list').append(html);  
        
        //数组去重
        function noRepeat(arr) {
            for(var i = 0; i < arr.length-1; i++){
                for(var j = i+1; j < arr.length; j++){
                    if(arr[i]===arr[j]){
                        arr.splice(j,1);
                        j--;
                    }
                }
            }
            return arr;
        }
        
        //将搜索历史写入缓存
        function setSearchStore(word){
             //搜索历史写入local
            if (keywords == null) {
                keywords = [word];
            } else {
                
                var item = $.inArray(word, keywords);
                if (item > 0) {  //如果已有
                    keywords.splice(item, 1);
                } else {
                    if (keywords.length > 4) {
                        keywords.pop();
                    }
                }
                keywords.unshift(word);
            }
            localStorage.setItem('novelKeywords', JSON.stringify(keywords));
        }
        
     //    var mySearchNav = new Swiper('#searchNav', {
     //        freeMode: true,
     //        freeModeMomentumRatio: 0.5,
     //        slidesPerView: 'auto',
     //        on:{
     //            tap: function(swiper,event){
     //                console.log(this.clickedIndex)
     // /*               console.log(swiper)
     //                console.log(event)*/
     //            },
     //        },
     //    });
    });
JS;

$this->registerJs($js);

?>

<div class="video-search-contanier">
    <div class="index-search-fix clearfix">
        <div class="video-search-box fl">
					<span class="video-search-img">
						<img src="/images/video/icon-search.png" alt="" />
					</span>
            <form action="javascript:true">
                <input type="search" placeholder="<?= empty($data['tab'][0]['list'][0]['video_name']) ? '': $data['tab'][0]['list'][0]['video_name']?>" class="search-input" id="keyword" />
                <img src="/images/video/icon-close.png" alt="" class="search-delete">
            </form>
        </div>
        <a href="javascript:history.go(-1);" class="fr search-cancel search-btn-cancel">取消</a>
        <a href="javascript:;" class="fr search-cancel search-btn-search">搜索</a>
    </div>
</div>
<!--历史搜索-->
<div class="video-history-search">
    <p class="search-title">历史搜索</p>
    <div class="history-delete">
        <img src="/images/video/icon-lj.png" alt="" />
    </div>
    <ul class="search-histoty-list clearfix">
    </ul>
</div>
<div class="h6F3"></div>
<!--热门搜索-->
<div class="video-search-rank">
    <div class="video-top-nav swiper-container" id="searchNav">
        <ul class="swiper-wrapper">
            <?php foreach ($data['tab'] as $key => $tab): ?>
                <li class="swiper-slide <?= $key == 0 ? 'on' : ''?>">
                    <a><?= $tab['title']?></a>
                    <span class="line"></span>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
    <div class="tab-box video-search-rank-list">
        <?php foreach ($data['tab'] as $key => $tab): ?>
            <dl class="tab-list <?= $key == 0 ? 'isshow' : ''?>">
                <?php foreach ($tab['list'] as $key => $list): ?>
                    <dd>
                        <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>" class="clearfix">
                            <span class="fl rank-item-num"><?= $key+1?></span>
                            <p class="fl rank-item-name"><?= $list['video_name']?></p>
                            <span class="fr fontArial rank-item-eval">评分：<?= $list['score']?></span>
                        </a>
                    </dd>
                <?php endforeach;?>
            </dl>
        <?php endforeach;?>
    </div>
</div>
<div class="pop-mask"></div>
<div class="pop-history">
    <div class="pop-history-notice">确认删除全部历史记录？</div>
    <div class="pop-history-btn clearfix">
        <a href="javascript:;" class="history-btn history-btn-cancel fl">取消</a>
        <a class="history-btn history-btn-ok fl">确定</a>
    </div>
</div>
<script src="/js/video/jquery.min.1.11.1.js"></script>
<script src="/js/video/swiper.min.js"></script>
<script src="/js/video/video.js"></script>
<script>
    var mySearchNav = new Swiper('#searchNav', {
        freeMode: true,
        freeModeMomentumRatio: 0.5,
        slidesPerView: 'auto',
        watchSlidesProgress : true,
    });

    swiperWidth = mySearchNav.width;
    maxTranslate = mySearchNav.maxTranslate();
    maxWidth = -maxTranslate + swiperWidth / 2;
    $("#searchNav").on('touchstart', function (e) {
        e.preventDefault();
    });
    // document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
    mySearchNav.on('tap', function (swiper, e) {
        // e.preventDefault()
        slide = mySearchNav.slides[this.clickedIndex];
        slideLeft = slide.offsetLeft;
        slideWidth = slide.clientWidth;
        slideCenter = slideLeft + slideWidth / 2;
        // 被点击slide的中心点
        mySearchNav.setTransition(300);

        if (slideCenter < swiperWidth / 2) {

            mySearchNav.setTranslate(0);

        } else if (slideCenter > maxWidth) {

            mySearchNav.setTranslate(maxTranslate);

        } else {

            nowTlanslate = slideCenter - swiperWidth / 2;

            mySearchNav.setTranslate(-nowTlanslate);

        }
        $("#searchNav  .on").removeClass('on');
        $("#searchNav .swiper-slide").eq(this.clickedIndex).addClass('on');
        $(".tab-box").find(".tab-list").eq(this.clickedIndex).addClass("isshow").siblings(".tab-list").removeClass("isshow");
    });
</script>
