<?php
use yii\helpers\Url;

$this->title = '瓜子TV - 澳新华人在线视频分享平台,海量高清视频在线观看';

$js = <<<JS
$(function(){
    
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
            var searchKeyword = $('#keywords').val();
            if(!searchKeyword) {
                window.location.href = '/';
                return false;
            }
            //写入缓存
            setSearchStore(searchKeyword);
            window.location.href = '/video/index?keyword=' + searchKeyword;
        }
        
        //点击搜索历史记录进行搜索
        $('.search-histoty-list').on('click', '.search-history', function() {
            window.location.href = '/video/index?keyword=' + $(this).attr('data-keyword');
        });
        
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
        
        //点击播放
        //播放源
        $('.video-play-btn-source').click(function() {
            //隐藏封面
            $('.video-play-left-cover').hide();
            //实例化video对象
            var myVideo = videojs('play-video', {
                bigPlayButton: true,
                textTrackDisplay: false,
                posterImage: false,
                errorDisplay: false,
                playbackRates: [0.5,1,1.5,2]
            });
            myVideo.play();
        });
        
        //播放iframe
        $('.video-play-btn-iframe').click(function() {
            //隐藏封面
            $('.video-play-left-cover').hide();
        });
        
        //5s后关闭封面图
        setTimeout(function() {
            $('.video-play-left-cover').hide();
        },5000);
        
        //显示播放源
        $(".video-source").hover(function(){
            $('.video-source-list').css('display', 'block');
        },function(){
            $('.video-source-list').css('display', 'none');
        });
        
        //用户点击目录切换剧集
        $('.icon-left').click(function() {
            var scroll = $('.clearfix-overflow').scrollLeft() - 70;
            if(scroll < 0) {
                scroll = 0;
            }
            $('.clearfix-overflow').scrollLeft(scroll)
        });
        
        $('.icon-right').click(function() {
            var scroll = $('.clearfix-overflow').scrollLeft() + 70;
            $('.clearfix-overflow').scrollLeft(scroll)
        });
        
        //用户点击，切换剧集
        $('.switch-next').click(function() {
            $('.switch-next-li').removeClass('on');
            $(this).addClass('on');
            var videoId = $(this).attr('data-video-id');
            var chapterId = $(this).attr('data-chapter-id');
            var sourceId = $('#video-source').val();
            var type = $(this).attr('data-type');
            
            window.location.href = '/video/detail?video_id=' + videoId + '&chapter_id=' + chapterId
            
            /*
            if(type == 2) {
                $('.switch-next').find('.add_img').find('img').remove();
                $(this).find('.add_img').append("<img src='/images/video/icon-bofang.png' alt='' class='icon-left'>");
            }
            
            //改变所有视频来源的章节ID
            $('.next-source').each(function(i,n){
                $(n).attr('data-video-chapter-id', chapterId);
            });
            
            $.get('/video/switch-video', {'video_id': videoId, 'chapter_id': chapterId, 'source_id': sourceId}, function(s) {
                if(s.data) {
                    $('.video-play-left-cover').css('display', 'block');
                    $('#video-cover').css('display', 'block');
                    $('#my-iframe').attr('src', s.data.info.resource_url);
                    
                    var iframe = document.getElementById("my-iframe");
                    if  (iframe.attachEvent){
                        iframe.attachEvent("onload", function (){
                            $('.video-play-left-cover').css('display', 'none');
                            $('#video-cover').css('display', 'none');
                        });
                    } else {
                        iframe.onload = function (){
                            $('.video-play-left-cover').css('display', 'none');
                            $('#video-cover').css('display', 'none');
                        };
                    }
                }
            }) */
        });
        
        //切换视频源
        $('.next-source').click(function() {
            var videoId = $(this).attr('data-video-id');
            var chapterId = $(this).attr('data-video-chapter-id');
            var sourceId = $(this).attr('data-source-id');
             window.location.href = "/video/detail?video_id="+videoId+"&chapter_id="+chapterId+"&source_id="+sourceId;
        })
    });
JS;

$index = 0;
foreach ($data['info']['videos'] as $k => $v) {
    if($data['info']['play_chapter_id'] == $v['chapter_id']) {
        $index = $k+1;
        break;
    }
}

$select_index = ceil($index/21);

$this->registerJs($js);

?>

<div class="index-main" xmlns="http://www.w3.org/1999/html">
    <div class="video-index-header clearfix">
        <h1 class="fl index-logo">瓜子tv</h1>
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
            <input type="text" placeholder="<?= empty($hot['tab'][0]['list'][0]['video_name']) ? '': $hot['tab'][0]['list'][0]['video_name']?>" class="search-input fl" id="keywords" autocomplete="off">
            <span href="javascript:;" class="index-search-btn fr">
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
    <div class="clearfix mt10 video-play-box">
        <div class="video-play-left fl">
            <?php if($data['info']['resource_type'] == 1) :?>
                <div class="video-play-left-cover">
                    <img src="<?= $data['info']['horizontal_cover'] ?>" alt="" onerror="this.src='/images/video/default-cover-ver.png'" id="video-cover" class="video-play-btn-source">
<!--                    <div class="video-play-btn video-play-btn-source">-->
<!--                        <div class="play-toggle-box">-->
<!--                            <div class="play-toggle">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
                <video id="play-video" class="video-js vjs-big-play-centered" controls data-setup="{}">
                    <?php if(substr($data['info']['resource_url'], strrpos($data['info']['resource_url'], ".") + 1) == 'm3u8') : ?>
                        <source id="source" src="<?= $data['info']['resource_url']?>" type="application/x-mpegURL">
                    <?php else:?>
                        <source id="source" src="<?= $data['info']['resource_url']?>" >
                    <?php endif;?>
                </video>
            <?php else:?>
                <div class="video-play-left-cover">
                    <img src="<?= $data['info']['horizontal_cover'] ?>" onerror="this.src='/images/video/default-cover-ver.png'" id="video-cover" class="video-play-btn-iframe">
<!--                    <div class="video-play-btn video-play-btn-iframe">-->
<!--                        <div class="play-toggle-box">-->
<!--                            <div class="play-toggle">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
                <iframe name="my-iframe" id="my-iframe" src="<?= $data['info']['resource_url']?>" allowfullscreen="true" allowtransparency="true" frameborder="0" scrolling="no" width="100%" height="100%" scrolling="no"></iframe>
            <?php endif;?>
        </div>
        <input type="hidden" value="<?= $source_id?>" id="video-source">
        <div class="video-play-right fl">
            <div class="clearfix video-play-rtop">
                <span class="video-title fl">正片</span>
                <span class="video-eval fl"><?= $data['info']['score']?></span>
                <div class="fr video-source">
                    <span class="video-source-name fl">来源</span>
                    <p class="fl video-source-btn">
                        <?php foreach ($data['info']['source'] as $key => $value): ?>
                            <?php if(empty($source_id) && $key == 0) : ?>
                                <img src="<?= $value['icon']?>" alt="">
                                <span class="source-name"><?= $value['name']?></span>
                            <?php endif;?>
                            <?php if($value['source_id'] == $source_id) : ?>
                                <img src="<?= $value['icon']?>" alt="">
                                <span class="source-name"><?= $value['name']?></span>
                            <?php endif;?>
                        <?php endforeach;?>
                    </p>
                    <div class="video-source-list">
                        <?php foreach ($data['info']['source'] as $key => $source): ?>
                            <div class="video-source-list-li <?= (empty($source_id) && $key == 0) ? 'video-source-list-li-select' : ''?> <?= $source['source_id'] == $source_id? 'video-source-list-li-select' : ''?>">
                                <span class="next-source" data-video-id="<?= $data['info']['video_id']?>" data-video-chapter-id="<?= $data['info']['play_chapter_id']?>" data-source-id="<?= $source['source_id']?>">
                                    <span class="<?= (empty($source_id) && $key == 0) ? 'video-source-list-li-select' : ''?> <?= $source['source_id'] == $source_id? 'video-source-list-li-select' : ''?>">
                                        <?= $source['name']?>
                                    </span>
                                </span>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
            <div class="video-play-rmid clearfix">
                <div class="video-play-item-left fl">
                    <img src="<?= $data['info']['cover']?>" alt="">
                </div>
                <div class="video-play-item-right fl">
                    <h5 class="video-name"><?= $data['info']['video_name']?></h5>
                    <p class="video-intro">主演：<?= $data['info']['actor']?></p>
                    <p class="video-intro">导演：<?= $data['info']['director']?></p>
                    <p class="video-intro">类型：<?= $data['info']['category']?></p>
                    <p class="video-intro">时间：<?= $data['info']['year']?></p>
                    <div class="clearfix video-people">
                        <span class="fl play">正在播放</span>
                        <span class="fr people"><?= $data['info']['total_views']?></span>
                    </div>
                </div>
            </div>
            <div class="video-play-rbottom" style="margin-top: <?= $data['info']['catalog_style'] == 1 ? '20px' : '0px'?>">
                <?php if($data['info']['catalog_style'] == 1) : ?>
                    <div class="video-play-series-top tab-nav">
                        <img src="/images/video/icon-fanye-left.png" alt="" class="arrow icon-left">
                        <ul class="clearfix clearfix-overflow">
                            <?php for($i=0; $i < ceil(count($data['info']['videos'])/21); $i++) :?>
                                <?php if(($i+1) == ceil(count($data['info']['videos'])/21)) : ?>
                                    <li class="<?= $select_index == ($i+1) ? 'on' : ''?>"><?= ($i*21+1) . '-' . count($data['info']['videos'])?></li>
                                <?php else:?>
                                    <li class="<?= $select_index == ($i+1) ? 'on' : ''?>"><?= ($i*21+1) . '-' . (($i+1)*21)?></li>
                                <?php endif;?>
                            <?php endfor;?>
                        </ul>
                        <img src="/images/video/icon-fanye-right.png" alt="" class="arrow icon-right">
                    </div>
                    <div class="tab-box video-play-series-bottom">
                        <?php for($i=0; $i < ceil(count($data['info']['videos'])/21); $i++) :?>
                            <dl class="tab-list video-play-rbottom-list <?= $select_index == ($i+1) ? 'isshow' : ''?>">
                                <?php
                                if(($i+1) == ceil(count($data['info']['videos'])/21)) {
                                    $end_index = count($data['info']['videos']);
                                }else {
                                    $end_index = ($i+1)*21;
                                }
                                ?>
                                <?php for ($j = ($i*21); $j < $end_index; $j++ ) : ?>
                                    <dd class="switch-next-li switch-next video-play-rbottom-list-li <?= $data['info']['play_chapter_id'] == $data['info']['videos'][$j]['chapter_id'] ? 'on' : ''?>" data-video-id="<?= $data['info']['videos'][$j]['video_id']?>" data-chapter-id="<?= $data['info']['videos'][$j]['chapter_id']?>"  data-type="1">
                                        <span >
                                            <p class="title"><?= $data['info']['videos'][$j]['title']?></p>
                                        </span>
                                    </dd>
                                <?php endfor;?>
                            </dl>
                        <?php endfor;?>
                    </div>
                <?php else:?>
                    <dl class="video-play-rbottom-list">
                        <?php foreach ($data['info']['videos'] as $value) : ?>
                            <dd class="<?= $data['info']['play_chapter_id'] == $value['chapter_id'] ? 'on' : ''?> switch-next-li switch-next" data-video-id="<?= $value['video_id']?>" data-chapter-id="<?= $value['chapter_id']?>" data-type="2">
                                <span class="add_img">
                                    <?php if($data['info']['play_chapter_id'] == $value['chapter_id'] ) : ?>
                                        <img src="/images/video/icon-bofang.png" alt="" class="icon-left">
                                    <?php endif;?>
                                    <p class="title"><?= $value['title']?></p>
                                </span>
                            </dd>
                        <?php endforeach;?>
                    </dl>
                <?php endif;?>
            </div>
        </div>
    </div>
    <h3 class="video-detail-title">猜你喜欢</h3>
    <dl class="video-list-box clearfix">
        <?php foreach ($data['guess_like'] as $key => $list) :?>
            <?php if($key < 6) :?>
                <dd>
                    <a href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>">
                        <div class="video-item-top">
                            <img src="<?= $list['cover']?>" alt="">
                            <div class="mark-box">
                                <p class="mark-box-hot"><?= $list['play_times']?></p>
                                <div class="clearfix mark-box-date">
                                    <span class="fl fontArial date">2020-09-03</span>
                                    <span class="fr fontArial eval"><?= $list['flag']?></span>
                                </div>
                            </div>
                        </div>
                        <h5 class="video-item-name"><?= $list['video_name']?></h5>
                        <p class="video-item-play"><?= $list['intro']?></p>
                    </a>
                </dd>
            <?php endif;?>
        <?php endforeach;?>
    </dl>
    <div class="video-index-footer">
<!--        <p class="footer-top"><a>手机版 </a>  |  <a> 电脑版</a></p>-->
        <p class="footer-bottom">本网站为非赢利性站点，所有内容均由机器人采集于互联网，或者网友上传，本站只提供WEB页面服务，本站不存储、不制作任何视频，不承担任何由于内容的合法性及健康性所引起的争议和法律责任。若本站收录内容侵犯了您的权益，请附说明联系邮箱，本站将第一时间处理。站长邮箱：guazitv@163.com</p>
    </div>
</div>
<script src="/js/jquery.js"></script>
<script src="/js/video.js?v=1.5"></script>
