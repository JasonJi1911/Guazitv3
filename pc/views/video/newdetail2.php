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
        color: #FF5722;
    }
    .div-replyname{
        color:#FF5722;
        cursor: pointer;
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
        background-color: #FF5722;
        color: #FFFFFF;
    }

    .per-tab-comment>li.act {
        background-color: #FF5722;
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
</style>
<!--黑色区域-->
<div class="box05">
    <!--播放器上面加广告-->
    <?php if(!empty($data['advert'])) :?>
        <?php foreach ($data['advert'] as $key => $advert) : ?>
            <?php if(!empty($advert) && $advert['position_id'] == AdvertPosition::POSITION_VIDEO_TOP_PC) :?>
                <div class="play-box video-add-column">
                    <a href="<?=$advert['ad_skip_url']?>" target="_blank">
                        <img src="<?=$advert['ad_image']?>" />
                    </a>
                </div>
            <?php endif;?>
        <?php endforeach;?>
    <?php endif;?>
    <div>
        <!--播放器位置-->
        <div class="play">
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
                'next_chapter'      => $data['info']['next_chapter']
            ]);?>
        </div>
        <!--广告-->
        <div class="AD-02">
            <?php if(!empty($data['advert'])) :?>
                <?php foreach ($data['advert'] as $key => $advert): ?>
                    <?php $adtab = false;
                    if(!empty($advert) && intval($advert['position_id']) == intval(AdvertPosition::POSITION_VIDEO_RIGHT_PC)){
                        $adtab = true;
                        break;
                    }?>
                <?php endforeach;?>
                <?php if($adtab) :?>
                    <a href="<?=$advert['ad_skip_url']?>" target="_blank">
                        <img src="<?=$advert['ad_image']?>" onerror="this.src='/images/NewVideo/GG03.png'"/>
                    </a>
                <?php else :?>
                    <img src="/images/NewVideo/GG03.png"/>
                <?php endif;?>
            <?php endif;?>
        </div>
        <!--评论，点赞，差评等按钮-->
        <div class="BtnList">
            <ul class="BtnList-boxL">
                <!--rBtn-01 display样式临时加用，加入赞踩分享后删除 -->
                <li class="rBtn-01" style="display:inline-block;margin-top:0px;"><input type="button" id="" value="<?=$data['commentcount']?>"  onclick="window.location.href = '#GNbox-PL'" /></li>
<!--                <li class="rBtn-02"><input type="button" id="" value="0" /></li>-->
<!--                <li class="rBtn-03"><input type="button" id="" value="0" /></li>-->
                <li class="rBtn-04 <?=$data['info']['fav_status']==1? 'act' : ''?>"><input type="button" id="id_favors" value="<?= $data['info']['total_favors']?>" /></li>
<!--                <li class="rBtn-05"><input type="button" id="" value="0" /></li>-->
                <li class="rBtn-06"><input type="button" id="" value="手机看" /></li>
                <li class="rBtn-07"><input type="button" id="err_feedback" value="片源报错" /></li>
                <li class="rBtn-08"><a href="<?= Url::to(['/video/seek'])?>" target="_blank">求片</a></li>
            </ul>
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
                    <a href="javascript:void(0);" onclick="showwarning();"><img src="/images/NewVideo/ipad.png" />iPhone客户端</a>
                    <a href="javascript:void(0);" onclick="showwarning();"><img src="/images/NewVideo/ipad.png" />iPad客户端</a>
                    <a href="javascript:void(0);" onclick="showwarning();"><img src="/images/NewVideo/anzhuo.png" />安卓客户端</a>
                </div>
            </div>
            <div class="Altsjk-03">
                没有<?=LOGONAME?>视频APP？ <a href="javascript:void(0);" onclick="showwarning();">立即下载</a>
<!--                <a href="--><?//= Url::to(['/site/share-down'])?><!--" target="_blank">立即下载</a>-->
            </div>
        </div>

        <!--博主信息-->
        <div class="BZbox02">
            <div class="BZtop">
                <div class="BZtx">
                    <a href="javascript:;"><img src="/images/NewVideo/logon.png" /></a>
                </div>
                <div class="BZname">
                    <a href="javascript:;"><?=LOGONAME?>影视</a>
                    <img src="/images/NewVideo/nan.png" />
                    <img src="/images/NewVideo/nv.png" />
                </div>
                <div class="BZdz">
                    <!--                    <img class="lv" src="/images/newindex/lv_1.png" />-->
                    <img class="dz" src="/images/NewVideo/dizi.png" /> 慕尼黑
                </div>
            </div>
            <ul class="BZsj">
                <li>粉丝：<span>0</span></li>
                <li>作品：<span>0</span></li>
                <li>获赞：<span>0</span></li>
            </ul>
            <div class="BZqm">
                此人很懒，没有更详细的介绍
            </div>
            <div class="BZbown">
                <a class="BtnSX" href="javascript:;">私信</a>
                <a class="BtnZY" href="javascript:;">个人主页</a>
            </div>
            <!--关注按钮-->
            <input class="BtnGZ" type="button" name="" id="" value="+关注" />
        </div>
    </div>
</div>

<!--白色区域-->
<div class="box06">
    <div>
        <!--左侧-->
        <div class="box06-L">
            <!--横向广告-->
            <div class="AD-03">
                <?php if(!empty($data['advert'])) :?>
                    <?php foreach ($data['advert'] as $key => $advert) : ?>
                        <?php if(!empty($advert) && $advert['position_id'] == AdvertPosition::POSITION_VIDEO_BOTTOM_PC) :?>
                            <a href="<?=$advert['ad_skip_url']?>" target="_blank">
                                <img src="<?=$advert['ad_image']?>" />
                            </a>
                        <?php endif;?>
                    <?php endforeach;?>
                <?php endif;?>
            </div>
            <div class="play-name" name="zt">
                <?= $data['info']['video_name']?>
            </div>
            <div class="GNbox">
                <div class="GNbox-xq" name="zt">
                    <span>详情</span>
                </div>
                <!--                <div class="GNbox-TJ" name="zt">-->
                <!--                    <span>统计</span>-->
                <!--                </div>-->
                <div class="GNbox-type" name="zt">
                    <?php foreach (explode(' ',$data['info']['category']) as $cate) : ?>
                        <span><?= $cate?></span>
                    <?php endforeach;?>
                    <span><?= $data['info']['year']?></span>
                    <span><?= $data['info']['area']?></span>
                </div>
                <div class="GNbox-RD" name="zt">
                    <?= $data['info']['total_views']?>
                </div>
                <div class="GNbox-PF">
                    <span><?= $data['info']['score']?></span>分
                </div>
            </div>
            <!--详情展开-->
            <div class="GNbox-xq-K">
                <div>
                    <div class="GNbox-xq-img">
                        <img src="<?= $data['info']['cover']?>" onerror="this.src='/images/newindex/default-cover.png'"/>
                    </div>
                    <div class="GNbox-xq-text" name="zt">
                        <div>
                            添加时间：<span><?= date("Y年m月d日",$data['info']['created_at']) ?></span>
                        </div>
                        <div>
                            更新：<span><?= $data['info']['summary'] ?></span>
                        </div>
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
            <!--小视频-->
            <!--            <div class="GNbox-xspxq-K">-->
            <!--                <p class="xsp" name="zt">-->
            <!--                    简介:<span>测试小视频简介内容测试小视频简介内容测试小视频简介内容测试小视频简介内容测试小视频简介内容测试小视频简介内容</span>-->
            <!--                </p>-->
            <!--            </div>-->
            <!--            <div class="GNbox-TJ-K">-->
            <!--                统计图表区域-->
            <!--            </div>-->
            <!--集数多余50集显示-->

            <div class="GNtab" name="zt">
                <?php if(count($data['info']['videos']) > 600): ?>
                    <div class="GNtab-all">
                        全部
                    </div>
                    <div class="GNtab-sq">
                        收起
                    </div>
                <?php endif; ?>

                <?php
                $page = ceil(count($data['info']['videos'])/50);
                $count = count($data['info']['videos']);
                $ontab = 0;
                foreach ($data['info']['videos'] as $index => $value){
                    if ($data['info']['play_chapter_id'] != $value['chapter_id'])
                        continue;

                    $ontab = ceil(($index+1) / 50);
                    break;
                }
                ?>
                <?php for($k=0; $k<$page; $k++){?>
                    <div class="GNtab-a <?= $k+1 == $ontab? 'act': ''?>">
                        <?= $k*50 + 1?>-<?= ($k == ($page -1))? $count:$k*50 + 50?>
                    </div>
                <?php } ?>
            </div>

            <!--集数区域-->
            <div class="GNtab-Box">
                <?php for($i=0; $i<$page; $i++){?>
                    <div class="GNbox-JS <?= (($i+1) == $ontab)? 'act': ''?>" name="zt">
                        <?php foreach ($data['info']['videos'] as $index => $value) : ?>
                            <?php if($index>=$i*50 && $index < ($i*50+50)){
                                $resource_arr = $value['resource_url'];
                                // $tmp_src = array_column($data['info']['all_source'], null, 'source_id');
                                $quality = [];
                                foreach ($data['info']['all_source'] as $key => $src) {
                                    if (empty(trim($resource_arr[$src['source_id']]))) { // source_id不在视频里面或者没有视频播放连接
                                        continue;
                                    }
                                    $src_id = $src['source_id'];
                                    $src_url = $resource_arr[$src_id];
                                    $quality[] = $src['name'].'#'.$src_url;
                                }
                                // foreach ($resource_arr as $k => $v)
                                //     $quality[] = $tmp_src[$k]['name'].'#'.$v;

                                $quality_str = implode('$$$', $quality);
                                ?>
                                <a class="<?= $data['info']['play_chapter_id'] == $value['chapter_id'] ? 'act' : ''?> <?= $value['latest']==1 ? 'icon_spot':'' ?>"
                                   href="<?= Url::to(['video/detail', 'video_id'=>$value['video_id'], 'chapter_id'=>$value['chapter_id']])?>"
<!--                                   attr-id="--><?//= $value['chapter_id']?><!--"-->
<!--                                   attr-quality="--><?//= $quality_str?><!--">-->
                                    <?= $value['title']?>
                                </a>
                            <?php }?>
                        <?php endforeach;?>
                    </div>
                <?php }?>
            </div>

            <script>
                //  集数切换效果
                $(".GNbox-JS>a").click(function() {
                    $(this).addClass("act").siblings().removeClass("act");
                    event.stopPropagation();
                    var epi_id = $(this).attr('attr-id')
                    var quality = $(this).attr('attr-quality')
                    var quality_arr = quality.split('$$$')
                    var new_video = { quality:[], pic: '', defaultQuality: 0, };
                    for (x in quality_arr){
                        var tmp_qua=quality_arr[x];
                        console.log(tmp_qua);
                        var tmp_arr = tmp_qua.split('#');
                        // 		console.log(tmp_arr);
                        new_video['quality'].push({
                            'name': tmp_arr[0],
                            'url': tmp_arr[1],
                            'type': 'auto',
                        });
                    }
                    initialPlayer(new_video)
                    $("#player1 .player-box-JS>a").each(function(){
                        $(this).removeClass("act");
                        var tm1_id = $(this).attr('attr-id');
                        if(epi_id == tm1_id)
                        {
                            $(this).addClass("act");
                            selected_id = tm1_id;
                        }
                    });
                });
            </script>

            <div class="GNbox-PL" id="GNbox-PL" name="zt">
                评论区<span>(<?=$data['commentcount']?>)</span>
            </div>
            <!--评论输入区-->
            <div class="GNbox-PLsr" name="zt">
                <div>
                    请在此发表意见
                </div>
                <textarea placeholder="注意，以下行为将被封号：严重剧透、发布广告、木马链接、宣传同类网站、辱骂工作人员等。"></textarea>
                <div class="GNbox-PL-box">
<!--                    <input class="GNbox-Btnbq" type="button" name="" id="" value="" />-->
<!--                    <input class="GNbox-Btntp" type="button" name="" id="" value="发起投票" />-->
                    <input class="GNbox-Btnfs" type="button" name="" id="send_comment" value="发送" />
                </div>
                <!--未登录时显示-->
                <div class="GNbox-PLsr-no" name="zt">
                    <div>
                        您还未登录，请登录后发表评论<br />
<!--                        功能暂未开放，敬请期待  style="display: none;"-->
                        <input type="button" name="" id="det_login" value="登录" />
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
                <div class="div-commenttab">
                    <ul class="per-tab-comment" name="zt">
                        <li data-order="time" class="act">全部评论</li>
                        <li data-order="replynum">热门评论</li>
                    </ul>
                </div>
                <?php if($data['comments']['list']):?>
                    <?php foreach ($data['comments']['list'] as $comment):?>
                        <div class="div-commentlist">
                            <ul class="per-now-box ul-box" name="zt">
                                <li class="per-now-h">
                                    <div class="navTopLogonImg">
                                        <a href="<?=Url::to(['/video/other-home','uid'=>$comment['uid']])?>">
                                            <?php if($comment['avatar']):?>
                                                <img src="<?=$comment['avatar']?>" />
                                            <?php else :?>
                                                <img src="/images/newindex/logon.png" />
                                            <?php endif;?>
                                        </a>
                                    </div>
                                    <div class="navTopLogon-GRXX" name="zt">
                                        <div class="navTopLogon-GRXX-box">
                                            <ul class="navTopLogon-box01">
                                                <li class="navTopLogon-name"><img src="/images/newindex/VIP-1.png" /><?=$comment['nickname']?></li>
                                                <li class="navTopLogon-Gender">
                                                    <?php if($comment['gender']==1):?>
                                                        <img src="/images/newindex/nv.png" />
                                                    <?php elseif($comment['gender']==2) :?>
                                                        <img src="/images/newindex/nan.png" />
                                                    <?php endif;?>
                                                </li>
                                            </ul>
                                            <ul class="navTopLogon-box02">
                                                <li class="navTopLogon-rank">LV.<span>1</span></li>
                                                <li class="navTopLogon-icon01"><img src="/images/newindex/jinbi.png" /></li>
                                                <li class="navTopLogon-text">0</li>
    <!--                                            <li class="per-gz-dz"><img src="/images/newindex/hlp-dz-w.png"><span>澳大利亚</span></li>-->
    <!--                                            <li class="navTopLogon-experience"><span>76</span>/<span>200</span></li>-->
    <!--                                            <li class="navTopLogon-icon01"><img src="/images/newindex/shangsheng.png" /></li>-->
<!--                                                <li class="navTopLogon-Progress">-->
<!--                                                    <div>-->
<!--                                                        <div class="Progress">&nbsp;</div>-->
<!--                                                    </div>-->
<!--                                                </li>-->
                                            </ul>
                                        </div>
                                        <ul class="navTopLogon-box03">
                                            <li>
                                                <a class="navTopLogon-A" href="<?=Url::to(['/video/other-home','uid'=>$comment['uid']])?>">个人主页</a>
                                            </li>
                                            <li>
<!--                                                <input class="per-now-btn" type="" name="" id="" value="私信" />-->
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li >
                                    <div class="per-now-box-01">
                                        <div>
                                            <?=$comment['nickname']?>
                                        </div>
                                        <img src="/images/newindex/lv_1.png" />
                                    </div>
                                    <div class="per-now-box-02" name="zt">
                                        <?=$comment['content']?>
                                    </div>
                                    <ul class="per-now-box-03" name="zt">
                                        <li><?=date("Y-m-d",$comment['created_at'])?></li>
                                        <li><input class="per-btn-z" type="button" name="" onclick="addlikes(<?=$comment['comment_id']?>,this);" value="" /><span><?=$comment['likes_num']?></span></li>
                                        <li><input class="per-btn-reply" type="button" name="" onclick="showreply(<?=$comment['comment_id']?>,this);" value="回复" /></li>
                                    </ul>
                                    <?php if($comment['reply_info']['list']):?>
                                        <div class="div-reply">
                                            <?foreach ($comment['reply_info']['list'] as $reply):?>
                                                <ul class="per-now-box ul-box" name="zt">
                                                    <li class="per-now-h">
                                                        <div class="navTopLogonImg">
<!--                                                                <a href="javascript"><img src="/images/newindex/logon.png" /></a>-->
                                                            <a href="<?=Url::to(['/video/other-home','uid'=>$reply['uid']])?>">
                                                                <?php if($reply['avatar']):?>
                                                                    <img src="<?=$reply['avatar']?>" />
                                                                <?php else :?>
                                                                    <img src="/images/newindex/logon.png" />
                                                                <?php endif;?>
                                                            </a>
                                                        </div>
                                                        <div class="navTopLogon-GRXX" name="zt">
                                                            <div class="navTopLogon-GRXX-box">
                                                                <ul class="navTopLogon-box01">
                                                                    <li class="navTopLogon-name"><img src="/images/newindex/VIP-1.png" /><?=$reply['nickname']?></li>
                                                                    <li class="navTopLogon-Gender">
                                                                        <?php if($reply['gender']==1):?>
                                                                            <img src="/images/newindex/nv.png" />
                                                                        <?php elseif($reply['gender']==2) :?>
                                                                            <img src="/images/newindex/nan.png" />
                                                                        <?php endif;?>
                                                                    </li>
                                                                </ul>
                                                                <ul class="navTopLogon-box02">
                                                                    <li class="navTopLogon-rank">LV.<span>1</span></li>
                                                                    <li class="navTopLogon-icon01"><img src="/images/newindex/jinbi.png" /></li>
                                                                    <li class="navTopLogon-text">0</li>
<!--                                                                        <li class="per-gz-dz"><img src="/images/newindex/hlp-dz-w.png"><span>澳大利亚</span></li>-->
<!--                                                                        <li class="navTopLogon-experience"><span>76</span>/<span>200</span></li>-->
<!--                                                                        <li class="navTopLogon-icon01"><img src="/images/newindex/shangsheng.png" /></li>-->
<!--                                                                        <li class="navTopLogon-Progress">-->
<!--                                                                            <div>-->
<!--                                                                                <div class="Progress">&nbsp;</div>-->
<!--                                                                            </div>-->
<!--                                                                        </li>-->
                                                                </ul>
                                                            </div>
                                                            <ul class="navTopLogon-box03">
                                                                <li>
                                                                    <a class="navTopLogon-A" href="<?=Url::to(['/video/other-home','uid'=>$reply['uid']])?>">个人主页</a>
                                                                </li>
                                                                <li>
<!--                                                                        <input class="per-now-btn" type="" name="" id="" value="私信" />-->
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li >
                                                        <div class="per-now-box-01">
                                                            <div>
                                                                <?=$reply['nickname']?>
                                                            </div>
                                                            <img src="/images/newindex/lv_1.png" />
                                                        </div>
                                                        <div class="per-now-box-02" name="zt">
                                                            <?=$reply['content']?>
                                                        </div>
                                                        <ul class="per-now-box-03" name="zt">
                                                            <li><?=date("Y-m-d",$reply['created_at'])?></li>
                                                            <li><input class="per-btn-z" type="button" name="" onclick="addlikes(<?=$reply['comment_id']?>,this);" value="" /><span><?=$reply['likes_num']?></span></li>
                                                            <li></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            <?php endforeach; ?>
                                            <div class="div-replyname" id="reply-more-<?=$comment['comment_id']?>" onclick="findmorereply(<?=$comment['comment_id']?>)"
                                                <?php if($comment['reply_info']['total_page']!=0 && $comment['reply_info']['current_page']==$comment['reply_info']['total_page']):?>
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
                <img src="/images/NewVideo/logo-02.png" />
                <a href="javascript:;"><?= $channelName ?>·排行榜</a>
            </div>
            <!--电影排行榜   小视频没有排行-->
            <div class="Movie-Ranking02" name="zt">
                <?php foreach ($hotword['tab'] as $key => $tab): ?>
                    <?php if($tab['title'] == $channelName) :?>
                        <?php foreach ($tab['list'] as $key => $list): ?>
                            <!--排名-->
                            <div class="Ranking-box">
                                <div class="Ranking-mun">
                                    <?= $key+1?>
                                </div>
                                <div class="Ranking-text">
                                    <div class="Ranking-name" name="zt">
                                        <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                                            <?= $list['video_name']?>
                                        </a>
                                    </div>
                                    <div class="Ranking-type" name="zt">
                                        <div><?= $list['year'] ?></div>
                                        <div><?= $list['area'] ?></div>
                                        <?php foreach (explode(' ',$list['category']) as $cate) : ?>
                                            <div><?= $cate?></div>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                                <div class="Ranking-score">
                                    <?= $list['score'] ?>
                                </div>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>
                <?php endforeach;?>
            </div>

            <div class="Title-04" name="zt">
                <img src="/images/NewVideo/logo-02.png" />相关视频
            </div>
            <?php foreach ($data['guess_like'] as $key => $list) :?>
                <?php if($key < 8) :?>
                    <!--剧集-->
                    <div class="JJXG">
                        <div class="JJXG-L">
                            <a href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>">
                                <img src="<?= $list['cover']?>"/>
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
        arrIndex['chapter_id'] = "<?= $data['info']['play_chapter_id']?>";
        arrIndex['source_id'] = "<?= $source_id?>";
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
            addwatchlog();
        });
    });
    function addwatchlog(){
        var arrindex = {};
        arrindex['video_id'] = '<?=$data['info']['play_video_id']?>';
        arrindex['chapter_id'] = '<?=$data['info']['play_chapter_id']?>';
        arrindex['watchTime'] = parseInt(dp1.video.currentTime);
        arrindex['totalTime'] = parseInt(dp1.video.duration);
        $.get('/video/add-watchlog',arrindex,function(res){
            console.log(res.data);
        });
    }

    //收藏
    var favor_tab = true;
    $("#id_favors").click(function(){
        var uid = finduser();
        if(!isNaN(uid) && uid!=""){
            if(favor_tab){
                favor_tab = false;
                var that = this;
                var total_favors = parseInt($(that).val());
                var arrindex = {};
                arrindex['videoid'] = '<?=$data['info']['play_video_id']?>';
                $.get('/video/change-favorite',arrindex,function(res){
                    favor_tab = true;
                    if(res.errno==0){
                        $(".rBtn-04").toggleClass("act");
                        if(res.data.status==0){
                            $(that).val(--total_favors);
                        }else{
                            $(that).val(++total_favors);
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
        var ar = {};
        ar['video_id'] = '<?=$data['info']['play_video_id']?>';
        ar['chapter_id'] = '<?=$data['info']['play_chapter_id']?>';
        ar['pid'] = 0;
        var that = this;
        var content = $(this).parent().siblings('textarea').val();
        ar['content'] = content;
        if(content==""){
            $(".alt-title").text("请填写评论");
            $("#alt05").show();
            return false;
        }else{
            $.get('/video/send-comment',ar,function(res){
                if(res.errno==0){
                    if(res.data.display==1){
                        commentNum();//本剧集评论数
                        commentstr(res.data.data);
                        ztBlack();
                        $(".alt-title").text(res.data.message);
                        $("#alt05").show();
                        $(that).parent().siblings('textarea').val("");
                    }else{
                        $(".alt-title").text(res.data.message);
                        $("#alt05").show();
                    }
                }
            });
        }
    });

    function commentstr(data){
        var html = "";
        var avatarstr = "";
        if(data['avatar']!=""){
            avatarstr = '<img src="'+data['avatar']+'" />';
        }else{
            avatarstr = '<img src="/images/newindex/logon.png" />';
        }
        var genderstr = "";
        if(data['gender']==1){
            genderstr = '<img src="/images/newindex/nv.png" />';
        }else if(data['gender']==2){
            genderstr = '<img src="/images/newindex/nan.png" />';
        }
        html = '<div class="div-commentlist">'+
                    '<ul class="per-now-box ul-box" name="zt">'+
                        '<li class="per-now-h">'+
                            '<div class="navTopLogonImg">'+
                                '<a href="/video/other-home?uid='+data['uid']+'">'+avatarstr+'</a>'+
                            '</div>'+
                            '<div class="navTopLogon-GRXX" name="zt">'+
                                '<div class="navTopLogon-GRXX-box">'+
                                    '<ul class="navTopLogon-box01">'+
                                        '<li class="navTopLogon-name"><img src="/images/newindex/VIP-1.png" />'+data['nickname']+'</li>'+
                                        '<li class="navTopLogon-Gender">'+genderstr+'</li>'+
                                    '</ul>'+
                                    '<ul class="navTopLogon-box02">'+
                                        '<li class="navTopLogon-rank">LV.<span>1</span></li>'+
                                        '<li class="navTopLogon-icon01"><img src="/images/newindex/jinbi.png" /></li>'+
                                        '<li class="navTopLogon-text">0</li>'+
                                    '</ul>'+
                                '</div>'+
                                '<ul class="navTopLogon-box03">'+
                                    '<li>'+
                                        '<a class="navTopLogon-A" href="/video/other-home?uid='+data['uid']+'">个人主页</a>'+
                                    '</li>'+
                                    '<li></li>'+
                                '</ul>'+
                            '</div>'+
                        '</li>'+
                        '<li >'+
                            '<div class="per-now-box-01">'+
                                '<div>'+data['nickname']+'</div>'+
                                '<img src="/images/newindex/lv_1.png" />'+
                            '</div>'+
                            '<div class="per-now-box-02" name="zt">'+data['content']+'</div>'+
                            '<ul class="per-now-box-03" name="zt">'+
                                '<li>'+data['created_time']+'</li>'+
                                '<li>'+
                                    '<input class="per-btn-z" type="button" name="" onclick="addlikes('+data['comment_id']+',this);" value="" />'+
                                    '<span>'+data['likes_num']+'</span>'+
                                '</li>'+
                                '<li><input class="per-btn-reply" type="button" name="" onclick="showreply('+data['comment_id']+',this);" value="回复" /></li>'+
                            '</ul>'+
                        '</li>'+
                    '</ul>'+
                '</div>';
        $("#comment-part .div-commenttab").after(html);
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
                '<input class="GNbox-Btnfs" type="button" name="" onclick="sendreply('+id+');" value="发送" />' +
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
        ar['chapter_id'] = '<?=$data['info']['play_chapter_id']?>';
        ar['pid'] = pid;
        var content = $("#addreplydiv").find('textarea').eq(0).val();
        ar['content'] = content;
        if(content==""){
            $(".alt-title").text("请填写评论");
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
            avatarstr = '<img src="/images/newindex/logon.png" />';
        }
        var genderstr = "";
        if(data['gender']==1){
            genderstr = '<img src="/images/newindex/nv.png" />';
        }else if(data['gender']==2){
            genderstr = '<img src="/images/newindex/nan.png" />';
        }
        html = '<ul class="per-now-box ul-box" name="zt">'+
                    '<li class="per-now-h">'+
                        '<div class="navTopLogonImg">'+
                            '<a href="/video/other-home?uid='+data['uid']+'">'+avatarstr+'</a>'+
                        '</div>'+
                        '<div class="navTopLogon-GRXX" name="zt">'+
                            '<div class="navTopLogon-GRXX-box">'+
                                '<ul class="navTopLogon-box01">'+
                                    '<li class="navTopLogon-name">'+
                                        '<img src="/images/newindex/VIP-1.png" />'+data['nickname']+
                                    '</li>'+
                                    '<li class="navTopLogon-Gender">'+genderstr+'</li>'+
                                '</ul>'+
                                '<ul class="navTopLogon-box02">'+
                                    '<li class="navTopLogon-rank">LV.<span>1</span></li>'+
                                    '<li class="navTopLogon-icon01"><img src="/images/newindex/jinbi.png" /></li>'+
                                    '<li class="navTopLogon-text">0</li>'+
                                '</ul>'+
                            '</div>'+
                            '<ul class="navTopLogon-box03">'+
                                '<li>'+
                                    '<a class="navTopLogon-A" href="/video/other-home?uid='+data['uid']+'">个人主页</a>'+
                                '</li>'+
                                '<li></li>'+
                            '</ul>'+
                        '</div>'+
                    '</li>'+
                    '<li >'+
                        '<div class="per-now-box-01">'+
                            '<div>'+data['nickname']+'</div>'+
                            '<img src="/images/newindex/lv_1.png" />'+
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
        var order = $(".per-tab-comment li.act").attr("data-order");
        var ar = {};
        ar['video_id'] = '<?=$data['info']['play_video_id']?>';
        ar['chapter_id'] = '<?=$data['info']['play_chapter_id']?>';
        ar['page_num'] = page_num;
        ar['order'] = order;
        $.get('/video/comment-more',ar,function(res){
            $("#comment-more").before(res);//添加评论列表
            ztBlack();
            if(total==0 || total == page_num+1){
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
                if(total == page_num+1){
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
                avatarstr = '<img src="/images/newindex/logon.png" />';
            }
            var genderstr = "";
            if(data[i]['gender']==1){
                genderstr = '<img src="/images/newindex/nv.png" />';
            }else if(data[i]['gender']==2){
                genderstr = '<img src="/images/newindex/nan.png" />';
            }
            html += '<ul class="per-now-box ul-box" name="zt">'+
                        '<li class="per-now-h">'+
                            '<div class="navTopLogonImg">'+
                                '<a href="/video/other-home?uid='+data[i]['uid']+'">'+avatarstr+'</a>'+
                            '</div>'+
                            '<div class="navTopLogon-GRXX" name="zt">'+
                                '<div class="navTopLogon-GRXX-box">'+
                                    '<ul class="navTopLogon-box01">'+
                                        '<li class="navTopLogon-name">'+
                                            '<img src="/images/newindex/VIP-1.png" />'+data[i]['nickname']+
                                        '</li>'+
                                        '<li class="navTopLogon-Gender">'+genderstr+'</li>'+
                                    '</ul>'+
                                    '<ul class="navTopLogon-box02">'+
                                        '<li class="navTopLogon-rank">LV.<span>1</span></li>'+
                                        '<li class="navTopLogon-icon01"><img src="/images/newindex/jinbi.png" /></li>'+
                                        '<li class="navTopLogon-text">0</li>'+
                                    '</ul>'+
                                '</div>'+
                                '<ul class="navTopLogon-box03">'+
                                    '<li>'+
                                        '<a class="navTopLogon-A" href="/video/other-home?uid='+data[i]['uid']+'">个人主页</a>'+
                                    '</li>'+
                                    '<li></li>'+
                                '</ul>'+
                            '</div>'+
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
    $(".per-tab-comment li").click(function(){
        var that = this;
        var page_num = 0;
        var total = ($("#comment-total").val()!="")?parseInt($("#comment-total").val()):0;
        var order = $(this).attr("data-order");
        var ar = {};
        ar['video_id'] = '<?=$data['info']['play_video_id']?>';
        ar['chapter_id'] = '<?=$data['info']['play_chapter_id']?>';
        ar['page_num'] = page_num;
        ar['order'] = order;
        $.get('/video/comment-more',ar,function(res){
            $("#comment-part .div-commentlist").remove();
            $("#comment-more").before(res);//添加评论列表
            $(that).addClass("act").siblings().removeClass("act");
            ztBlack();
            if(total==0 || total == page_num+1){
                $("#comment-more").hide();
            }else{
                $("#comment-more").show();
                $("#comment-current").val(++page_num);
            }
        });
    });
    //chapterId评论数
    function commentNum(){
        var value = $(".rBtn-01").find('input').val();
        var num = parseInt(value!='' ? value : 0 )+1;
        $(".rBtn-01").find('input').val(num);
        $("#GNbox-PL").find('span').html("("+num+")");
    }
</script>