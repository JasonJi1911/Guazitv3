<?php
use yii\helpers\Url;
use pc\assets\StyleInAsset;

$this->title = '瓜子TV - 澳新华人在线视频分享平台,海量高清视频在线观看';
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
    
    $('#J-channel-more').click(function(){
        var _txt = $(this).find('.more-txt').text();
        if( _txt == '更多'){
            $(this).find('.more-txt').text('收起');
            $(this).find('.qy-svgicon').addClass('qy-svgicon-anchorTop');
            $(this).parents('.top-channel').addClass('actived');
        }else{
            $(this).find('.more-txt').text('更多');
            $(this).find('.qy-svgicon').removeClass('qy-svgicon-anchorTop');
            $(this).parents('.top-channel').removeClass('actived');
        }
    });
    $('.m-list2 li').mouseenter(function() {
        $(this).addClass('open').siblings('li').removeClass('open');
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
    
    $('.backToTop').click(function() {
        $('html,body').stop(true, false).animate({
            scrollTop: 0
        })
    });
    
    $('.anchor-list').each(function(index, el) {
        $(this).hover(function() {
            $(this).find('.popBox').show();
        }, function() {
            $(this).find('.popBox').hide();
        });
    });
});
JS;

$this->registerJs($js);
?>

<style>
    .m-list2 .sub-title i {
        margin-right: 0px;
    }

    .m-list2 .pic {
        width: 40%;
    }
</style>
<body style="background-color:#fff;" class="classBody">
    <div class="c"></div>
    <div class="qy-list-page">
        <div class="qy-top-page">
            <div class="ban" style="background-image: url(../images/NewVideo//ban1.png);"></div>
            <div class="container">
                <div class="qy-top-tab-box">
                    <ul class="qy-top-tab">
                        <li class="tab-item">
                            <a href="<?= Url::to(['hot-play'])?>" title="热播榜" class="tab-link selected">热播榜</a>
                        </li>
                        <li class="tab-item">
                            <a href="<?= Url::to(['hot-search'])?>" title="热搜榜" class="tab-link">热搜榜</a>
                        </li>
                    </ul>
                    <div class="tab-right-box"><a href="" class="qy-top-sprite zhishu-link"></a></div>
                </div>

                <div class="qy-top-channel">
                    <div id="J-channel-wrap" class="top-channel">
                        <a href="<?= Url::to(['hot-play'])?>"
                           class="channel-item nuxt-link-exact-active nuxt-link-active <?= $channel_id == 0?"selected":"" ?>"
                           aria-current="page"> 全部 </a>
                        <?php if(!empty($channels)) :?>
                            <?php foreach ($channels['list'] as $channel) :?>
                                <?php if($channel['channel_id'] != 0) :?>
                                    <a href="<?= Url::to(['hot-play', 'channel_id' => $channel['channel_id']])?>"
                                       class="channel-item <?= $channel_id == $channel['channel_id']?"selected":"" ?>">
                                        <?= $channel['channel_name']?>
                                    </a>
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php endif;?>
                        <span id="J-channel-more" class="channel-more">
                            <span id="J-more-text" class="more-txt">更多</span>
                            <i id="J-more-icon" class="qy-svgicon qy-svgicon-anchorDown"></i>
                        </span>
                    </div>
                </div>

                <?php if($channel_id == 0) {?>
                    <div class="row-so row-so1">
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
                                    <div class="col-l">
                                        <div class="item">
                                            <div class="m-t2">
                                                <h3><?= $labels['title']?></h3>
                                                <a href="<?= Url::to(['hot-play', 'channel_id' => $channel])?>" class="more">更多&gt;</a>
                                            </div>
                                            <ul class="m-list2">
                                                <?php foreach ($labels['list'] as $key => $list): ?>
                                                    <?php if($key < 10) :?>
                                                        <li class="i<?= $key + 1?><?= $key == 0? " open":"" ?>">
                                                            <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>" class="con">
                                                                <div class="tit-con">
                                                                    <span class="num"><?= $key + 1?></span>
                                                                    <h3><?= $list['video_name']?></h3>
                                                                    <div class="sub-title">
                                                                        <i class="qy-svgicon qy-svgicon-hot"></i>
                                                                        <span><?= str_replace("播放:","",$list['play_times'])?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="pic-con">
                                                                    <div class="pic">
                                                                        <span class="num"><?= $key + 1?></span>
                                                                        <img src="<?= $list['horizontal_cover']?>" alt="">
                                                                    </div>
                                                                    <div class="txt">
                                                                        <h3><?= $list['video_name']?></h3>
                                                                        <p><?= $list['summary']?></p>
                                                                        <div class="sub-title">
                                                                            <i class="qy-svgicon qy-svgicon-hot"></i>
                                                                            <span><?= str_replace("播放:","",$list['play_times'])?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach;?>
                        <?php endif; ?>
                    </div>
                <?php } else {?>
                    <div id="J-rebobang-topbar" class="qy-top-order">
                        <div class="order-left-box">
                            <em class="order-title">排序：</em>
                            <span class="order-con">
                                <em class="J-tab-item order-name selected">热度榜</em>
                            </span>
                        </div>
                        <div class="order-right-box">
                        </div>
                    </div>

                    <ul class="m-list3">
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
                                    <?php if($channel == $channel_id) { ?>
                                        <?php foreach ($labels['list'] as $key => $list): ?>
                                            <li class="i<?= $key + 1?>">
                                                <div class="pic">
                                                    <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                                                        <span class="num"><?= $key + 1?></span>
                                                        <img src="<?= $list['horizontal_cover']?>" alt="">
                                                        <div class="icon-br">
                                                            <span class="qy-mod-label"> <?= $list['flag']?></span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="txt">
                                                    <h3><a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"><?= $list['video_name']?></a></h3>
                                                    <p><?= $list['summary']?></p>
                                                    <div class="sub-title"><i class="qy-svgicon qy-svgicon-hot"></i>
                                                        <span><?= str_replace("播放:","",$list['play_times'])?></span>
                                                    </div>
                                                </div>
                                                <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>" class="J-btn-wrap collect">
                                                    <i class="J-btn-icon qy-svgicon qy-svgicon-collect"></i>
                                                    <span>立即播放</span>
                                                </a>
                                            </li>
                                        <?php endforeach;?>
                                    <?php } ?>
                                <?php endif; ?>
                            <?php endforeach;?>
                        <?php endif; ?>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="c"></div>
    <div class="qy-scroll-anchor qy-aura3">
        <ul class="scroll-anchor">
            <li class="anchor-list anchor-integral">
                <div class="qy-scroll-integral popBox dn">
                    <span class="tianjia-arrow"></span>
                    <img src="/images/NewVideo/client_wechat.jpg" alt="">
                </div>
                <a href="javascript:;" class="anchor-item j-pannel"><i class="qy-svgicon qy-svgicon-anchorIntegral j-pannel"></i><i class="dot j-pannel"></i></a>
            </li>
            <li class="anchor-list">
                <a href="" class="anchor-item qy-aura3"><i class="qy-svgicon qy-svgicon-anchorHelp"></i><span class="anchor-txt">帮助反馈</span></a>
            </li>
            <li class="anchor-list dn">
                <a href="javascript:;"  class="anchor-item backToTop">
                    <i class="qy-svgicon qy-svgicon-anchorTop"></i>
                    <span class="anchor-txt">回到顶部</span>
                </a>
            </li>
        </ul>
    </div>
    <script src="/js/jquery.js"></script>
</body>
