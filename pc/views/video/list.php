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
    
    $('.video-list-box').bind('DOMNodeInserted', function(e) {
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
    });
    
    //播放页是否传入搜索内容
        if($('#is-keyword').val())
        {
            searchKeywords($('#is-keyword').val(), 'detail');
        }
        //搜索信息
        $('.search-box-out').on('click', function() {
            searchInfo()
        });
        
        //回车搜索
        $('#keywords').keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                searchInfo()
            }
        });
        
        //搜索信息
        function searchInfo() {
            if(!$('#keywords').val()) {
                window.location.href = '/video/list';
            }
            
            $('.index-header-search').removeClass("result");
            $('.index-header-search-result').hide();
            $('.index-search-btn').css('background-color', '#FF556E');
            $('.index-header-search').css('border', '1px solid #FF556E');
            $('.index-header-search-result').css('border', '1px solid #FF556E');
            //写入缓存
            var searchKeyword = $('#keywords').val();
            searchKeywords(searchKeyword, 'index');
        }
        
        //根据关键字，进行查询
        function searchKeywords(keyword, type)
        {
            if(type == 'index') {
                setSearchStore(keyword);
            }
            searchContent(keyword);
            searchDisplay();
        }
        
        //清楚搜索信息
        $('.history-delete').click(function() {
		    localStorage.removeItem('pcNovelKeywords');
		    searchDisplay();
        });
        
        //历史搜索信息展示与隐藏
        function searchDisplay()
        {
             //搜索历史
            keywords = JSON.parse(localStorage.getItem('pcNovelKeywords'));
            var html = '';
            if(keywords != null) {
                keywords = noRepeat(keywords);
            }
            
            //遍历历史搜索
            if(keywords != null) {
                $.each(keywords, function(i, v) {
                    html = html + "<li><a class='search-history' data-keyword='"+v+"'>" + v + "</a></li>";
                });
            }
            
            if(keywords == null) {
                $('.video-history-search').hide();
            }else {
                $('.video-history-search').show();
            }
            
            $('.search-histoty-list').html(html);
        }
        
        searchDisplay();
        
        //点击搜索历史，进行搜索
        $(".search-histoty-list").on('click', '.search-history',function(){
            $('#keywords').val($(this).attr('data-keyword'));
			$('.index-header-search').removeClass("result");
			$('.index-header-search-result').hide();
            searchContent($(this).attr('data-keyword'));
        });
        
        
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
            localStorage.setItem('pcNovelKeywords', JSON.stringify(keywords));
        }
        
    //展示搜索内容
    function searchContent(searchKeyword) {
        //隐藏频道，展示数据
        $('.video-list-box').html('');
        $('.category-content').hide();
        //点击搜索，加载数据
        $.get('/video/search-video', {keyword:searchKeyword}, function(res) {
            var data = res.data.list;
            var content = refreshVideo(data);
            $('.video-list-box').html(content); // 更新内容
            $('.refresh-video-num-all').html('共'+ res.data.total_count +'个结果'); //刷新影片数
            $('.video-list-box').attr('data-pages', res.data.total_page);
            $('.video-list-box').attr('data-page', res.data.current_page);
            $('.video-list-box').attr('data-url', '/video/search-video');
        })
    }
    
    //筛选影片
    var arrIndex = {};
    arrIndex['channel_id']= $('#channel-id').val();
    
    $(document).on('click', '.cate-list-li', function() {
        var type = $(this).attr('data-type');
        var value = $(this).attr('data-value');
        
        //追加筛选参数
        arrIndex[type] = value;
        arrIndex['page_num']= 1;
        
        console.log(arrIndex);
        
        //选中分类，添加背景
        $(this).parent().find('.cate-list-li').removeClass('selected');
        $(this).addClass('selected');
        
        //发送请求，获取数据
        $.get('/video/refresh-cate', arrIndex, function(s) {
            var data = s.data.list;
            var content = refreshVideo(data);
            refreshCate(s.data.search_box);
            $('.video-list-box').html(content); // 更新内容
            $('.refresh-video-num-all').html('共'+ s.data.total_count +'个结果'); //刷新影片数
            $('.video-list-box').attr('data-pages', s.data.total_page);
            $('.video-list-box').attr('data-page', 1);
            $('.video-list-box').attr('data-url', '/video/refresh-cate');
        });
    });
        
    //刷新筛选条件
    function refreshCate(list) {
        var content = '';
        for(var i=0;i<list.length; i++) {
            content += "<div class='category-class category-class2'>" + 
                            "<div class='category-list'>" +
                            "<span class='category-item'><span class='category-text'>"+list[i]['label']+"</span></span>";
            var selectFlag = false;
            
            for(var j=0;j<list[i]['list'].length; j++) {
                if(list[i]['list'][j]['checked'] == 1) {
                    selectFlag = true;
                }
            }

           for(var k=0;k<list[i]['list'].length;k++) {
              if(list[i]['list'][k]['checked'] == 1) {
                  if(list[i]['field'] == 'channel_id')
                  {
                       content += "<input type='hidden' id='channel-id' value='"+list[i]['list'][k]['value']+"'>";
                  }
                  content += "<span class='category-item selected cate-list-li' data-value='"+list[i]['list'][k]['value']+"' data-type='"+list[i]['field']+"'>"+list[i]['list'][k]['display']+"</span>";
                  continue;
              }
              content += "<span class='category-item cate-list-li' data-value='"+list[i]['list'][k]['value']+"' data-type='"+list[i]['field']+"'>"+list[i]['list'][k]['display']+"</span>";
            }

            content +="</div>" +
                       "</div>";
        }
        
        $('.category-content').html(content);
    }
    
    //下拉加载更多
    var progress = false; // 是否正在请求中
    var isFlag = true;
    $(window).scroll(function () {
        if (($(window).scrollTop()+488) >= $(document).height() - $(window).height()) {
            if(isFlag) {
                    var arrScroll = arrIndex;
                    var pages = $('.video-list-box').attr('data-pages') || 1;
                    var page  = $('.video-list-box').attr('data-page') || 1;
                    var url = $('.video-list-box').attr('data-url');
                    
                     if (parseInt(page) < parseInt(pages) && !progress) {
                        progress = true;
                        page++;
                        var params = {};
                        if(url == '/video/refresh-cate') {
                            arrScroll['page_num'] = page;
                            params = arrScroll;
                        }else {
                            params['keyword'] = $('#keywords').val();
                            params['page_num'] = page;
                        }

                        $.get(url, params, function(res) {
                            if(res) {
                                 var data = res.data.list;
                                 var content = refreshVideo(data);
                                 $('.video-list-box').append(content); // 更新内容
                                 $('.refresh-video-num-all').html('共'+ res.data.total_count +'个结果'); //刷新影片数
                                 $('.video-list-box').attr('data-pages',res.data.total_page);
                                 $('.video-list-box').attr('data-page',res.data.current_page);
                            }
                             progress = false;
                        });
                     } else if (page == pages) {
                         progress = false;
                     }
                isFlag = false;
            }
        }else {
            isFlag = true;
        }
    });
    
    //刷新影片内容
    function refreshVideo(data) {
        var content = '';
        for (var i=0; i<data.length; i++) { //拼接换一换内容
            var actors = '';
            if (data[i]['actors'] != undefined) {
                for (var j=0; j<data[i]['actors'].length; j++) 
                {
                    actors +=  "<span class='starring_link'>"+data[i]['actors'][j]['actor_name']+"/</span>";
                }
            }
            
            content += "<li class='qy-mod-li'>"+
                            "<div class='qy-mod-img vertical'>"+
                                "<div class='qy-mod-link-wrap'>"+
                                    "<a href='/video/detail?video_id="+data[i]['video_id']+ "' class='qy-mod-link'>"+
                                        "<div style='height:100%;overflow:hidden;'>"+
                                            "<img src='"+data[i]['cover']+"' class='qy-mod-cover'>"+
                                            "<div class='icon-br icon-b'><span rseat='' class='qy-mod-label'>"+data[i]['flag']+"</span>"+
                                            "</div>"+
                                        "</div>"+
                                        "<div class='icon-tr icon-b'>"+
                                            "<span rseat='' class='qy-mod-label'>"+data[i]['score']+"</span>"+
                                        "</div>"+
                                    "</a>"+
                                "</div>"+
                                "<div class='title-wrap'>"+
                                    "<p class='main score'>"+
                                        "<a href='/video/detail?video_id="+data[i]['video_id']+ "'class='link-txt' >"+data[i]['video_name']+"</a>"+
                                    "</p>"+
                                    "<p class='sub'>"+data[i]['intro']+"</p>"+
                                "</div>"+
                            "</div>"+
                            "<div class='qy-video-card-small qy-video-info-tips qy-video-info-tips2'>"+
                                "<a href='/video/detail?video_id="+data[i]['video_id']+"' class='movie_tipLink'>"+
                                    "<div class='movie_tipHd'>"+
                                        "<div class='movie_tipImg'>"+
                                            "<img src='"+data[i]['horizontal_cover']+"'>"+
                                        "</div>"+
                                    "</div>"+
                                    "<div class='movie_tipCon'>"+
                                        "<div class='movie_tipTitle'>"+
                                            "<p class='movie_tipName'>"+data[i]['video_name']+"</p>"+
                                        "</div>"+
                                        "<div class='tipLableBox'>"+
                                            "<p class='tipLable_inner'>"+
                                                "<span class='tipLable_title'>标签：</span>"+
                                                "<span class='tipLable'>"+data[i]['category']+"</span>"+
                                            "</p>"+
                                            // "<p class='movie_tipTime'>"+data[i]['play_limit']+"分钟</p>"+
                                        "</div>"+
                                        "<div class='tip_starring'>"+
                                            "主演："+
                                            actors+
                                        "</div>"+
                                        "<div class='tip_des four_line'>"+data[i]['intro']+"</div>"+
                                    "</div>"+
                                "</a>"+
                                "<div class='movie_tipBd'>"+
                                    "<a href='/video/detail?video_id="+data[i]['video_id']+"'"+
                                       "class='qy-button-small topBd_btn'>"+
                                        "<span class='topBd_btnIn'>立即观看</span>"+
                                    "</a>"+
                                "</div>"+
                            "</div>"+
                        "</li>"
        };
        
        return content;
    }
});
JS;

$this->registerJs($js);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
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
                <a href="/video/index" class="logo-link" title="瓜子TV"><img src="/images/NewVideo/logo.png" alt="">瓜子TV</a>
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
                <div class="search-box">
						<span class="search-box-in">
                            <input type="hidden" id="is-keyword" value="<?= $keyword?>">
							<input autocomplete="off" 
							placeholder="<?= empty($hot['tab'][0]['list'][0]['video_name']) ? '': $hot['tab'][0]['list'][0]['video_name']?>" 
							type="text" class="search-box-input" id="keywords" value="<?= $keyword?>">
							<!--<a href="" class="search-right-entry"><i class="qy-svgicon qy-svgicon-rank-hot2"></i>热搜榜 </a>-->
						</span>
                    <span class="search-box-out"><span id="J-search-btn" type="button" class="search-box-btn"><i class="qy-svgicon qy-svgicon-search"></i><em class="search-box-btnTxt">搜索</em></span></span>
                </div>
                <div id="J-search-result-wrap" class="search-result" style="">
                    <div class="search-result-con">
                        <div id="J-search-result-hot" class="search-result-hot" style="">
                            <div class="search-result-title">热门搜索</div>
                            <?php foreach ($hot['tab'][0]['list'] as $key => $list): ?>
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
            </div>
        </div>
    </div>
</header>
<div class="c"></div>
<div class="qy-list-page">
    <div class="qy-list-category">
        <div class="list-content">
            <div class="list-content">
                <div class="category-content">
                    <?php foreach ($info['search_box'] as $cates): ?>
                        <div class="category-class category-class2">
                            <div class="category-list">
                                <span class="category-item"><span class="category-text"><?= $cates['label']?></span></span>
                                <?php foreach ($cates['list'] as $key => $cate): ?>
                                    <?php if($cates['field'] == 'channel_id' && $cate['checked'] == 1) : ?>
                                        <input type="hidden" id="channel-id" value="<?= $cate['value']?>">
                                    <?php endif;?>
                                    <span class="category-item <?= $cate['checked'] == 1 ? 'selected' : ''?>
                                        cate-list-li"
                                       data-value="<?= $cate['value']?>"
                                       data-type="<?= $cates['field']?>">
                                        <?= $cate['display']?>
                                    </span>
                                <?php endforeach;?>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
    <div class="c"></div>
    <div class="list-content">
        <div class="qy-list-filter" id="block-C"><div class="filter-tab" style="height: 24px;"></div><!----></div>
        <div class="qy-list-wrap">
            <div class="total refresh-video-num-all">共<?= $info['total_count']?>个结果 </div>
            <ul class="qy-mod-ul qy-mod-ul-search video-list-box"
                data-pages="<?= $info['total_page']?>"
                data-page="<?= $info['current_page']?>"
                data-url="/video/refresh-cate">
                <?php foreach ($info['list'] as $list): ?>
                    <li class="qy-mod-li">
                        <div class="qy-mod-img vertical">
                            <div class="qy-mod-link-wrap">
                                <a href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>"
                                   class="qy-mod-link">
                                    <div style="height:100%;overflow:hidden;">
                                        <img src="<?= $list['cover']?>" class="qy-mod-cover">
                                        <div class="icon-br icon-b">
                                            <span rseat="" class="qy-mod-label">
										          <?= $list['flag']?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="icon-tr icon-b">
                                        <span rseat="" class="qy-mod-label">
                                            <?= $list['score']?>
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="title-wrap">
                                <p class="main score">
                                    <a href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>"
                                       class="link-txt" ><?= $list['video_name']?>
                                    </a>
                                </p>
                                <p class="sub"><?= $list['intro']?></p>
                            </div>
                        </div>
                        <div class="qy-video-card-small qy-video-info-tips qy-video-info-tips2">
                            <a href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>"
                               class="movie_tipLink">
                                <div class="movie_tipHd">
                                    <div class="movie_tipImg">
                                        <img src="<?= $list['horizontal_cover']?>">
                                    </div>
                                </div>
                                <div class="movie_tipCon">
                                    <div class="movie_tipTitle">
                                        <p class="movie_tipName"><?= $list['video_name']?></p>
                                    </div>
                                    <div class="tipLableBox">
                                        <p class="tipLable_inner">
                                            <span class="tipLable_title">标签：</span>
                                            <span class="tipLable"><?= $list['category']?></span>
                                        </p>
                                        <!--<p class="movie_tipTime"><?= $list['play_limit']?>分钟</p>-->
                                    </div>
                                    <div class="tip_starring">
    									主演：
    									<?php foreach ($list['actors'] as $key => $actor): ?>
    									    <span class="starring_link"><?= $actor['actor_name']?>/</span>
									    <?php endforeach;?>
    								</div>
                                    <div class="tip_des four_line"><?= $list['intro']?></div>
                                </div>
                            </a>
                            <div class="movie_tipBd">
                                <a href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>"
                                   class="qy-button-small topBd_btn">
                                    <span class="topBd_btnIn">立即观看</span>
                                </a>
                            </div>
                        </div>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>

<div class="c"></div>
<footer class="qy-footer">
    <div class="wp">
        <p>本网站为非赢利性站点，所有内容均由机器人采集于互联网，或者网友上传，本站只提供WEB页面服务，本站不存储、不制作任何视频，不承担任何由于内容的合法性及健康性所引起的争议和法律责任。<br />若本站收录内容侵犯了您的权益，请附说明联系邮箱，本站将第一时间处理。站长邮箱：guazitv@163.com</p>
    </div>
</footer>
<div class="qy-scroll-anchor qy-aura3">
    <ul class="scroll-anchor">
        <li class="anchor-list anchor-integral">
            <div class="qy-scroll-integral popBox dn">
                <span class="tianjia-arrow"></span>
                <img src="/images/NewVideo/ewm.png" alt="">
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
</body>
</html>
