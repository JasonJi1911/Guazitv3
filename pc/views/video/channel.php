<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

//$this->title = '';
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
                slidesPerView: 7,
            },
        }
    });
});
SCRIPT;

$this->registerJs($js);
?>
<!--首页大轮播-->
<div id="playBox" class="play-box">
    <!--图片列表-->
    <div id="imgList" style="background-color:#000;">
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
                <?php foreach ($data['banner'] as $banner): ?>
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
</div>

<!--分类列表-->
<div class="sort02" name="zt">
    <?php foreach ($info['search_box'] as $cates): ?>
<!--        --><?php //if($cates['label'] == '排序') : ?>
<!--            <div class="sort-box02">-->
<!--                <div class="sort-tle">-->
<!--                    排序-->
<!--                </div>-->
<!--                <div class="sort-list">-->
<!--                    --><?php //foreach ($cates['list'] as $key => $cate): ?>
<!--                        <a class="sort-a" href="--><?//= Url::to(['list', 'channel_id' => $channel_id, $cates['field'] => $cate['value']])?><!--">--><?//= $cate['display']?><!--</a>-->
<!--                    --><?php //endforeach;?>
<!--                </div>-->
<!--            </div>-->
        <?php  if($cates['label'] == '地区'): ?>
        <div class="sort-box02">
            <div class="sort-tle">
                地区
            </div>
            <div class="sort-list">
                <?php foreach ($cates['list'] as $key => $cate): ?>
                    <?php if($key < 10) :?>
                        <a href="<?= Url::to(['list', 'channel_id' => $channel_id, $cates['field'] => $cate['value']])?>"><?= $cate['display']?></a>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>
        <?php  elseif($cates['label'] == '类型'): ?>
            <div class="sort-box02">
                <div class="sort-tle">
                    分类
                </div>
                <div class="sort-list">
                    <?php foreach ($cates['list'] as $key => $cate): ?>
                        <?php if($key < 14) :?>
                            <a href="<?= Url::to(['list', 'channel_id' => $channel_id, $cates['field'] => $cate['value']])?>"><?= $cate['display']?></a>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            </div>
        <?php  elseif($cates['label'] == '年代'): ?>
            <div class="sort-box02">
                <div class="sort-tle">
                    年份
                </div>
                <div class="sort-list">
                    <?php foreach ($cates['list'] as $key => $cate): ?>
                        <?php if($key < 10) :?>
                            <a href="<?= Url::to(['list', 'channel_id' => $channel_id, $cates['field'] => $cate['value']])?>"><?= $cate['display']?></a>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            </div>
        <?php endif;?>
    <?php endforeach;?>
</div>
<!--视频列表-->
<?php if($data['video_update']['video_update']):?>
    <ul class="NewTrailer-box-title movie-update">
        <li class="Title-01">
            <a href="javascript:;" class="J_movie_update_week" data-value=""><?=$data['video_update']['video_update_title']['title']?></a>
            <div class="movie-update-time">
                <span class="movie-update-week J_movie_update_week" data-value="1">周一</span><span>|</span>
                <span class="movie-update-week J_movie_update_week" data-value="2">周二</span><span>|</span>
                <span class="movie-update-week J_movie_update_week" data-value="3">周三</span><span>|</span>
                <span class="movie-update-week J_movie_update_week" data-value="4">周四</span><span>|</span>
                <span class="movie-update-week J_movie_update_week" data-value="5">周五</span><span>|</span>
                <span class="movie-update-week J_movie_update_week" data-value="6">周六</span><span>|</span>
                <span class="movie-update-week J_movie_update_week" data-value="7">周日</span>
            </div>
        </li>
    </ul>
    <div class="ss-no-update J_update_empty" name="zt" style="display: none;">
        <h2 class="per-zw-new" name="zt" >
            暂无更新，快去看看精彩视频吧~
        </h2>
    </div>
    <ul class="NewTrailer-box J_video_update_content">
        <?php foreach ($data['video_update']['video_update'] as $list): ?>
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
                <?php if(is_int($key/7)):?>
                    <div class="Movie-page">
                        <img src="/images/Index/left.png" />
                    </div>
                <?php endif;?>
                <?php if(is_int(($key+1)/7)):?>
                    <div class="Movie-page">
                        <img src="/images/Index/right.png" />
                    </div>
                <?php endif;?>
            </a>
            <a class="Movie-name02" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                <?= $list['video_name']?>
            </a>
            <div class="Movie-type02" name="zt">
                <div>
                    <?php foreach (explode(' ',$list['category']) as $category): ?>
                        <span><?= $category?></span>
                    <?php endforeach;?>
                </div>
                <div><?= $list['flag']?></div>
            </div>
        </li>
        <!--详情弹出层,默认隐藏-->
        <div class="alt alt03" id="alt03<?= $list['video_id']?>">
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
        <?php endforeach;?>
    </ul>
</ul>
<?php endif;?>
<?php if (!empty($data['label'])) :?>
    <?php foreach ($data['label'] as  $labels): ?>
        <?php if (!isset($labels['advert_id'])) : ?>
            <?php
            $tag = '';
            $channel = '';
            $year = '';
            $area = '';
            foreach ($labels['search'] as $s_k => $s_v) {
                if($s_v['field'] == 'channel_id') {
                    $channel = $s_v['value'];
                }
                if($s_v['field'] == 'tag') {
                    $tag = $s_v['value'];
                }
//                if($s_v['field'] == 'year') {
//                    $year = $s_v['value'];
//                }'year' => $year,
                if($s_v['field'] == 'area') {
                    $area = $s_v['value'];
                }
            }
            ?>
            <ul class="Sports-box" name="zt">
                <li class="Title-01">
<!--                    <img src="/images/newindex/logo-02.png" />-->
                    <a href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag, 'area' => $area])?>" class="margin_r5" >
                        <?= $labels['title']?>
                    </a>
                    <?php foreach ($data['tags'] as $k => $t): ?>
                        <?php if(!empty($t['cat_id'])) : ?>
                            <a class="Title-more margin_l5" href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $t['cat_id'], 'area' => $area])?>"><?=$t['name']?></a>
                            <div class="channel-title-shu margin_l5">|</div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <a class="Title-more" href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag, 'area' => $area])?>">更多></a>
                </li>
                <?php foreach ($labels['list'] as $key => $list): ?>
                    <?php if($key < 7) :?>
                    <li class="Movie-list">
                        <a class="Movie" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                            <img class="Movie-img i_background_errorimg" src="<?= $list['cover']?>" />
<!--                            <div class="oth-time">-->
                                <!--评分-->
<!--                                --><?//= $list['score']?>
<!--                            </div>-->
                            <div class="palyBtn">
                                <img src="/images/newindex/bofang.png" />
                            </div>
                            <div class="Movie-details" name="zt">
                                <div class="Movie-name01" name="zt">
                                    <?= $list['video_name']?>
                                </div>
                                <ul class="Movie-type" name="zt">
                                    <?php foreach (explode(' ',$list['category']) as $category): ?>
                                        <li><?= $category?></li>
                                    <?php endforeach;?>
                                </ul>
                                <div class="Movie-star" name="zt">
                                    主演：
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
<!--                            <div class="Movie-J">-->
<!--                                <img src="/images/newindex/tuijian.png" />-->
<!--                            </div>-->
<!--                            <div class="Movie-X">-->
<!--                                新-->
<!--                            </div>-->
                        </a>
                        <a class="Movie-name02" name="zt" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"><?= $list['video_name']?></a>
                        <div class="Movie-type02" name="zt">
                            <div>
                                <?php foreach (explode(' ',$list['category']) as $category): ?>
                                    <span><?= $category?></span>
                                <?php endforeach;?>
                            </div>
                            <div>
                                <?= $list['flag']?>
                            </div>
                        </div>
                    </li>

                        <!--详情弹出层,默认隐藏-->
                        <div class="alt alt03" id="alt03<?= $list['video_id']?>">
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
                                            <input type="button" value="收藏" onclick="addfavors(<?=$list['video_id']?>)"  />
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
                                <input class="alt-GB" type="button" id="" value="X" />
                            </div>
                        </div>
                    <?php endif;?>
                <?php endforeach;?>
            </ul>
<!--        --><?php // else: ?>
<!--            <div class="play-box video-add-column">-->
<!--                <a href="--><?//=$labels['ad_skip_url']?><!--" target="_blank">-->
<!--                    <img src="--><?//=$labels['ad_image']?><!--" alt="">-->
<!--                </a>-->
<!--            </div>-->
        <?php endif; ?>
    <?php endforeach;?>
<?php endif; ?>
<div style="margin-top: 30px;"></div>
<script>
    //获取更新列表
    var is_click = true;
    $('.J_movie_update_week').click(function(){
        if(!is_click){
            return false;
        }
        var week = $(this).attr('data-value');
        var arr = {};
        arr['channel_id'] = <?=$channel_id?>;
        arr['week'] = week;
        is_click = false;
        $.get('/video/video-update', arr, function (res) {
            is_click = true;
            if(res['data']['video_update'].length == 0){
                $('.J_update_empty').show();
                $('.J_video_update_content').hide();
            } else {
                $('.J_update_empty').hide();
                $('.J_video_update_content').show();
                html = updateContent(res['data']['video_update']);
                $('.J_video_update_content').html(html);
            }
        })
    });

    function updateContent(list){
        var html = '';
        for(var i=0;i<list.length;i++) {
            var catstr = "";
            var catstr1 = "";
            var cat = list[i]['category'].split(' ');
            for (var k = 0; k < cat.length; k++) {
                catstr += '<li>' + cat[k] + '</li>';
                catstr1 += '<span>' + cat[k] + '</span>';
            }
            var actorstr = "";
            for (var k = 0; k < list[i]['actors'].length; k++) {
                actorstr += '<span>' + list[i]['actors'][k]['actor_name'] + '</span>';
            }
            var directorstr = "";
            for (var k = 0; k < list[i]['director'].length; k++) {
                directorstr += '<span>' + list[i]['director'][k]['actor_name'] + '</span>';
            }
            html += '<li class="Movie-list">\n' +
                '                <a class="Movie" href="/video/detail?video_id='+list[i]['video_id']+'">\n' +
                '                    <img class="Movie-img i_background_errorimg" src="'+list[i]['cover']+'">\n' +
                '                    <div class="palyBtn">\n' +
                '                        <img src="/images/newindex/bofang.png">\n' +
                '                    </div>\n' +
                '                    <div class="Movie-details" name="zt">\n' +
                '                        <div class="Movie-name01" name="zt">\n' +
                '                            '+list[i]['video_name']+'                              </div>\n' +
                '                        <ul class="Movie-type" name="zt">\n' + catstr +
                '                        </ul>\n' +
                '                        <div class="Movie-star" name="zt">\n' +
                '                            主演：\n' +actorstr+
                '                        </div>\n' +
                '                        <div class="Movie-content" name="zt">\n' +
                '                            简介：\n' +
                '                            <span>'+list[i]['intro']+'</span>\n' +
                '                        </div>\n' +
                '                        <ul class="Movie-btm" name="zt">\n' +
                '                            <li>'+list[i]['play_times']+'</li>\n' +
                '                            <li><input class="XQ" type="button" value="详情" onclick="XQ('+list[i]['video_id']+')"></li>\n' +
                '                        </ul>\n' +
                '                    </div>\n' +
                '                </a>\n' +
                '                <a class="Movie-name02" name="zt" href="/video/detail?video_id='+list[i]['video_id']+'">'+list[i]['video_name']+'</a>\n' +
                '                <div class="Movie-type02" name="zt">\n' +
                '                   <div>'+catstr1+'</div>\n'+
                '                   <div>'+list[i]['flag']+'</div>\n'+
                '                </div>\n' +
                '            </li>\n';
            '            <div class="alt alt03" id="alt03'+list[i]['video_id']+'">\n' +
            '                <div class="alt03-box" name="zt">\n' +
            '                    <div class="alt03-box-t">\n' +
            '                        <div class="alt03-box-R">\n' +
            '                            <img class="i_background_errorimg" src="'+list[i]['cover']+'">\n' +
            '                        </div>\n' +
            '                        <div class="alt03-box-L">\n' +
            '                            <a class="XQ-name" name="zt" href="/video/detail?video_id='+list[i]['video_id']+'">'+list[i]['video_name']+'</a>\n' +
            '                            <div class="GNbox">\n' +
            '                                <div class="GNbox-type" name="zt">\n' +catstr1+
            '                                </div>\n' +
            '                                <div class="GNbox-RD" name="zt">\n' +list[i]['play_times']+
            '                                </div>\n' +
            '                                <div class="GNbox-PF">\n' +
            '                                    <span></span>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                            <ul class="XQ-text">\n' +
            '                                <li>年代:<span>'+list[i]['year']+'</span></li>\n' +
            '                                <li>导演:'+directorstr+'</li>' +
            '                                <li>主演:'+actorstr+'</li>\n'+
            '                            </ul>\n' +
            '                            <div class="XQ-btn" name="zt">\n' +
            '                                <a href="/video/detail?video_id='+list[i]['video_id']+'">播放</a>\n' +
            '                                <input type="button" value="收藏" onclick="addfavors('+list[i]['video_id']+')">\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                    <p class="alt03-box-Z">\n' +
            '                        简介：<span>'+list[i]['intro']+'</span>\n' +
            '                    <input class="alt-GB" type="button" id="" value="X">\n' +
            '                </div>\n' +
            '            </div>';
        }
        return html;
    }

    //按城市加载广告
    $(function () {
        advertByCity('channel');
    });
</script>
