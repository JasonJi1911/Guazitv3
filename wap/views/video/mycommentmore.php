<?php
use yii\helpers\Url;
?>
<?php if($data):?>
    <?php foreach ($data as $comment):?>
        <div class="plr15 comment-div font12">
            <div>
                <img class="comment-avatar" src="<?=$comment['avatar']?>" onerror="this.src='/images/video/touxiang.png'" />
            </div>
            <div>
                <div class="h20 color91"><?=$comment['username']?></div>
                <div class="h20 color91"><?=$comment['date']?></div>
                <div class="h20"><?=$comment['content']?></div>
                <div class="h20">《<?=$comment['film_name']?>》</div>
                <div class="line mt5" ></div>
            </div>
        </div>
    <?php endforeach;?>
<?php endif;?>
