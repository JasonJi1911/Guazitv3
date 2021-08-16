<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;
use common\models\advert\AdvertPosition;

// $this->metaTags['keywords'] = '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片';
$this->registerMetaTag(['name' => 'keywords', 'content' => '吉祥tv,澳洲吉祥tv,新西兰吉祥tv,澳新吉祥tv,吉祥视频,吉祥影视,电影,电视剧,榜单,综艺,动画,记录片']);
// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = $data['info']['video_name'].'-吉祥TV - 澳新华人在线视频分享平台,海量高清视频在线观看';
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
    body,html{
        overflow-y: scroll !important;
    }
</style>
<!--黑色区域-->
<div class="box05">
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
                'source'            =>  $data['info']['all_source']
            ]);?>
        </div>
        <!--广告-->
        <div class="AD-02">
            <?php if(!empty($data['advert'])) :?>
                <?php foreach ($data['advert'] as $key => $advert): ?>
                    <?php if(!empty($advert) && intval($advert['position_id']) == intval(AdvertPosition::POSITION_VIDEO_TOP_PC)) :?>
                        <a href="<?=$advert['ad_skip_url']?>" target="_blank">
                            <img src="<?=$advert['ad_image']?>" onerror="this.src='/images/NewVideo/GG03.png'"/>
                        </a>
                    <?php else :?>
                        <img src="/images/NewVideo/GG03.png"/>
                    <?php endif;?>
                <?php endforeach;?>
            <?php endif;?>
        </div>
        <!--评论，点赞，差评等按钮-->
        <div class="BtnList">
            <ul class="BtnList-boxL">
                <li class="rBtn-01"><input type="button" id="" value="0"  onclick="window.location.href = '#GNbox-PL'" /></li>
                <li class="rBtn-02"><input type="button" id="" value="0" /></li>
                <li class="rBtn-03"><input type="button" id="" value="0" /></li>
                <li class="rBtn-04"><input type="button" id="" value="<?= $data['info']['total_views']?>" /></li>
                <li class="rBtn-05"><input type="button" id="" value="0" /></li>
                <li class="rBtn-06"><input type="button" id="" value="手机看" /></li>
                <li class="rBtn-07"><input type="button" id="err_feedback" value="片源报错" /></li>
            </ul>
        </div>

        <div class="Altsjk">
            <div class="Altsjk-01">
                扫一扫，手机观看更便捷
                <input class="GB" type="button" name="" id="" value="" />
            </div>
            <div class="Altsjk-02">
                <img src="/images/newindex/jxewm.png" />
                <div class="Altsjk-02-a">
<!--                    --><?//= Url::to(['/site/share-down'])?>
                    <a href="javascript:void(0);" onclick="showwarning();"><img src="/images/NewVideo/ipad.png" />iPhone客户端</a>
                    <a href="javascript:void(0);" onclick="showwarning();"><img src="/images/NewVideo/ipad.png" />iPad客户端</a>
                    <a href="javascript:void(0);" onclick="showwarning();"><img src="/images/NewVideo/anzhuo.png" />安卓客户端</a>
                </div>
            </div>
            <div class="Altsjk-03">
                没有吉祥视频APP？ <a href="<?= Url::to(['/site/share-down'])?>" target="_blank">立即下载</a>
            </div>
        </div>

        <!--博主信息-->
        <div class="BZbox02">
            <div class="BZtop">
                <div class="BZtx">
                    <a href="javascript:;"><img src="/images/NewVideo/logon.png" /></a>
                </div>
                <div class="BZname">
                    <a href="javascript:;">吉祥影视</a>
                    <img src="/images/NewVideo/nan.png" />
                    <img src="/images/NewVideo/nv.png" />
                </div>
                <div class="BZdz">
                    <!--                    <img class="lv" src="img/lv_1.png" />-->
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
                评论区<span>(3)</span>
            </div>
            <!--评论输入区-->
            <div class="GNbox-PLsr" name="zt">
                <div>
                    请在此发表意见
                </div>
                <textarea placeholder="注意，以下行为将被封号：严重剧透、发布广告、木马链接、宣传同类网站、辱骂工作人员等。"></textarea>
                <div class="GNbox-PL-box">
                    <input class="GNbox-Btnbq" type="button" name="" id="" value="" />
                    <input class="GNbox-Btntp" type="button" name="" id="" value="发起投票" />
                    <input class="GNbox-Btnfs" type="button" name="" id="" value="发送" />
                </div>
                <!--未登录时显示-->
                <div class="GNbox-PLsr-no" name="zt">
                    <div>
                        <!--您还未登录，请登录后发表评论<br />-->
                        功能暂未开放，敬请期待
                        <input type="button" name="" id="" value="登录" style="display: none;" />
                    </div>
                </div>
            </div>
            <!--评论留言位置-->
            <div class="GNbox-PL-text">
                <div class="GNbox-PL-no" style="display: none;">
                    功能暂未开放，敬请期待
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
                            <a href="javascript:;"><?= $list['video_name']?></a>
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
    <div class="alt04-box" name="zt" style="height:300px;">
        <div class="hlp-t03" name="zt">
            片源报错<!--<span class="clrOrangered">(您需要先登录才能提交反馈)</span>-->
        </div>
        <div class="seekbox02-text" name="zt">
            报错原因
        </div>
        <div class="seekbox-tta seek-bottom">
            <textarea placeholder="请输入报错原因 最多50字" name="zt" id="v_reason"></textarea>
        </div>

        <div class="seekbox-text03 seek-bottom" name="zt">
            <span id="v_feedresult" style="color:red;"></span>
            <input class="seek-btn" type="button" name="" id="v_feedsubmit" value="提交" />
        </div>
    </div>
    <!--关闭按钮-->
    <input class="alt-GB" type="button" id="" value="X" />
</div>
<script>
    //片源报错
    $('#err_feedback').click(function(){
        $("#alt04").show();
    })
    //提交
    $('#v_feedsubmit').click(function(){
        var feedUrl = "/video/feed-back";
        var feedIndex = {};
        feedIndex['video_id'] = "<?= $data['info']['play_video_id']?>";
        feedIndex['chapter_id'] = "<?= $data['info']['play_chapter_id']?>";
        feedIndex['source_id'] = "<?= $source_id?>";
        feedIndex['reason'] = $("#v_reason").val();
        $.get(feedUrl, feedIndex ,function(response) {
            var result = response.data;
            $("#v_feedresult").text(result.message);
            // alert(result.message);
        });
        //console.log(feedIndex);
        // alert("功能维护中，敬请期待")
    })

</script>