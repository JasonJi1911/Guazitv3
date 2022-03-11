<?php
use yii\helpers\Url;
?>
<input type="hidden" value="<?= $info['current_page']?>" id="parpage">
<input type="hidden" value="<?= $info['total_page']?>" id="parpages">
<input type="hidden" value="<?= $info['total_count']?>" id="parcount">
<input type="hidden" value="<?= $info['tvNum']?>" id="tvNum">
<!--关键字搜索结果列表-->
<div class="box04 haskeyword container">
    <!--搜索结果-->
    <?php foreach ($info['list'] as $list): ?>
    <?php
    $firstChap = $list['chapters'][0];
    ?>
    <div class="SSbox" name="zt">
        <a class="SSjgImg" href="<?= Url::to(['detail', 'video_id' => $firstChap['video_id'], 'chapter_id' => $firstChap['chapter_id'], 'source_id' => $firstChap['source_id']])?>">
            <img class="i_background_errorimg" src="<?= $list['cover']?>" />
        </a>
        <div class="SSjg">
            <div class="SSjgName" name="zt">
                <div class="SSjgTitle"><?= $list['channel_name']?></div>
                <a href="<?= Url::to(['detail', 'video_id' => $firstChap['video_id'], 'chapter_id' => $firstChap['chapter_id'], 'source_id' => $firstChap['source_id']])?>">
                    <span><?= $list['video_name']?></span>
                </a>
            </div>
<!--            <div class="SSjg-category">类型：-->
<!--                --><?php //foreach (explode(' ',$list['category']) as $category): ?>
<!--                    <span>--><?//= $category?><!--</span>-->
<!--                --><?php //endforeach;?>
<!--            </div>-->
            <p>类型：<?= $list['category']?></p>
<!--            <p>添加：--><?//= date("Y年m月d日",$list['created_at'])?><!--</p>-->
<!--            <p>导演：--><?//= str_replace("导演:","",$list['director']);?><!--</p>-->
<!--            <p>主演：-->
<!--                --><?//= substr(str_replace("演员:","/ ",$list['artist']),1);?>
<!--            </p>-->
            <p class="SSjgIntro">简介：<?= $list['intro']?></p>
            <div class="SSjgBox">
                <div>
                    <!--视频集数最多显示7集，超出中间用点表示-->
                    <div class="SSjgJS" name="zt">
                        <?php if(count($list['chapters'],0)<=$info['tvNum']) : ?>
                        <!--集数小于5 或者 7，正常全显示-->
                            <?php foreach ($list['chapters'] as $key => $chap): ?>
                                <?php $latest = "";
                                if($chap['latest']==1){
                                    $latest = "icon_spot";
                                }else{
                                    $latest = "";
                                }?>
                                <a class="<?=$latest?>" href="<?= Url::to(['detail', 'video_id' => $chap['video_id'], 'chapter_id' => $chap['chapter_id'], 'source_id' => $chap['source_id']])?>" title="<?= $chap['title'] ?>"><?= $chap['title'] ?></a>
                            <?php endforeach;?>
                        <?php else: ?>
                        <!--集数大于5或7-->
                            <?php if($info['tvNum']==5) : ?>
                                <!--显示5个，0 1 2 ... count-1-->
                                <?php foreach ($list['chapters'] as $key => $chap): ?>
                                    <?php $latest = "";
                                    if($chap['latest']==1){
                                        $latest = "icon_spot";
                                    }else{
                                        $latest = "";
                                    }?>
                                    <?php if($key == 2) {  ?>
                                        <a class="<?=$latest?>" href="<?= Url::to(['detail', 'video_id' => $chap['video_id'], 'chapter_id' => $chap['chapter_id'], 'source_id' => $chap['source_id']])?>" title="<?= $chap['title']?>" ><?= $chap['title'] ?></a>
                                        <a class="getnum" data-value="<?=$chap['video_id']?>" href="javascript:;">...</a>
                                    <?php }else if($key > 2 && $key < count($list['chapters'],0)-1){  ?>
                                        <a class="<?=$latest?> hiddennum<?=$chap['video_id']?> " style="display:none" href="<?= Url::to(['detail', 'video_id' => $chap['video_id'], 'chapter_id' => $chap['chapter_id'], 'source_id' => $chap['source_id']])?>" title="<?= $chap['title']?>" ><?= $chap['title'] ?></a>
                                    <?php }else{  ?>
                                        <a class="<?=$latest?>" href="<?= Url::to(['detail', 'video_id' => $chap['video_id'], 'chapter_id' => $chap['chapter_id'], 'source_id' => $chap['source_id']])?>" title="<?= $chap['title']?>" ><?= $chap['title'] ?></a>
                                    <?php } ?>
                                <?php endforeach;?>
                            <?php else: ?>
                                <!--显示7个，0 1 2 ... count-3 count-2 count-1-->
                                <?php foreach ($list['chapters'] as $key => $chap): ?>
                                    <?php $latest = "";
                                    if($chap['latest']==1){
                                        $latest = "icon_spot";
                                    }else{
                                        $latest = "";
                                    }?>
                                    <?php if($key == 2) {  ?>
                                        <a class="<?=$latest?>" href="<?= Url::to(['detail', 'video_id' => $chap['video_id'], 'chapter_id' => $chap['chapter_id'], 'source_id' => $chap['source_id']])?>" title="<?= $chap['title']?>" ><?= $chap['title'] ?></a>
                                        <a class="getnum" data-value="<?=$chap['video_id']?>" href="javascript:;">...</a>
                                    <?php }else if($key > 2 && $key < count($list['chapters'],0)-3){  ?>
                                        <a class="<?=$latest?> hiddennum<?=$chap['video_id']?> " style="display:none" href="<?= Url::to(['detail', 'video_id' => $chap['video_id'], 'chapter_id' => $chap['chapter_id'], 'source_id' => $chap['source_id']])?>" title="<?= $chap['title']?>" ><?= $chap['title'] ?></a>
                                    <?php }else{  ?>
                                        <a class="<?=$latest?>" href="<?= Url::to(['detail', 'video_id' => $chap['video_id'], 'chapter_id' => $chap['chapter_id'], 'source_id' => $chap['source_id']])?>" title="<?= $chap['title']?>" ><?= $chap['title'] ?></a>
                                    <?php } ?>
                                <?php endforeach;?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
<!--                <div>-->
<!--                    <ul class="SSjgPJ">-->
<!--                        <li><span>0</span></li>-->
<!--                        <li><span>0</span></li>-->
<!--                        <li><span>0</span></li>-->
<!--                        <li><span>--><?//= str_replace("热度:","",$list['total_views']);?><!--</span></li>-->
<!--                        <li>--><?//= $list['score']?><!--</li>-->
<!--                    </ul>-->
<!--                </div>-->
            </div>
        </div>
    </div>
    <?php endforeach;?>
</div>
<!--筛选结果列表  搜索条件关闭时显示-->
<ul class="Sports-box hiddenclass nokeyword container" name="zt" style="margin: 0 auto;">
    <?php foreach ($info['list'] as $list): ?>
        <li class="Movie-list">
            <a class="Movie" href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>">
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
                        <li><?= $list['total_views']?></li>
                        <!--                        <li><input class="XQ" type="button" id="" value="详情" /></li>-->
                    </ul>
                </div>
<!--                <div class="Movie-J">-->
<!--                    <img src="/images/newindex/tuijian.png" />-->
<!--                </div>-->
<!--                <div class="Movie-X">-->
<!--                    新-->
<!--                </div>-->
            </a>
            <a class="Movie-name02" name="zt" href="<?= Url::to(['/video/detail', 'video_id' => $list['video_id']])?>">
                <?= $list['video_name']?>
            </a>
            <div class="Movie-type02" name="zt">
                <div>
                    <?php foreach (explode(' ',$list['category']) as $category): ?>
                        <span><?= $category?></span>
                    <?php endforeach;?>
                </div>
                <div>
                    <?= $list['flag']?>&nbsp;&nbsp;&nbsp;
                </div>
            </div>
        </li>
    <?php endforeach;?>
</ul>
