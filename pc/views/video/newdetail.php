<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;
use common\models\advert\AdvertPosition;

// $this->metaTags['keywords'] = '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片';
// $this->title = '瓜子TV-澳新华人在线视频分享网站';

//$this->registerMetaTag(['name' => 'keywords', 'content' => '吉祥tv,澳洲吉祥tv,新西兰吉祥tv,澳新吉祥tv,吉祥视频,吉祥影视,电影,电视剧,榜单,综艺,动画,记录片']);
//$this->title = $data['info']['video_name'].'-吉祥TV - 澳新华人在线视频分享平台,海量高清视频在线观看';
NewIndexStyleAsset::register($this);

?>

<?php
$channelName = '';
if(isset($channel_id))
{
    foreach ($channels['list'] as $s_k => $s_v) {
        if($s_v['channel_id'] == $channel_id) {
            $channelName = $s_v['channel_name'];
        }
    }
}
else
{
    $channelName = '热搜';
}
?>

<script src="/js/jquery.js"></script>
<script src="/js/VideoSearch.js"></script>
<script src="/js/video/MyPage.js" type="text/javascript" charset="utf-8"></script>
<style>
    /*body,html{*/
    /*    overflow-y: scroll !important;*/
    /*}*/
    /*片源报错alert*/
    .hlp-bd input {
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        outline: none;
    }

    .hlp-bd ul {
        list-style: none;
    }

    .hlp-bd input {
        cursor: pointer;
        -webkit-appearance: none;
        font-family: "微软雅黑";
        appearance: none;
        border: none;
        border-radius: 0;
        background-color: rgba(0, 0, 0, 0);
        -webkit-border-radius: 0;
        -webkit-border: none;
        outline: none;
    }

    .hlp-bd textarea {
        outline: none;
        resize: none;
        font-family: "微软雅黑";
        appearance: none;
        border: none;
        border-radius: 0;
        -webkit-border-radius: 0;
        -webkit-border: none;
        -webkit-appearance: none;
        text-align: center;
    }

    .hlp-bd input::placeholder,
    .hlp-bd textarea::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .hlp-bd select {
        width: 100%;
        font-size: 16px;
        border: none;
        outline: none;
        -moz-appearance: none;
        -webkit-appearance: none;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        background-image: url(../images/newindex/icon-down.png);
        background-repeat: no-repeat;
        background-size: 10px 10px;
        background-position: right center;
    }
    .hlp-bd {
        position: fixed;
        left: 50%;
        margin-left:-400px;
        top: 50%;
        margin-top:-250px;
        width: 800px;
        height:504px;
        padding: 20px;
        box-sizing: border-box;
        background-color: #FFFFFF;
    }

    .hlp-t03 {
        font-size: 18px;
        margin-top: 20px;
        margin-bottom: 40px;
    }

    .hlp-t03>span {
        margin-left: 10px;
        font-size: 14px;
    }

    .hlp-bd-box {
        display: grid;
        grid-template-columns: 200px auto;
        grid-gap: 20px;
        overflow: hidden;
    }

    .hlp-bd-box>li {
        overflow: hidden;
    }

    .hlp-bd-box>li>div {
        font-size: 16px;
        height: 40px;
        line-height: 40px;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .hlp-bd-box>li:first-of-type>div>span {
        margin-right: 10px;
    }

    .hlp-bd-box>li:last-of-type>div {
        box-sizing: border-box;
        border: solid 1px hsla(0, 0%, 40%, .2);
    }

    .hlp-bd-box>li:last-of-type>div:last-of-type {
        height: 80px;
    }

    .hlp-bd-box>li:last-of-type>p {
        font-size: 14px;
        color: #999999;
        margin-bottom: 20px;
    }

    .hlp-bd-box>li:last-of-type>input.seek-btn {
        float: left;
    }
    .hlp-bd .seek-slk {
        box-sizing: border-box;
        padding: 0px 10px;
        height: 40px;
        background-color: #F4F4F4;
        background-position-x: 95%;
    }

    .hlp-bd .seek-slk.ZT-black {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .seekbox-tta>textarea {
        width: 100%;
        height: 80px;
        line-height: 20px;
        text-align: left;
        padding: 10px;
        box-sizing: border-box;
        background-color: #F4F4F4;
    }

    .seekbox-tta>textarea::placeholder {
        color: #999999;
    }
    .hlp-bd .seek-btn {
        padding: 0px 20px;
        height: 40px;
        font-size: 16px;
        color: #FFFFFF;
        background-color: #FF5722;
    }
    .clrOrangered {
        color: #FF5722;
    }

    #alt04 .btn-close {
        position: absolute;
        top: 0px;
        right: 0px;

        font-size: 30px;
        color: rgba(0, 0, 0, 0);
        background-image: url(../images/newindex/guanbi.png);
        background-position: center;
        background-repeat: no-repeat;
        background-size: 24px;
        width: 50px;
        height: 50px;
    }

    /*评论留言回复*/
    .ul-box{
        margin-top:10px;
    }
    .ul-box>li:last-of-type{
        margin-top:10px;
        border:0px;
        text-align:left;
    }
    .per-btn-reply {
        height: 24px;
        line-height: 24px;
        width: 70px;
        font-size: 16px;
        color: #999999;
        padding-left: 29px;
    }
    .per-btn-reply:hover {
        color: #FF556E;
    }
    .div-replyname{
        color:#FF556E;
        cursor: pointer;
        margin-left: 60px;
        line-height: 30px;
    }
    .more-comment{
        background-color:#f3f3f3;
        color:#888;
        height:40px;
        line-height:40px;
        text-align:center;
        margin-top: 20px;
        margin-left: 60px;
        margin-bottom:20px;
        font-size:14px;
        cursor: pointer;
    }
    .div-commenttab{
        height:40px;
        line-height: 40px;
    }
    .per-tab-comment {
        float: left;
        margin-right: 20px;
        background-color: #FFFFFF;
        height: 40px;
        line-height: 40px;
        overflow: hidden;
    }

    .per-tab-comment>li {
        float: left;
        width: 150px;
        font-size: 16px;
        text-align: center;
        color: #999999;
        cursor: default;
    }

    .per-tab-comment>li:hover {
        background-color: #FF556E;
        color: #FFFFFF;
    }

    .per-tab-comment>li.act {
        background-color: #FF556E;
        color: #FFF4D6;
    }
    .per-tab-comment.ZT-black,.more-comment.ZT-black{
        background-color: rgba(255, 255, 255, 0.05);
    }

    .rBtn-08 {
        margin-bottom: -9px;
        padding: 0px 5px;
        border-radius: 4px;
        overflow: hidden;
        background-image: linear-gradient( 150deg, #FF5722 60%, #FF972A);
    }

    .rBtn-08>a {
        height: 24px;
        line-height: 24px;
        padding-left: 20px;
        color: #FFFFFF;
        font-size: 14px;
        background-image: url(../images/newindex/navlf-qpW.png);
        background-position: left center;
        background-repeat: no-repeat;
        background-size: 16px 16px;
    }
    /*顶部导航特殊处理*/
    /*1910px至更大*/
    .navTop {
        padding: 0;
        width: 1600px;
        margin: 0 auto;
    }
    .navTopLogo {
        left:0;
    }
    .navTopMenuBox {
        left: 230px;
    }
    .navTopSearchBox-r {
        left: 773px;
    }
    .navTopBtnBox{
        right: 0;
    }
    /*1525-1910px*/
    @media screen and (max-width:1910px) {
        .navTop {
            padding: 0;
            width: 1445px;
            margin: 0 auto;
        }
        .navTopLogo {
            left:0;
        }
        .navTopMenuBox {
            left: 230px;
        }
        .navTopSearchBox-r {
            left: 693px;
        }
        .navTopBtnBox{
            right: 0;
        }
    }
    /*1207-1525px*/
    @media screen and (max-width:1525px) {
        .navTop {
            padding: 0;
            width: 1207px;
            margin: 0 auto;
        }
        .navTopLogo {
            left:0;
        }
        .navTopMenuBox {
            left: 230px;
        }
        .navTopSearchBox-r {
            left: 693px;
        }
        .navTopBtnBox{
            right: 0;
        }
    }
    @media screen and (max-width: 1400px){
        .navTopSearchBox-r {
            left: 550px;
        }
    }
    /*更小默认样式*/
    @media screen and (max-width:1336px){
        .navTop {
            padding: 0 40px;
            width: auto;
        }
        .navTopLogo {
            left:160px;
        }
        .navTopMenuBox {
            left: 400px;
        }
        .navTopSearchBox-r {
            left: 550px;
        }
        .navTopBtnBox{
            right: 160px;
        }
    }
    .pop-tip {
        left:40%;
    }
    .per-now-box{
        border-bottom: solid 1px #F5F5F6;
    }
</style>
<!--黑色区域-->
<div class="box05">
    <!--播放器上面加广告-->
    <div id="videotop"></div>
<!--    --><?php //if(!empty($data['advert'])) :?>
<!--        --><?php //foreach ($data['advert'] as $key => $advert) : ?>
<!--            --><?php //if(!empty($advert) && $advert['position_id'] == AdvertPosition::POSITION_VIDEO_TOP_PC) :?>
<!--                <div class="play-box video-add-column video-detail-ad">-->
<!--                    <a href="--><?//=$advert['ad_skip_url']?><!--" target="_blank">-->
<!--                        <img src="--><?//=$advert['ad_image']?><!--" />-->
<!--                    </a>-->
<!--                </div>-->
<!--            --><?php //endif;?>
<!--        --><?php //endforeach;?>
<!--    --><?php //endif;?>
    <div>
        <div class="play-video-container">
            <div class="play-video-left-container">
                <link rel="stylesheet" href="/MyPlayer/css/base.css">
                <link rel="stylesheet" href="/MyPlayer/css/DPlayer.min.css?v=3">
                <script src="/MyPlayer/js/DPlayer.min-1.7.js?v=7" type="text/javascript" charset="utf-8"></script>
                <script src="/MyPlayer/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
                <script src="/MyPlayer/js/hls.min.js?v=2" type="text/javascript" charset="utf-8"></script>
                <!--播放器位置-->
                <div class="play" id="jianghu2">
                    <?php foreach ($data['advert'] as $key => $advert) : ?>
                        <?php if(!empty($advert) && $advert['position_id'] == AdvertPosition::POSITION_PLAY_BEFORE_PC) :?>
                            <?php if(strpos($advert['ad_image'], '.mp4') !== false) {
                                $ad_type = 'mp4';
                                $ad_url = $advert['ad_image'];
                                $ad_link = $advert['ad_skip_url'];
                            }else{
                                $ad_type = 'img';
                                $ad_url = $advert['ad_image'];
                                $ad_link = $advert['ad_skip_url'];
                            }?>
                        <?php endif;?>
                    <?php endforeach;?>
                    <?php echo $this->render('/MyPlayer/jianghu',[
                        'url'   =>      explode('v=',$data['info']['resource_url'])[1],
                        'ad_url' =>    $ad_url,
                        'ad_link'  =>   $ad_link,
                        'ad_type'  =>   $ad_type,
                        'videos'    =>  $data['info']['videos'],
                        'play_chapter_id'   => $data['info']['play_chapter_id'],
                        'source_id'         => $data['info']['source_id'],
                        'source'            => $data['info']['source'],
                        'last_chapter'      => $data['info']['last_chapter'],
                        'next_chapter'      => $data['info']['next_chapter'],
                        'last_play_time'    => $data['info']['last_play_time'],
                        'source_count'      => count($data['info']['filter'])
                    ]);?>
                </div>
                <!--评论，点赞，差评等按钮-->
                <div class="player-mnb">
                    <div class="player-mnb-left">
                        <div class="qy-flash-func qy-flash-func-v1">
                            <div class="func-item func-comment">
                                <div class="func-inner">
                                    <span class="func-name qy-comment J_comment"  ><?=$data['commentcount']?></span>
                                </div>
                            </div>
                            <div class="func-item func-like-v1">
                                <div class="func-inner">
                                    <span class="func-name qy-dianzan"><?= $data['info']['total_views']?></span>
                                </div>
                            </div>
                            <div class="func-item func-collect">
                                <div class="func-inner">
                                    <span class="func-name qy-shoucang <?=$data['info']['fav_status']==1? 'act' : ''?>" id="id_favors"><?= $data['info']['total_favors']?></span>
                                </div>
                            </div>
                            <!--                                    <div class="func-item func-like-v1">-->
                            <!--                                        <div class="func-inner">-->
                            <!--                                            <span class="like-icon-box">-->
                            <!--                                                <i title="" class="qy-svgicon qy-svgicon-report"></i>-->
                            <!--                                            </span>-->
                            <!--                                            <span class="func-name" id='err_feedback'>片源报错</span>-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                        </div>
                    </div>
                    <div class="player-mnb-mid">
                        <div class="func-item func-like-v1">
                            <div class="func-inner">
                                <span class="func-name qy-shouji">手机看</span>
                            </div>
                        </div>
                        <div class="func-item func-like-v1">
                            <div class="func-inner">
                                <a href="<?= Url::to(['/video/seek'])?>" target="_blank"><span class="func-name qy-qiupian">求片</span></a>
                            </div>
                        </div>
                        <!--<?= json_encode($data['info']['test'], JSON_UNESCAPED_UNICODE) ?>-->
                    </div>
                    <!--<div class="player-mnb-right">
                                <div class="qy-flash-func qy-flash-func-v1">
                                    <div class="func-item <?/*= $data['info']['last_chapter'] == 0 ? 'pointer-none': ''*/?>">
                                        <div title="上一集" class="func-inner func-swicthCap"
                                             data-video-id="<?/*= $data['info']['video_id']*/?>"
                                             data-chapter-id="<?/*= $data['info']['last_chapter']*/?>"
                                             data-source-id="<?/*= $source_id*/?>">
                                            <span class="qy-svgicon qy-svgicon-leftarrow_cu"></span>
                                            <span class="func-name">上一集</span>
                                        </div>
                                    </div>
                                    <div class="func-item <?/*= $data['info']['next_chapter'] == 0 ? 'pointer-none': ''*/?>">
                                        <div title="下一集" class="func-inner func-swicthCap"
                                             data-video-id="<?/*= $data['info']['video_id']*/?>"
                                             data-chapter-id="<?/*= $data['info']['next_chapter']*/?>"
                                             data-source-id="<?/*= $source_id*/?>">
                                            <span class="func-name">下一集</span>
                                            <span class="qy-svgicon qy-svgicon-rightarrow_cu"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                </div>
            </div>
            <div class="player-sd">
                <div class="player-sdc">
                    <div class="qy-player-side-loading" style="display: none;">
                        <img src="/images/NewVideo/con-loading-black.gif" alt="正在加载" class="loading-img">
                        <p class="loading-txt">正在加载…</p>
                    </div>
                    <div class="qy-player-side qy-episode-side">
                        <div class="qy-player-side-head">
                            <div class="head-title">
                                <h2 class="header-txt">
                                    <a href="" class="header-link">
                                        <?= $data['info']['video_name']?>
                                    </a>
                                    <span class="update-tip-1">
                                        <?=$data['info']['flag']?>
                                    </span>
                                </h2>
                            </div>
                        </div>
                        <div class="qy-player-side-body v_scroll_plist_bc qy-advunder-show">
                            <div class="body-inner">
                                <?php if($data['channel_id'] == '2'){?>
                                    <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
                                        <div class="padding-box">
                                            <div class="qy-episode-tab">
                                                <ul class="tab-bar TAB_CLICK sourceTab" id=".srctabShow">
                                                    <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                        <li class="bar-li <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'hover' : ''?>" id='srcTab-<?=$source['resId']?>'>
                                                            <a href="javascript:void(0);"
                                                               class="bar-link"
                                                               data-source-id="<?= $source['resId']?>">
                                                                <?= $source['resName']."(".count($source['data'])."集)" ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach;?>
                                                </ul>
                                            </div>
                                            <div class="c"></div>
                                            <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                <div class="srctabShow <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'dn' : 'nn'?>" id='srctab-<?=$source['resId']?>'>
                                                    <?php
                                                    $page = ceil(count($source['data'])/30);
                                                    $count = count($source['data']);
                                                    $ontab = 1;
                                                    foreach ($source['data'] as $index => $value){
                                                        if ($data['info']['play_chapter_id'] != $value['chapter_id'])
                                                            continue;

                                                        $ontab = ceil(($index+1) / 30);
                                                        break;
                                                    }
                                                    ?>
                                                    <div class="qy-episode-tab">
                                                        <ul class="tab-bar TAB_CLICK" id=".tabShow<?=$key?>">
                                                            <?php for($k=0; $k<$page; $k++){?>
                                                                <li class="bar-li <?= $k+1 == $ontab? 'hover': ''?>">
                                                                    <a href="javascript:void(0);" class="bar-link">
                                                                        <?= $k*30 + 1?>-<?= ($k == ($page -1))? $count:$k*30 + 30?></a>
                                                                </li>
                                                            <?php }?>
                                                        </ul>
                                                    </div>
                                                    <div class="c"></div>
                                                    <?php for($i=0; $i<$page; $i++){?>
                                                        <ul class="qy-episode-num tabShow<?=$key?> <?= (($i+1) == $ontab)? 'dn': 'nn'?>">
                                                            <?php foreach ($source['data'] as $index => $value) : ?>
                                                                <?php if($index>=$i*30 && $index < ($i*30+30)){?>
                                                                    <li class="select-item switch-next-li switch-next J_switch_next <?= $data['info']['play_chapter_id'] == $value['chapter_id']
                                                                    && ((empty($source_id) && $key == 0) || ($source['resId'] == $source_id))? 'selected' : ''?>"
                                                                        data-video-id="<?= $value['video_id']?>"
                                                                        data-chapter-id="<?= $value['chapter_id']?>"
                                                                        data-type="<?= $data['info']['catalog_style']?>"
                                                                        data-source-id="<?=$source['resId']?>"
                                                                        id='chap-<?=$source['resId']?>-<?=$value['chapter_id']?>'>
                                                                        <div class="select-link">
                                                                            <?= $value['title']?>
                                                                        </div>
                                                                    </li>
                                                                <?php }?>
                                                            <?php endforeach;?>
                                                        </ul>
                                                    <?php }?>
                                                </div>
                                            <?php endforeach;?>
                                            <div class="c"></div>
                                        </div>
                                    </div>
                                <?php } elseif($data['channel_id'] == '1'){?>
                                    <div class="qy-episode-tab">
                                        <ul class="tab-bar TAB_CLICK sourceTab" id=".tabShow">
                                            <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                <li class="bar-li <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'hover' : ''?>" id='srcTab-<?=$source['resId']?>'>
                                                    <a href="javascript:void(0);"
                                                       class="bar-link"
                                                       data-source-id="<?= $source['resId']?>">
                                                        <?= $source['resName'] ?>
                                                    </a>
                                                </li>
                                            <?php endforeach;?>
                                        </ul>
                                    </div>
                                    <div class="h20"></div>
                                    <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
                                        <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                            <ul class="qy-play-list tabShow
                                                    <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'dn' : 'nn'?>"
                                                 id='srctab-<?=$source['resId']?>'>
                                                <?php foreach ($source['data'] as $value) : ?>
                                                    <li class="play-list-item switch-next-li switch-next J_switch_next <?= $data['info']['play_chapter_id'] == $value['chapter_id']
                                                    && ((empty($source_id) && $key == 0) || ($source['resId'] == $source_id))? 'selected' : ''?>"
                                                        data-video-id="<?= $value['video_id']?>"
                                                        data-chapter-id="<?= $value['chapter_id']?>"
                                                        data-type="<?= $data['info']['catalog_style']?>"
                                                        id='chap-<?=$source['resId']?>-<?=$value['chapter_id']?>'>
                                                        <div class="mod-left">
                                                            <div class="mod-img-link">
                                                                <img originalSrc="<?= $value['cover']?>" class="mod-img" src="/images/newindex/default-cover.png">
                                                                <i class="img-border"></i>
                                                            </div>
                                                        </div>
                                                        <div class="mod-right">
                                                            <h3 class="main-title">
                                                                <span class="title-link"><?= $value['title']?></span>
                                                            </h3>
                                                            <div class="sub-title" style="">
                                                                <i class="qy-svgicon qy-svgicon-hot"></i>
                                                                <span class="count"><?= $data['info']['total_views']?></span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endforeach;?>
                                            </ul>
                                        <?php endforeach;?>
                                    </div>
                                <?php } elseif($data['channel_id'] == '3'){?>
                                    <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
                                        <div class="qy-episode-tab">
                                            <ul class="tab-bar TAB_CLICK sourceTab" id=".tabShow">
                                                <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                    <li class="bar-li <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'hover' : ''?>" id='srcTab-<?=$source['resId']?>'>
                                                        <a href="javascript:void(0);"
                                                           class="bar-link"
                                                           data-source-id="<?= $source['resId']?>">
                                                            <?= $source['resName']."(".count($source['data'])."集)"  ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                        <div class="h20"></div>
                                        <div class="qy-player-side-body v_scroll_plist_bc" style="height: 100%;">
                                            <div class="body-inner">
                                                <div class="side-content v_scroll_plist_content">
                                                    <div class="">
                                                        <div class="qy-player-side-list qy-advunder-show">
                                                            <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                                <ul class="qy-play-list tabShow
                                                                        <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'dn' : 'nn'?>"
                                                                     id='srctab-<?=$source['resId']?>'>
                                                                    <?php foreach ($source['data'] as $value) : ?>
<!--                                                                        <a href="--><?//= Url::to(['video/detail', 'video_id'=>$value['video_id'], 'chapter_id'=>$value['chapter_id']])?><!--">-->
                                                                            <li class="play-list-item-new J_switch_next <?= $data['info']['play_chapter_id'] == $value['chapter_id']
                                                                            && ((empty($source_id) && $key == 0) || ($source['resId'] == $source_id))? 'selected' : ''?>"
                                                                                data-video-id="<?= $value['video_id']?>"
                                                                                data-chapter-id="<?= $value['chapter_id']?>"
                                                                                id="chap-<?=$source['resId']?>-<?=$value['chapter_id']?>"><?= $value['title']?></li>
<!--                                                                        </a>-->
                                                                    <?php endforeach;?>
                                                                </ul>
                                                            <?php endforeach;?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } elseif($data['channel_id'] >= '4'){?>
                                    <div class="side-content v_scroll_plist_content" style="transform: translateY(0px);">
<!--                                        <div class="qy-episode-update">-->
<!--                                            <p class="update-tip">-->
<!--                                                更新至第--><?//= count($data['info']['videos'])?><!--集-->
<!--                                            </p>-->
<!--                                        </div>-->
                                        <div class="qy-episode-tab">
                                            <ul class="tab-bar TAB_CLICK sourceTab" id=".tabShow">
                                                <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                                    <li class="bar-li <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'hover' : ''?>" id='srcTab-<?=$source['resId']?>'>
                                                        <a href="javascript:void(0);"
                                                           class="bar-link"
                                                           data-source-id="<?= $source['resId']?>">
                                                            <?= $source['resName']."(".count($source['data'])."集)"  ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                        <div class="c"></div>
                                        <?php foreach ($data['info']['filter'] as $key => $source): ?>
                                            <ul class="qy-episode-txt tabShow
                                                    <?= (empty($source_id) && $key == 0) || ($source['resId'] == $source_id) ? 'dn' : 'nn'?>"
                                                 id='srctab-<?=$source['resId']?>'>
                                                <?php foreach ($source['data'] as $key1 =>$value) : ?>
                                                    <li class="select-item switch-next-li switch-next J_switch_next <?= $data['info']['play_chapter_id'] == $value['chapter_id']
                                                    && ((empty($source_id) && $key == 0) || ($source['resId'] == $source_id))? 'selected' : ''?>"
                                                        data-video-id="<?= $value['video_id']?>"
                                                        data-chapter-id="<?= $value['chapter_id']?>"
                                                        data-type="<?= $data['info']['catalog_style']?>"
                                                        id='chap-<?=$source['resId']?>-<?=$value['chapter_id']?>'>
                                                        <div class="select-inline">
                                                            <div class="select-title">
                                                                <span class="select-pre"><?= $key1+1?></span>
                                                                <div href="" class="select-link"><?= $value['title']?></div>
                                                            </div>
                                                        </div>
                                                        <i class="playon-icon"></i>
                                                    </li>
                                                <?php endforeach;?>
                                            </ul>
                                        <?php endforeach;?>
                                    </div>
                                <?php } ?>
                                <?php foreach ($data['advert'] as $key => $advert): ?>
                                    <?php $adtab = false;
                                    if(!empty($advert) && intval($advert['position_id']) == intval(AdvertPosition::POSITION_VIDEO_RIGHT_PC)){
                                        $adtab = true;
                                        break;
                                    }?>
                                <?php endforeach;?>
                                <div id="videoright"></div>
<!--                                --><?php //if($adtab) :?>
<!--                                    <div class="video-right-ad-img J_video_right_ad_img">-->
<!--                                        <img "--><?//=$advert['ad_image']?><!--" onerror="this.src='/images/NewVideo/GG03_2.png'">-->
<!--                                    </div>-->
<!--                                --><?php //endif;?>
                            </div>
                            <div class="side-scrollbar">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="Altsjk">
            <div class="Altsjk-01">
                扫一扫，手机观看更便捷
                <input class="GB" type="button" name="" id="" value="" />
            </div>
            <div class="Altsjk-02">
                <img src="/images/newindex/ryewm_wap.png" />
                <div class="Altsjk-02-a">
                    <!--                    --><?//= Url::to(['/site/share-down'])?>
                    <a href="<?= Url::to(['/video/help', 'tab' => 'appdownload'])?>"><img src="/images/NewVideo/ipad.png" />iPhone客户端</a>
                    <a href="<?= Url::to(['/video/help', 'tab' => 'appdownload'])?>"><img src="/images/NewVideo/ipad.png" />电视TV版</a>
                    <a href="<?= Url::to(['/video/help', 'tab' => 'appdownload'])?>"><img src="/images/NewVideo/anzhuo.png" />安卓客户端</a>
                </div>
            </div>
            <div class="Altsjk-03">
                没有<?=LOGONAME?>视频APP？ <a href="javascript:void(0);" onclick="showwarning();">立即下载</a>
                <!--                <a href="--><?//= Url::to(['/site/share-down'])?><!--" target="_blank">立即下载</a>-->
            </div>
        </div>
    </div>
    <div id="videobottom"></div>
<!--    --><?php //if(!empty($data['advert'])) :?>
<!--        --><?php //foreach ($data['advert'] as $key => $advert) : ?>
<!--            --><?php //if(!empty($advert) && $advert['position_id'] == AdvertPosition::POSITION_VIDEO_BOTTOM_PC) :?>
<!--                <div class="play-box video-add-column video-detail-ad">-->
<!--                    <a href="--><?//=$advert['ad_skip_url']?><!--" target="_blank" class="video-bottom-add">-->
<!--                        <img src="--><?//=$advert['ad_image']?><!--">-->
<!--                    </a>-->
<!--                </div>-->
<!--            --><?php //endif;?>
<!--        --><?php //endforeach;?>
<!--    --><?php //endif;?>
    <div class="advert_2 J_xini_advert" style="display: none;" >
        <div class="advert_content">
            <div class="advert_content_title J_advertyy_title" id="J_qualityService_title">优质服务</div>
            <div class="advert_content_ad">
                <ul id="J_qualityService" class="J_advertyy">
                    <li><a href="javascript:;">冰箱急售</a></li>
                    <li><a href="javascript:;">翡翠耳钉</a></li>
                    <li><a href="javascript:;">两张音乐剧门票</a></li>
                    <li><a href="javascript:;">售99新51寸Samsung智能新机</a></li>
                    <li><a href="javascript:;">最新款iPhone13pro</a></li>
                    <li><a href="javascript:;">2021最新款苹果智能蓝牙</a></li>
                    <li><a href="javascript:;">苹果台式机9折起</a></li>
                </ul>
            </div>
        </div>
        <div class="advert_content">
            <div class="advert_content_title J_advertyy_title" id="J_recruitment_title">求职招聘</div>
            <div class="advert_content_ad">
                <ul id="J_recruitment" class="J_advertyy">
                    <li><a href="javascript:;">冰箱急售</a></li>
                    <li><a href="javascript:;">翡翠耳钉</a></li>
                    <li><a href="javascript:;">两张音乐剧门票</a></li>
                    <li><a href="javascript:;">售99新51寸Samsung智能新机</a></li>
                    <li><a href="javascript:;">最新款iPhone13pro</a></li>
                    <li><a href="javascript:;">2021最新款苹果智能蓝牙</a></li>
                    <li><a href="javascript:;">苹果台式机9折起</a></li>
                </ul>
            </div>
        </div>
        <div class="advert_content">
            <div class="advert_content_title J_advertyy_title" id="J_houseRent_title">房屋租赁</div>
            <div class="advert_content_ad">
                <ul id="J_houseRent" class="J_advertyy">
                    <li><a href="javascript:;">冰箱急售</a></li>
                    <li><a href="javascript:;">翡翠耳钉</a></li>
                    <li><a href="javascript:;">两张音乐剧门票</a></li>
                    <li><a href="javascript:;">售99新51寸Samsung智能新机</a></li>
                    <li><a href="javascript:;">最新款iPhone13pro</a></li>
                    <li><a href="javascript:;">2021最新款苹果智能蓝牙</a></li>
                    <li><a href="javascript:;">苹果台式机9折起</a></li>
                </ul>
            </div>
        </div>
        <div class="advert_content last">
            <div class="advert_content_title last">
                <span id="J_secondaryMarket_title" class="J_advertyy_title">二手市场</span>
                <img src="/images/Index/chahao.png" class="J_del_advert">
            </div>
            <div class="advert_content_ad last">
                <ul id="J_secondaryMarket" class="J_advertyy">
                    <li><a href="javascript:;">冰箱急售</a></li>
                    <li><a href="javascript:;">翡翠耳钉</a></li>
                    <li><a href="javascript:;">两张音乐剧门票</a></li>
                    <li><a href="javascript:;">售99新51寸Samsung智能新机</a></li>
                    <li><a href="javascript:;">最新款iPhone13pro</a></li>
                    <li><a href="javascript:;">2021最新款苹果智能蓝牙</a></li>
                    <li><a href="javascript:;">苹果台式机9折起</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--   详情 -->
    <div class="GNbox">
        <h1 class="player-title">
            <em class="title-txt"><?= $data['info']['video_name']?></em>
<!--            <span class="sub-title">第1集</span>-->
            <span class="sub-title"></span>
        </h1>
    </div>
    <div class="GNbox">
        <div class="GNbox-xq" name="zt">
            <span>简介</span>
        </div>
        <div class="GNbox-RD video-detail-GNbox-RD" name="zt">
            <?= $data['info']['total_views']?>
        </div>
        <div class="GNbox-type video-detail-GNbox-type" name="zt">
            <?php foreach (explode(' ',$data['info']['category']) as $cate) : ?>
                <span><?= $cate?></span>
            <?php endforeach;?>
            <span><?= $data['info']['year']?></span>
            <span><?= $data['info']['area']?></span>
        </div>
    </div>
    <!--详情展开-->
    <div class="GNbox-xq-K">
        <div>
            <div class="GNbox-xq-img">
                <img originalSrc="<?= $data['info']['cover']?>" src="/images/newindex/default-cover.png" onerror="this.src='/images/newindex/default-cover.png'"/>
            </div>
            <div class="GNbox-xq-text" name="zt">
                <div>
                    导演：<span>
                                <?= $data['info']['director'] ?>
                            </span>
                </div>
                <div>
                    主演：<span>
                                <?= implode('/', array_column($data['info']['actors'], 'actor_name')) ?>
                            </span>
                </div>
                <div>
                    简介：<span><?= $data['info']['intro']?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!--白色区域-->
<div class="box06" id="comment_box">
    <div>
        <!--左侧-->
        <div class="box06-L">
            <div class="GNbox-PL" id="GNbox-PL" name="zt">
                评论区<span>(<?=$data['commentcount']?>)</span>
            </div>
            <!--评论输入区-->
            <div class="GNbox-content">
                <img src="/images/Index/default_header.png">
                <div class="GNbox-PLsr" name="zt">
                    <!--                        <div>-->
                    <!--                            来说两句吧！-->
                    <!--                        </div>-->
                    <textarea placeholder="来说两句吧！注意，以下行为将被封号：严重剧透、发布广告、木马链接、宣传同类网站、辱骂工作人员等。"></textarea>
                    <div class="GNbox-PL-box">
                        <!--                    <input class="GNbox-Btnbq" type="button" name="" id="" value="" />-->
                        <!--                    <input class="GNbox-Btntp" type="button" name="" id="" value="发起投票" />-->
                        <input class="GNbox-Btnfs" type="button" name="" id="send_comment" value="发布" />
                    </div>
                </div>
            </div>
            <!--评论留言位置-->
            <?php if(!$data['comments']['list']){
                $comment_style = "display:none";
            }else{
                $comment_style = "";
            }?>
            <div class="GNbox-PL-text" id="comment-part" style="<?=$comment_style?>">
                <?php if($data['comments']['list']):?>
                    <?php foreach ($data['comments']['list'] as $comment):?>
                        <div class="div-commentlist">
                            <ul class="per-now-box ul-box" name="zt">
                                <li class="per-now-h">
                                    <div class="navTopLogonImg">
                                        <!--                                            <a href="--><?//=Url::to(['/video/other-home','uid'=>$comment['uid']])?><!--">-->
                                        <?php if($comment['avatar']):?>
                                            <img src="<?=$comment['avatar']?>" />
                                        <?php else :?>
                                            <img src="/images/Index/user_c.png" />
                                        <?php endif;?>
                                        <!--                                            </a>-->
                                    </div>
                                </li>
                                <li >
                                    <div class="per-now-box-01">
                                        <div>
                                            <?=$comment['nickname']?>
                                        </div>
                                    </div>
                                    <div class="per-now-box-02" name="zt">
                                        <?=$comment['content']?>
                                    </div>
                                    <ul class="per-now-box-03" name="zt">
                                        <li><?=date("Y-m-d",$comment['created_at'])?></li>
                                        <li><input class="per-btn-z" type="button" name="" onclick="addlikes(<?=$comment['comment_id']?>,this);" value="" /><span><?=$comment['likes_num']?></span></li>
                                        <li><input class="per-btn-reply" type="button" name="" onclick="showreply(<?=$comment['comment_id']?>,this);" value="" /></li>
                                    </ul>
                                    <?php if($comment['reply_info']['list']):?>
                                        <div class="div-reply">
                                            <?foreach ($comment['reply_info']['list'] as $key=>$reply):?>
                                                <ul class="per-now-box ul-box <?php if($key+1==count($comment['reply_info']['list'])):?>per-now-box_last<?endif;?>" name="zt">
                                                    <li class="per-now-h">
                                                        <div class="navTopLogonImg">
                                                            <!--                                                                <a href="javascript"><img src="/images/newindex/logon.png" /></a>-->
                                                            <!--                                                                <a href="--><?//=Url::to(['/video/other-home','uid'=>$reply['uid']])?><!--">-->
                                                            <?php if($reply['avatar']):?>
                                                                <img src="<?=$reply['avatar']?>" />
                                                            <?php else :?>
                                                                <img src="/images/Index/user_c.png" />
                                                            <?php endif;?>
                                                            <!--                                                                </a>-->
                                                        </div>
                                                    </li>
                                                    <li >
                                                        <div class="per-now-box-01">
                                                            <div>
                                                                <?=$reply['nickname']?>
                                                            </div>
                                                        </div>
                                                        <div class="per-now-box-02" name="zt">
                                                            <?=$reply['content']?>
                                                        </div>
                                                        <ul class="per-now-box-03" name="zt">
                                                            <li><?=date("m-d",$reply['created_at'])?></li>
                                                            <li><input class="per-btn-z" type="button" name="" onclick="addlikes(<?=$reply['comment_id']?>,this);" value="" /><span><?=$reply['likes_num']?></span></li>
                                                            <li></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            <?php endforeach; ?>
                                            <div class="div-replyname" id="reply-more-<?=$comment['comment_id']?>" onclick="findmorereply(<?=$comment['comment_id']?>)"
                                                <?php if($comment['reply_info']['total_page']!=0 && $comment['reply_info']['current_page'] >= $comment['reply_info']['total_page']):?>
                                                    style="display: none;"
                                                <?php endif;?> >
                                                <input type="hidden" id="reply-current-<?=$comment['comment_id']?>" value="<?=$comment['reply_info']['current_page']?>" />
                                                <input type="hidden" id="reply-total-<?=$comment['comment_id']?>" value="<?=$comment['reply_info']['total_page']?>" />
                                                查看更多回复
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
                <?php $current_page = 0; $total_page = 0;
                if($data['comments']['total_page']){
                    $current_page = $data['comments']['current_page'];
                    $total_page = $data['comments']['total_page'];
                }?>
                <div class="more-comment" id="comment-more"
                    <?php if($total_page==0 || $current_page==$total_page):?>
                        style="display: none;"
                    <?php endif;?>  name="zt">
                    <input type="hidden" id="comment-current" value="<?=$current_page?>" />
                    <input type="hidden" id="comment-total" value="<?=$total_page?>" />
                    查看更多评论
                </div>
            </div>
        </div>

        <!--右侧-->
        <div class="box06-R">

            <div class="Title-04" name="zt">
                <a href="javascript:;"><?= $channelName ?>·排行榜</a>
            </div>
            <!--电影排行榜   小视频没有排行-->
            <div class="Movie-Ranking02" name="zt">
                <?php foreach ($hotword['tab'] as $key => $tab): ?>
                    <?php if($tab['title'] == $channelName) :?>
                        <?php foreach ($tab['list'] as $key => $list): ?>
                            <?php if($key<10):?>
                            <!--排名-->
                            <div class="Ranking-box">
                                <div class="Ranking-mun index-rank-<?=$key+1?>" style="position: relative;">
<!--                                    <img class="Movie-Ranking-img" src="/images/hotPlay/bangdan--><?//= $key+1?><!--.png">-->
                                    <div class="index-rank-NO detail-rank-NO">NO</div>
                                    <div class="index-rank-num detail-rank-num"><?= $key+1?></div>
                                </div>
                                <div class="Ranking-text">
                                    <div class="Ranking-name" name="zt">
                                        <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                                            <?= $list['video_name']?>
                                        </a>
                                    </div>
                                    <div class="Ranking-type" name="zt">
                                        <span><?= $list['year'] ?></span>
                                        <span><?= $list['area'] ?></span>
                                        <?php foreach (explode(' ',$list['category']) as $cate) : ?>
                                            <span><?= $cate?></span>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                                <div class="Ranking-score">
                                    <?= $list['score'] ?>
                                </div>
                            </div>
                            <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>
                <?php endforeach;?>
            </div>

            <div class="Title-04" name="zt">
                相关视频
            </div>
            <?php foreach ($data['guess_like'] as $key => $list) :?>
                <?php if($key < 8) :?>
                    <!--剧集-->
                    <div class="JJXG">
                        <div class="JJXG-L">
                            <a href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>">
                                <img originalSrc="<?= $list['cover']?>" src="/images/newindex/default-cover.png"/>
                            </a>
                        </div>
                        <div class="JJXG-R" name="zt">
                            <a href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>"><?= $list['video_name']?></a>
                            <div class="JJXG-R-tp" name="zt">
                                <?php foreach (explode(' ',$list['category']) as $cate) : ?>
                                    <span><?= $cate?></span>
                                <?php endforeach;?>
                                <span><?= $list['year'] ?></span>
                                <span><?= $list['area'] ?></span>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
            <?php endforeach;?>
        </div>
    </div>
</div>

<!--片源报错alert-->
<div class="alt" id="alt04">
    <div class="hlp-bd" name="zt">
        <!--关闭按钮-->
        <input class="btn-close" type="button" id="closealt04" value="X" />
        <div class="hlp-t03" name="zt">
            片源报错
        </div>
        <ul class="hlp-bd-box" name="zt">
            <li>
                <div><span class="clrOrangered">*</span>您所在的国家：</div>
                <div><span class="clrOrangered">*</span>您的上网环境：</div>
                <div><span class="clrOrangered">*</span>您使用的设备和系统：</div>
                <div><span class="clrOrangered">*</span>您使用的浏览器：</div>
                <div><span class="clrOrangered">*</span>问题描述：</div>
            </li>
            <li>
                <div>
                    <select class="seek-slk" name="zt" id="v_country">
                        <?php if(!empty($feedbackinfo['country'])) :?>
                            <?php foreach ($feedbackinfo['country'] as $internet): ?>
                                <option value="<?=$internet['country_id']?>"><?=$internet['country_name']?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                </div>
                <div>
                    <select class="seek-slk" name="zt" id="v_internet">
                        <?php if(!empty($feedbackinfo['internet'])) :?>
                            <?php foreach ($feedbackinfo['internet'] as $internet): ?>
                                <option value="<?=$internet['id']?>"><?=$internet['message']?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                </div>
                <div>
                    <select class="seek-slk" name="zt" id="v_system">
                        <?php if(!empty($feedbackinfo['system'])) :?>
                            <?php foreach ($feedbackinfo['system'] as $system): ?>
                                <option value="<?=$system['id']?>"><?=$system['message']?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                </div>
                <div>
                    <select class="seek-slk" name="zt" id="v_browser">
                        <?php if(!empty($feedbackinfo['browser'])) :?>
                            <?php foreach ($feedbackinfo['browser'] as $browser): ?>
                                <option value="<?=$browser['id']?>"><?=$browser['message']?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                </div>
                <div class="seekbox-tta">
                    <textarea id="v_description" placeholder="请详细描述问题现象以及出现了哪些错误提示等等，至少10个字。" name="zt"></textarea>
                </div>
                <!--<p>-->
                <!--    如果您的描述只有“视频无法播放”，“网站打不开”， “为什么不能登录”这类毫无信息量的文字，客服将直接忽略您的问题。-->
                <!--</p>-->
                <input class="seek-btn" type="button" name="" id="v_submit" value="提交" />
            </li>
        </ul>
    </div>
</div>
<script>
    let timer = null;
    let wechattimer = null
    let picUrl = "/video/get-wechat";
    let checkUrl = "/video/check-wechat";
    let clearUrl = "/video/clear-catch";

    //局部刷新后的剧集chapter_id和线路source_id; 20220509 yin
    var refreshchapterid = '<?=$data['info']['play_chapter_id']?>';
    var refreshsourceid = '';

    $(document).ready(function(){
        $(".wechat-block").remove("");
        if ($("#play_resource").val() != "")
            $("#my-iframe").attr('src', $("#play_resource").val() + "&ad_url=<?php echo $ad_url;?>&ad_link=<?php echo $ad_link;?>&ad_type=<?php echo $ad_type;?>");
        // refreshWechat();
        // alert(document.getElementById('wechat-block').style.display);
        if(document.getElementById('wechat-block') && document.getElementById('wechat-block').style.display!='none')
        {
            setTimeout(function(){
                clearInterval(wechattimer);
                document.getElementById('wechat-block').style.display='none';

                // if(document.getElementById('easiBox') && document.getElementById('easiBox').style.display!='none')
                //     $('#btn-video-play').trigger("click");

                // if(document.getElementById('picBox') && document.getElementById('picBox').style.display!='none')
                //     countPicAds();

                // setTimeout("document.getElementById('easiBox').style.display='none'",15000);
                // setTimeout("document.getElementById('picBox').style.display='none'",15000);
            },30000);
        }
        // else
        // {
        //     setTimeout("document.getElementById('easiBox').style.display='none'",15000);
        //     setTimeout("document.getElementById('picBox').style.display='none'",15000);
        // }
        // $('#btn-video-play').trigger("click");
        // countPicAds();
        // refreshAds();
        getAD();
        //文字链广告
        var citycode = getcity();
        var arrIndex = {};
        arrIndex['citycode'] = citycode;
        $.ajax({
            url:'/video/adverty',
            data:arrIndex,
            type:'get',
            cache:false,
            dataType:'json',
            success:function(res) {
                var html = "";
                if(res.errno==0 && res.data.length>0){
                    for(var i=0;i<res.data.length;i++){
                        if(res.data[i].advert && res.data[i].advert.length>0){
                            $(".J_advertyy_title").eq(i).text(res.data[i].title);
                            var advert = res.data[i].advert;
                            html = "";
                            for(var j=0;j<advert.length;j++){
                                html += '<li><a target="_blank" href="'+advert[j].url+'">'+advert[j].title+'</a></li>'
                            }
                            $(".J_advertyy").eq(i).html(html);
                        }
                    }
                    $(".J_xini_advert").show();
                }
            },
            error : function() {
                console.log("接口广告加载失败");
            }
        });
    });

    function refreshAds()
    {
        var arrIndex = {};

        arrIndex['page'] = "detail";
        var advertKey = 0;
        $.get('/video/advert', arrIndex, function(res) {
            if(!res.data.hasOwnProperty("advert"))
                return false;

            for (var prop in res.data.advert) {
                console.log("obj." + prop + " = " + res.data.advert[prop]);
                var adddata = res.data.advert[prop];
                if (adddata.hasOwnProperty("position_id")) {
                    if (prop == "videotop") {
                        $(".video-top-ad").attr("href", adddata.ad_skip_url);
                        $(".video-top-ad img").attr("src", adddata.ad_image);
                    }
                    else if (prop == "videobottom") {
                        $(".video-bottom-add").attr("href", adddata.ad_skip_url);
                        $(".video-bottom-add img").attr("src", adddata.ad_image );
                    }
                    else if (prop == "playbefore") {
                        $(".add-box .ad_url_link").attr("href", adddata.ad_skip_url);
                        if (adddata.ad_image.indexOf(".mp4") != -1)
                        {
                            $("#picBox").remove();
                            $(".add-box video").html("");
                            $(".add-box video").html("<source src='"+ adddata.ad_image + "' type='video/mp4'></source>");
                            $(".add-box video").load();
                            // $(".add-box video").trigger('play');
                            // countVieoAds();
                            $('#btn-video-play').trigger("click");
                            setTimeout("document.getElementById('easiBox').style.display='none'",15000);
                            $("#my-iframe").attr('src', $("#play_resource").val());
                        }
                        else
                        {
                            $("#easiBox").remove();
                            $(".add-box img").attr("src", adddata.ad_image);
                            setTimeout("document.getElementById('picBox').style.display='none'",15000);
                            countPicAds();
                        }
                    }
                }
            }
        })
    }

    function refreshWechat()
    {
        var arrIndex = {};
        // $(".wechat-block").hide();
        $.get(picUrl, function(response) {
            console.log(response);
            let result = response.data;
            if (result.status_code != "200") {
                $(".wechat-block").remove("");
                //   refreshAds();
                $('#btn-video-play').trigger("click");
                countPicAds();
                return;
            }
            console.log(response);
            $(".wechat-block").show();

            $('.wechat-url').attr('src', result.data.img_url)
            $('.wechat_tip').html("<span>"+ result.data.weChatFlag +"</span>");

            wechattimer = setInterval(function() {
                arrIndex['wechat_flag'] = result.data.weChatFlag;
                $.get(checkUrl, arrIndex ,function(response) {
                    let scene = response.data.scene;
                    console.log(response);
                    console.log(scene);
                    if(scene == "gotted")
                    {
                        $(".wechat-block").remove("");
                        arrIndex['catachkey'] = result.data.weChatFlag;
                        $.get(clearUrl, arrIndex);
                        clearInterval(wechattimer);
                        // refreshAds();
                        $('#btn-video-play').trigger("click");
                        countPicAds();
                    }
                })
            }, 2000)
        })
    }

    $("#btn-video-play").click(function(){
        var currentTime = 0;
        var duration = 0;
        var elevideo = document.getElementById("easi");
        $(this).hide();
        duration = Math.round(elevideo.duration);
        if (isNaN(duration))
            duration = 10;

        document.getElementById('timer1').innerHTML = duration;

        $(".add-box video").trigger('play');
        elevideo.addEventListener('play', function () { //播放开始执行的函数
            duration = Math.round(elevideo.duration);
            if (isNaN(duration))
                duration = 10;

            if (elevideo.currentTime != 0){
                duration = Math.round(elevideo.duration - elevideo.currentTime);
            }

            console.log("开始播放");
            //10s后关闭广告视频
            countDown(duration - 1,function(msg) {
                if(msg == '0'){
                    if(document.getElementById('easiBox'))
                        document.getElementById('easiBox').style.display='none';
                }
                document.getElementById('timer1').innerHTML = msg;
            })
        });

        elevideo.addEventListener('pause', function () { //暂停开始执行的函数
            duration = document.getElementById('timer1').innerHTML;
            clearInterval(timer);
            console.log("暂停播放");
        });

        elevideo.addEventListener('ended', function () { //结束
            document.getElementById('easiBox').style.display='none';
            console.log("播放结束");
            // $("#my-iframe").attr('src', $("#play_resource").val());
        }, false);
    });

    function countPicAds()
    {
        if($('.iqp-player #picBox').length > 0)
        {
            //8s后关闭广告图
            document.getElementById('timer1').innerHTML = 10;
            countDown(9, function(msg) {
                if(msg == 0){
                    //if(document.getElementById('picBox'))
                    document.getElementById('picBox').style.display='none';
                }
                console.log(msg);
                document.getElementById('timer1').innerHTML = msg;
            });
        }
    }

    function countDown(maxtime,fn){
        timer = setInterval(function() {
            if(!!maxtime ){
                seconds = Math.floor(maxtime%60),
                    msg = seconds;
                fn( msg );
                --maxtime;
            } else {
                clearInterval(timer );
                msg="0";
                fn(msg);
            }
        },1000);
    }

    $("#hide-add").click(function(){
        if(document.getElementById('picBox'))
            document.getElementById('picBox').style.display='none';

        if(document.getElementById('easiBox'))
        {
            var elevideo = document.getElementById("easi");
            elevideo.pause()
            document.getElementById('easiBox').style.display='none';
        }

    });

    //切换线路
    $('.bar-link').click(function(){
        var videoId = "<?= $data['info']['play_video_id']?>";
        var chapterId = refreshchapterid;
        var sourceId = $(this).attr('data-source-id');
        refreshsourceid = sourceId;
        if(sourceId != undefined && sourceId != null)
        {
            $('#srcTab-'+sourceId).trigger('click');
            if(document.getElementById('chap-'+sourceId +'-'+chapterId))
                $('#chap-'+sourceId +'-'+chapterId).trigger('click');
            else{
                $('#srctab-'+sourceId +' .switch-next-li:first').trigger('click');
            }
        }

    });
    //片源报错
    $('#err_feedback').click(function(){
        var uid = finduser();
        if(isNaN(uid) || uid==""){
            showloggedin();//弹登录框
        }else{
            $("#alt04").show();
        }
    })
    //提交
    $("#v_submit").click(function(){
        var arrIndex = {};
        var str = '提交成功';

        var description = $("#v_description").val();
        if(description.length < 10){
            $(".alt-title").text("请详细描述问题，至少10个字");
            $("#alt05").show();
            return false;
        }
        arrIndex['country'] = $("#v_country").val();
        arrIndex['internets'] = $("#v_internet").val();
        arrIndex['systems'] = $("#v_system").val();
        arrIndex['browsers'] = $("#v_browser").val();
        arrIndex['description'] = description;
        arrIndex['video_id'] = "<?= $data['info']['play_video_id']?>";
        arrIndex['chapter_id'] = refreshchapterid;
        arrIndex['source_id'] = (refreshsourceid!=""?refreshsourceid:"<?= $source_id?>");
        //发送请求，获取数据
        $.get('/video/save-feedbackinfo', arrIndex, function(s) {
            // console.log(s);
            if(s>0){
                //插入成功，所有值置空
                // $("#v_country").val('');
                $("#v_country").find("option").eq(0).prop("selected",true);
                $("#v_internet").find("option").eq(0).prop("selected",true);
                $("#v_system").find("option").eq(0).prop("selected",true);
                $("#v_browser").find("option").eq(0).prop("selected",true);
                $("#v_description").val('');
                str = '提交成功';
                $("#alt04").hide();
                $(".alt-title").text(str);
                $("#alt05").show();
            }else{
                str = '提交失败';
                $("#alt04").hide();
                $(".alt-title").text(str);
                $("#alt05").show();
            }
        });
    });
    //关闭片源拨错
    $('#closealt04').click(function(){
        $("#alt04").hide();
        $("#v_country").find("option").eq(0).prop("selected",true);
        $("#v_internet").find("option").eq(0).prop("selected",true);
        $("#v_system").find("option").eq(0).prop("selected",true);
        $("#v_browser").find("option").eq(0).prop("selected",true);
        $("#v_description").val('');
    });

    //添加播放记录
    $(document).ready(function () {
        //网页关闭时执行的方法
        $(window).bind("beforeunload", function () {
            var watchTime = dp1.video.currentTime;
            var totalTime = dp1.video.duration;
            addwatchlog(watchTime,totalTime);
        });
    });
    function addwatchlog(watchTime,totalTime){
        var uid = finduser();
        if(!isNaN(uid) && uid!=""){
            var arrindex = {};
            arrindex['video_id'] = '<?=$data['info']['play_video_id']?>';
            arrindex['chapter_id'] = $('li.J_switch_next.selected').attr('data-chapter-id');
            arrindex['watchTime'] = parseInt(watchTime);
            arrindex['totalTime'] = parseInt(totalTime);
            if(arrindex['totalTime']>0){
                $.get('/video/add-watchlog',arrindex,function(res){
                    console.log(res.data);
                });
            }
        }
    }

    //收藏
    var favor_tab = true;
    $("#id_favors").click(function(){
        var uid = finduser();
        if(!isNaN(uid) && uid!=""){
            if(favor_tab){
                favor_tab = false;
                var that = this;
                var total_favors = parseInt($(that).text());
                var arrindex = {};
                arrindex['videoid'] = '<?=$data['info']['play_video_id']?>';
                $.get('/video/change-favorite',arrindex,function(res){
                    favor_tab = true;
                    if(res.errno==0){
                        $(".qy-shoucang").toggleClass("act");
                        if(res.data.status==0){
                            if(total_favors>0){
                                $(that).text(--total_favors);
                            }
                        }else{
                            $(that).text(++total_favors);
                        }
                    }
                });
            }
        }else{//弹框登录
            showloggedin();
        }
    });

    //评论区登录
    $("#det_login").click(function(){
        showloggedin();
    });

    //发送
    $("#send_comment").click(function(){
        var uid = finduser();
        if(!isNaN(uid) && uid!=""){
            var ar = {};
            ar['video_id'] = '<?=$data['info']['play_video_id']?>';
            ar['chapter_id'] = refreshchapterid;
            ar['pid'] = 0;
            var that = this;
            var content = $(this).parent().siblings('textarea').val();
            ar['content'] = content;
            if(content==""){
                $(".alt-title").text("请填写评论");
                $("#alt05").show();
                return false;
            }else if(content.length>100){
                $(".alt-title").text("评论最多100字");
                $("#alt05").show();
                return false;
            }else{
                console.log('评论参数---------',ar);
                $.get('/video/send-comment',ar,function(res){
                    console.log('评论结果---------',res);
                    if(res.errno==0){
                        if(res.data.display==1){
                            commentNum();//本剧集评论数
                            commentstr(res.data.data);
                            ztBlack();
                            // $(".alt-title").text(res.data.message);
                            // $("#alt05").show();
                            $(that).parent().siblings('textarea').val("");
                        }else{
                            $(".alt-title").text(res.data.message);
                            $("#alt05").show();
                        }
                    }
                });
            }
        }else{
            //弹框登录
            showloggedin();
        }
    });

    function commentstr(data){
        var html = "";
        var avatarstr = "";
        if(data['avatar']!=""){
            avatarstr = '<img src="'+data['avatar']+'" />';
        }else{
            avatarstr = '<img src="/images/Index/user_c.png" />';
        }
        html = '<div class="div-commentlist">'+
            '<ul class="per-now-box ul-box" name="zt">'+
            '<li class="per-now-h">'+
            '<div class="navTopLogonImg">'+avatarstr+
            // '<a href="/video/other-home?uid='+data['uid']+'">'+avatarstr+'</a>'+
            '</div>'+
            '</li>'+
            '<li>'+
            '<div class="per-now-box-01">'+
            '<div>'+data['nickname']+'</div>'+
            '</div>'+
            '<div class="per-now-box-02" name="zt">'+data['content']+'</div>'+
            '<ul class="per-now-box-03" name="zt">'+
            '<li>'+data['created_time']+'</li>'+
            '<li>'+
            '<input class="per-btn-z" type="button" name="" onclick="addlikes('+data['comment_id']+',this);" value="" />'+
            '<span>'+data['likes_num']+'</span>'+
            '</li>'+
            '<li><input class="per-btn-reply" type="button" name="" onclick="showreply('+data['comment_id']+',this);" value="" /></li>'+
            '</ul>'+
            '</li>'+
            '</ul>'+
            '</div>';
        $("#comment-part").prepend(html);
        $("#comment-part").show();
    }

    //点赞
    function addlikes(id,that){
        var uid = $("#login_id").val();
        if(!isNaN(uid) && uid!=""){
            var arr = {};
            arr['id'] = id;
            if($(that).hasClass("act")){
                arr['cal'] = 'subtract';
            }else{
                arr['cal'] = 'plus';
            }
            $.get('/video/add-likes', arr,function(res){
                $(that).toggleClass("act");
                if(res.errno==0 && res.data>=0){
                    $(that).parent().find("span").html(res.data);
                }else{
                    $(that).parent().find("span").html(0);
                }
            });
        }else{//弹框登录
            showloggedin();
        }
    }
    //回复
    function showreply(id,that){
        var uid = $("#login_id").val();
        if(!isNaN(uid) && uid!=""){
            var black = "";
            if($(that).parent().parent().hasClass("ZT-black")){
                black = "ZT-black";
            }
            var str = '<div id="addreplydiv" class="GNbox-PLsr '+black+'" name="zt">' +
                '<textarea placeholder="在此输入回复内容"></textarea>' +
                '<div class="GNbox-PL-box">' +
                '<input class="GNbox-Btnfs" type="button" name="" onclick="sendreply('+id+');" value="发布" />' +
                '</div>' +
                '</div>';
            $("#addreplydiv").remove();
            $(that).parent().parent().after(str);
        }else{//弹框登录
            showloggedin();
        }
    }

    //提交回复
    function sendreply(pid){
        var ar = {};
        ar['video_id'] = '<?=$data['info']['play_video_id']?>';
        ar['chapter_id'] = refreshchapterid;
        ar['pid'] = pid;
        var content = $("#addreplydiv").find('textarea').eq(0).val();
        ar['content'] = content;
        if(content==""){
            $(".alt-title").text("请填写评论");
            $("#alt05").show();
            return false;
        }else if(content.length>100){
            $(".alt-title").text("评论最多100字");
            $("#alt05").show();
            return false;
        }else{
            $.get('/video/send-comment',ar,function(res){
                if(res.errno==0){
                    if(res.data.display==1){
                        commentNum();//本剧集评论数
                        var rstr = replystr(res.data.data);
                        if($("#addreplydiv").siblings('.div-reply').length>0){
                            $("#addreplydiv").siblings('.div-reply').prepend(rstr);
                        }else{
                            $("#addreplydiv").after('<div class="div-reply">'+rstr+'</div>');
                        }
                        ztBlack();
                        $(".alt-title").text(res.data.message);
                        $("#alt05").show();
                        $("#addreplydiv").remove();
                    }else{
                        $(".alt-title").text(res.data.message);
                        $("#alt05").show();
                    }
                }
            });
        }
    }

    function replystr(data){
        var html = "";
        var avatarstr = "";
        if(data['avatar']!=""){
            avatarstr = '<img src="'+data['avatar']+'" />';
        }else{
            avatarstr = '<img src="/images/Index/user_c.png" />';
        }
        html = '<ul class="per-now-box ul-box" name="zt">'+
            '<li class="per-now-h">'+
            '<div class="navTopLogonImg">'+avatarstr+
            // '<a href="/video/other-home?uid='+data['uid']+'">'+avatarstr+'</a>'+
            '</div>'+
            '</li>'+
            '<li>'+
            '<div class="per-now-box-01">'+
            '<div>'+data['nickname']+'</div>'+
            '</div>'+
            '<div class="per-now-box-02" name="zt">'+data['content']+'</div>'+
            '<ul class="per-now-box-03" name="zt">'+
            '<li>'+data['created_time']+'</li>'+
            '<li>'+
            '<input class="per-btn-z" type="button" name="" onclick="addlikes('+data['comment_id']+',this);" value="" />'+
            '<span>'+data['likes_num']+'</span>'+
            '</li>'+
            '<li></li>'+
            '</ul>'+
            '</li>'+
            '</ul>';
        return html;
    }
    //查看更多评论
    $("#comment-more").click(function(){
        var page_num = ($("#comment-current").val()!="")?parseInt($("#comment-current").val()):0;
        var total = ($("#comment-total").val()!="")?parseInt($("#comment-total").val()):0;
        var order = "time";
        var ar = {};
        ar['video_id'] = '<?=$data['info']['play_video_id']?>';
        ar['chapter_id'] = refreshchapterid;
        ar['page_num'] = page_num;
        ar['order'] = order;
        $.get('/video/comment-more',ar,function(res){
            $("#comment-more").before(res);//添加评论列表
            ztBlack();
            if(total==0 || total <= page_num+1){
                $("#comment-more").hide();
            }else{
                $("#comment-more").show();
                $("#comment-current").val(++page_num);
            }
        });
    });
    //查看更多回复
    function findmorereply(pid){
        //#reply-more-  .reply-current- .reply-total-
        var page_num = ($("#reply-current-"+pid).val()!="")?parseInt($("#reply-current-"+pid).val()):0;
        var total = ($("#reply-total-"+pid).val()!="")?parseInt($("#reply-total-"+pid).val()):0;
        var ar = {};
        ar['pid'] = pid;
        ar['page_num'] = page_num
        $.get('/video/reply-more',ar,function(res){
            if(res.errno==0 && res.data.length>0){
                var str = replyMorestr(res.data);
                $("#reply-more-"+pid).before(str);//添加评论列表
                ztBlack();
                if(total <= page_num+1){
                    $("#reply-more-"+pid).hide();
                }else{
                    $("#reply-more-"+pid).show();
                    $("#reply-current-"+pid).val(++page_num);
                }
            }
        });
    }
    function replyMorestr(data){
        var html = "";
        for(var i=0;i<data.length;i++){var avatarstr = "";
            if(data[i]['avatar']!=""){
                avatarstr = '<img src="'+data[i]['avatar']+'" />';
            }else{
                avatarstr = '<img src="/images/Index/user_c.png" />';
            }
            html += '<ul class="per-now-box ul-box" name="zt">'+
                '<li class="per-now-h">'+
                '<div class="navTopLogonImg">'+avatarstr+'</div>'+
                '</li>'+
                '<li >'+
                '<div class="per-now-box-01">'+
                '<div>'+data[i]['nickname']+'</div>'+
                '<img src="/images/newindex/lv_1.png" />'+
                '</div>'+
                '<div class="per-now-box-02" name="zt">'+data[i]['content']+'</div>'+
                '<ul class="per-now-box-03" name="zt">'+
                '<li>'+data[i]['created_time']+'</li>'+
                '<li>'+
                '<input class="per-btn-z" type="button" name="" onclick="addlikes('+data[i]['comment_id']+',this);" value="" />'+
                '<span>'+data[i]['likes_num']+'</span>'+
                '</li>'+
                '<li></li>'+
                '</ul>'+
                '</li>'+
                '</ul>';
        }
        return html;
    }
    //切换order-tab
    //$(".per-tab-comment li").click(function(){
    //    var that = this;
    //    var page_num = 0;
    //    var total = ($("#comment-total").val()!="")?parseInt($("#comment-total").val()):0;
    //    var order = "time";
    //    var ar = {};
    //    ar['video_id'] = '';
    //    ar['chapter_id'] = '';
    //    ar['page_num'] = page_num;
    //    ar['order'] = order;
    //    $.get('/video/comment-more',ar,function(res){
    //        $("#comment-part .div-commentlist").remove();
    //        $("#comment-more").before(res);//添加评论列表
    //        $(that).addClass("act").siblings().removeClass("act");
    //        ztBlack();
    //        if(total==0 || total <= page_num+1){
    //            $("#comment-more").hide();
    //        }else{
    //            $("#comment-more").show();
    //            $("#comment-current").val(++page_num);
    //        }
    //    });
    //});
    //chapterId评论数
    function commentNum(){
        var value = $(".J_comment").text();
        var num = parseInt(value!='' ? value : 0 )+1;
        $(".J_comment").text(num);
        $("#GNbox-PL").find('span').html("("+num+")");
    }
    //关闭广告
    $('.J_del_advert').click(function(){
        $('.J_xini_advert').hide();
    });
    // 2022-04-12 Jason修改
    //空格键切换播放暂停状态
    $(document).keydown(function(e){
        switch(e.keyCode) {
            case 32:
                if(e.preventDefault){
                    e.preventDefault();
                }else{
                    window.event.returnValue = false;
                }
                if($("#player1").is(":visible")){
                    $("#player1 .dplayer-play-icon").trigger("click");
                }
                else{
                    $("#player_ad .dplayer-play-icon").trigger("click");
                }

                break;
        }
    });
    //用户点击，切换剧集
    $('.J_switch_next').click(function() {
        var that = this;
        var videoId = $(this).attr('data-video-id');
        var chapterId = $(this).attr('data-chapter-id');
        var sourceId = $('.sourceTab .hover a').attr('data-source-id');
        var type = $(this).attr('data-type');
        loadvideo(videoId,chapterId,sourceId);//局部刷新播放器jianghu2
        // window.location.href = '/video/detail?video_id=' + videoId + '&chapter_id=' + chapterId+"&source_id="+sourceId;
        // window.location.href = '/video/detail?video_id=' + videoId + '&chapter_id=' + chapterId;
    });
    var canSwitch = true; // 2022-04-12 Jason修改
    //切换剧集
    function loadvideo(videoId,chapterId,sourceId){
        //局部刷新，记录新chapter_id,source_id
        refreshchapterid = chapterId;
        refreshsourceid = sourceId;
        // 2022-04-12 Jason修改
        if (!canSwitch) {
            // alert("剧集正在加载中，请稍后...");
            $("#pop-tip").text("剧集正在加载中，请稍后...");
            $("#pop-tip").show().delay(2000).fadeOut();
            return false;
        }
        var citycode = getcity();
        var arrIndex = {};
        arrIndex['citycode'] = citycode;
        arrIndex['video_id'] = videoId;
        arrIndex['chapter_id'] = chapterId;
        arrIndex['last_chapter_id'] = $('li.J_switch_next.selected').attr('data-chapter-id');
        arrIndex['source_id'] = sourceId;
        // arrIndex['watchTime'] = parseInt(dp1.video.currentTime);
        // arrIndex['totalTime'] = parseInt(dp1.video.duration);
        // console.log(arrIndex);
        canSwitch = false;  // 2022-04-12 Jason修改
        $.ajax({
            url:'/video/detail-part',
            data:arrIndex,
            type:'get',
            cache:false,
            // dataType:'json',
            success:function(s) {
                dp.destroy();
                dp1.destroy();
                $("#jianghu2").empty();
                if(warnTimeout != undefined)
                {
                    clearTimeout(warnTimeout);
                }

                $("#jianghu2").html(s);

                $('.J_switch_next').removeClass('selected');
                $('#chap-'+sourceId +'-'+chapterId).addClass('selected');
            },
            error : function(){
                console.log("视频切换失败");
                canSwitch = true; // 2022-04-12 Jason修改
            }
        });
        //局部刷新评论区域--20220509 yin
        refreshComment(videoId,chapterId);
        refreshwatchlog();//右上角局部刷新
    }
    //右上角局部刷新
    function refreshwatchlog(){
        var uid = finduser();
        var ar = {};
        ar['uid'] = uid;
        $.get('/video/userall',ar,function(res){
            $("#navTopBtnBox").html(res);
            ztBlack();
            if(!isNaN(uid) && uid!=""){
                $("#det_login").parent().parent().hide();
            }
        });
    }
    //局部刷新评论
    function refreshComment(videoId,chapterId){
        var page_num = 0;
        var order = "time";
        var ar = {};
        ar['video_id'] = videoId;
        ar['chapter_id'] = chapterId;
        ar['page_num'] = page_num;
        ar['order'] = order;
        $.get('/video/comment-more',ar,function(res){
            $("#comment-part .div-commentlist").remove();
            $("#comment-more").before(res);//局部刷新评论列表
            var total = ($("#refreshtotal").val()!="")?parseInt($("#refreshtotal").val()):0;
            var num = ($("#refreshcommentcount").val()!="")?parseInt($("#refreshcommentcount").val()):0;
            //局部刷新后的总评论数
            $(".J_comment").text(num);
            $("#GNbox-PL").find('span').html("("+num+")");
            ztBlack();
            if(total==0 || total <= page_num+1){
                $("#comment-more").hide();
            }else{
                $("#comment-more").show();
            }
            $("#comment-total").val(total);
            $("#comment-current").val(++page_num);
        });
    }

    //切换视频源
    // $('.next-source').click(function() {
    //     var videoId = $(this).attr('data-video-id');
    //     var chapterId = $(this).attr('data-video-chapter-id');
    //     var sourceId = $(this).attr('data-source-id');
    //     window.location.href = "/video/detail?video_id="+videoId+"&chapter_id="+chapterId+"&source_id="+sourceId;
    // });
    // $('.func-swicthCap').click(function(){
    //     var videoId = $(this).attr('data-video-id');
    //     var chapterId = $(this).attr('data-chapter-id');
    //     // var sourceId = $('.sourceTab .hover a').attr('data-source-id');
    //     var sourceId = $(this).attr('data-source-id');;
    //
    //     window.location.href = '/video/detail?video_id=' + videoId + '&chapter_id=' + chapterId+"&source_id="+sourceId;
    // });

    $('.J_comment').click(function () {
        $('html, body').animate({
            scrollTop: $("#comment_box").offset().top - 62
        }, 500);
        return false;
    });

    function getAD(){
        var citycode = getcity();
        var arrIndex = {};
        arrIndex['citycode'] = citycode;
        arrIndex['page'] = 'detail';
        arrIndex['chapterId'] = '<?=$play_chapter_id?>';

        var advert = {};
        advert['ad_type'] = '';
        advert['ad_url'] = '';
        advert['ad_link'] = '';
        $.ajax({
            url:'/video/advert-info',
            data:arrIndex,
            type:'get',
            cache:false,
            dataType:'json',
            timeout: 4000,
            success:function(res) {
                if(res.errno == 0){
                    var ad = {};
                    if(res.data.advert.videotop.ad_image){
                        ad = res.data.advert.videotop;
                        $("#videotop").html('<div class="play-box video-add-column video-detail-ad"><a href="'+ad.ad_skip_url+'" target="_blank"><img src="'+ad.ad_image+'" /></a></div>')
                    }
                    if(res.data.advert.videoright.ad_image){
                        ad = res.data.advert.videoright;
                        $("#videoright").html('<div class="video-right-ad-img"><a href="'+ad.ad_skip_url+'" target="_blank"><img src="'+ad.ad_image+'"></a></div>');
                    }
                    if(res.data.advert.videobottom.ad_image){
                        ad = res.data.advert.videobottom;
                        $("#videobottom").html('<div class="play-box video-add-column video-detail-ad"><a href="'+ad.ad_skip_url+'" target="_blank" class="video-bottom-add"><img src="'+ad.ad_image+'"></a></div>');
                    }
                }
            },
            error : function() {
                console.log("广告加载失败");
            },
            complete:function(XHR,TextStatus){
                if(TextStatus=='timeout'){ //超时执行的程序
                    console.log("请求超时！");
                }
            }
        });
    }

    //关闭暂停广告
    function closePauseAD(){
        $("#pause-img").hide();
        eventStop();
    }

    function getcity(){
        var citycode = '';
        if(COUNTRYINFO['city_code'] && COUNTRYINFO['city_code'] != "" && COUNTRYINFO['city_code']!="undefined"){
            citycode = COUNTRYINFO['city_code'];
        }else{
            var req = new XMLHttpRequest();
            req.open('GET', '../../images/NewVideo/logo.png', false);
            req.send(null);
            var cf_ray = req.getResponseHeader('cf-Ray');//指定cf-Ray的值
            var cf_cache_status = req.getResponseHeader('cf-cache-status');//指定cf-cache-status的值
            if(cf_cache_status == 'HIT'){
                citycode = cf_ray.substring(cf_ray.length-3);
            }else{
                req.open('GET', '../../images/Index/fenlei.png', false);
                req.send(null);
                cf_ray = req.getResponseHeader('cf-Ray');//指定cf-Ray的值
                cf_cache_status = req.getResponseHeader('cf-cache-status');//指定cf-cache-status的值
                if(cf_cache_status == 'HIT'){
                    citycode = cf_ray.substring(cf_ray.length-3);
                }else{
                    citycode = 'MEL'//墨尔本
                }
            }
        }
        return citycode;
    }
</script>
