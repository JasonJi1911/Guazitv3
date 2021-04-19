<?php
use yii\helpers\Url;

$this->title = '瓜子TV - 澳新华人在线视频分享平台,海量高清视频在线观看';

$js = <<<JS
$(function(){
        //播放页是否传入搜索内容
        if($('#is-keyword').val())
        {
            searchKeywords($('#is-keyword').val(), 'detail');
        }
        //搜索信息
        $('.index-search-btn').on('click', function() {
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
                return false;
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
            $.each(keywords, function(i, v) {
                html = html + "<li><a class='search-history' data-keyword='"+v+"'>" + v + "</a></li>";
            });
            
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
            $('.video-index-select').hide();
            //点击搜索，加载数据
            $.get('/video/search-video', {keyword:searchKeyword}, function(res) {
                var data = res.data.list;
                var content = refreshVideo(data);
                $('.video-list-box').html(content); // 更新内容
                $('.refresh-video-num-all').html(res.data.total_count); //刷新影片数
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
            $(this).parent().find('.cate-list-li').removeClass('on');
            $(this).addClass('on');
            
            //发送请求，获取数据
            $.get('/video/refresh-cate', arrIndex, function(s) {
                var data = s.data.list;
                var content = refreshVideo(data);
                refreshCate(s.data.search_box);
                $('.video-list-box').html(content); // 更新内容
                $('.refresh-video-num-all').html(s.data.total_count); //刷新影片数
                $('.video-list-box').attr('data-pages', s.data.total_page);
                $('.video-list-box').attr('data-page', 1);
                $('.video-list-box').attr('data-url', '/video/refresh-cate');
            })
        });
        
        //刷新筛选条件
        function refreshCate(list) {
            var content = '';
            for(var i=0;i<list.length; i++) {
                content += "<li class='clearfix'>" + 
                                "<span class='fl index-select-left'>"+list[i]['label']+"：</span>" +
                                "<div class='fl index-select-right clearfix' >";
                var selectFlag = false;
                
                for(var j=0;j<list[i]['list'].length; j++) {
                    if(list[i]['list'][j]['checked'] == 1) {
                        selectFlag = true;
                    }
                }

               for(var k=0;k<list[i]['list'].length;k++) {
                  if((selectFlag == false) && (k==0)) {
                      content += "<a class='item on cate-list-li' data-value="+list[i]['list'][k]['value']+" data-type="+list[i]['field']+">"+list[i]['list'][k]['display']+"</a>";
                      continue;
                  }
                  if(list[i]['list'][k]['checked'] == 1) {
                      content += "<a class='item on cate-list-li' data-value="+list[i]['list'][k]['value']+" data-type="+list[i]['field']+">"+list[i]['list'][k]['display']+"</a>";
                      continue;
                  }
                  content += "<a class='item cate-list-li' data-value="+list[i]['list'][k]['value']+" data-type="+list[i]['field']+">"+list[i]['list'][k]['display']+"</a>";
                }

                content +="</div>" +
                           "</li>";
            }
            
            $('.cate-select').html(content);
        }
        
        //下拉加载更多
        var progress = false; // 是否正在请求中
        var isFlag = true;
        $(window).scroll(function () {
            if (($(window).scrollTop()+288) >= $(document).height() - $(window).height()) {
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
                                
                                if(res.data) {
                                     var data = res.data.list;
                                     var content = refreshVideo(data);
                                     $('.video-list-box').append(content); // 更新内容
                                     $('.refresh-video-num-all').html(res.data.total_count); //刷新影片数
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
                content += "<dd>"+
                                "<a href='/video/detail?video_id="+data[i]['video_id']+"'>"+
                                    "<div class='video-item-top'>"+
                                        "<img src='"+data[i]['cover']+"' alt=''>"+
                                        "<div class='mark-box'>"+
                                            "<p class='mark-box-hot'>"+data[i]['play_times']+"</p>"+
                                            "<div class='clearfix mark-box-date'>"+
                                                "<span class='fl fontArial date'>"+data[i]['flag']+"</span>"+
                                                "<span class='fr fontArial eval'>"+data[i]['score']+"</span>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                    "<h5 class='video-item-name'>"+data[i]['video_name']+"</h5>"+
                                    "<p class='video-item-play'>"+data[i]['intro']+"</p>"+
                                "</a>"+
                            "</dd>";
            }
            return content;
        }
        
        
    });
JS;

$this->registerJs($js);

?>

<div class="index-main">
    <div class="video-index-header clearfix">
        <h1 class="fl index-logo">瓜子视频</h1>
        <a href="<?= Url::to(['/'])?>" class="fl index-link ml44">首页</a>
        <div class="fl video-header-drop">
            <a href="#" class="fl index-link index-link-icon">导航</a>
            <div class="video-header-dropdown">
                <div class="drop-toggle-box">
                    <div class="drop-toggle"></div>
                </div>
                <div class="video-header-dropdown-channel">
                    <?php if(!empty($channels)) :?>
                        <?php foreach ($channels['list'] as $channel) :?>
                            <a href="<?= Url::to(['/video/index', 'channel_id' => $channel['channel_id']])?>" class="item"><?= $channel['channel_name']?></a>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
        </div>

        <div class="index-header-search fl clearfix">
            <input type="text" placeholder="<?= empty($hot['tab'][0]['list'][0]['video_name']) ? '': $hot['tab'][0]['list'][0]['video_name']?>" class="search-input fl" id="keywords" autocomplete="off" value="<?= $keyword?>" >
            <input type="hidden" id="is-keyword" value="<?= $keyword?>">
            <span href="javascript:;" class="index-search-btn fr c">
                <img src="/images/video/icon-search.png" alt="" class="search-icon">
                搜索
            </span>
            <div class="index-header-search-result">
                <div class="video-history-search">
                    <div class="clearfix">
                        <p class="search-title fl">历史记录</p>
                        <div class="history-delete fr">
                            <img src="/images/video/icon-lj.png" alt="" />
                            <span>清楚历史记录</span>
                        </div>
                    </div>
                    <ul class="search-histoty-list clearfix">
                    </ul>
                </div>
                <div class="video-search-rank-list">
                    <p class="search-title ml20">热门搜索</p>
                    <dl>
                        <?php if(!empty($hot)) :?>
                            <?php foreach ($hot['tab'] as $tabs): ?>
                                <?php if($tabs['title'] == '热搜') :?>
                                    <?php foreach ($tabs['list'] as $key => $value): ?>
                                        <dd>
                                            <a href="<?= Url::to(['/video/detail', 'video_id' => $value['video_id']])?>" class="clearfix">
                                                <span class="fl rank-item-num"><?= $key+1?></span>
                                                <p class="fl rank-item-name"><?= $value['video_name']?></p>
                                                <span class="fr fontArial rank-item-eval">评分：<?= $value['score']?></span>
                                            </a>
                                        </dd>
                                    <?php endforeach;?>
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php endif;?>
                    </dl>
                </div>
            </div>
        </div>
        <ul class="fr clearfix index-header-nav">
            <li class="upload">
                <span class="ask-share">
                    <span class="iconfont">&#xe612;</span>
                    <p class="item-bottom-title">上传</p>
                </span>
            </li>
            <li class="viewed">
                <a href="javascript:void(0);" class="watchYes">
                    <span class="iconfont">&#xe617;</span>
                    <p class="item-bottom-title">看过</p>
                </a>
            </li>
        </ul>
    </div>
    <ul class="video-index-select">
        <div class="cate-select">
            <?php foreach ($info['search_box'] as $cates): ?>
                <li class="clearfix">
                    <span class="fl index-select-left"><?= $cates['label']?>：</span>
                    <div class="fl index-select-right clearfix" >
                        <?php foreach ($cates['list'] as $key => $cate): ?>
                            <?php if($cates['field'] == 'channel_id' && $cate['checked'] == 1) : ?>
                                <input type="hidden" id="channel-id" value="<?= $cate['value']?>">
                            <?php endif;?>
                            <a class="item <?= $cate['checked'] == 1 ? 'on' : ''?> cate-list-li" data-value="<?= $cate['value']?>" data-type="<?= $cates['field']?>"><?= $cate['display']?></a>
                        <?php endforeach;?>
                    </div>
                </li>
            <?php endforeach;?>
        </div>
    </ul>
    <div class="video-num-all">全部共<em class="fontArial refresh-video-num-all"><?= $info['total_count']?></em>部视频</div>
    <dl class="video-list-box clearfix" data-pages="<?= $info['total_page']?>" data-page="<?= $info['current_page']?>" data-url="/video/refresh-cate">
        <?php foreach ($info['list'] as $list): ?>
            <dd>
                <a href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>">
                    <div class="video-item-top">
                        <img src="<?= $list['cover']?>" alt="">
                        <div class="mark-box">
                            <p class="mark-box-hot"><?= $list['play_times']?></p>
                            <div class="clearfix mark-box-date">
                                <span class="fl fontArial date"><?= $list['flag']?></span>
                                <span class="fr fontArial eval"><?= $list['score']?></span>
                            </div>
                        </div>
                    </div>
                    <h5 class="video-item-name"><?= $list['video_name']?></h5>
                    <p class="video-item-play"><?= $list['intro']?></p>
                </a>
            </dd>
        <?php endforeach;?>
    </dl>
    <div class="video-index-footer">
<!--        <p class="footer-top"><a>手机版 </a>  |  <a> 电脑版</a></p>-->
        <p class="footer-bottom">本网站为非赢利性站点，所有内容均由机器人采集于互联网，或者网友上传，本站只提供WEB页面服务，本站不存储、不制作任何视频，不承担任何由于内容的合法性及健康性所引起的争议和法律责任。若本站收录内容侵犯了您的权益，请附说明联系邮箱，本站将第一时间处理。站长邮箱：guazitv@163.com</p>
    </div>
</div>
<!-- 弹窗 -->

<script src="/js/jquery.js"></script>
<script src="/js/video.js?v=1.5"></script>
