<?php
use yii\helpers\Url;
?>

<input type="hidden" value="<?= $info['current_page']?>" id="parpage">
<input type="hidden" value="<?= $info['total_page']?>" id="parpages">
<input type="hidden" value="<?= $info['total_count']?>" id="parcount">
<?php if(!empty($info['list'])) { ?>
    <?php foreach ($info['list'] as $list): ?>
        <?php
        $firstChap = $list['chapters'][0];
        ?>
        <?php if($list['channel_id'] == '2') { ?>
            <div class="accordion-divider clearfix">
                <a class="img fl" style="display: block"
                   href="<?= Url::to(['detail', 'video_id' => $firstChap['video_id'], 'chapter_id' => $firstChap['chapter_id'], 'source_id' => $firstChap['source_id']])?>">
                    <img src="<?= $list['cover']?>">
                    <span><?= $list['flag']?></span>
                    <div class="zhezhao"></div>
                </a>
                <div class="text-span fl">
                    <a href="<?= Url::to(['detail', 'video_id' => $firstChap['video_id'], 'chapter_id' => $firstChap['chapter_id'], 'source_id' => $firstChap['source_id']])?>">
                        <h2><?= $list['video_name']?> <span> <?= $list['year']?></span></h2>
                    </a>
                    <p><span>主演:</span>
                        <?= str_replace("演员:","",$list['artist']);?>
                        <span> 导演: </span> <?= str_replace("导演:","",$list['director']);?>
                    </p>
                    <p><span>简介:</span><?= $list['intro'] ?></p>
                    <ul class="clearfix">
                        <?php foreach ($list['chapters'] as $key => $chap): ?>
                            <?php if($key < 19) { ?>
                                <li><a href="<?= Url::to(['detail', 'video_id' => $chap['video_id'], 'chapter_id' => $chap['chapter_id'], 'source_id' => $chap['source_id']])?>">
                                        <?= $key+1 ?>
                                    </a>
                                </li>
                            <?php } else { ?>
                                <li><a href="<?= Url::to(['detail', 'video_id' => $list['chapters'][0]['video_id'], 'chapter_id' => $list['chapters'][0]['chapter_id'], 'source_id' => $list['chapters'][0]['source_id']])?>">
                                        更多
                                    </a>
                                </li>
                                <?php break; } ?>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        <?php } else { ?>
            <div class="accordion-divider clearfix">
                <a class="img fl" style="display: block"
                   href="<?= Url::to(['detail', 'video_id' => $firstChap['video_id'], 'chapter_id' => $firstChap['chapter_id'], 'source_id' => $firstChap['source_id']])?>">
                    <img src="<?= $list['cover']?>">
                    <span><?= $list['flag']?></span>
                    <div class="zhezhao"></div>
                </a>
                <div class="text-span fl">
                    <a href="<?= Url::to(['detail', 'video_id' => $firstChap['video_id'], 'chapter_id' => $firstChap['chapter_id'], 'source_id' => $firstChap['source_id']])?>">
                        <h2><?= $list['video_name']?> <span> <?= $list['year']?></span></h2>
                    </a>
                    <p><span>主演:</span>
                        <?= str_replace("演员:","",$list['artist']);?>
                        <span> 导演: </span> <?= str_replace("导演:","",$list['director']);?>
                    </p>
                    <p><span>简介:</span><?= $list['intro']?></p>
                    <div class="bottom-grid-poa">
                        <ul>
                            <?php foreach ($list['chapters'] as $key => $chap): ?>
                                <?php if($key < 3) { ?>
                                    <li><a href="<?= Url::to(['detail', 'video_id' => $chap['video_id'], 'chapter_id' => $chap['chapter_id'], 'source_id' => $chap['source_id']])?>">
                                            <?= $chap['title'] ?>
                                        </a>
                                    </li>
                                <?php } else { ?>
                                    <li><a href="<?= Url::to(['detail', 'video_id' => $list['chapters'][0]['video_id'], 'chapter_id' => $list['chapters'][0]['chapter_id'], 'source_id' => $list['chapters'][0]['source_id']])?>">
                                            查看更多
                                        </a>
                                    </li>
                                    <?php break; } ?>
                            <?php endforeach;?>
                            <!--                                    <li class=""><a href="###">2021-01-02：第4期下：欧阳超立论惊呆杨</a></li>-->
                            <!--                                    <li><a href="###">2021-01-02：第4期下：欧阳超立论惊呆杨</a><span>新</span></li>-->
                            <!--                                    <li><a href="###">2021-01-02：第4期下：欧阳超立论惊呆杨</a></li>-->
                            <!--                                    <li><a href="###">查看更多</a></li>-->
                        </ul>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php endforeach;?>
<?php } ?>

