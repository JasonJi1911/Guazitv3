//topNav
var mySwiper = new Swiper('#topNav', {
    freeMode: true,
    freeModeMomentumRatio: 0.5,
    slidesPerView: 'auto',
    preventClicks : false,
    preventClicksPropagation : false,
});
swiperWidth = swiperWidth = mySwiper.width;
maxTranslate = mySwiper.maxTranslate();
maxWidth = -maxTranslate + swiperWidth / 2;
$(".swiper-container").on('touchstart', function (e) {
    e.preventDefault();
});
//document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
var channel_id = '';
mySwiper.on('tap', function (swiper, e) {
    //	e.preventDefault()
    slide = mySwiper.slides[this.clickedIndex];
    slideLeft = slide.offsetLeft;
    slideWidth = slide.clientWidth;
    slideCenter = slideLeft + slideWidth / 2;
    // 被点击slide的中心点
    mySwiper.setTransition(300);

    if (slideCenter < swiperWidth / 2) {

        mySwiper.setTranslate(0);

    } else if (slideCenter > maxWidth) {

        mySwiper.setTranslate(maxTranslate);

    } else {

        nowTlanslate = slideCenter - swiperWidth / 2;

        mySwiper.setTranslate(-nowTlanslate);

    }
    $("#topNav  .on").removeClass('on');
    if($('#swiper-type').val() == 'index') {
        $("#topNav .swiper-slide").eq(this.clickedIndex).find('.line').addClass('line_show');
    }
    $("#topNav .swiper-slide").eq(this.clickedIndex).addClass('on');
	//当前页面切换数据可以去掉下面的跳转链接
    var hr = $("#topNav .swiper-slide").eq(this.clickedIndex).find("a").attr("href");
    window.location.href = hr;

    if($('#swiper-type').val() == 'search') {
        //刷新数据
        channel_id = $(slide).attr('data-channel');
        $.get('search-result-more', {keyword: $('#keyword').val(), 'channel_id': channel_id}, function(s) {

            var data = s.data.list;
            var content = '';
            for (var i=0; i<data.length; i++) { //拼接换一换内容
                content += "<dd>"+
                    "<a href='detail?video_id="+data[i]['video_id']+"' class='clearfix'>"+
                    "<div class='sresult-item-left fl'>"+
                    "<img src='"+data[i]['cover']+"' alt=''>"+
                    "<div class='mark-box'>"+
                    "<p class='mark'>"+data[i]['flag']+"'</p>"+
                    "</div>"+
                    "</div>"+
                    "<div class='sresult-item-right fr'>"+
                    "<h3 class='name'>"+data[i]['video_name']+"</h3>"+
                    "<p class='intro'>"+data[i]['intro']+"</p>"+
                    "<div class='clearfix type'>"+
                    "<span class='fl'>"+data[i]['cats']+"</span>"+
                    "<span class='fr fontArial'>评分："+data[i]['score']+"</span>"+
                    "</div>"+
                    "</div>"+
                    "</a>"+
                    "</dd>";
            }

            $('.video-search-result-list').html(content); // 更新内容
            $('.video-search-result-list').attr('data-pages',s.data.total_page);
            $('.video-search-result-list').attr('data-page',1);
        })
    }
});
