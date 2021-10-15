<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

//$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子tv,澳洲瓜子tv,新西兰瓜子tv,澳新瓜子tv,瓜子视频,瓜子影视,电影,电视剧,榜单,综艺,动画,记录片']);
//$this->title = '首页';
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

    <!--首页分类列表-->
    <div class="sort" name="zt">
        <div class="sortBox">
            <ul class="sort-menu" name="zt">
                <?php if(!empty($channels)) : ?>
                    <?php foreach ($channels['list'] as $key => $channel): ?>
                        <?php if($channel['channel_name'] == '首页'): ?>
                            <li>
                                <a href="<?= Url::to(['/video/index'])?>" >
                                    <?= $channel['channel_name']?>
                                </a>
                            </li>
                            <li><a href="https://sport.rysp.tv" target="_blank">体育直播</a></li>
                        <?php else : ?>
                            <li>
                                <a href="<?= Url::to(['video/channel', 'channel_id' => $channel['channel_id']])?>">
                                    <span><?= $channel['channel_name']?></span>
                                    <? if($channel['num'] != 0) : ?>
                                        <span class="sortSpan"><?=$channel['num']?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach ?>
                <?php endif;?>
            </ul>

            <ul class="sort-recommend" name="zt">
                <?php foreach ($hotword['tab'] as $key => $tab): ?>
                    <?php if($key == 0) :?>
                        <?php foreach ($tab['list'] as $key => $list): ?>
                            <li>
                                <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                                    <span><?= $list['video_name']?> </span>
                                    <? if($list['num'] != 0) : ?>
                                        <span class="sortSpan"><?=$list['num']?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endforeach;?>
                    <?php endif;?>
                <?php endforeach;?>
            </ul>

            <ul class="sort-link">
                <li>
                    <a href="javascript:;" onclick="showwarning();">
                        <div class="VIPlink">
                            &nbsp;
                        </div>
                        <div class="sortLinkText">
                            VIP
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?= Url::to(['/video/adcenter'])?>">
                        <div class="ADlink">
                            &nbsp;
                        </div>
                        <div class="sortLinkText">
                            广告
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" onclick="showwarning();">
                        <div class="APPlink">
                            &nbsp;
                        </div>
                        <div class="sortLinkText">
                            APP
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" onclick="showwarning();">
                        <div class="TsetLink">
                            &nbsp;
                        </div>
                        <div class="sortLinkText">
                            儿童
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
<?php if (!empty($data['label'])) :?>
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
                <ul class="Movie-box" name="zt">
                    <li class="Title-02">
                        <img src="/images/newindex/logo-02.png" />
                        <a href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag])?>"><?= $labels['title']?></a>
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
                        <img src="/images/newindex/logo-02.png" />
                        <a href="<?= Url::to(['hot-play', 'channel_id' => $channel])?>">
                            <?= $channelName?>排行榜
                        </a>
                    </li>
                    <!--电影排行榜-->
                    <li class="Movie-Ranking" name="zt">
                        <?php foreach ($hotword['tab'] as $key => $tab): ?>
                            <?php if($tab['title'] == $channelName) :?>
                                <?php foreach ($tab['list'] as $key => $list): ?>
                                    <?php if($key < 9) :?>
                                        <!--排名前9-->
                                        <div class="Ranking-box">
                                            <div class="Ranking-mun">
                                                <?= $key+1?>
                                            </div>
                                            <div class="Ranking-text">
                                                <div class="Ranking-name" name="zt">
                                                    <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"><?= $list['video_name']?></a>
                                                </div>
                                                <div class="Ranking-type" name="zt">
                                                    <?php foreach (explode(' ',$list['category']) as $category): ?>
                                                        <div>
                                                            <?= $category?>
                                                        </div>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                            <div class="Ranking-score">
                                                <?= $list['score']?>
                                            </div>
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
                                    <div class="oth-time">
                                        <!--评分-->
                                        <?= $list['score']?>
                                    </div>
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
                                <a class="Movie-name02" name="zt" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
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
                <ul class="Sports-box" name="zt">
                    <li class="Title-01">
                        <img src="/images/newindex/logo-02.png" />
                        <a href="<?= Url::to(['list', 'channel_id' => $channel, 'tag' => $tag])?>"><?= $labels['title']?></a>
                    </li>
                    <?php foreach ($labels['list'] as $key => $list): ?>
                        <?php if($key < 8) :?>
                            <li class="Movie-list">
                                <a class="Movie" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                                    <img class="Movie-img i_background_errorimg" src="<?= $list['cover']?>" />
                                    <div class="oth-time">
                                        <!--评分-->
                                        <?= $list['score']?>
                                    </div>
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
                                <a class="Movie-name02" name="zt" href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
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
        <?php  else: ?>
            <div class="play-box video-add-column">
                <a href="<?=$labels['ad_skip_url']?>" target="_blank">
                    <img src="<?=$labels['ad_image']?>" alt="">
                </a>
            </div>
        <?php endif; ?>
    <?php endforeach;?>
<?php endif; ?>