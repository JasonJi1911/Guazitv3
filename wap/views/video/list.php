<?php
use yii\helpers\Url;

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = '吉祥视频';
$this->registerMetaTag(['name' => 'keywords', 'content' => '吉祥,视频,吉祥视频,澳洲吉祥视频,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片']);

$js = <<<JS
$(function(){
        //筛选影片
        var arrIndex = {};
        arrIndex['channel_id']= $('#channel-id').val();
        arrIndex['tag']= $('#tag').val();
        $('.swiper-slide-li').click(function() {
            var type = $(this).attr('data-type');
            var value = $(this).attr('data-value');
            
            //追加筛选参数
            arrIndex[type] = value;
            arrIndex['page_num']= 1;
            
            //选中分类，添加背景
            $(this).parent().find('.swiper-slide-li').removeClass('on');
            $(this).addClass('on');
            
            //发送请求，获取数据
            $.get('refresh-cate', arrIndex, function(s) {
                var data = s.data.list;
                var content = refreshVideo(data);
                $('.video-list-box').html(content); // 更新内容
                // $('.refresh-video-num-all').html(s.data.total_count); //刷新影片数
                $('.video-list-box').attr('data-pages', s.data.total_page);
                $('.video-list-box').attr('data-page', 1);
                $('.video-list-box').attr('data-url', 'refresh-cate');
            })
        });
        
        //下拉加载更多
        var progress = false; // 是否正在请求中
        var isFlag = true;
        $(window).scroll(function () {
            if (($(window).scrollTop()+188) >= $(document).height() - $(window).height()) {
                if(isFlag) {
                        var arrScroll = arrIndex;
                        var pages = parseInt($('.video-list-box').attr('data-pages') || 1);
                        var page  = parseInt($('.video-list-box').attr('data-page') || 1);
                        
                        var url = $('.video-list-box').attr('data-url') || location.href;
    
                        if (page < pages && !progress) {
                            
                            progress = true;
                            page++;
                            arrScroll['page_num'] = page;
                               
                            $.get(url, arrScroll, function(res) {
                                var data = res.data.list;
                                var content = refreshVideo(data);
                                $('.video-list-box').append(content); // 更新内容
                                $('.video-list-box').attr('data-pages',res.data.total_page);
                                $('.video-list-box').attr('data-page',res.data.current_page);
                                
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
                                "<a href='detail?video_id="+data[i]['video_id']+"'>"+
                                    "<div class='video-item-top'>"+
                                        "<img src='"+data[i]['cover']+"' alt=''>"+
                                        "<div class='mark-box'>"+
                                            "<p class='mark'>"+data[i]['flag']+"</p>"+
                                        "</div>"+
                                    "</div>"+
                                    "<h5 class='video-item-name'>"+data[i]['video_name']+"</h5>"+
                                    "<p class='video-item-play'>"+data[i]['play_times']+"</p>"+
                                "</a>"+
                            "</dd>";
            }
            return content;
        }
        
        //初次进入，类别跳转到相应位置
        $('.cate-list-scroll').each(function() {
            if(($(this).find('.on').index()+1) > 4) {
                $(this).css('transform', 'translate3d(-'+($(this).find('.on').offset().left-17)+'px, 0px, 0px)')
            }
        });
});
JS;

$this->registerJs($js);
?>
<style>
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
</style>
<header class="video-header video-list-header">
    <div class="video-header-top clearfix">
        <a href="<?= Url::to(['/'])?>" class="logo fl">吉祥视频</a>
        <div class="search-cont fr">
            <div class="search-notice"><?= empty($hot['tab'][0]['list'][0]['video_name']) ? '': $hot['tab'][0]['list'][0]['video_name']?></>
        </div>
    </div>
</header>

<?php foreach ($info['search_box'] as $cates): ?>
    <?php if($cates['field'] != 'status'):?>
        <div class="video-select-box swiper-container">
            <div class="select-item swiper-wrapper cate-list-scroll">
                <?php if($cates['field'] == 'tag') :?>
                    <?php foreach ($cates['list'] as $key => $cate): ?>
                        <?php if(empty($tag) && $key == 0) :?>
                            <a href="javascript:void(0);" class="swiper-slide on swiper-slide-li" data-value="<?= $cate['value']?>" data-type="<?= $cates['field']?>"><?= $cate['display']?></a>
                        <?php else:?>
                            <a href="javascript:void(0);" class="swiper-slide <?= $cate['value'] == $tag ? 'on' : ''?> swiper-slide-li" data-value="<?= $cate['value']?>" data-type="<?= $cates['field']?>"><?= $cate['display']?></a>
                        <?php endif;?>
                    <?php endforeach;?>
                <?php else:?>
                    <?php foreach ($cates['list'] as $key => $cate): ?>
                        <a href="javascript:void(0);" class="swiper-slide <?= $key == 0 ? 'on' : ''?> swiper-slide-li" data-value="<?= $cate['value']?>" data-type="<?= $cates['field']?>"><?= $cate['display']?></a>
                    <?php endforeach;?>
                <?php endif;?>
            </div>
        </div>
    <?php endif;?>
<?php endforeach;?>

<input type="hidden" id="channel-id" value="<?= $channel_id?>">
<input type="hidden" id="tag" value="<?= $tag?>">

<div class="video-index-column ">
    <dl class="video-list-box clearfix"  data-pages="<?= $info['total_page']?>" data-page="<?= $info['current_page']?>" data-url="refresh-cate">
        <?php foreach ($info['list'] as $list): ?>
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
        <?php endforeach;?>
    </dl>
</div>

<div class="video-index-notice">
     <p style="padding-bottom: 5px;text-align: center;">
        <a class="browser browser1" href="https://m.jxsp.tv/">手机端</a>
        <a class="browser" href="https://www.jxsp.tv">电脑端</a></p>
    <p>版权声明：如果来函说明本网站提供内容本人或法人版权所有。本网站在核实后，有权先行撤除，以保护版权拥有者的权益。
        &nbsp; 邮箱地址： jxsptv@gmail.com
    </p>
    <p style="text-align:center;">Copyright 2020-2021 jxsp.tv Allrights Reserved.</p>
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
<script src="/js/video/video.js?v=1.0"></script>
