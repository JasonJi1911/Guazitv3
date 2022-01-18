<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

//$this->title = '';
NewIndexStyleAsset::register($this);
?>
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
                    <?php if($key < 6) :?>
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
                        <?php if($key < 8) :?>
                            <a href="<?= Url::to(['list', 'channel_id' => $channel_id, $cates['field'] => $cate['value']])?>"><?= $cate['display']?></a>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            </div>
        <?php endif;?>
    <?php endforeach;?>
</div>
<!--视频列表-->
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
                    <a href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag, 'area' => $area])?>">
                        <?= $labels['title']?>
                    </a>
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
        <?php  else: ?>
            <div class="play-box video-add-column">
                <a href="<?=$labels['ad_skip_url']?>" target="_blank">
                    <img src="<?=$labels['ad_image']?>" alt="">
                </a>
            </div>
        <?php endif; ?>
    <?php endforeach;?>
<?php endif; ?>
