<?php
use yii\helpers\Url;
?>
<?php if($data['comments']):?>
    <?php foreach ($data['comments'] as $comment):?>
        <div class="div-commentlist">
            <ul class="per-now-box ul-box" name="zt">
                <li class="per-now-h">
                    <div class="navTopLogonImg">
                        <a href="<?=Url::to(['/video/other-home','uid'=>$comment['uid']])?>">
                            <?php if($comment['avatar']):?>
                                <img src="<?=$comment['avatar']?>" />
                            <?php else :?>
                                <img src="/images/newindex/logon.png" />
                            <?php endif;?>
                        </a>
                    </div>
                    <div class="navTopLogon-GRXX" name="zt">
                        <div class="navTopLogon-GRXX-box">
                            <ul class="navTopLogon-box01">
                                <li class="navTopLogon-name"><img src="/images/newindex/VIP-1.png" /><?=$comment['nickname']?></li>
                                <li class="navTopLogon-Gender">
                                    <?php if($comment['gender']==1):?>
                                        <img src="/images/newindex/nv.png" />
                                    <?php elseif($comment['gender']==2) :?>
                                        <img src="/images/newindex/nan.png" />
                                    <?php endif;?>
                                </li>
                            </ul>
                            <ul class="navTopLogon-box02">
                                <li class="navTopLogon-rank">LV.<span>1</span></li>
                                <li class="navTopLogon-icon01"><img src="/images/newindex/jinbi.png" /></li>
                                <li class="navTopLogon-text">0</li>
<!--                                            <li class="per-gz-dz"><img src="/images/newindex/hlp-dz-w.png"><span>澳大利亚</span></li>-->
<!--                                            <li class="navTopLogon-experience"><span>76</span>/<span>200</span></li>-->
<!--                                            <li class="navTopLogon-icon01"><img src="/images/newindex/shangsheng.png" /></li>-->
<!--                                                <li class="navTopLogon-Progress">-->
<!--                                                    <div>-->
<!--                                                        <div class="Progress">&nbsp;</div>-->
<!--                                                    </div>-->
<!--                                                </li>-->
                            </ul>
                        </div>
                        <ul class="navTopLogon-box03">
                            <li>
                                <a class="navTopLogon-A" href="<?=Url::to(['/video/other-home','uid'=>$comment['uid']])?>">个人主页</a>
                            </li>
                            <li>
<!--                                                <input class="per-now-btn" type="" name="" id="" value="私信" />-->
                            </li>
                        </ul>
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
<!--                                                                <a href="javascript"><img src="/images/newindex/logon.png" /></a>-->
                                            <a href="<?=Url::to(['/video/other-home','uid'=>$reply['uid']])?>">
                                                <?php if($reply['avatar']):?>
                                                    <img src="<?=$reply['avatar']?>" />
                                                <?php else :?>
                                                    <img src="/images/newindex/logon.png" />
                                                <?php endif;?>
                                            </a>
                                        </div>
                                        <div class="navTopLogon-GRXX" name="zt">
                                            <div class="navTopLogon-GRXX-box">
                                                <ul class="navTopLogon-box01">
                                                    <li class="navTopLogon-name"><img src="/images/newindex/VIP-1.png" /><?=$reply['nickname']?></li>
                                                    <li class="navTopLogon-Gender">
                                                        <?php if($reply['gender']==1):?>
                                                            <img src="/images/newindex/nv.png" />
                                                        <?php elseif($reply['gender']==2) :?>
                                                            <img src="/images/newindex/nan.png" />
                                                        <?php endif;?>
                                                    </li>
                                                </ul>
                                                <ul class="navTopLogon-box02">
                                                    <li class="navTopLogon-rank">LV.<span>1</span></li>
                                                    <li class="navTopLogon-icon01"><img src="/images/newindex/jinbi.png" /></li>
                                                    <li class="navTopLogon-text">0</li>
<!--                                                                        <li class="per-gz-dz"><img src="/images/newindex/hlp-dz-w.png"><span>澳大利亚</span></li>-->
<!--                                                                        <li class="navTopLogon-experience"><span>76</span>/<span>200</span></li>-->
<!--                                                                        <li class="navTopLogon-icon01"><img src="/images/newindex/shangsheng.png" /></li>-->
<!--                                                                        <li class="navTopLogon-Progress">-->
<!--                                                                            <div>-->
<!--                                                                                <div class="Progress">&nbsp;</div>-->
<!--                                                                            </div>-->
<!--                                                                        </li>-->
                                                </ul>
                                            </div>
                                            <ul class="navTopLogon-box03">
                                                <li>
                                                    <a class="navTopLogon-A" href="<?=Url::to(['/video/other-home','uid'=>$reply['uid']])?>">个人主页</a>
                                                </li>
                                                <li>
<!--                                                                        <input class="per-now-btn" type="" name="" id="" value="私信" />-->
                                                </li>
                                            </ul>
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