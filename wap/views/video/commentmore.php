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
                    <div class="h05 color00 fontW4 mt5 height-auto" onclick="showreply(<?=$comment['comment_id']?>)" ><?=$comment['content']?></div>
                    <div id="commentid<?=$comment['comment_id']?>">
                        <?php if($comment['reply_info']['list']):?>
                            <input type="hidden" id="reply-current-<?=$comment['comment_id']?>" value="<?=$comment['reply_info']['current_page']?>" />
                            <input type="hidden" id="reply-total-<?=$comment['comment_id']?>" value="<?=$comment['reply_info']['total_page']?>" />
                            <div class="h05 color70 fontW4 comment-reply mt5" >
                                <?php foreach ($comment['reply_info']['list'] as $key=>$reply):?>
                                    <div class="h04 height-auto"><?=$reply['nickname']?>：<?=$reply['content']?></div>
                                <?php endforeach; ?>
                                <?php if($comment['reply_info']['total_page']>1):?>
                                    <div class="h04 reply-more" onclick="replymore(<?=$comment['comment_id']?>,this)">
                                        查看更多回复>
                                    </div>
                                <?php endif;?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="h05 color70 fontW4 mt5"><?=date("Y-m-d",$comment['created_at'])?></div>
                </li>
            </ul>
        </div>
    <?php endforeach;?>
<?php endif;?>