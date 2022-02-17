<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

NewIndexStyleAsset::register($this);
?>
<style>
    body {
        background-color: #F9F9F9;
    }
    .more-load{
        color:#888;
        height:40px;
        line-height:40px;
        text-align:center;
        font-size:14px;
    }
</style>
<script>
//首次加载
$(document).ready(function() {
    var tab = '<?=$ptab?>';
    if(tab=='watchlog'){
        $('.c_watchlog').addClass('act');
        $('.c_watchlog').siblings().removeClass('act');
        $('.c_watchlog .J_per_tab_img_c').show().siblings().hide();
        $('.c_watchlog').siblings().find('.J_per_tab_img_c').hide().siblings().show();
    }else if(tab=='message'){
        $('.c_message').addClass('act');
        $('.c_message').siblings().removeClass('act');
        $('.c_message .J_per_tab_img_c').show().siblings().hide();
        $('.c_message').siblings().find('.J_per_tab_img_c').hide().siblings().show();
    }else if(tab=='favorite'){
        $('.c_favorite').addClass('act');
        $('.c_favorite').siblings().removeClass('act');
        $('.c_favorite .J_per_tab_img_c').show().siblings().hide();
        $('.c_favorite').siblings().find('.J_per_tab_img_c').hide().siblings().show();
    }else if(tab=='task'){
        $('.c_task').addClass('act');
        $('.c_task').siblings().removeClass('act');
        $('.c_task .J_per_tab_img_c').show().siblings().hide();
        $('.c_task').siblings().find('.J_per_tab_img_c').hide().siblings().show();
    }else if(tab=='upload'){
        $('.c_upload').addClass('act');
        $('.c_upload').siblings().removeClass('act');
        $('.c_upload .J_per_tab_img_c').show().siblings().hide();
        $('.c_upload').siblings().find('.J_per_tab_img_c').hide().siblings().show();
    }else if(tab=='relation'){
        $('.c_relation').addClass('act');
        $('.c_relation').siblings().removeClass('act');
        $('.c_relation J_per_tab_img_c').show().siblings().hide();
        $('.c_relation').siblings().find('.J_per_tab_img_c').hide().siblings().show();
    }else if(tab=='safe'){
        $('.c_safe').addClass('act');
        $('.c_safe').siblings().removeClass('act');
        $('.c_safe .J_per_tab_img_c').show().siblings().hide();
        $('.c_safe').siblings().find('.J_per_tab_img_c').hide().siblings().show();
    }else{//c_question
        $('.c_upload').addClass('act');
        $('.c_upload').siblings().removeClass('act');
        $('.c_upload .J_per_tab_img_c').show().siblings().hide();
        $('.c_upload').siblings().find('.J_per_tab_img_c').hide().siblings().show();
    }
});
</script>
<div class="per-box-new">
        <div class="per-title">
            <div class="per-title-name">
                <img src="/images/Index/user_c.png"/>
                <p>瓜子TV用户</p>
                <p><a href="<?= Url::to(['/video/personal'])?>">个人主页></a></p>
            </div>
        </div>
        <ul class="box-per-tab J_per_tab">
            <li class="c_favorite act J_collect">
                <div class="per-img-icon">
                    <img class="J_per_tab_img" src="/images/Index/icon_collect.png" style="display: none;">
                    <img class="J_per_tab_img_c" src="/images/Index/icon_collect_c.png">
                </div>
                我的收藏
            </li>
            <li class="c_watchlog J_watch">
                <div class="per-img-icon">
                    <img class="J_per_tab_img" src="/images/Index/bofangjilu_line.png">
                    <img class="J_per_tab_img_c" src="/images/Index/bofangjilu_line_c.png" style="display: none;">
                </div>
                播放记录
            </li>
            <li class="c_safe J_safe">
                <div class="per-img-icon">
                    <img class="J_per_tab_img" src="/images/Index/anquanzhongxin.png">
                    <img class="J_per_tab_img_c" src="/images/Index/anquanzhongxin_c.png" style="display: none;">
                </div>
                安全中心
            </li>
            <li class="J_seek">
                <a target="_blank" href="<?= Url::to(['/video/seek'])?>">
                    <div class="per-img-icon">
                        <img class="J_per_tab_img" src="/images/Index/dianying-4.png">
                        <img class="J_per_tab_img_c" src="/images/Index/dianying-4.png" style="display: none;">
                    </div>求片
                </a>
            </li>
        </ul>
    </div>

    <div class="per-tab-w-new">
        <!--tab 收藏夹-->
        <div class="per-tab-box-new c_favorite act" name="zt">
            <!-- 头部导航 -->
            <div class="per-sp-box-new">
                <ul class="per-tab02-new" name="zt">
                    <li class="act">剧集</li>
                    <li>视频</li>
                </ul>
                <!-- 批量删除 -->
                <div class="per-sc-new" name="zt">
                    <ul class="per-sc-pl act J_fa_pl">
                        <li>批量删除</li>
                    </ul>
                    <ul class="per-sc-btn">
                        <li class="J_cancel_all">取消全选</li>
                        <li class="J_del_num" onclick="removefavorite('all');">删除(<span>0</span>)</li>
                        <li class="J_cancel">取消</li>
                    </ul>
                </div>
                <!-- 搜索 -->
                <div class="per-ss-new" name="zt">
                    <input type="button"  value="" id="fav_searchbtn"/>
                    <input type="text" name=""  value="" placeholder="搜索"id="fav_search" />
                </div>
            </div>
            <div class="per-tab-wrap">
                <div class="per-tab-w02-new act">
                    <?php if(!$data['favorite']):?>
                        <div class="no-video">
                            <h2 class="per-zw-new" name="zt" >
                                暂无内容，快去看看精彩视频吧~
                            </h2>
                        </div>
                    <?php else :?>
                        <div class="per-tab-video-list">
                            <?php foreach ($data['favorite'] as $video):?>
                                <div class="RANbox-list01-new id_fav<?=$video['video_id']?>" name="zt">
                                    <ul class="RANbox-list-xx-new">
                                        <li>
                                            <a href="<?= Url::to(['detail', 'video_id' => $video['video_id']])?>"><img src="<?=$video['cover']?>"></a>
                                        </li>
                                        <li>
                                            <a class="RAN-z-box01-name-new" href="<?= Url::to(['detail', 'video_id' => $video['video_id']])?>" name="zt"><?=$video['video_name']?></a>
                                            <div class="GNbox-type-new" name="zt">
                                                <?php foreach (explode(' ',$video['category']) as $category): ?>
                                                    <span><?= $category?></span>
                                                <?php endforeach;?>
                                            </div>
                                            <div class="RANbox-list01-b-new">
                                                <span><?=$video['is_finished']==1? '完结' : '更新中' ?></span>
                                                <span><?=$video['flag']?></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="RANbox-choose">
                                                <div class="RANbox-choose-img J_choose_check"  data-value="<?=$video['video_id']?>" onclick="favchoose(this);" ></div>
                                            </div>
                                            <input type="button" value="删除" onclick="removefavorite(<?=$video['video_id']?>)">
                                        </li>
                                    </ul>
                                </div>
                            <?php endforeach;?>
                        </div>
                    <?php endif;?>
                </div>
                <!-- 视频列表 -->
                <div class="per-tab-w02-new">
                    <div class="per-tab-video-list">
                        <div class="no-video">
                            <h2 class="per-zw-new" name="zt" >
                                暂无内容，快去看看精彩视频吧~
                            </h2>
                        </div>
                        <!--<div class="RANbox-list01-new id_fav1" name="zt">
                            <ul class="RANbox-list-xx-new">
                                <li>
                                    <a href="play.html"><img src="/images/newindex/test-03.jpg" /></a>
                                </li>
                                <li>
                                    <a class="RAN-z-box01-name-new" href="play.html" name="zt">测试视频名称</a>
                                    <div class="GNbox-type-new" name="zt">
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                    </div>
                                    <div class="RANbox-list01-b-new">
                                        <span>发布中</span>
                                        <span>测试更新文字内容</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="RANbox-choose">
                                        <div class="RANbox-choose-img J_choose_check" data-value="1" onclick="favchoose(this);"></div>
                                    </div>
                                    <input type="button" value="删除" onclick="removefavorite(1)">
                                </li>
                            </ul>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
        <!--tab 播放记录-->
        <div class="per-tab-box-new c_watchlog" name="zt">
            <!-- 头部导航 -->
            <div class="per-sp-box-new">
                <ul class="per-tab02-new-02 J_select_channel" name="zt">
                    <li class="act" onclick="channelswatchlog('all',this);" channel-id=0>全部</li>
                    <?php if(!empty($channels)) :?>
                        <?php foreach ($channels['channeltags'] as $key=>$channel) :?>
                            <?php if ($key < 6 && $channel['channel_name'] != '首页') :?>
                            <li onclick="channelswatchlog(<?= $channel['channel_id']?>,this)" channel-id=<?= $channel['channel_id']?>>
                                <?= $channel['channel_name']?>
                            </li>
                            <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>
                <!-- 批量删除 -->
                <div class="per-sc-new" name="zt">
                    <ul class="per-sc-pl act J_wl_pl">
                        <li>批量删除</li>
                    </ul>
                    <ul class="per-sc-btn">
                        <li class="J_cancel_all">取消全选</li>
                        <li class="J_del_num"  onclick="removewatchlog('all');">删除(<span>0</span>)</li>
                        <li class="J_cancel">取消</li>
                    </ul>
                </div>
                <!-- 搜索 -->
                <div class="per-ss-new" name="zt">
                    <input type="button"  value="" id="watchlog_search" />
                    <input type="text" name=""  value="" placeholder="搜索" id="watchlog_stext" />
                </div>
            </div>
            <div class="per-tab-wrap">
                <div class="per-tab-w02-new act">
                    <?php if(!$data['watchlog']):?>
                    <div class="no-video">
                        <h2 class="per-zw-new" name="zt" >
                            暂无内容，快去看看精彩视频吧~
                        </h2>
                    </div>

                    <?php else :?>
                        <?php foreach ($data['watchlog'] as $i => $watchdate):?>
                        <div class="per-bf-lst">
                            <?php if($data['watchlog'][$i-1]['date']!=$watchdate['date']):?>
                            <div class="per-bf-lst-btn act"><?=$watchdate['date']?></div>
                            <?php endif;?>
                            <?php foreach ($watchdate['list'] as $video):?>
                            <ul class="per-bof-box id_watchlog_<?=$video['log_id']?>" name="zt">
                                <li class="per-bof-box-01 show-times"><?=$video['show_times']?></li>
                                <li class="per-bof-box-02" name="zt">
                                    <div class="RANbox-list01" name="zt">
                                        <ul class="RANbox-list-xx RANbox-list-xx-new">
                                            <li>
                                                <a href="<?= Url::to(['detail', 'video_id' => $video['video_id']])?>"><img src="<?=$video['cover']?>"></a>
                                            </li>
                                            <li>
                                                <a class="RAN-z-box01-name-new" href="<?= Url::to(['detail', 'video_id' => $video['video_id']])?>" name="zt"><?=$video['title']?></a>
                                                <div class="GNbox-type-new" name="zt">
                                                    <?php foreach (explode(' ',$video['category']) as $category): ?>
                                                        <span><?= $category?></span>
                                                    <?php endforeach;?>
                                                </div>
                                                <div class="RANbox-list01-b-new">
                                                    <span><?=$video['is_finished']==1? '完结' : '更新中' ?></span>
                                                    <span> <?=$video['flag']?></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="RANbox-choose">
                                                    <div class="RANbox-choose-img J_choose_check" data-value="1" onclick="favchoose(this);"></div>
                                                </div>
                                                <input type="button" value="删除"  onclick="removewatchlog(<?=$video['log_id']?>);">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                            <?php endforeach;?>
                        </div>
                        <?php endforeach;?>
                    <?php endif;?>
                    <!--<div class="per-bf-lst">
                        <div class="per-bf-lst-btn">一周前</div>
                        <ul class="per-bof-box" name="zt">
                            <li class="per-bof-box-01">2022-1-13</li>
                            <li class="per-bof-box-02" name="zt">
                                <div class="RANbox-list01" name="zt">
                                    <ul class="RANbox-list-xx RANbox-list-xx-new">
                                        <li>
                                            <a href="play.html"><img src="/images/newindex/RDimg.jpg"></a>
                                        </li>
                                        <li>
                                            <a class="RAN-z-box01-name-new" href="play.html" name="zt">测试视频名称</a>
                                            <div class="GNbox-type-new" name="zt">
                                                <span>爱情</span>
                                                <span>爱情</span>
                                                <span>爱情</span>
                                                <span>爱情</span>
                                                <span>爱情</span>
                                                <span>爱情</span>
                                            </div>
                                            <div class="RANbox-list01-b-new">
                                                <span>发布中</span>
                                                <span>测试更新文字内容</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="RANbox-choose">
                                                <div class="RANbox-choose-img J_choose_check" data-value="1" onclick="favchoose(this);"></div>
                                            </div>
                                            <input type="button" value="删除" onclick="removefavorite(1)">
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <ul class="per-bof-box" name="zt">
                            <li class="per-bof-box-01">2022-1-12</li>
                            <li class="per-bof-box-02" name="zt">
                                <div class="RANbox-list01" name="zt">
                                    <ul class="RANbox-list-xx RANbox-list-xx-new">
                                        <li>
                                            <a href="play.html"><img src="/images/newindex/RDimg.jpg"></a>
                                        </li>
                                        <li>
                                            <a class="RAN-z-box01-name-new" href="play.html" name="zt">测试视频名称</a>
                                            <div class="GNbox-type-new" name="zt">
                                                <span>爱情</span>
                                                <span>爱情</span>
                                                <span>爱情</span>
                                                <span>爱情</span>
                                                <span>爱情</span>
                                                <span>爱情</span>
                                            </div>
                                            <div class="RANbox-list01-b-new">
                                                <span>发布中</span>
                                                <span>测试更新文字内容</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="RANbox-choose">
                                                <div class="RANbox-choose-img J_choose_check" data-value="1" onclick="favchoose(this);"></div>
                                            </div>
                                            <input type="button" value="删除" onclick="removefavorite(1)">
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>-->
                </div>
            </div>
        </div>
        <!--tab 安全中心-->
        <div class="per-tab-box-new c_safe J_safe_auth" name="zt">
            <?php
            $account_length = strlen($data['user']['mobile']);
            $hide_account_length = $account_length - 5;
            $xing = '';
            $hide_account = '';
            if ($hide_account_length > 0) {
                for ($i = 0; $i < $hide_account_length; $i++) {
                    $xing .= '*';
                }
                $hide_account = substr($data['user']['mobile'],0, 3) . $xing . substr($data['user']['mobile'],-2);
            } else {
                $hide_account = $data['user']['mobile'];
            }
            ?>
<!--            安全中心列表页-->
            <ul class="per-safe-box J_safe_list act">
                <li>
                    <span class="per-safe-title-c">手机</span>
                    <span class="per-safe-content"><?=$hide_account?></span>
<!--                    <span class="per-safe-action J_per_edit_phone">修改</span>-->
                </li>
                <li>
                    <span class="per-safe-title-c">邮箱</span>
                    <span class="per-safe-content J_is_bind_email"><?php if($data['user']['email']):?><?=$data['user']['email']?><?php else:?>未绑定<?php endif;?></span>
                    <span class="per-safe-action J_per_edit_email">修改</span>
                </li>
                <li>
                    <span class="per-safe-title-c">登录密码</span>
                    <span class="per-safe-content J_is_bind_pass"><?php if($data['user']['password_flag']==0):?>未设置<?php else:?>已设置<?php endif;?></span>
                    <span class="per-safe-action J_per_edit_pass">修改</span>
                </li>
<!--                <li>-->
<!--                    <span class="per-safe-title">登录记录</span>-->
<!--                    <span class="per-safe-content"></span>-->
<!--                    <span class="per-safe-action">查看</span>-->
<!--                </li>-->
            </ul>
<!--            修改手机页面-->
            <div class="per-edit-phone-box J_ep">
                <div class="alt-content02" name="zt">
                    <p>修改手机号</p>
                    <div class="per-safe-title">您的账号当前处于安全环境</div>
                </div>
                <div class="per-safe-auth-box J_ep_safe_auth_title">
                    <div class="hlp-forget-pass-item">

                        <div class="hlp-forget-pass-jindu">
                            <div class="hlp-forget-pass-line hlp-forget-pass-line-01 act"></div>
                            <div class="hlp-forget-pass-jindu-01 act">
                                1
                            </div>
                        </div>
                        <p class="hlp-forget-pass-desc act">安全认证</p>
                    </div>
                    <div class="hlp-forget-pass-item">
                        <div class="hlp-forget-pass-jindu">
                            <div class="hlp-forget-pass-line hlp-forget-pass-line-02 J_ep_line2"></div>
                            <div class="hlp-forget-pass-jindu-01 J_ep_jindu2">
                                2
                            </div>
                        </div>
                        <p class="hlp-forget-pass-desc J_ep_auth_text2">修改号码</p>
                    </div>
                    <div class="hlp-forget-pass-item">
                        <div class="hlp-forget-pass-jindu">
                            <div class="hlp-forget-pass-line hlp-forget-pass-line-03 J_line3"></div>
                            <div class="hlp-forget-pass-jindu-01 J_jindu3">
                                3
                            </div>
                        </div>
                        <p class="hlp-forget-pass-desc J_auth_text3">操作成功</p>
                        <div class="hlp-forget-pass-text"></div>
                    </div>
                </div>
                <div class="hlp-forget-pass-sub J_ep_safe_auth">
                    <div class="help-tel-check-box act J_ep_step_one">
                        <div class="help-tel-check">通过手机<span class="J_ep_hide_account" data-phone="<?=$data['user']['mobile']?>" data-prefix_phone="<?=$data['user']['mobile_areacode']?>"><?=$hide_account?></span>验证</div>
                        <div class="bttn-box-warning1 J_ep_warning1">验证码发送失败</div>
                    </div>
                    <div class="help-tel-check-code-box J_ep_step_one1">
                        <div class="help-tel-check-item">
                        <p>短信验证码已经发送至<span class="J_hide_account"><?=$hide_account?></span></p>
                        <div class="help-tel-check-code">
                            <input class="yzm J_ep_yzm" type="text" name="" value="" />
                            <input type="button" class="yzm-btn J_ep_one1_step" id="reg_prefix_phone" value="验证" />
                        </div>
                        <div class="bttn-box-warning2 J_ep_warning2">验证码发送失败</div>
                        <p>未收到验证码？<span class="J_ep_count_down">53s后重新发送</span></p>
                    </div>
                    </div>
                    <div class="help-te-box J_ep_step_two">
                        <div class="inp-box J_account">
                            <span class="inp-title">手机号</span>
                            <ul class="opJ J_opt_country">
                                <?php
                                $selectVal = "";
                                $selectData = "";
                                foreach ($channels['country_info'] as $country){
                                    if($country['mobile_areacode']!=''){
                                        $selectVal = $country['country_name'] . '+' . $country['mobile_areacode'];
                                        $selectData = '+' . $country['mobile_areacode'];
                                        break;
                                    }
                                }
                                ?>
                                <?php if(!empty($channels['country_info'])) :?>
                                    <?php foreach ($channels['country_info'] as $country): ?>
                                        <?php if($country['mobile_areacode']!=''):?>
                                            <li data="<?=$country['country_name']?>+<?=$country['mobile_areacode']?>"><?=$country['country_name']?><span>+<?=$country['mobile_areacode']?></span></li>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </ul>
                            <input type="button" class="selectJ J_ep_select_country" value="<?=$selectVal?>" data="<?=$selectData?>"/>
                            <input class="tel J_ep_phone" type="text" name="" placeholder="请输手机号" value="" />
                        </div>
                        <div class="bttn-box-warning J_ep_warning">账号有误</div>
                        <div class="bttn-box J_ep_second_step">
                            <input type="button" value="获取验证码" />
                        </div>
                    </div>
                    <div class="help-tel-check-code-box J_ep_step_two2">
                        <div class="help-tel-check-item">
                        <p>短信验证码已经发送至<span class="J_ep_hide_account">155******02</span></p>
                        <div class="help-tel-check-code">
                            <input class="yzm J_ep_yzm" type="text" name="" value="" />
                            <input type="button" class="yzm-btn J_ep_two2_step" id="reg_prefix_phone" value="绑定" />
                        </div>
                        <div class="bttn-box-warning2 J_ep_warning2">验证码发送失败</div>
                        <p>未收到验证码？<span class="J_ep_count_down">53s后重新发送</span></p>
                    </div>
                    </div>
                </div>
            </div>
<!--            绑定/修改邮箱页面-->
            <div class="per-edit-phone-box J_email_box">
                <div class="alt-content02" name="zt">
                    <p>修改邮箱</p>
                    <div class="per-safe-title">您的账号当前处于安全环境</div>
                </div>
                <div class="per-safe-auth-box J_email_safe_auth_title">
                    <div class="hlp-forget-pass-item">
                        <div class="hlp-forget-pass-jindu">
                            <div class="hlp-forget-pass-line hlp-forget-pass-line-01 act"></div>
                            <div class="hlp-forget-pass-jindu-01 act">
                                1
                            </div>
                        </div>
                        <p class="hlp-forget-pass-desc act">安全认证</p>
                    </div>
                    <div class="hlp-forget-pass-item">
                        <div class="hlp-forget-pass-jindu">
                            <div class="hlp-forget-pass-line hlp-forget-pass-line-02 J_email_line2 act"></div>
                            <div class="hlp-forget-pass-jindu-01 J_email_jindu2 act">
                                2
                            </div>
                        </div>
                        <p class="hlp-forget-pass-desc J_email_auth_text2 act"><?php if($data['user']['email']):?>修改邮箱<?php else:?>绑定邮箱<?php endif;?></p>
                    </div>
                    <div class="hlp-forget-pass-item">
                        <div class="hlp-forget-pass-jindu">
                            <div class="hlp-forget-pass-line hlp-forget-pass-line-03 J_email_line3"></div>
                            <div class="hlp-forget-pass-jindu-01 J_email_jindu3">
                                3
                            </div>
                        </div>
                        <p class="hlp-forget-pass-desc J_email_auth_text3">操作成功</p>
                        <div class="hlp-forget-pass-text"></div>
                    </div>
                </div>
                <div class="hlp-forget-pass-sub J_email_safe_auth">
                    <div class="help-tel-check-box J_email_step_one">
                        <div class="help-tel-check">通过手机<span class="J_email_send_code" data-phone="<?=$data['user']['mobile']?>" data-prefix_phone="<?=$data['user']['mobile_areacode']?>"><?=$hide_account?></span>验证</div>
                        <div class="bttn-box-warning1 J_email_warning1">验证码发送失败</div>
                    </div>
                    <div class="help-tel-check-code-box ">
                        <div class="help-tel-check-item">
                            <p>短信验证码已经发送至<span class="J_email_hide_account"><?=$hide_account?></span></p>
                            <div class="help-tel-check-code">
                                <input class="yzm J_email_yzm" type="text" name="" value="" />
                                <input type="button" class="yzm-btn J_email_one1_step" value="验证" />
                            </div>
                            <div class="bttn-box-warning2 J_email_warning2">验证码发送失败</div>
                            <p>未收到验证码？<span class="J_email_count_down">53s后重新发送</span></p>
                        </div>
                    </div>
                    <div class="help-te-box J_email_step_two act">
                        <div class="per-bind-email">
                            <input class="email-inpt J_email" type="text" placeholder="请输入邮箱" value=""/>
                            <input type="button" class="yzm-btn J_email_two_step" value="绑定" />
                        </div>
                        <div class="bttn-box-warning J_email_warning">账号有误</div>
                    </div>
                </div>
            </div>
<!--            修改密码页面-->
            <div class="per-edit-phone-box J_edit_pass_box">
                <div class="alt-content02" name="zt">
                    <p>修改密码</p>
                    <div class="per-safe-title">您的账号当前处于安全环境</div>
                </div>
                <div class="per-safe-auth-box J_ep_safe_auth_title">
                    <div class="hlp-forget-pass-item">
                        <div class="hlp-forget-pass-jindu">
                            <div class="hlp-forget-pass-line hlp-forget-pass-line-01 act"></div>
                            <div class="hlp-forget-pass-jindu-01 act">
                                1
                            </div>
                        </div>
                        <p class="hlp-forget-pass-desc act">安全认证</p>
                    </div>
                    <div class="hlp-forget-pass-item">
                        <div class="hlp-forget-pass-jindu">
                            <div class="hlp-forget-pass-line hlp-forget-pass-line-02 J_edp_line2 act"></div>
                            <div class="hlp-forget-pass-jindu-01 J_edp_jindu2 act">
                                2
                            </div>
                        </div>
                        <p class="hlp-forget-pass-desc J_edp_auth_text2 act">修改密码</p>
                    </div>
                    <div class="hlp-forget-pass-item">
                        <div class="hlp-forget-pass-jindu">
                            <div class="hlp-forget-pass-line hlp-forget-pass-line-03 J_edp_line3"></div>
                            <div class="hlp-forget-pass-jindu-01 J_edp_jindu3">
                                3
                            </div>
                        </div>
                        <p class="hlp-forget-pass-desc J_edp_auth_text3">操作成功</p>
                        <div class="hlp-forget-pass-text"></div>
                    </div>
                </div>
                <div class="hlp-forget-pass-sub J_edp_safe_auth">
                    <div class="help-tel-check-box J_edp_step_one">
                        <div class="help-tel-check">通过手机<span class="J_edp_hide_account" data-phone="<?=$data['user']['mobile']?>" data-prefix_phone="<?=$data['user']['mobile_areacode']?>"><?=$hide_account?></span>验证</div>
                        <div class="bttn-box-warning1 J_edp_warning1">验证码发送失败</div>
                    </div>
                    <div class="help-tel-check-code-box J_edp_step_one1">
                        <div class="help-tel-check-item">
                            <p>短信验证码已经发送至<span class="J_edp_hide_account"><?=$hide_account?></span></p>
                            <div class="help-tel-check-code">
                                <input class="yzm J_edp_yzm" type="text" name="" value="" />
                                <input type="button" class="yzm-btn J_edp_one1_step" id="reg_prefix_phone" value="验证" />
                            </div>
                            <div class="bttn-box-warning2 J_edp_warning2">验证码发送失败</div>
                            <p>未收到验证码？<span class="J_edp_count_down">53s后重新发送</span></p>
                        </div>
                    </div>
                    <div class="help-pass-box J_edp_step_two act">
                        <div class="inp-box pasbox">
                            <span class="inp-title">新密码</span>
                            <input type="password" class="inp pas J_edp_new_pass" name="" placeholder="请输入密码" id="login_pwd" value="" onkeyup="value=value.replace(/[^(\w-*\.*)]/g,'')" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" autocomplete="off">
                            <input type="button" class="eye" value="">
                        </div>
                        <div class="inp-box pasbox">
                            <span class="inp-title">确认密码</span>
                            <input type="password" class="inp pas J_edp_sure_pass" name="" placeholder="请再次输入密码" id="login_pwd" value="" onkeyup="value=value.replace(/[^(\w-*\.*)]/g,'')" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" autocomplete="off">
                            <input type="button" class="eye" value="">
                        </div>
                        <div class="inp-box pasbox J_edp_inp_box" style="display: none;">
                            <span class="inp-title"></span>
                            <div class="bttn-box-warning3 J_edp_warning3">两次输入密码不一致</div>
                        </div>
                        <div class="inp-box pasbox">
                            <span class="inp-title"></span>
                            <input type="button" value="确认" class="inp-sure-btn J_edp_two_step"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery.js"></script>
<script>
/*-----------公共------------*/
var arrall = {};
arrall['favorite-page'] = 1;
arrall['favorite-total'] = ('<?=$data['favorite'][0]['total_page']?>'?parseInt('<?=$data['favorite'][0]['total_page']?>'):0);
arrall['watchlog-page'] = 1;
arrall['watchlog-total'] = ('<?=$data['watchlog'][0]['total_page']?>'?parseInt('<?=$data['watchlog'][0]['total_page']?>'):0);

var favarr = {};
favarr['channel'] = 0;
favarr['is_finished'] = 0;

var relaAr = {};
relaAr['type'] = '1';
relaAr['order'] = 'time';
relaAr['searchword'] = '';
relaAr['tabNum'] = 0;
//个人中心类目切换,将所有复选框清空
$(".J_per_tab>li").click(function() {
    //图标为选中样式
    $(this).find('.J_per_tab_img').hide().siblings('.J_per_tab_img_c').show();
    $(this).siblings().find('.J_per_tab_img').show().siblings('.J_per_tab_img_c').hide();
    $(".per-tab-w02-new .RANbox-list-xx-new>li:last-of-type>.RANbox-choose>.J_choose_check").removeClass("act").removeClass("act1");
    if($(this).hasClass("J_safe")){
        $('.c_safe>.J_safe_list').addClass('act').siblings().removeClass('act');
    }
});
/*-----------收藏（新）------------*/
// 收藏页tab  切换
$(".per-tab02-new>li").click(function() {
    var tabNum = $(this).index();
    $(this).addClass("act").siblings().removeClass("act");
    $(".per-tab-w02-new").eq(tabNum).addClass("act").siblings().removeClass("act");
    //删除样式还原
    $(".per-sc-new").find(".per-sc-pl").addClass("act").siblings().removeClass("act");
    //将勾选按钮去掉
    $(".per-tab-w02-new.act .RANbox-list-xx-new>li:last-of-type>.RANbox-choose>.J_choose_check").removeClass("act").removeClass("act1");
    $(this).parents(".per-sp-box-new").find(".J_del_num span").text(0);
});
//批量删除-全选,显示选中按钮，同时显示选中个数
$(".per-sc-pl>li").click(function() {
    //1.显示选中删除样式
    $(".per-tab-w02-new.act .RANbox-list-xx-new>li:last-of-type>.RANbox-choose>.J_choose_check").addClass("act");
    //2.删除按钮样式变动
    $(this).parents(".per-sc-new").find(".per-sc-btn").addClass("act").siblings().removeClass("act");
    //3.更改删除的数量
    var num = $(".per-tab-box-new.act").find(".per-tab-w02-new.act .RANbox-list-xx-new").length;
    $(this).parents('.per-sc-new').find(".J_del_num span").text(num);
});
//批量删除-单选
function favchoose(obj) {
    if($(obj).hasClass('act')){
        $(obj).removeClass('act').addClass('act1');
    }else{
        $(obj).removeClass('act1').addClass('act');
    }
    //同时更新删除数量
    var num = $(".per-tab-w02-new.act .RANbox-list-xx-new .J_choose_check.act").length;
    $(".J_del_num span").text(num);
}
//取消全选
$('.J_cancel_all').click(function(){
    $(".per-tab-w02-new.act .RANbox-list-xx-new .J_choose_check.act").removeClass('act').addClass('act1');
    $(".J_del_num span").text(0);
})
//取消
$('.J_cancel').click(function(){
    //1.显示选中删除样式
    $(".per-tab-w02-new.act .RANbox-list-xx-new>li:last-of-type>.RANbox-choose>.J_choose_check").removeClass("act").removeClass("act1");
    //2.删除按钮样式变动
    $(this).parents(".per-sc-new").find(".per-sc-pl").addClass("act").siblings().removeClass("act");
})
//收藏条件切换
var no_video_str = '<div class="no-video">'
    +'<h2 class="per-zw-new" name="zt" >'
    +'暂无内容，快去看看精彩视频吧~'
    +'</h2>'
    +'</div>';
$(".per-slt-list-favorite>input").click(function() {
    var perSlt=$(this).val();
    var datavalue=$(this).attr('data-value');
    var datatype=$(this).attr('data-type');
    $(this).addClass("act").siblings().removeClass("act");
    $(this).parents(".per-slt").find(".per-slt-name>input").val(perSlt);
    $('.per-slt-name>input').removeClass("act");
    $('.per-slt-list').removeClass("act");
    favarr[datatype] = datavalue;
    $.get('/video/search-favorite',favarr,function(res){
        arrall['favorite-page'] = 1;
        if(res.errno==0){
            var html = findfavoritelist(res.data,false);
            $(".per-tab-w02-new.act .per-tab-video-list").html(html);
        }else{
            $(".per-tab-w02-new.act .per-tab-video-list").html(no_video_str);
        }
        ztBlack();
    });
});
//收藏搜索
$("#fav_searchbtn").click(function (){
    favarr['searchword'] = $("#fav_search").val();
    $.get('/video/search-favorite',favarr,function(res){
        arrall['favorite-page'] = 1;
        if(res.errno==0){
            var html = findfavoritelist(res.data,false);
            $(".per-tab-w02-new.act .per-tab-video-list").html(html);
        }else{
            $(".per-tab-w02-new.act .per-tab-video-list").html(no_video_str);
        }
        ztBlack();
    });
});
function findfavoritelist(list,flag){
    var html = "";
    for(var i=0;i<list.length;i++) {
        var cat = list[i]['category'].split(' ');
        var catstr = "";
        for (var k = 0; k < cat.length; k++) {
            catstr += '<span>' + cat[k] + '</span>';
        }
        html += '<div class="RANbox-list01-new id_fav' + list[i]['video_id'] + '" name="zt">' +
            '<ul class="RANbox-list-xx-new">' +
            '<li>' +
            '<a href="/video/detail?video_id=' + list[i]['video_id'] + '"><img src="' + list[i]['cover'] + '"></a>' +
            '</li>' +
            '<li>' +
            '<a class="RAN-z-box01-name-new" href="<?= Url::to(['detail', 'video_id' => $video['video_id']])?>" name="zt"><?=$video['video_name']?></a>' +
            '<div class="GNbox-type-new" name="zt">' + catstr +
            '</div>' +
            '<div class="RANbox-list01-b-new">' +
            '<span>' + (list[i]['is_finished'] == 1 ? '完结' : '更新中') + '</span>' +
            '<span>' + list[i]['flag'] + '</span>' +
            '</div>' +
            '</li>' +
            '<li>' +
            '<div class="RANbox-choose">' +
            '<div class="RANbox-choose-img J_choose_check" onclick="favchoose(this);"></div>' +
            '</div>' +
            '<input type="button" value="删除" onclick="removefavorite(' + list[i]['video_id'] + ')">' +
            '</li>' +
            '</ul>' +
            '</div>';
    }
    return html;
}
//删除收藏
function removefavorite(videoid){
    var arrindex = {};
    if(videoid=='all'){
        var videoids = '';
        $(".J_choose_check").each(function(){
            if($(this).hasClass('act')){
                videoids += $(this).attr('data-value')+",";
            }
        });
        if(videoids!=''){
            videoids = videoids.substring(0,videoids.length-1);
            arrindex['videoid'] = videoids;
        }
    }else{
        arrindex['videoid'] = videoid;
    }
    $.get('/video/change-favorite',arrindex,function(res){
        if(res.errno==0 && res.data.status==0){
            if(videoid=='all'){
                var num = $(".per-tab-w02-new.act .RANbox-list-xx-new .J_choose_check.act").length;
                var all_num = $(".per-tab-w02-new.act .RANbox-list-xx-new .J_choose_check").length;
                if(num == all_num){
                    $(".per-tab-w02-new.act .per-tab-video-list").html(no_video_str);
                }
                var videoar = videoids.split(",");
                for(var i=0;i<videoar.length;i++){
                    console.log(videoar[i]);
                    $(".id_fav"+videoar[i]).remove();
                }
            }else{
                $(".id_fav"+videoid).remove();
            }
            unselectAll();
            $("#pop-tip").text("删除成功");
            $("#pop-tip").show().delay(1500).fadeOut();
        }
    });
}

function unselectAll(){
    //同时更新删除数量
    var num = $(".per-tab-w02-new.act .RANbox-list-xx-new .J_choose_check.act").length;
    $(".J_del_num span").text(num);
}

/*-----------播放记录(新)------------*/
//分类获取播放记录
function channelswatchlog(channel_id,obj){
    $(obj).addClass('act').siblings().removeClass('act');
    var arr = {};
    if(channel_id != 'all'){
        arr['channel_id'] = channel_id;
    }
    var str = $("#watchlog_stext").val();
    if(str){
        arr['searchword'] = str;
    }
    console.log(arr);
    $.get('/video/search-watchlog',arr,function(res){
        arrall['watchlog-page'] = 1;
        console.log(res);
        if(res.errno==0){
            var html = findwatchloglist(res.data);
            $(".per-tab-box-new.act").find(".per-tab-w02-new.act").html(html);
        }else{
            $(".per-tab-box-new.act").find(".per-tab-w02-new.act").html(no_video_str);
        }
        ztBlack();
    });
}
//删除播放记录
function removewatchlog(logid){
    var arrindex = {};
    arrindex['logid'] = logid;
    console.log(logid);
    if(logid=='all'){
        var logid = '';
        $(".J_choose_check").each(function(){
            if($(this).hasClass('act')){
                logid += $(this).attr('data-value')+",";
            }
        });
        if(logid!=''){
            logid = logid.logid(0,logid.length-1);
            arrindex['logid'] = logid;
        }
    }
    $.get('/video/remove-watchlog',arrindex,function(res){
        if(res.errno==0 && res.data>0){
            if(logid=='all'){
                //获取选中数量是否与现有总数一致，一致则清空
                var num = $(".per-tab-w02-new.act .RANbox-list-xx-new .J_choose_check.act").length;
                var all_num = $(".per-tab-w02-new.act .RANbox-list-xx-new .J_choose_check").length;
                if(num == all_num){
                    $(".per-tab-w02-new.act").html(no_video_str);
                }
                var logidar = logid.split(",");
                for(var i=0;i<logidar.length;i++){
                    $(".id_watchlog_"+logidar[i]).remove();
                }
            }else{
                $(".id_watchlog_"+logid).remove();
            }
            $("#pop-tip").text("删除成功");
            $("#pop-tip").show().delay(1500).fadeOut();
        }
    });
}
//播放记录搜索
$(function(){
    $("#watchlog_search").click(function(){
        var str = $("#watchlog_stext").val();
        console.log(str);
        var arr = {};
        arr['searchword'] = str;
        $.get('/video/search-watchlog', arr,function(res){
            arrall['watchlog-page'] = 1;
            console.log(res);
            if(res.errno==0){
                var html = findwatchloglist(res.data);
                $(".per-tab-box-new.act").find(".per-tab-w02-new.act").html(html);
            }else{
                $(".per-tab-box-new.act").find(".per-tab-w02-new.act").html(no_video_str);
            }
            ztBlack();
        });
    });
});
function findwatchloglist(list){
    var html = "";
    for(var i=0;i<list.length;i++){
        html += '<div class="per-bf-lst">'+
                '<div class="per-bf-lst-btn">'+list[i]['date']+'</div>';
        var video = list[i]['list'];
        for(var j=0;j<video.length;j++) {
            var cat = video[j]['category'].split(' ');
            var catstr = "";
            for (var k = 0; k < cat.length; k++) {
                catstr += '<span>' + cat[k] + '</span>';
            }
            html += '<ul class="per-bof-box id_watchlog_' + video[j]['log_id'] + '" name="zt">' +
                '<li class="per-bof-box-01">' + video[j]['show_times'] + '</li>' +
                '<li class="per-bof-box-02" name="zt">' +
                '<div class="RANbox-list01" name="zt">' +
                '<ul class="RANbox-list-xx RANbox-list-xx-new">' +
                '<li>' +
                '<a href="/video/detail?video_id=' + video[j]['video_id'] + '"><img src="' + video[j]['cover'] + '"></a>' +
                '</li>' +
                '<li>' +
                '<a class="RAN-z-box01-name-new" href="/video/detail?video_id=' + video[j]['video_id'] + '" name="zt">' + video[j]['title'] + '</a>' +
                '<div class="GNbox-type-new" name="zt">' + catstr +
                '</div>' +
                '<div class="RANbox-list01-b-new">' +
                '<span>' + (list[i]['is_finished'] == 1 ? '完结' : '更新中') + '</span>' +
                '<span>' + video[j]['flag'] + '</span>' +
                '</div>' +
                '</li>' +
                '<li>' +
                '<div class="RANbox-choose">' +
                '<div class="RANbox-choose-img J_choose_check" data-value="1" onclick="favchoose(this);"></div>' +
                '</div>' +
                '<input type="button" value="删除" onclick="removewatchlog(' + video[j]['log_id'] + ');">' +
                '</li>' +
                '</ul>' +
                '</div>' +
                '</li>' +
                '</ul>';
        }
        html += '</div>';
    }
    return html;
}
/*-----------下拉加载更多------------*/
var progress = false; // 是否正在请求中
var isFlag = true;
$(window).scroll(function () {
    if (($(window).scrollTop()+488) >= $(document).height() - $(window).height()) {
        if(isFlag) {
            var tab = $(".per-tab>li.act").attr("data-value");
            var total = 0;
            var page  = 0;
            var r = "";
            var c = "";
            var params = {};
            params['tab'] = tab;
            if(tab=="favorite" ||tab=="watchlog"){
                total = arrall[tab+'-total'];
                page  = arrall[tab+'-page'];
            }else if(tab=="relation"){
                r = $(".per-tab03>li.act").attr("data-type");
                total = arrall[tab+r+'-total'];
                page  = arrall[tab+r+'-page'];
            }else if(tab=="comment"){
                c = $(".per-tab04>li.act").attr("data-type");
                total = arrall[c+'-total'];
                page  = arrall[c+'-page'];
            }
            if (parseInt(page) < parseInt(total) && !progress) {
                // $(".more-load").show();
                progress = true;
                page++;
                params['page_num'] = page;
                if(tab=="relation"){
                    params = expendObject(params,relaAr);
                    arrall[tab+r+'-page'] = page;
                }else if(tab=="favorite"){
                    params = expendObject(params,favarr);
                    arrall[tab+'-page'] = page;
                }else if(tab=="watchlog"){
                    params['searchword'] = $("#watchlog_stext").val();
                    arrall[tab+'-page'] = page;
                }else if(tab=="comment"){
                    var type = $(".per-tab04>li.act").attr("data-type");
                    params['ctype'] = (type!=""?type:"comment");
                    arrall[c+'-page'] = page;
                }
                //console.log(params);
                $.get('/video/load-more', params, function(res) {
                    // console.log(res);
                    // $(".more-load").hide();
                    if(res.errno==0){
                        var html = "";
                        if(tab=="relation"){
                            html = findrelationlist(res.data,relaAr['type']);
                            // $(".per-tab-w03>div").eq(relaAr['tabNum']).append(html);
                            $(".per-tab-box03.act").append(html);
                        }else if(tab=="favorite"){
                            var favoflag = $(".per-sp-box02").hasClass("act")? true : false;
                            html = findfavoritelist(res.data,favoflag);
                            $(".per-tab-w02-new.act .per-tab-video-list").append(html);
                        }else if(tab=="watchlog"){
                            html = findwatchloglist(res.data);
                            $(".per-tab-w02-new.act").append(html);
                        }else if(tab=="comment"){
                            html = findcommentlist(res.data,type);
                            $(".per-tab-box04.act").append(html);
                        }
                        ztBlack();
                    }
                    progress = false;
                });
            } else if (page == total) {
                progress = false;
            }
            isFlag = false;
        }
    }else {
        isFlag = true;
    }
});
function findcommentlist(list,type){
    var html = '';
    for(var i=0;i<list.length;i++){
        if(type=="system_message"){
            html += '<ul class="per-now-box message_'+list[i]['message_id']+'" name="zt">'+
                        '<li class="per-now-h"><img src="/images/newindex/admin_avatar.png" /></li>'+
                        '<li>'+
                            '<div class="per-now-box-01"><div>系统管理员</div></div>'+
                            '<div class="per-now-box-02" name="zt">'+list[i]['content']+'</div>'+
                            '<ul class="per-now-box-03" name="zt">'+
                                '<li>'+list[i]['date']+'</li>'+
                                '<li><input class="per-btn-s" onclick="removecomment(this)" type="button" name="" data-value="'+list[i]['message_id']+'" data-type="message" value="删除" /></li>'+
                            '</ul>'+
                        '</li>'+
                    '</ul>';
        }else{
            var avastr = "";
            if(list[i]['avatar']!=""){
                avastr = '<img src="'+list[i]['avatar']+'" />';
            }else{
                avastr = '<img src="/images/newindex/logon.png" />';
            }
            var gerstr = "";
            if(list[i]['gender']==2){
                gerstr = '<img src="/images/newindex/nan.png" />';
            }else if(list[i]['gender']==1){
                gerstr = '<img src="/images/newindex/nv.png" />';
            }
            html += '<ul class="per-now-box comment_'+list[i]['comment_id']+'" name="zt">'+
                    '<li class="per-now-h">'+
                        '<div class="navTopLogonImg">'+
                            '<a href="javascript">'+avastr+'</a>'+
                        '</div>'+
                        '<div class="navTopLogon-GRXX" name="zt">'+
                            '<div class="navTopLogon-GRXX-box">'+
                                '<ul class="navTopLogon-box01">'+
                                    '<li class="navTopLogon-name"><img src="/images/newindex/VIP-1.png" />'+list[i]['username']+'</li>'+
                                    '<li class="navTopLogon-Gender">'+gerstr+'</li>'+
                                '</ul>'+
                                '<ul class="navTopLogon-box02">'+
                                    '<li class="navTopLogon-rank">LV.<span>'+list[i]['grade']+'</span></li>'+
                                    '<li class="navTopLogon-icon01"><img src="/images/newindex/jinbi.png" /></li>'+
                                    '<li class="navTopLogon-text">'+list[i]['score']+'</li>'+
                                    '<li class="per-gz-dz"></li>'+
                                '</ul>'+
                            '</div>'+
                            '<ul class="navTopLogon-box03">'+
                                '<li>'+
                                    '<a class="navTopLogon-A" href="/video/other-home?uid='+list[i]['uid']+'">个人主页</a>'+
                                '</li>'+
                                '<li></li>'+
                            '</ul>'+
                        '</div>'+
                    '</li>'+
                    '<li>'+
                        '<div class="per-now-box-01">'+
                            '<div>'+list[i]['username']+'</div>'+
                            '<img src="/images/newindex/lv_1.png" />'+
                            '<a href="/video/detail?video_id='+list[i]['video_id']+'">'+list[i]['film_name']+'</a>'+
                        '</div>'+
                        '<div class="per-now-box-02" name="zt">'+list[i]['content']+'</div>'+
                        '<ul class="per-now-box-03" name="zt">'+
                            '<li>'+list[i]['date']+'</li>'+
                            '<li><input class="per-btn-z" onclick="commentAddlikes(this)" type="button" data-value="'+list[i]['comment_id']+'" /><span>'+list[i]['likes_num']+'</span></li>'+
                            '<li><input class="per-btn-s" onclick="removecomment(this)" type="button" data-value="'+list[i]['comment_id']+'" data-type="comment" value="删除" /></li>'+
                        '</ul>'+
                    '</li>'+
                '</ul>';
        }
    }
    return html;
}
function expendObject(o,n){
    for (var p in n){
        if(n.hasOwnProperty(p))
            o[p]=n[p];
    }
    return o;
}
</script>
