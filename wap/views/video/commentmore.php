<?php
use yii\helpers\Url;
?>
<?php if($data['comments']):?>
    <?php foreach ($data['comments'] as $comment):?>
        <div class="comment-list">
            <ul>
                <li class="comment-avatar" >
                    <?php if($comment['avatar']):?>
                        <img src="<?=$comment['avatar']?>" />
                    <?php else :?>
                        <img src="/images/video/touxiang.png" />
                    <?php endif;?>
                </li>
                <li class="comment-detail">
                    <div class="h05 color70 fontW4 mt5" ><?=$comment['nickname']?></div>
                    <div class="h05 color00 fontW4 mt5" ><?=$comment['content']?></div>
                    <?php if($comment['reply_info']['list']):?>
                        <div class="h05 color70 fontW4 comment-reply mt5" >
                            <?php foreach ($comment['reply_info']['list'] as $key=>$reply):?>
                                <?php if($key==0):?>
                                    <div class="h04"><?=$reply['nickname']?>：<?=$reply['content']?></div>
                                    <?php if($comment['reply_info']['total_count']>1):?>
                                        <div class="h04 reply-more">共<?=$comment['reply_info']['total_count']?>条评论></div>
                                    <?php endif;?>
                                <?php else :?>
                                    <div class="h04 reply-other"><?=$reply['nickname']?>：<?=$reply['content']?></div>
                                <?php endif;?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="h05 color70 fontW4 mt5"><?=date("Y-m-d",$comment['created_at'])?></div>
                </li>
            </ul>
        </div>
    <?php endforeach;?>
<?php endif;?>