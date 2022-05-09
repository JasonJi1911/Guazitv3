<?php
use yii\helpers\Url;
?>
<?php if($data['total_page']>=0):?>
    <input id="refreshtotal" class="div-commentlist" type="hidden" value="<?=$data['total_page']?>" />
<?php endif;?>
<?php if($data['comments']):?>
    <?php foreach ($data['comments'] as $comment):?>
        <div class="div-commentlist">
            <ul class="per-now-box ul-box" name="zt">
                <li class="per-now-h">
                    <div class="navTopLogonImg">
                        <?php if($comment['avatar']):?>
                            <img src="<?=$comment['avatar']?>" />
                        <?php else :?>
                            <img src="/images/Index/user_c.png" />
                        <?php endif;?>
                    </div>
                </li>
                <li >
                    <div class="per-now-box-01">
                        <div>
                            <?=$comment['nickname']?>
                        </div>
                        <img src="/images/newindex/lv_1.png" />
                    </div>
                    <div class="per-now-box-02" name="zt">
                        <?=$comment['content']?>
                    </div>
                    <ul class="per-now-box-03" name="zt">
                        <li><?=date("Y-m-d",$comment['created_at'])?></li>
                        <li><input class="per-btn-z" type="button" name="" onclick="addlikes(<?=$comment['comment_id']?>,this);" value="" /><span><?=$comment['likes_num']?></span></li>
                        <li><input class="per-btn-reply" type="button" name="" onclick="showreply(<?=$comment['comment_id']?>,this);" value="回复" /></li>
                    </ul>
                    <?php if($comment['reply_info']['list']):?>
                        <div class="div-reply">
                            <?foreach ($comment['reply_info']['list'] as $reply):?>
                                <ul class="per-now-box ul-box" name="zt">
                                    <li class="per-now-h">
                                        <div class="navTopLogonImg">
                                            <?php if($reply['avatar']):?>
                                                <img src="<?=$reply['avatar']?>" />
                                            <?php else :?>
                                                <img src="/images/Index/user_c.png" />
                                            <?php endif;?>
                                        </div>
                                    </li>
                                    <li >
                                        <div class="per-now-box-01">
                                            <div>
                                                <?=$reply['nickname']?>
                                            </div>
                                            <img src="/images/newindex/lv_1.png" />
                                        </div>
                                        <div class="per-now-box-02" name="zt">
                                            <?=$reply['content']?>
                                        </div>
                                        <ul class="per-now-box-03" name="zt">
                                            <li><?=date("Y-m-d",$reply['created_at'])?></li>
                                            <li><input class="per-btn-z" type="button" name="" onclick="addlikes(<?=$reply['comment_id']?>,this);" value="" /><span><?=$reply['likes_num']?></span></li>
                                            <li></li>
                                        </ul>
                                    </li>
                                </ul>
                            <?php endforeach; ?>
                            <div class="div-replyname" id="reply-more-<?=$comment['comment_id']?>" onclick="findmorereply(<?=$comment['comment_id']?>)"
                                <?php if($comment['reply_info']['total_page']!=0 && $comment['reply_info']['current_page']==$comment['reply_info']['total_page']):?>
                                    style="display: none;"
                                <?php endif;?> >
                                <input type="hidden" id="reply-current-<?=$comment['comment_id']?>" value="<?=$comment['reply_info']['current_page']?>" />
                                <input type="hidden" id="reply-total-<?=$comment['comment_id']?>" value="<?=$comment['reply_info']['total_page']?>" />
                                查看更多回复
                            </div>
                        </div>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    <?php endforeach;?>
<?php endif;?>