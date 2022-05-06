<?php
use yii\helpers\Url;
?>
<?php foreach ($data as $i => $watchdate):?>
    <?php if($data[$i-1]['date']!=$watchdate['date'] && $watchdate['date']!=$timetitle):?>
        <div class="text-left font14 fontW7 h08 w-time plr15"><?=$watchdate['date']?></div>
    <?php endif;?>
    <div class="position-r plr15">
        <?php foreach ($watchdate['list'] as $video):?>
            <label class="position-r">
                <div class="w-video position-r <?php if($tab=="取消"):?>w-video-edit<?php endif;?>">
                    <div class="w-checkbox" <?php if($tab=="取消"):?>style="display: block;" <?php endif;?>>
                        <input type="checkbox" name="w-video-checkbox" data-id="<?=$video['log_id']?>"/>
                    </div>
                    <div>
                        <a href="<?= Url::to(['detail', 'video_id' => $video['video_id']])?>">
                            <img src="<?=$video['cover']?>">
                        </a>
                    </div>
                    <div class="position-r w-video-detail">
                        <div class="font14 h05" style="height: auto;">
                            <a href="<?= Url::to(['detail', 'video_id' => $video['video_id']])?>">
                                <?=$video['title']?>
                                <?= is_numeric($video['chapter_title']) ? ('第'.$video['chapter_title'].'集') : $video['chapter_title']?>
                            </a>
                        </div>
                        <div class="category">
                            <span><?=$video['year']?></span>
                            <?php foreach (explode(' ',$video['category']) as $category): ?>
                                <span><?= $category?></span>
                            <?php endforeach;?>
                        </div>
                        <div class="font14 h05 colorB2"><?=$video['watch_time']?></div>
                        <div class="font14 h05 colorB2 w-bottom-time"><?=$video['time_diff']?></div>
                    </div>
                </div>
                <!-- 编辑遮罩层 -->
                <div class="checkbox-div  <?php if($tab=="取消"):?>checkbox-div-show<?php endif;?>"></div>
            </label>
        <?php endforeach;?>
    </div>
<?php endforeach;?>
