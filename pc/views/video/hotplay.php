<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

//$this->title = '排行榜';
NewIndexStyleAsset::register($this);

$js = <<<JS
$(function(){
    $(document).ready(function() {
        var channelid = $("#v_channelid").val();
        if(channelid != '' ){
            //v_navi v_ranbox
            var ranTabNum = $(this).index();
            $("#v_navi"+channelid).addClass("act").siblings().removeClass("act");
            $("#v_ranbox"+channelid).addClass("act").siblings().removeClass("act");
        }
    });
});
JS;

$this->registerJs($js);
?>

<style>
    body{
        background-color: #F9F9F9;
    }
</style>
<!--排行榜标题-->
<div class="RANbox-title">
    <input id="v_channelid" type="hidden" value="<?=$channel_id?>" />
    <div class="RANbox-title-icon">
        <img src="/images/hotPlay/paihang-1.png" />
    </div>
    <div class="RANbox-title-name">
        —— 瓜子tv热播榜 ——
    </div>
    <ul class="RANbox-tab">
        <li id="v_navi0" class="act">全站榜</li>
        <?php if(!empty($channels)) :?>
            <?php foreach ($channels['list'] as $channel) :?>
                <?php if($channel['channel_id'] != 0 && $channel['channel_id'] != '32' && $channel['channel_id'] != '39') :?>
                    <li  id="v_navi<?=$channel['channel_id']?>" >
                        <?= $channel['channel_name']?>
                    </li>
                <?php endif;?>
            <?php endforeach;?>
        <?php endif;?>
    </ul>
</div>
<div class="RANbox">
    <!--全站榜-->
    <div class="RANbox-box01 act" id="v_ranbox0">
        <!--排行榜样式-->
        <?php if (!empty($data['label'])) :?>
            <?php foreach ($data['label'] as  $labels): ?>
                <?php if (!isset($labels['advert_id'])) : ?>
                    <?php  $channel = '';
                    foreach ($labels['search'] as $s_k => $s_v) {
                        if($s_v['field'] == 'channel_id') {
                            $channel = $s_v['value'];
                        }
                    } ?>
                    <? if($channel != '32' && $channel != '39') :?>
                    <div class="RAN">
                        <div class="RAN-t">
                            <div class="RAN-name">
                                <?= $labels['title']?>
                            </div>
                            <ul class="RAN-date">
<!--                                <li class="act">周</li>-->
<!--                                <li>月</li>-->
<!--                                <li>年</li>-->
                            </ul>
                        </div>
                        <?php foreach ($labels['list'] as $key => $list): ?>
                            <?php if($key < 3){?>
                                <div class="RAN-z">
                                    <ul class="RAN-z-box01">
<!--                                        <li class="clr0--><?//=$key+1?><!--">--><?//=$key+1?><!--</li>-->
                                        <li><img class="Movie-Ranking-img" src="/images/hotPlay/<?= $key+1?>.png"></li>
                                        <li>
                                            <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                                                <img class="i_background_errorimg" src="<?= $list['cover']?>" />
                                            </a>
                                        </li>
                                        <li>
                                            <a class="RAN-z-box01-name" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"><?= $list['video_name']?></a>
                                            <div class="GNbox-type">
                                                <?php foreach (explode(' ',$list['category']) as $category): ?>
                                                    <span><?= $category?></span>
                                                <?php endforeach;?>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="RAN-z-box02">
                                        <div class="RAN-z-box02-L">
                                            <?= str_replace(["播放:","热度:"],["",""],$list['play_times'])?>
                                        </div>
<!--                                        <div class="RAN-z-box02-R"></div>-->
<!--                                        <div class="RAN-z-box02-R">-->
<!--                                            --><?//= $list['score']?>
<!--                                        </div>-->
                                    </div>
                                </div>
                            <?php }else if($key < 10){?>
                                <div class="RAN-b">
                                    <ul>
<!--                                        <li>--><?//=$key+1?><!--</li>-->
                                        <li><img class="Movie-Ranking-img-num" src="/images/hotPlay/<?= $key+1?>.png"></li>
                                        <li>
                                            <a class="RAN-z-box01-name" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"><?= $list['video_name']?></a>
                                        </li>
                                        <li></li>
<!--                                        <li>--><?//= $list['score']?><!--</li>-->
                                    </ul>
                                </div>
                            <?php } ?>
                        <?php endforeach;?>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach;?>
        <?php endif; ?>
    </div>
    <!--电影榜(单榜)-->
    <?php if (!empty($data['label'])) :?>
        <?php foreach ($data['label'] as  $labels): ?>
            <?php if (!isset($labels['advert_id'])) : ?>
                <?php  $channel = '';
                foreach ($labels['search'] as $s_k => $s_v) {
                    if($s_v['field'] == 'channel_id') {
                        $channel = $s_v['value'];
                    }
                } ?>
                <? if($channel != '32') :?>
                <div class="RANbox-box02" id="v_ranbox<?=$channel?>">
                    <?php foreach ($labels['list'] as $key => $list): ?>
                        <?php if($key < 10) { ?>
                        <div class="RANbox-content">
                            <div class="RANbox-list01">
                                <img class="Movie-Ranking-img" src="/images/hotPlay/bangdan<?= $key+1?>.png">
<!--                                <div class="clr0--><?//= $key+1?><!--">-->
<!--                                    --><?//= $key+1?>
<!--                                </div>-->
                                <ul class="RANbox-list-xx">
                                    <li>
                                        <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                                            <img class="i_background_errorimg" src="<?= $list['cover']?>" />
                                        </a>
                                    </li>
                                    <li>
                                        <div class="RANbox-list01-t">
                                            <a class="RAN-z-box01-name" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"><?= $list['video_name']?></a>
                                        </div>
                                        <div class="GNbox-type">
                                            <?php foreach (explode(' ',$list['category']) as $category): ?>
                                                <span><?= $category?></span>
                                            <?php endforeach;?>
                                        </div>
                                        <div class="RANbox-list01-b">
                                            <div>
                                                年代:<span><?=$list['year']?></span>
<!--                                                添加:<span></span>-->
                                            </div>
                                            <div>导演:
                                                <span>
                                                    <?php if($list['director']):?>
                                                        <?php foreach ($list['director'] as $key => $director): ?>
                                                            <?php if($key == 0):?>
                                                                <?= $director['actor_name']?>
                                                            <?php else :?>
                                                                ,<?= $director['actor_name']?>
                                                            <?php endif;?>
                                                        <?php endforeach;?>
                                                    <?php endif;?>
                                                </span>
                                            </div>
                                            <div>主演:
                                                <span>
                                                    <?php foreach ($list['actors'] as $key => $actor): ?>
                                                        <?php if($key == 0):?>
                                                            <?= $actor['actor_name']?>
                                                        <?php else :?>
                                                            ,<?= $actor['actor_name']?>
                                                        <?php endif;?>
                                                    <?php endforeach;?>
                                                </span>
                                            </div>
                                            <div>
                                                <span>简介:</span>
                                                <span><?=$list['intro']?></span>
                                            </div>
                                            <div class="RAN-z-box02">
                                                <div class="RAN-z-box02-L">
                                                    <?= str_replace(["播放:","热度:"],["",""],$list['play_times'])?>
                                                </div>
                                            </div>
                                        </div>

                                    </li>
                                    <li>
                                        <div class="GNbox-button font-14"><a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">前往观看</a></div>
                                        <?php if($list['favorite']==0):?>
                                            <div class="GNbox-button font-14 GNbox-button-add" onclick="addCollect(<?=$list['video_id']?>,this)">添加收藏</div>
                                        <?php else:?>
                                            <div class="GNbox-button GNbox-button-collect font-14">已收藏</div>
                                        <?php endif;?>
                                    </li>
                                </ul>
<!--                                <div class="RANbox-list01-sj">-->
<!--                                    <ul class="SSjgPJ">-->
<!--                                        <li><span>0</span></li>-->
<!--                                        <li><span>0</span></li>-->
<!--                                        <li><span>0</span></li>-->
<!--                                        <li><span>--><?//= str_replace("播放:","",$list['play_times'])?><!--</span></li>-->
<!--                                        <li>--><?//=$list['score']?><!--</li>-->
<!--                                    </ul>-->
<!--                                </div>-->
                            </div>
                            <span class="RANbox-bottom-line"></span>
                        </div>
<!--                        --><?php //}elseif($key < 10){?>
<!--                            <div class="RANbox-content">-->
<!--                                <div class="RANbox-list02">-->
<!--                                    <ul>-->
<!--                                        <li>--><?//= $key+1?><!--</li>-->
<!--                                        <img class="Movie-Ranking-img" src="/images/hotPlay/bangdan--><?//= $key+1?><!--.png">-->
<!--                                        <li>-->
<!--                                            <a class="RAN-z-box01-name" href="--><?//= Url::to(['detail', 'video_id' => $list['video_id']])?><!--">--><?//= $list['video_name']?><!--</a>-->
<!--                                            <div class="GNbox-type">-->
<!--                                                --><?php //foreach (explode(' ',$list['category']) as $category): ?>
<!--                                                    <span>--><?//= $category?><!--</span>-->
<!--                                                --><?php //endforeach;?>
<!--                                            </div>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <ul class="SSjgPJ">-->
<!--                                                <li><span>0</span></li>-->
<!--                                                <li><span>0</span></li>-->
<!--                                                <li><span>0</span></li>-->
<!--                                                <li><span>--><?//= str_replace("播放:","",$list['play_times'])?><!--</span></li>-->
<!--                                                <li>--><?//=$list['score']?><!--</li>-->
<!--                                            </ul>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                                <span class="RANbox-bottom-line"></span>-->
<!--                            </div>-->
                        <?php } ?>
                    <?php endforeach;?>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach;?>
    <?php endif; ?>
</div>
<script>
    //收藏
    var favor_tab = true;
    function addCollect(videoid,obj){
        var uid = finduser();
        if(!isNaN(uid) && uid!=""){
            if(favor_tab){
                favor_tab = false;
                var arrindex = {};
                arrindex['videoid'] = videoid;
                console.log('获取我的收藏参数----',arrindex);
                $.get('/video/change-favorite',arrindex,function(res){
                    console.log('获取我的收藏结果----',res);
                    favor_tab = true;
                    if(res.errno==0){
                        $(obj).removeClass("GNbox-button-add").addClass("GNbox-button-collect");
                        $(obj).text("已收藏");
                    }
                });
            }
        }else{//弹框登录
            showloggedin();
        }
    };
</script>
