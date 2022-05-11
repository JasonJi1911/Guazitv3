<?php
use yii\helpers\Url;
use api\models\video\Video;
?>
<?php foreach ($data as $i => $video):?>
    <?php if($data[$i-1]['favorite_date']!=$video['favorite_date'] && $video['favorite_date']!=$timetitle):?>
        <div class="text-left font14 fontW7 h08 w-time plr15"><?=$video['favorite_date']?></div>
    <?php endif;?>
    <div class="position-r plr15">
        <label class="position-r">
            <div class="w-video position-r <?php if($tab=="取消"):?>w-video-edit<?php endif;?>">
                <div class="w-checkbox" <?php if($tab=="取消"):?>style="display: block;" <?php endif;?>>
                    <input type="checkbox" name="w-video-checkbox" data-id="<?=$video['video_id']?>" id="J_chechbox<?=$video['video_id']?>"/>
                </div>
                <div>
                    <a href="javascript:void(0);" onclick="clicka(<?=$video['video_id']?>)">
                        <img originalSrc="<?= $video['cover']?>" src="/images/default-cover.jpg">
                    </a>
                </div>
                <div class="position-r w-video-detail">
                    <div class="font14 h05">
                        <a href="javascript:void(0);" onclick="clicka(<?=$video['video_id']?>)"><?=$video['video_name']?></a>
                    </div>
                    <div class="category">
                        <span><?=$video['year']?></span>
                        <?php foreach (explode(' ',$video['category']) as $category): ?>
                            <span><?= $category?></span>
                        <?php endforeach;?>
                    </div>
                    <div class="font14 h05 colorB2"><?=$video['is_finished']==1? '完结' : '更新中' ?></div>
                    <div class="font14 h05 colorB2 w-bottom-time"><?=(($video['type']==Video::STATUS_DISABLED)?$video['flag']:'')?></div>
                </div>
            </div>
        </label>
    </div>
<?php endforeach;?>
