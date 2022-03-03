<?php

use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

//$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子tv,澳洲瓜子tv,新西兰瓜子tv,澳新瓜子tv,瓜子视频,瓜子影视,电影,电视剧,榜单,综艺,动画,记录片']);
//$this->title = '首页';
NewIndexStyleAsset::register($this);

$js = <<<SCRIPT
$(function(){
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 7,
        slidesPerColumn: 1,
        spaceBetween: 17,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            1024: {
                slidesPerView: 6,
            },
            1440: {
                slidesPerView: 6,
            },
            1550: {
                slidesPerView: 6,
            },
        }
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
            $("#jBox1-overlay").hide();
            $("#jBox1").fadeOut();
        }
        if(document.getElementById('closeAd'))
            document.getElementById('closeAd').innerHTML = msg+"秒后自动关闭"; 
    }) 
	
	$(".jBox-closeButton").click(function(){
	    $("#jBox1-overlay").hide();
        $("#jBox1").fadeOut();
	});
});
SCRIPT;

$this->registerJs($js);
?>
<style>
    body{
        background-color: #000000;
    }

    .jBox-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        /* background-color: rgba(0,0,0,.82); */
        background-color: rgba(255, 255, 255, 0.6);
    }

    #jBox1 {
        /* top: 165px !important; */
        top: 80px !important;
    }

    .jBox-wrapper {
        text-align: left;
        box-sizing: border-box;
    }

    /**
    * 去掉广告白色边框
    */
    /* .jBox-Modal .jBox-container, .jBox-Modal.jBox-closeButton-box:before {
        box-shadow: 0 3px 15px rgb(0 0 0 / 40%), 0 0 5px rgb(0 0 0 / 40%);
    } */

    /**
    * 去掉广告白色边框
    * background: #fff;
    */
    .jBox-Modal .jBox-container {
        border-radius: 4px;
        /* background: #fff; */
    }

    .jBox-container, .jBox-content, .jBox-title {
        position: relative;
        word-break: break-word;
        box-sizing: border-box;
    }

    .jBox-Modal .jBox-content {
        padding: 15px 20px;
    }

    .jBox-content {
        padding: 8px 10px;
        overflow-x: hidden;
        overflow-y: auto;
        transition: opacity .2s;
    }
    /**
    * 移至右下放
    */
    .jBox-closeButton-box .jBox-closeButton {
        /* top: -8px; */
        bottom: 0px;
        right: -10px;
        width: 24px;
        height: 24px;
        background: #fff;
        border-radius: 50%;
    }

    .jBox-closeButton {
        z-index: 1;
    }

    .jBox-closeButton {
        cursor: pointer;
        position: absolute;
    }

    .jBox-closeButton-box .jBox-closeButton svg {
        width: 10px;
        height: 10px;
        margin-top: -5px;
        margin-right: -5px;
    }

    .jBox-closeButton svg {
        position: absolute;
        top: 50%;
        right: 50%;
    }

    .jBox-closeButton path {
        fill: #aaa;
    }

    .jBox-closeButton path {
        transition: fill .2s;
    }
</style>
<!--首页大轮播-->
<div id="playBox" class="play-box">
    <!--图片列表-->
    <div id="imgList">
        <?php if(!empty($data['banner'])) : ?>
            <?php foreach ($data['banner'] as $key => $banner): ?>
                <a href="<?= str_replace("/detail","/detail",$banner['content'])?>" target="_blank"
                    <?php if($key==0) : ?>
                        class="current"
                    <?php endif;?>
                >
                    <img src="<?= $banner['image']?>"  />
                </a>
            <?php endforeach ?>
        <?php endif;?>
    </div>
    <!--图标列表-->
    <div class="iconList">
        <ul>
            <?php if(!empty($data['banner'])) : ?>
                <?php foreach ($data['banner'] as $key => $banner): ?>
                    <li
                        <?php if($key==0) : ?>
                            class="current"
                        <?php endif;?> >
                        <a href="<?= str_replace("/detail","/detail",$banner['content'])?>"><?= $banner['title']?></a>
                    </li>
                <?php endforeach ?>
            <?php endif;?>
        </ul>
    </div>
    <div class="qy20-h-carousel__maskbottom"></div>
    <!--首页分类列表-->
    <div class="sort">
        <div class="sortBox">
            <?php if(!empty($channels)) : ?>
                <?php foreach ($channels['list'] as $key => $channel): ?>
                    <div class="sort_content">
                        <?php
                        switch($channel['channel_id']){
                            case 0:
                                $icon_img = "../images/Index/shouye.png";
                                $icon_img_c = "../images/Index/shouye_c.png";
                                break;
                            case 1:
                                $icon_img = "../images/Index/dianying.png";
                                $icon_img_c = "../images/Index/dianying_c.png";
                                break;
                            case 2:
                                $icon_img = "../images/Index/zhuireju.png";
                                $icon_img_c = "../images/Index/zhuireju_c.png";
                                break;
                            case 3:
                                $icon_img = "../images/Index/zongyi.png";
                                $icon_img_c = "../images/Index/zongyi_c.png";
                                break;
                            case 4:
                                $icon_img = "../images/Index/dongmanxian.png";
                                $icon_img_c = "../images/Index/dongmanxian_c.png";
                                break;
                            case 32:
                                $icon_img = "../images/Index/jilupian_2.png";
                                $icon_img_c = "../images/Index/jilupian_2c.png";
                                break;
                            case 39:
                                $icon_img = "../images/Index/tiyu.png";
                                $icon_img_c = "../images/Index/tiyu_c.png";
                                break;
                            default:
                                $icon_img = "";
                                $icon_img_c = "";

                        }
                        ?>
                        <?php if($channel['channel_id'] == 0) : ?>
                            <div class="sort_img">
                                <a href="<?= Url::to(['/video/index'])?>" style="display: flex;align-items: center;flex-direction: row;">
                                    <img class="J_sort_img_c" src="<?=$icon_img_c?>" style="display:none;">
                                    <img class="J_sort_img" src="<?=$icon_img?>">
                                    <div class="sort-text">
                                        <span><?= $channel['channel_name']?></span>
                                    </div>
                                </a>
                            </div>
                        <?php else:?>
                            <div class="sort_img">
                                <a href="<?= Url::to(['video/channel', 'channel_id' => $channel['channel_id']])?>">
                                    <img class="J_sort_img_c" src="<?=$icon_img_c?>" style="display:none;">
                                    <img class="J_sort_img" src="<?=$icon_img?>">
                                    <div class="sort-text">
                                        <span><?= $channel['channel_name']?></span>
                                        <? if($channel['num'] != 0) : ?>
                                            <span class="sortSpan"><?=$channel['num']?></span>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            </div>
                    <?php endif;?>
                    </div>
                <?php endforeach ?>
            <?php endif;?>
        </div>
    </div>
</div>
<?php if (!empty($data['label'])) :?>
    <!--今日热点-->
    <ul class="RD-box" name="zt">
        <li class="Title-00">
            <a class="Title-big" href="javascript:;">今日热点</a>
        </li>
        <li class="RD-banner">
            <!--热点轮播-->
            <div id="playBox02" class="play-box02">
                <!--图片列表-->
                <a class="RD-boxA current02" href="https://www.baidu.com" target="_blank">
                    <div class="RD-img" class="current02">
                        <img src="/images/Index/img_2.png" />
                    </div>
                    <div class="RD-title">
                        <div class="RD-name">
                            测试名称
                        </div>
                        <div class="RD-cs">
                            <span>454545</span>次播放
                        </div>
                    </div>
                    <!--                    <a class="RD-boxA" href="javascript:;" target="_blank">-->
                    <!--                        <div class="RD-img">-->
                    <!--                            <img src="/images/Index/img_2.png" />-->
                    <!--                        </div>-->
                    <!--                        <div class="RD-title">-->
                    <!--                            <div class="RD-name">-->
                    <!--                                测试名称-->
                    <!--                            </div>-->
                    <!--                            <div class="RD-cs">-->
                    <!--                                <span>454545</span>次播放-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </a>-->
                </a>
                <!--图标列表-->
                <!--                <div class="iconList02">-->
                <!--                    <ul>-->
                <!--                        <li class="current02">&nbsp;</li>-->
                <!--                        <li>&nbsp;</li>-->
                <!--                        <li>&nbsp;</li>-->
                <!--                        <li>&nbsp;</li>-->
                <!--                        <li>&nbsp;</li>-->
                <!--                    </ul>-->
                <!--                </div>-->
            </div>
        </li>

        <li>
            <a class="RD-boxA" href="https://www.baidu.com" target="_blank">
                <div class="RD-img">
                    <img src="/images/Index/img_1.png" />
                </div>
                <div class="RD-title">
                    <div class="RD-name">
                        测试名称测试名称测试名称测试名称测试名称测试名称测试名称测试名称
                    </div>
                    <div class="RD-cs">
                        <span>454545</span>次播放
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a class="RD-boxA" href="javascript:;">
                <div class="RD-img">
                    <img src="/images/Index/img_1.png" />
                </div>
                <div class="RD-title">
                    <div class="RD-name">
                        测试名称
                    </div>
                    <div class="RD-cs">
                        <span>454545</span>次播放
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a class="RD-boxA" href="javascript:;">
                <div class="RD-img">
                    <img src="/images/Index/img_1.png" />
                </div>
                <div class="RD-title">
                    <div class="RD-name">
                        测试名称测试名称测试名称测试名称测试名称测试名称测试名称测试名称
                    </div>
                    <div class="RD-cs">
                        <span>454545</span>次播放
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a class="RD-boxA" href="javascript:;">
                <div class="RD-img">
                    <img src="/images/Index/img_1.png" />
                </div>
                <div class="RD-title">
                    <div class="RD-name">
                        测试名称
                    </div>
                    <div class="RD-cs">
                        <span>454545</span>次播放
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a class="RD-boxA" href="javascript:;">
                <div class="RD-img">
                    <img src="/images/Index/img_1.png" />
                </div>
                <div class="RD-title">
                    <div class="RD-name">
                        测试名称测试名称测试名称测试名称测试名称测试名称测试名称测试名称
                    </div>
                    <div class="RD-cs">
                        <span>454545</span>次播放
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a class="RD-boxA" href="javascript:;">
                <div class="RD-img">
                    <img src="/images/Index/img_1.png" />
                </div>
                <div class="RD-title">
                    <div class="RD-name">
                        测试名称
                    </div>
                    <div class="RD-cs">
                        <span>454545</span>次播放
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a class="RD-boxA" href="javascript:;">
                <div class="RD-img">
                    <img src="/images/Index/img_1.png" />
                </div>
                <div class="RD-title">
                    <div class="RD-name">
                        测试名称测试名称测试名称测试名称测试名称测试名称测试名称测试名称
                    </div>
                    <div class="RD-cs">
                        <span>454545</span>次播放
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a class="RD-boxA" href="javascript:;">
                <div class="RD-img">
                    <img src="/images/Index/img_1.png" />
                </div>
                <div class="RD-title">
                    <div class="RD-name">
                        测试名称
                    </div>
                    <div class="RD-cs">
                        <span>454545</span>次播放
                    </div>
                </div>
            </a>
        </li>
    </ul>
    <!--新片预告-->
    <?php if($data['trailer']['trailer']):?>
    <ul class="NewTrailer-box" name="zt">
        <li class="Title-01">
            <a class="Title-big" href="javaScript:;"><?=$data['trailer']['trailer_title']['title']?></a>
        </li>
        <!--电影列表-->
        <?php foreach ($data['trailer']['trailer'] as $key=>$list): ?>
            <?php if($key < 7) :?>
                <li class="Movie-list"  >
                    <div class="Coming-online">
                        <div class="Coming-online-line"></div>
                        <div class="Coming-online-text"><?=date('Y-m-d',$list['online_time'])?></div>
                    </div>
                    <a class="Movie" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                        <img class="Movie-img i_background_errorimg" src="<?= $list['cover']?>" />
                        <div class="palyBtn">
                            <img src="/images/newindex/bofang.png" />
                        </div>

                        <div class="Movie-details" name="zt">
                            <div class="Movie-name01" name="zt">
                                <?= $list['video_name']?>
                            </div>
                            <ul class="Movie-type" name="zt">
                                <?php foreach (explode(' ',$list['category']) as $category): ?>
                                    <li>
                                        <?= $category?>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                            <div class="Movie-star" name="zt">
                                主演：
                                <?php if (!empty($list['actors'])) :?>
                                    <?php foreach ($list['actors'] as $key => $actor): ?>
                                        <span><?= $actor['actor_name']?></span>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </div>
                            <div class="Movie-content" name="zt">
                                简介：
                                <span><?= $list['intro']?></span>
                            </div>
                            <ul class="Movie-btm" name="zt">
                                <li><?= $list['play_times']?></li>
                                <li><input class="XQ" type="button" value="详情" onclick="XQ('<?= $list['video_id']?>')"/></li>
                            </ul>
                        </div>
                    </a>
                    <a class="Movie-name02 font-color-FFFFFF" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                        <?= $list['video_name']?>
                    </a>
                    <div class="Movie-type02" name="zt">
                        <div>
                            <?php foreach (explode(' ',$list['category']) as $category): ?>
                                <span><?= $category?></span>
                            <?php endforeach;?>
                        </div>
                        <div></div>
                    </div>
                </li>
                <!--详情弹出层,默认隐藏-->
                <div class="alt" id="alt03<?= $list['video_id']?>">
                    <div class="alt03-box" name="zt">
                        <div class="alt03-box-t">
                            <div class="alt03-box-R">
                                <img class="i_background_errorimg" src="<?= $list['cover']?>"  />
                            </div>
                            <div class="alt03-box-L">
                                <a class="XQ-name" name="zt" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"><?= $list['video_name']?></a>
                                <div class="GNbox">
                                    <div class="GNbox-type" name="zt">
                                        <?php foreach (explode(' ',$list['category']) as $category): ?>
                                            <span>
                                                <?= $category?>
                                            </span>
                                        <?php endforeach;?>
                                    </div>
                                    <div class="GNbox-RD" name="zt">
                                        <?= $list['play_times']?>
                                    </div>
                                    <div class="GNbox-PF">
                                        <span><?= $list['score']?></span>分
                                    </div>
                                </div>
                                <ul class="XQ-text">
                                    <li>年代:<span><?= $list['year']?></span></li>
                                    <li>导演:<span>
                                                <?php if (!empty($list['director'])) :?>
                                                    <?php foreach ($list['director'] as $key => $director): ?>
                                                        <?= $director['actor_name']?>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                    </li>
                                    <li>主演:
                                        <span>
                                            <?php if (!empty($list['actors'])) :?>
                                                <?php foreach ($list['actors'] as $key => $actor): ?>
                                                    <?php if ($actor['actor_name'] !='') :?>
                                                        <?php if ($key==0) :?>
                                                            <?= $actor['actor_name']?>
                                                        <?php else: ?>
                                                            &nbsp;/&nbsp;<?= $actor['actor_name']?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        </span>
                                    </li>
                                </ul>
                                <div class="XQ-btn" name="zt">
                                    <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">播放</a>
                                    <input type="button" value="收藏" onclick="addfavors(<?=$list['video_id']?>)" />
                                </div>
                            </div>
                        </div>

                        <p class="alt03-box-Z">
                            简介：<span><?= $list['intro']?></span>
                        </p>
                        <!--                                <div class="alt03-box-B">-->
                        <!--                                    <div><span>173</span>评论</div>-->
                        <!--                                    <div><span>173</span>赞</div>-->
                        <!--                                    <div><span>50</span>踩</div>-->
                        <!--                                    <div><span>12</span>分享 </div>-->
                        <!--                                </div>-->
                        <!--关闭按钮-->
                        <input class="alt-GB" type="button" value="X" />
                    </div>
                </div>
            <?php endif;?>
        <?php endforeach ?>
    </ul>
    <?php endif;?>
    <?php foreach ($data['label'] as $labels): ?>
        <?php if (!isset($labels['advert_id'])) : ?>
            <?php
            $tag = '';
            $channel = '';
            foreach ($labels['search'] as $s_k => $s_v) {
                if($s_v['field'] == 'channel_id') {
                    $channel = $s_v['value'];
                }
            }
            ?><!-- 频道 + 排行榜 -->
            <?php if($channel <= 4 && $channel>=1) :?>
                <ul class="Movie-box" name="zt"  id="section<?= $channel?>">
                    <li class="Title-02" style="display: flex;height:37px;">
                        <a class="Title-02-a" href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag])?>"><?= $labels['title']?></a>
                        <div class="qy-mod-nav-link" style="display: flex;align-items: center;">
                            <ul class="qy-mod-crumb" style="color:#FFF;font-size:16px;line-height: 16px;display:flex;">
                                <?php if(!empty($labels['tags'])) : ?>
                                    <?php foreach ($labels['tags'] as $key=>$li): ?>
                                        <?php if($key < 7) : ?>
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
                                            <li style="display: flex;margin-left:10px;"><a href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag])?>" class="font-color color-pink"><?= $li['name']?></a><div style="width:1px;background-color: #FFF;margin-left:14px;height:16px;"></div></li>
                                        <?php endif;?>
                                    <?php endforeach ?>
                                <?php endif;?>
                                <li style="margin-left:30px;"><a href="/video/channel?channel_id=2" class="font-color">更多 &gt;</a></li>
                            </ul>
                        </div>
                    </li>

                    <?php
                    $channelName = '';
                    foreach ($channels['list'] as $s_k => $s_v) {
                        if($s_v['channel_id'] == $channel) {
                            $channelName = $s_v['channel_name'];
                        }
                    }
                    ?>
                    <li class="Title-03">
                        <!--                        <img src="/images/newindex/logo-02.png" />-->
                        <!--                        <a href="--><?//= Url::to(['hot-play', 'channel_id' => $channel])?><!--">-->
                        <!--                            --><?//= $channelName?><!--排行榜-->
                        <!--                        </a>-->
                    </li>
                    <!--电影排行榜-->
                    <li class="Movie-Ranking" name="zt">
                        <?php foreach ($hotword['tab'] as $key => $tab): ?>
                            <?php if($tab['title'] == $channelName) :?>
                                <?php foreach ($tab['list'] as $key => $list): ?>
                                    <?php if($key < 10) :?>
                                        <!--排名前10-->
                                        <div class="Movie-Ranking-height <?php if($key > 0) :?>Movie-Ranking-margin-top<?php endif;?>">
                                            <div class="Movie-Ranking-flex-row">
                                                <div><img class="Movie-Ranking-img" src="/images/Index/paiming<?= $key+1?>.png"></div>
                                                <div class="Movie-Ranking-right-top">
                                                    <div class="Movie-Ranking-right-top-up">
                                                        <div>
                                                            <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>" class="font-color"><?= $list['video_name']?></a>
                                                        </div>
                                                        <div class="pink-color"><?= $list['score']?></div>
                                                    </div>
                                                    <div class="Movie-Ranking-right-bottom">
                                                        <?php foreach (explode(' ',$list['category']) as $category): ?>
                                                            <span>
                                                                <?= $category?>
                                                            </span>
                                                        <?php endforeach;?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="Movie-Ranking-bottom-border"></div>
                                        </div>
                                    <?php endif;?>
                                <?php endforeach;?>
                            <?php endif;?>
                        <?php endforeach;?>
                    </li>

                    <!--电影列表-->
                    <?php foreach ($labels['list'] as $key => $list): ?>
                        <?php if($key < 12) :?>
                            <li class="Movie-list">
                                <a class="Movie" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                                    <img class="Movie-img i_background_errorimg" src="<?= $list['cover']?>" />
                                    <div class="palyBtn">
                                        <img src="/images/newindex/bofang.png" />
                                    </div>
                                    <div class="Movie-details" name="zt">
                                        <div class="Movie-name01" name="zt">
                                            <?= $list['video_name']?>
                                        </div>
                                        <ul class="Movie-type" name="zt">
                                            <?php foreach (explode(' ',$list['category']) as $category): ?>
                                                <li>
                                                    <?= $category?>
                                                </li>
                                            <?php endforeach;?>
                                        </ul>
                                        <div class="Movie-star" name="zt">
                                            主演：
                                            <?php if (!empty($list['actors'])) :?>
                                                <?php foreach ($list['actors'] as $key => $actor): ?>
                                                    <span><?= $actor['actor_name']?></span>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        </div>
                                        <div class="Movie-content" name="zt">
                                            简介：
                                            <span><?= $list['intro']?></span>
                                        </div>
                                        <ul class="Movie-btm" name="zt">
                                            <li><?= $list['play_times']?></li>
                                            <li><input class="XQ" type="button" value="详情" onclick="XQ('<?= $list['video_id']?>')"/></li>
                                        </ul>
                                    </div>
                                    <div class="Movie-J">
                                        <img src="/images/newindex/tuijian.png" />
                                    </div>
                                    <?php if($list['video_newest']=='1'):?>
                                        <div class="Movie-X">新</div>
                                    <?php endif;?>
                                </a>
                                <a class="Movie-name02 font-color-FFFFFF" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                                    <?= $list['video_name']?>
                                </a>
                                <div class="Movie-type02" name="zt">
                                    <div>
                                        <?php foreach (explode(' ',$list['category']) as $category): ?>
                                            <span><?= $category?></span>
                                        <?php endforeach;?>
                                    </div>
                                    <div>
                                        <?= $list['flag']?>
                                        <!-- 更新01 -->
                                    </div>
                                </div>
                            </li>

                            <!--详情弹出层,默认隐藏-->
                            <div class="alt" id="alt03<?= $list['video_id']?>">
                                <div class="alt03-box" name="zt">
                                    <div class="alt03-box-t">
                                        <div class="alt03-box-R">
                                            <img class="i_background_errorimg" src="<?= $list['cover']?>"  />
                                        </div>
                                        <div class="alt03-box-L">
                                            <a class="XQ-name" name="zt" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"><?= $list['video_name']?></a>
                                            <div class="GNbox">
                                                <div class="GNbox-type" name="zt">
                                                    <?php foreach (explode(' ',$list['category']) as $category): ?>
                                                        <span>
                                                        <?= $category?>
                                                    </span>
                                                    <?php endforeach;?>
                                                </div>
                                                <div class="GNbox-RD" name="zt">
                                                    <?= $list['play_times']?>
                                                </div>
                                                <div class="GNbox-PF">
                                                    <span><?= $list['score']?></span>分
                                                </div>
                                            </div>
                                            <ul class="XQ-text">
                                                <li>年代:<span><?= $list['year']?></span></li>
                                                <li>导演:<span>
                                                        <?php if (!empty($list['director'])) :?>
                                                            <?php foreach ($list['director'] as $key => $director): ?>
                                                                <?= $director['actor_name']?>
                                                            <?php endforeach;?>
                                                        <?php endif;?>
                                                </li>
                                                <li>主演:
                                                    <span>
                                                    <?php if (!empty($list['actors'])) :?>
                                                        <?php foreach ($list['actors'] as $key => $actor): ?>
                                                            <?php if ($actor['actor_name'] !='') :?>
                                                                <?php if ($key==0) :?>
                                                                    <?= $actor['actor_name']?>
                                                                <?php else: ?>
                                                                    &nbsp;/&nbsp;<?= $actor['actor_name']?>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach;?>
                                                    <?php endif;?>
                                                </span>
                                                </li>
                                            </ul>
                                            <div class="XQ-btn" name="zt">
                                                <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">播放</a>
                                                <input type="button" value="收藏" onclick="addfavors(<?=$list['video_id']?>)" />
                                            </div>
                                        </div>
                                    </div>

                                    <p class="alt03-box-Z">
                                        简介：<span><?= $list['intro']?></span>
                                    </p>
                                    <!--                                <div class="alt03-box-B">-->
                                    <!--                                    <div><span>173</span>评论</div>-->
                                    <!--                                    <div><span>173</span>赞</div>-->
                                    <!--                                    <div><span>50</span>踩</div>-->
                                    <!--                                    <div><span>12</span>分享 </div>-->
                                    <!--                                </div>-->
                                    <!--关闭按钮-->
                                    <input class="alt-GB" type="button" value="X" />
                                </div>
                            </div>
                        <?php endif;?>
                    <?php endforeach;?>
                </ul>
            <?php else : ?><!-- 只有频道 -->
                <ul class="Sports-box" name="zt"  id="section<?= $channel?>">
                    <li class="Title-01" style="display: flex;height:37px;">
                        <a class="Title-02-a" href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag])?>"><?= $labels['title']?></a>
                        <div class="qy-mod-nav-link" style="display: flex;align-items: center;">
                            <ul class="qy-mod-crumb" style="color:#FFF;font-size:16px;line-height: 16px;display:flex;">
                                <?php if(!empty($labels['tags'])) : ?>
                                    <?php foreach ($labels['tags'] as $key=>$li): ?>
                                        <?php if($key < 7) : ?>
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
                                            <li style="display: flex;margin-left:10px;"><a href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag])?>" class="font-color"><?= $li['name']?></a><div style="width:1px;background-color: #FFF;margin-left:14px;height:16px;"></div></li>
                                        <?php endif;?>
                                    <?php endforeach ?>
                                <?php endif;?>
                                <li style="margin-left:30px;"><a href="/video/channel?channel_id=2" class="font-color">更多 &gt;</a></li>
                            </ul>
                    </li>
                    <?php foreach ($labels['list'] as $key => $list): ?>
                        <?php if($key < 7) :?>
                            <li class="Movie-list">
                                <a class="Movie" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                                    <img class="Movie-img i_background_errorimg" src="<?= $list['cover']?>" />
                                    <!--                                    <div class="oth-time">-->
                                                                            <!--评分-->
                                    <!--                                        --><?//= $list['score']?>
                                    <!--                                    </div>-->
                                    <div class="palyBtn">
                                        <img src="/images/newindex/bofang.png" />
                                    </div>
                                    <div class="Movie-details" name="zt">
                                        <div class="Movie-name01" name="zt">
                                            <?= $list['video_name']?>
                                        </div>
                                        <ul class="Movie-type" name="zt">
                                            <?php foreach (explode(' ',$list['category']) as $category): ?>
                                                <li>
                                                    <?= $category?>
                                                </li>
                                            <?php endforeach;?>
                                        </ul>
                                        <div class="Movie-star" name="zt">
                                            主演：
                                            <?php if (!empty($list['actors'])) :?>
                                                <?php foreach ($list['actors'] as $key => $actor): ?>
                                                    <span><?= $actor['actor_name']?></span>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        </div>
                                        <div class="Movie-content" name="zt">
                                            简介：
                                            <span><?= $list['intro']?></span>
                                        </div>
                                        <ul class="Movie-btm" name="zt">
                                            <li><?= $list['play_times']?></li>
                                            <li><input class="XQ" type="button" value="详情" onclick="XQ('<?= $list['video_id']?>')"/></li>
                                        </ul>
                                    </div>
                                    <div class="Movie-J">
                                        <img src="/images/newindex/tuijian.png" />
                                    </div>
                                    <?php if($list['video_newest']=='1'):?>
                                        <div class="Movie-X">新</div>
                                    <?php endif;?>
                                </a>
                                <a class="Movie-name02 font-color-FFFFFF" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                                    <?= $list['video_name']?>
                                </a>
                                <div class="Movie-type02" name="zt">
                                    <div>
                                        <?php foreach (explode(' ',$list['category']) as $category): ?>
                                            <span>
                                                <?= $category?>
                                            </span>
                                        <?php endforeach;?>
                                    </div>
                                    <div>
                                        <?= $list['flag']?>
                                        <!-- 更新01-->
                                    </div>
                                </div>
                            </li>
                            <!--详情弹出层,默认隐藏-->
                            <div class="alt" id="alt03<?= $list['video_id']?>">
                                <div class="alt03-box" name="zt">
                                    <div class="alt03-box-t">
                                        <div class="alt03-box-R">
                                            <img class="i_background_errorimg" src="<?= $list['cover']?>" />
                                        </div>
                                        <div class="alt03-box-L">
                                            <a class="XQ-name" name="zt" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"><?= $list['video_name']?></a>
                                            <div class="GNbox">
                                                <div class="GNbox-type" name="zt">
                                                    <?php foreach (explode(' ',$list['category']) as $category): ?>
                                                        <span><?= $category?></span>
                                                    <?php endforeach;?>
                                                </div>
                                                <div class="GNbox-RD" name="zt">
                                                    <?= $list['play_times']?>
                                                </div>
                                                <div class="GNbox-PF">
                                                    <span><?= $list['score']?></span>分
                                                </div>
                                            </div>
                                            <ul class="XQ-text">
                                                <li>年代:<span><?= $list['year']?></span></li>
                                                <li>导演:<span>
                                                                <?php if (!empty($list['director'])) :?>
                                                                    <?php foreach ($list['director'] as $key => $director): ?>
                                                                        <?= $director['actor_name']?>
                                                                    <?php endforeach;?>
                                                                <?php endif;?>
                                                </li>
                                                <li>主演:
                                                    <span>
                                                            <?php if (!empty($list['actors'])) :?>
                                                                <?php foreach ($list['actors'] as $key => $actor): ?>
                                                                    <?php if ($actor['actor_name'] !='') :?>
                                                                        <?php if ($key==0) :?>
                                                                            <?= $actor['actor_name']?>
                                                                        <?php else: ?>
                                                                            &nbsp;/&nbsp;<?= $actor['actor_name']?>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                <?php endforeach;?>
                                                            <?php endif;?>
                                                        </span>
                                                </li>
                                            </ul>
                                            <div class="XQ-btn" name="zt">
                                                <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">播放</a>
                                                <input type="button" value="收藏" onclick="addfavors(<?=$list['video_id']?>)" />
                                            </div>
                                        </div>
                                    </div>

                                    <p class="alt03-box-Z">
                                        简介：<span><?= $list['intro']?></span>
                                    </p>
                                    <!--                                <div class="alt03-box-B">-->
                                    <!--                                    <div><span>173</span>评论</div>-->
                                    <!--                                    <div><span>173</span>赞</div>-->
                                    <!--                                    <div><span>50</span>踩</div>-->
                                    <!--                                    <div><span>12</span>分享 </div>-->
                                    <!--                                </div>-->
                                    <!--关闭按钮-->
                                    <input class="alt-GB" type="button"  value="X" />
                                </div>
                            </div>
                        <?php endif;?>
                    <?php endforeach;?>
                </ul>
            <?php endif; ?>
<!--        --><?php //else : ?>
            <!--广告 -->
<!--            <div class="play-ad-box video-add-column">-->
<!--                <a href="--><?//=$labels['ad_skip_url']?><!--" target="_blank">-->
<!--                    <img src="--><?//=$labels['ad_image']?><!--" alt="">-->
<!--                </a>-->
<!--            </div>-->
        <?php endif; ?>
    <?php endforeach;?>
    <!--赛事直播-->
    <ul class="Livemaches-box" name="zt">
        <li class="Title-01">
            <a class="Title-big" href="javascript:;">赛事直播</a>
        </li>
        <li class="Livemaches-Movie-list J_Livemaches-Movie-list">
            <a class="Livemaches-Movie" href="https://www.baidu.com">
                <img class="Livemaches-img i_background_errorimg" src="<?= $list['cover']?>" />
            </a>
            <div class="Livemaches-title">
                <div class="Livemaches-name">
                    WWW RAW1484期
                </div>
            </div>
            <div class="Livemaches-yuyue" style="display:none;">
                预约
            </div>
        </li>
        <li class="Livemaches-Movie-list J_Livemaches-Movie-list">
            <a class="Livemaches-Movie" href="https://www.baidu.com">
                <img class="Livemaches-img i_background_errorimg" src="<?= $list['cover']?>" />
            </a>
            <div class="Livemaches-title">
                <div class="Livemaches-name">
                    WWW RAW1484期
                </div>
            </div>
            <div class="Livemaches-yuyue">
                预约
            </div>
        </li>
        <li class="Livemaches-Movie-list J_Livemaches-Movie-list">
            <a class="Livemaches-Movie" href="https://www.baidu.com">
                <img class="Livemaches-img i_background_errorimg" src="<?= $list['cover']?>" />
            </a>
            <div class="Livemaches-title">
                <div class="Livemaches-name">
                    WWW RAW1484期
                </div>
            </div>
            <div class="Livemaches-yuyue" style="display:none;">
                预约
            </div>
        </li>
        <li class="Livemaches-Movie-list J_Livemaches-Movie-list">
            <a class="Livemaches-Movie" href="https://www.baidu.com">
                <img class="Livemaches-img i_background_errorimg" src="<?= $list['cover']?>" />
            </a>
            <div class="Livemaches-title">
                <div class="Livemaches-name">
                    WWW RAW1484期
                </div>
            </div>
            <div class="Livemaches-yuyue" style="display:none;">
                预约
            </div>
        </li>
        <li class="Livemaches-Movie-list J_Livemaches-Movie-list">
            <a class="Livemaches-Movie" href="https://www.baidu.com">
                <img class="Livemaches-img i_background_errorimg" src="<?= $list['cover']?>" />
            </a>
            <div class="Livemaches-title">
                <div class="Livemaches-name">
                    WWW RAW1484期
                </div>
            </div>
            <div class="Livemaches-yuyue" style="display:none;">
                预约
            </div>
        </li>
        <li class="Livemaches-Movie-list J_Livemaches-Movie-list">
            <a class="Livemaches-Movie" href="https://www.baidu.com">
                <img class="Livemaches-img i_background_errorimg" src="<?= $list['cover']?>" />
            </a>
            <div class="Livemaches-title">
                <div class="Livemaches-name">
                    WWW RAW1484期
                </div>
            </div>
            <div class="Livemaches-yuyue" style="display:none;">
                预约
            </div>
        </li>
        <li class="Livemaches-Movie-list J_Livemaches-Movie-list">
            <a class="Livemaches-Movie" href="https://www.baidu.com">
                <img class="Livemaches-img i_background_errorimg" src="<?= $list['cover']?>" />
            </a>
            <div class="Livemaches-title">
                <div class="Livemaches-name">
                    WWW RAW1484期
                </div>
            </div>
            <div class="Livemaches-yuyue" style="display:none;">
                预约
            </div>
        </li>
    </ul>
<?php endif; ?>
<!-- 弹窗 -->
<?php //if (!empty($data['flash']) && $tick) : ?>
    <div id="jBox1" class="jBox-wrapper jBox-Modal jBox-Default jBox-closeButton-box"
         style="position: fixed; display: none; opacity: 1; z-index: 10000; left:25%; right: 25%">
        <div class="jBox-container">

            <div class="jBox-content" style="width: auto; height: auto;">
                <div style="width:auto;font-size:15px;text-align:center"></div>
                <div id="popup-ads" style="display: block;" data-jbox-content-appended="1">
                    <a href="" target="_blank">
                        <img src="" style="border: 0px;width:100%;">
                    </a>
                </div>
            </div>
            <div class="jBox-closeButton jBox-noDrag">
                <svg viewBox="0 0 24 24">
                    <path d="M22.2,4c0,0,0.5,0.6,0,1.1l-6.8,6.8l6.9,6.9c0.5,0.5,0,1.1,0,1.1L20,22.3c0,0-0.6,0.5-1.1,0L12,15.4l-6.9,6.9c-0.5,0.5-1.1,0-1.1,0L1.7,20c0,0-0.5-0.6,0-1.1L8.6,12L1.7,5.1C1.2,4.6,1.7,4,1.7,4L4,1.7c0,0,0.6-0.5,1.1,0L12,8.5l6.8-6.8c0.5-0.5,1.1,0,1.1,0L22.2,4z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div id="jBox1-overlay" class="jBox-overlay jBox-overlay-Modal" style="display: none; opacity: 1; z-index: 9999;"></div>
<?php //endif; ?>
<script>
    //标签悬浮“图片变动”
    $('.sort_content').hover(function(){
        $(this).find('.J_sort_img_c').show();
        $(this).find('.J_sort_img').hide();
    },function(){
        $(this).find('.J_sort_img_c').hide();
        $(this).find('.J_sort_img').show();
    });
    //“赛事直播”显示隐藏“预约”按钮
    $('.J_Livemaches-Movie-list').hover(function(){
        $(this).find('.Livemaches-yuyue').show();
    },function(){
        $(this).find('.Livemaches-yuyue').hide();
    });
    //获取今日预告总条数
    <?php
    $trailercount = 0;
    if($data['trailer']['trailer']){
        $trailercount = count($data['trailer']['trailer']);
    }?>
    var trailer_length = <?=$trailercount?>;

    //按城市加载广告
    $(function () {
        advertByCity('home');

        $('#det-nav>ul>.list-item>a.list-link').click(function () {
            var target = $(this).attr('data-id');
            console.log(target);
            $('html, body').animate({
                scrollTop: $(target).offset().top - 62
            }, 500);
            return false;
        });
    });
</script>
