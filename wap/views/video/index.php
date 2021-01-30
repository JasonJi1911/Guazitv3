<?php
use yii\helpers\Url;

$this->title = '瓜子TV-澳新华人在线视频分享网站';

?>

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
                    <li class="swiper-slide on swiper-slide-li">
                        <a href="<?= Url::to(['index', 'channel_id' => $channel['channel_id']])?>"><?= $channel['channel_name']?></a>
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

<div class="video-banner swiper-container video-banner-caroul" id="video-list-banner">
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
            <?php foreach ($data['tags'] as $li): ?>
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
                <li class="swiper-slide on"><a href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag])?>"><?= $li['name']?></a></li>
            <?php endforeach ?>
        <?php endif;?>
    </ul>
</div>

<?php if (!empty($data['label'])) :?>
    <?php foreach ($data['label'] as  $labels): ?>
        <?php if (!isset($labels['advert_id'])) : ?>
            <div class="video-index-column <?= $key == 0 ? 'mt20' : 'mt15';?>">
                <h3 class="video-index-title"><?= $labels['title']?></h3>
                <dl class="video-list-box clearfix <?= 'more-change-'.$labels['recommend_id'] ?>">
                    <?php foreach ($labels['list'] as $key => $list): ?>
                        <?php if($key < 9) :?>
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
                        <?php endif;?>
                    <?php endforeach;?>
                </dl>
            </div>

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
            <div class="video-other-more clearfix">
                <a href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag])?>" class="fl more-item ">
                    <span>查看更多</span>
                </a>
                <a href="javascript:;" class="fl more-item more-change" data-recommend="<?= $labels['recommend_id'] ?>">
                    <span class="change">换一换</span>
                </a>
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
<div class="addtohomescreen" style="position: fixed;bottom: 1px;left: 50%;transform: translateX(-50%);width: 75%;max-width: 75%;display: block;">
    <img src="http://img.guazitv8.com/addtohomescreen.png" alt="" style="width: 100%;">
</div>
<div class="video-index-notice">
    <p style="padding-bottom: 5px;text-align: center;">
        <a class="browser browser1" href="http://m.guazitv.tv">手机端</a>
        <a class="browser" href="http://www.guazitv.tv">电脑端</a></p>
    <p>本网站为非赢利性站点，所有内容均由机器人采集于互联网，或者网友上传，本站只提供WEB页面服务，本站不存储、不制作任何视频，不承担任何由于内容的合法性及健康性所引起的争议和法律责任。若本站收录内容侵犯了您的权益，请附说明联系邮箱，本站将第一时间处理。站长邮箱：guazitv@163.com</p>
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
<script src="/js/video/video.js?v=1.1"></script>
<script src="/js/video/mtop.js"></script>
<script>
    //导航选中项处于中间位置
    $(function () {
        var index = $('#nav-channel').val();

        $(".video-top-nav li").eq(index).addClass("on").siblings().removeClass("on");
        var $cur = $("#topNav .on");
        var index = $cur.index();
        slideLeft1 = $cur.offset().left-20;
        slideWidth1 = $cur.outerWidth(true);
        slideCenter1 = slideLeft1 + slideWidth1 / 2;
        if (slideCenter1 < swiperWidth / 2) {
            mySwiper.setTranslate(0);
        } else if (slideCenter1 > maxWidth) {
            mySwiper.setTranslate(maxTranslate);
        } else {
            nowTlanslate = slideCenter1 - swiperWidth / 2;
            mySwiper.setTranslate(-nowTlanslate);
        }
    });

    $('.addtohomescreen').on('click', function () {
        $('.addtohomescreen').hide();
    })
    //设置banner距离顶部距离
    $('.video-banner').css('margin-top',$('.video-header').css('height'))
</script>
