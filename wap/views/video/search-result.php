<?php

use yii\helpers\Url;
$this->registerJsFile('/js/common.js', ['depends' => 'wap\assets\AppAsset']);

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = '热搜结果-瓜子TV|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv - m.guazitv.tv';
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
        
        //搜索信息
        var is_click = false; //加锁，防止数据没更新，用户频繁点击
        $('.search-btn-search').on('click', function() { //发送请求，获取数据
            is_click = true;
            //写入缓存
            setSearchStore($('#keyword').val());
            $.get('search-result-more', {keyword: $('#keyword').val(), 'channel_id': ''}, function(s) {
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
                 is_click = false;
             })
        });
        
        //将搜索历史写入缓存
        keywords = JSON.parse(localStorage.getItem('novelKeywords'));
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
        
    })
JS;

$this->registerJs($js);

?>

<style>
    .search-btn-cancel {
        display: none;
    }
    .search-btn-search {
        display: block;
    }
</style>

<div class="video-search-contanier">
    <div class="index-search-fix clearfix">
        <div class="video-search-box fl">
            <span class="video-search-img">
                <img src="/images/video/icon-search.png" alt="" />
            </span>
            <form action="javascript:return true">
                <input type="search" value="<?= $keyword?>" class="search-input" id="keyword" />
                <img src="/images/video/icon-close.png" alt="" class="search-delete">
            </form>
        </div>
        <a href="javascript:history.go(-1);" class="fr search-cancel search-btn-cancel">取消</a>
        <a href="javascript:;" class="fr search-cancel search-btn-search">搜索</a>
    </div>
</div>
<input type="hidden" id="swiper-type" value="search">
<div class="video-search-rank video-search-snav ">
    <div class="video-top-nav swiper-container" id="topNav">
        <ul class="swiper-wrapper">
            <?php foreach ($data['tabs'] as $key => $tab): ?>
                <li class="swiper-slide <?= $key == 0 ? 'on' : ''?> swiper-slide-channel" data-channel="<?= $tab['channel_id']?>">
                    <a href="javascript:void(0);"><?= $tab['channel_name']?></a>
                    <span class="line"></span>
                </li>
            <?php endforeach;?>

        </ul>
    </div>
    <dl class="video-search-result-list" data-pages="<?= $data['total_page']?>" data-page="<?= $data['current_page']?>">
        <?php foreach ($data['list'] as $key => $list): ?>
            <dd>
                <a href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>" class="clearfix">
                    <div class="sresult-item-left fl">
                        <img src="<?= $list['cover']?>" alt="">
                        <div class="mark-box">
                            <p class="mark"><?= $list['flag']?></p>
                        </div>
                    </div>
                    <div class="sresult-item-right fr">
                        <h3 class="name"><?= $list['video_name']?></h3>
                        <p class="intro"><?= $list['intro']?></p>
                        <div class="clearfix type">
                            <span class="fl"><?= $list['cats']?></span>
                            <span class="fr fontArial">评分：<?= $list['score']?></span>
                        </div>
                    </div>
                </a>
            </dd>
        <?php endforeach;?>
    </dl>

    <p class="search-result-notice"><?= $data['total_page'] < 2 ? '没有更多内容了~' : '查看更多' ?></p>
</div>
<script src="/js/video/jquery.min.1.11.1.js"></script>
<script src="/js/video/swiper.min.js"></script>
<script src="/js/video/video.js"></script>
<script src="/js/video/mtop.js"></script>
