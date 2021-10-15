<?php
use yii\helpers\Url;
?>
<style>
    .XX-a{display:block;}
    .XX-adiv{height:50px;padding:5px 0;}
    .XX-adiv div{
        height:25px;line-height:25px;
        color: #999999;
        text-align:left;
        padding-left:15px;
        overflow: hidden;
        text-overflow:ellipsis;
        white-space: nowrap;
    }
    .XX-adiv span{color:#FF5722;padding:0 5px;}
    .ls-div{margin-left: -250px;}
</style>
<script>
    //tab 切换
    $(document).ready(function() {
        $(".XX-tabA>li").click(function() {
            var tabNum = $(this).index();
            $(this).addClass("tabA").siblings().removeClass("tabA");
            $(".XX-tabBox>div").eq(tabNum).addClass("tabBox").siblings().removeClass("tabBox");
        });
    });
</script>
<input type="hidden" id="login_id" value="<?=$data['main_uid']?>" />
<!--升级vip-->
<?php if($data['isvip']!=1){
    $vip_display = "";
}else{
    $vip_display = "display:none;";
}?>
<div id="vipbtn" class="navTopBtn " style="<?=$vip_display?>">
    <div class="navTopBtnImg">
        &nbsp;
    </div>
    <div class="navTopBtnName">
        升级VIP
    </div>
    <!--登录显示-->
    <div class="VIPHui" style="display: none;">
        惠
    </div>
    <!--菜单-->
    <ul class="VIPmenuBOX " name="zt" style="display: none;">
        <li class="VIPmenuBOX-li">
            <div class="VIPmenuBOX-liText">
                还不是VIP？会员
            </div>
            <div class="VIPmenuBOX-liBtn">
                <input type="button"  value="立即开通" />
            </div>
        </li>
        <li class="VIPmenuBOX-A " name="zt">
            <a href="javascript:;">
                <img src="/images/newindex/adguanggao.png" /> 过滤广告
            </a>
        </li>
        <li class="VIPmenuBOX-A " name="zt">
            <a href="javascript:;">
                <img src="/images/newindex/hdchaoqing.png" /> 观看超清视频
            </a>
        </li>
        <li class="VIPmenuBOX-A " name="zt">
            <a href="javascript:;">
                <img src="/images/newindex/xiazai.png" /> 下载视频
            </a>
        </li>
        <li class="VIPmenuBOX-A " name="zt">
            <a href="javascript:;">
                <img src="/images/newindex/pianku.png" /> 求片
            </a>
        </li>
        <li class="VIPmenuBOX-A " name="zt">
            <a href="javascript:;">
                <img src="/images/newindex/Vipbiaoshi.png" /> 尊贵身份标识
            </a>
        </li>
        <!--登录后显示-->
        <div class="LSmenuBottom">
            <div class="LSmenuBottom-rg">
                <a href="javascript:;">前往会员专区&nbsp;》</a>
            </div>
        </div>
    </ul>
</div>
<!--福利-->
<div class="navTopBtn" onclick="showwarning();">
    <div class="navTopBtnImg">
        &nbsp;
    </div>
    <div class="navTopBtnName">
        福利
    </div>
    <div class="VIPmenuTop " name="zt">
        &nbsp;
    </div>
    <!--菜单-->
    <ul class="FLmenuBox " name="zt" style="display: none;">
        <li class="FLmenuBox-li">
            <a href="javascript:;">
                <div class="FLmenuBox-liImg">
                    <img src="/images/newindex/qiandao.png" />
                </div>
                <div class="FLmenuBox-liText">
                    每日签到
                </div>
            </a>
        </li>
        <li class="FLmenuBox-li">
            <a href="javascript:;">
                <div class="FLmenuBox-liImg">
                    <img src="/images/newindex/renwu.png" />
                </div>
                <div class="FLmenuBox-liText">
                    日常任务
                </div>
            </a>
        </li>
    </ul>
</div>
<!--上传-->
<div class="navTopBtn" onclick="showwarning();">
    <div class="navTopBtnImg">
        &nbsp;
    </div>
    <div class="navTopBtnName">
        上传
    </div>
    <div class="VIPmenuTop " name="zt">
        &nbsp;
    </div>
    <!--菜单-->
    <ul class="FLmenuBox " name="zt" style="display: none;">
        <li class="FLmenuBox-li">
            <a href="javascript:;">
                <div class="FLmenuBox-liImg">
                    <img src="/images/newindex/Sdianying.png" />
                </div>
                <div class="FLmenuBox-liText">
                    上传视频
                </div>
            </a>
        </li>
        <li class="FLmenuBox-li">
            <a href="javascript:;">
                <div class="FLmenuBox-liImg">
                    <img src="/images/newindex/Sjuji.png" />
                </div>
                <div class="FLmenuBox-liText">
                    上传剧集
                </div>
            </a>
        </li>
    </ul>
</div>
<!--观看历史-->
<div class="navTopBtn">
    <div class="navTopBtnImg">
        &nbsp;
    </div>
    <div class="navTopBtnName">
        观看历史
    </div>
    <div class="VIPmenuTop " name="zt">
        &nbsp;
    </div>
    <!--菜单-->
    <div class="LSmenuBox ls-div" name="zt" id="LSmenuBox_div">
        <?php if(!$data['watchlog']):?>
            <!--无记录   显示-->
            <div class="LSmenu-No">暂无历史</div>
        <?php else :?>
            <!--有记录显示-->
            <ul class="LSmenu " name="zt">
                <?php foreach ($data['watchlog'] as $watchlist):?>
                    <?php foreach ($watchlist['list'] as $watchlog):?>
                        <li>
                            <a href="<?= Url::to(['detail', 'video_id' => $watchlog['video_id']])?>">
                                <div><?=$watchlog['title']?></div>
                                <div><?=$watchlog['chapter_title']?></div>
                                <div>
                                    <span><?=$watchlog['time_diff']?></span>
                                    <!--<span>天前</span>-->
                                </div>
                            </a>
                        </li>
                    <?php endforeach;?>
                <?php endforeach;?>
            </ul>
        <?php endif;?>
        <div class="LSmenuBottom" style="<?=$data['login_show']?>">
            <div class="LSmenuBottom-lf" onclick="removetab('watchlog');">
                &nbsp;
            </div>
            <div class="LSmenuBottom-rg">
                <a href="<?= Url::to(['/video/personal', 'ptab' => 'watchlog'])?>">查看更多&nbsp;》</a>
            </div>
        </div>
    </div>
</div>
<!--通知-->
<div class="navTopBtn">
    <div class="navTopBtnImg">
        &nbsp;
    </div>
    <div class="navTopBtnName">
        通知
    </div>
    <div class="VIPmenuTop " name="zt">
        &nbsp;
    </div>
    <!--菜单未登录显示-->
    <ul class="FLmenuBox " name="zt" style="display: none;">
        <li class="FLmenuBox-li">
            <a href="javascript:;">
                <div class="FLmenuBox-liImg">
                    <img src="/images/newindex/xiaoxi.png" />
                </div>
                <div class="FLmenuBox-liText">
                    消息
                </div>
            </a>
        </li>
        <li class="FLmenuBox-li">
            <a href="javascript:;">
                <div class="FLmenuBox-liImg">
                    <img src="/images/newindex/guanzu.png" />
                </div>
                <div class="FLmenuBox-liText">
                    关注&收藏
                </div>
            </a>
        </li>
    </ul>
    <!--登录显示-->
    <div class="LSmenuBox lf " name="zt" style="<?=$data['login_show']?>">
        <ul class="XX-tabA " name="zt">
            <li class="tabA">消息</li>
            <li>关注&收藏</li>
        </ul>
        <div class="XX-tabBox">
            <div id="XX-tabBox-message" class="tabBox">
                <?php if(!$data['message']):?>
                    <div class="LSmenu-No">暂无历史</div>
                <?php else:?>
                    <?php foreach ($data['message'] as $m):?>
                        <a class="XX-a" href="<?= Url::to(['/video/personal', 'ptab' => 'message'])?>" >
                            <div class="XX-adiv">
                                <div><?=$m['content']?></div>
                                <div><?=$m['time_diff']?></div>
                            </div>
                        </a>
                    <?php endforeach;?>
                <?php endif;?>
                <div class="LSmenuBottom">
                    <div class="LSmenuBottom-lf" onclick="removetab('message');">
                        &nbsp;
                    </div>
                    <div class="LSmenuBottom-rg">
                        <a href="<?= Url::to(['/video/personal', 'ptab' => 'message'])?>">更多&nbsp;》</a>
                    </div>
                </div>
            </div>
            <div id="XX-tabBox-favorite">
                <?php if(!$data['favorite']):?>
                    <div class="LSmenu-No">暂无历史</div>
                <?php else:?>
                    <?php foreach ($data['favorite'] as $f):?>
                        <a class="XX-a" href="<?= Url::to(['detail', 'video_id' => $f['video_id']])?>" >
                            <div class="XX-adiv">
                                <?php $favoStr = '';
                                if($f['type']=='favorite'){
                                    $favoStr = "您收藏的<span> 《".$f['video_name']."》 </span>已更新至 <span>".$f['chapter_title']."</span>";
                                }//关注消息等上传视频后再加
                                ?>
                                <div><?=$favoStr?></div>
                                <div><?=$f['time_diff']?></div>
                            </div>
                        </a>
                    <?php endforeach;?>
                <?php endif;?>
                <div class="LSmenuBottom">
                    <div class="LSmenuBottom-lf" onclick="removetab('favorite');">
                        &nbsp;
                    </div>
                    <div class="LSmenuBottom-rg">
                        <a href="<?= Url::to(['/video/personal', 'ptab' => 'favorite'])?>">更多&nbsp;》</a>
                    </div>
                </div>
            </div>
        </div>

<!--        <div class="LSmenuBottom">-->
<!--            <div class="LSmenuBottom-lf">-->
<!--                &nbsp;-->
<!--            </div>-->
<!--            <div class="LSmenuBottom-rg">-->
<!--                <a href="javascript:;">更多&nbsp;》</a>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>
<!--未登录显示-->
<div class="navTopLogon" id="notloggedin" style="<?=$data['notlogin_show']?>">
    <div class="navTopLogonImg-no">
        <img src="/images/newindex/logon.png" />
    </div>
    <div class="navTopLogonName " name="zt">
        登录
    </div>
</div>
<!--登录显示-->
<div class="navTopLogon" id="loggedin" style="<?=$data['login_show']?>">
    <div class="navTopLogonImg">
        <?php $avatar = '';
        if($data['user']['avatar']==1){
            $avatar = $data['user']['avatar'];
        }else{
            $avatar = '/images/newindex/logon.png';
        }?>
        <img id="user_headimg" src="<?=$avatar?>" onerror="javascript:this.src='/images/newindex/logon.png';" />
    </div>
    <div class="navTopLogon-GRXX " name="zt">
        <div class="navTopLogon-GRXX-box">
            <ul class="navTopLogon-box01">
                <li class="navTopLogon-name" id="user_name"><?=$data['user']['nickname']?></li>
                <?php $gender = '';
                if($data['user']['gender']==1){
                    $gender = '<img src="/images/newindex/nv.png" />';
                }else if($data['user']['gender']==2){
                    $gender = '<img src="/images/newindex/nan.png" />';
                }?>
                <li class="navTopLogon-Gender"><?=$gender?></li>
            </ul>
            <ul class="navTopLogon-box02">
                <li class="navTopLogon-icon01"><img src="/images/newindex/jinbi.png" /></li>
                <li class="navTopLogon-text" class="user_score">0</li>
                <?php if($data['isvip']!=1){
                    $vipstr = "还不是vip会员";
                }else{
                    $vipstr = "";
                }?>
                <li class="navTopLogon-text" id="user_isvip"><?=$vipstr?></li>
                <li class="navTopLogon-rank">LV.<span id="user_grade">1</span></li>
                <!--<li class="navTopLogon-icon01"><img src="/images/newindex/shangsheng.png" /></li>
                <li class="navTopLogon-Progress">
                    <div>
                        <div class="Progress">&nbsp;</div>
                    </div>
                </li>
                <li class="navTopLogon-experience">
                    <span class="user_score">76</span>/<span id="user_allscore">200</span>
                </li>-->
            </ul>
        </div>
        <ul class="navTopLogon-box03">
            <li>
                <a class="navTopLogon-A" href="<?= Url::to(['/video/personal'])?>">个人中心</a>                        </li>
            <li><input class="navTopLogon-btn" type="" name="" id="logout" value="退出" /></li>
        </ul>
    </div>
</div>
<script>
//初始化验证码
var verifyCode = new GVerify({
    id : "picyzm",
    type : "blend"
});
$(function(){
    //刷新验证码
    $("#v_refresh").click(function(){
        verifyCode.refresh();
    });
    //未登录状态-登录
    $("#notloggedin").click(function(){
        showloggedin();
    });
    //提交登录
    $("#login_submit").click(function(){
        $(this).addClass("login-loading");
        var account = $("#login_account").val();
        var pwd = $("#login_pwd").val();
        var yzm = verifyCode.validate($("#login_yzm").val());
        var tab = true;
        var arrIndex = {};
        if(account==""){
            $("#login_account").parent().addClass("wor");
            $(".alt-title").text("账号不能为空");
            $("#alt05").show();
            verifyCode.refresh();
            tab = false;
            $("#login_submit").removeClass("login-loading");
            return false;
        }else{
            var ismobile = isMobilePhone(account);
            var isemail = isEmail(account);
            if(!ismobile && !isemail){
                $("#login_account").parent().addClass("wor");
                $(".alt-title").text("账号格式错误");
                $("#alt05").show();
                verifyCode.refresh();
                tab = false;
                $("#login_submit").removeClass("login-loading");
                return false;
            }else{
                arrIndex['account'] = account;
            }
        }
        if(pwd==""){
            $("#login_pwd").parent().addClass("wor");
            $(".alt-title").text("密码不能为空");
            $("#alt05").show();
            verifyCode.refresh();
            tab = false;
            $("#login_submit").removeClass("login-loading");
            return false;
        }else{
            arrIndex['password'] = pwd;
        }
        if(!yzm) {
            //验证不通过
            $("#login_yzm").parent().addClass("wor");
            $(".alt-title").text("验证码错误");
            $("#alt05").show();
            verifyCode.refresh();
            tab = false;
            $("#login_submit").removeClass("login-loading");
            return false;
        }
        if(!$("#xy").hasClass("act")){
            $(".alt-title").text("请阅读并同意《用户协议》");
            $("#alt05").show();
            verifyCode.refresh();
            tab = false;
            $("#login_submit").removeClass("login-loading");
            return false;
        }
        if(tab){
            $.get('/site/login',arrIndex,function(res){
                // console.log(res);
                $("#login_submit").removeClass("login-loading");
                if(res.errno==0 && res.data){
                    //登陆成功,页面刷新
                    var zd = $("#zd").hasClass("act")? 1:0;
                    if(!isNaN(res.data) && res.data!=""){
                        saveuser(res.data,zd);
                    }
                    location.reload();
                    // showlogin(res.data);
                    // $("#login_id").val(res.data.uid);
                    // $("#alt01").hide();
                }else{
                    $("#login_account").parent().addClass("wor");
                    $("#login_pwd").parent().addClass("wor");
                    $(".alt-title").text("账号或密码错误");
                    $("#alt05").show();
                    verifyCode.refresh();
                }
            });
        }
    });
    //提交注册
    $("#reg_submit").click(function(){
        $(this).addClass("login-loading");
        var email = $("#reg_email").val();
        var prefix_phone = $("#reg_prefix_phone").val();
        var phone = $("#reg_phone").val();
        var newpwd = $("#reg_newpwd").val();
        var question = $("#reg_question").val();
        var answer = $("#reg_answer").val();
        var tab = true;
        var arrIndex = {};
        if(email==""){
            $("#reg_email").parent().addClass("wor");
            $(".alt-title").text("邮箱不能为空");
            $("#alt05").show();
            tab = false;
            $("#reg_submit").removeClass("login-loading");
            return false;
        }else{
            var isemail = isEmail(email);
            if(!isemail){
                $("#reg_email").parent().addClass("wor");
                $(".alt-title").text("邮箱格式错误");
                $("#alt05").show();
                tab = false;
                $("#reg_submit").removeClass("login-loading");
                return false;
            }else{
                arrIndex['email'] = email;
            }
        }
        if(phone==""){
            $("#reg_phone").parent().addClass("wor");
            $(".alt-title").text("手机号不能为空");
            $("#alt05").show();
            tab = false;
            $("#reg_submit").removeClass("login-loading");
            return false;
        }else{
            var ismobile = isMobilePhone(phone);
            if(!ismobile){
                $("#reg_phone").parent().addClass("wor");
                $(".alt-title").text("手机号格式错误");
                $("#alt05").show();
                tab = false;
                $("#reg_submit").removeClass("login-loading");
                return false;
            }else{
                arrIndex['prefix_phone'] = prefix_phone;
                arrIndex['phone'] = phone;
            }
        }
        if(newpwd==""){
            $("#reg_newpwd").parent().addClass("wor");
            $(".alt-title").text("新密码不能为空");
            $("#alt05").show();
            tab = false;
            $("#reg_submit").removeClass("login-loading");
            return false;
        }else{
            arrIndex['newpwd'] = newpwd;
        }
        if(answer==""){
            $("#reg_answer").parent().addClass("wor");
            $(".alt-title").text("密保答案不能为空");
            $("#alt05").show();
            tab = false;
            $("#reg_submit").removeClass("login-loading");
            return false;
        }else{
            arrIndex['question'] = question;
            arrIndex['answer'] = answer;
        }
        if(!$("#xy").hasClass("act")){
            $(".alt-title").text("请阅读并同意《用户协议》");
            $("#alt05").show();
            tab = false;
            $("#reg_submit").removeClass("login-loading");
            return false;
        }
        if(tab){
            $.get('/video/register', arrIndex, function(res) {
                //console.log(res);
                $("#reg_submit").removeClass("login-loading");
                if(res.errno==0){
                    //注册成功,页面刷新
                    var zd = $("#zd").hasClass("act")? 1:0;
                    if(!isNaN(res.data.uid) && res.data.uid!=""){
                        saveuser(res.data.uid,zd);
                    }
                    location.reload();
                    // showlogin(res.data);
                    // $("#login_id").val(res.data.uid);
                    // $("#alt01").hide();
                    // $(".alt-title").text("注册成功");
                    // $("#alt05").show();
                }else{
                    var mes = "";
                    if(res.data!=''){
                        mes = res.data.message;
                    }else{
                        mes = '注册失败';
                    }
                    $("#login_account").parent().addClass("wor");
                    $("#login_pwd").parent().addClass("wor");
                    $(".alt-title").text(mes);
                    $("#alt05").show();
                }
            });
        }
    });
    //登录状态-退出
    $("#logout").click(function(){
        $.get('/site/logout', {}, function(res) {
            if(res.errno==0){
                $("#login_id").val("");
                $("#notloggedin").show();
                $("#loggedin").hide();
                removeuser();
                location.reload();
            }
        });
    });
    //升级vip
    $("#vipbtn").click(function(){
        var uid = finduser();
        if(!isNaN(uid) && uid!=""){
            $("#mvip-title").text("您还不是vip呦！赶紧联系客服吧");
            $("#altvip").show();
        }else{//弹框登录
            showloggedin();
        }
    });
});
function removetab(tab){
    var arr = {};
    if(tab=='watchlog'){//删除全部播放记录
        arr ['logid'] = 'all';
        $.get('/video/remove-watchlog',arr,function(res){
            if(res.errno==0){
                $("#LSmenuBox_div").find("ul.LSmenu").remove();
                $("#LSmenuBox_div").find("div.LSmenu-No").remove();
                $("#LSmenuBox_div").prepend("<div class='LSmenu-No'>暂无历史</div>");
                $(".alt-title").text("播放记录删除成功");
                $("#alt05").show();
            }else{
                $(".alt-title").text("播放记录删除失败");
                $("#alt05").show();
            }
        });
    }else if(tab=='favorite'){//删除所有收藏/关注消息
        arr ['type'] = 'all';
        $.get('/video/remove-fmes', arr,function(res){
            if(res.errno==0 && res.data>0){
                $("#XX-tabBox-favorite").find("a.XX-a").remove();
                $("#XX-tabBox-favorite").find("div.LSmenu-No").remove();
                $("#XX-tabBox-favorite").prepend("<div class='LSmenu-No'>暂无历史</div>");
                $(".alt-title").text("关注&收藏删除成功");
                $("#alt05").show();
            }else{
                $(".alt-title").text("关注&收藏删除失败");
                $("#alt05").show();
            }
        });
    }else if(tab=='message'){//删除消息
        arr['id'] = 'all';
        arr['type'] = 'message';
        $.get('/video/remove-message', arr,function(res){
            if(res.errno==0 && res.data>0){
                $("#XX-tabBox-message").find("a.XX-a").remove();
                $("#XX-tabBox-message").find("div.LSmenu-No").remove();
                $("#XX-tabBox-message").prepend("<div class='LSmenu-No'>暂无历史</div>");
                $(".alt-title").text("消息删除成功");
                $("#alt05").show();
            }else{
                $(".alt-title").text("消息删除失败");
                $("#alt05").show();
            }
        });
    }
}
</script>
