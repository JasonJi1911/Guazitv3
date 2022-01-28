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
            $(this).find(".LSmenu-line").addClass("act");
            $(this).siblings().find(".LSmenu-line").removeClass("act");
            $(".XX-tabBox>div").eq(tabNum).addClass("tabBox").siblings().removeClass("tabBox");
        });
    });
</script>
<input type="hidden" id="login_id" value="<?=$data['main_uid']?>" />
<!--观看历史/收藏-->
<div class="navTopBtn J_history">
    <div class="navTopBtnImg">
        &nbsp;
    </div>
    <!--登录显示-->
    <div class="LSmenuBox lf " name="zt" style="<?=$data['login_show']?>">
        <ul class="XX-tabA " name="zt">
            <li class="tabA">
                <p>观看记录</p>
                <p class="LSmenu-line act"></p>
            </li>
            <li>
                <p>我的收藏<p>
                <p class="LSmenu-line"></p>
            </li>
        </ul>
        <div class="XX-tabBox">
            <div class="tabBox" name="zt" id="LSmenuBox_div">
                <?php if(!$data['watchlog']):?>
                    <!--无记录   显示-->
                    <div class="LSmenu-No">暂无历史</div>
                <?php else :?>
                    <!--有记录显示-->
                    <ul class="LSmenu " name="zt">
                        <?php $i=0;?>
                        <?php foreach ($data['watchlog'] as $watchlist):?>
                            <?php foreach ($watchlist['list'] as $watchlog):?>
                                <?php $i++;?>
                                <?php if($i<6):?>
                                <li>
                                    <a href="<?= Url::to(['detail', 'video_id' => $watchlog['video_id']])?>">
                                        <div><?=$watchlog['title']?>&nbsp;&nbsp;<?php if($watchlog['chapter_title']):?>第<?=$watchlog['chapter_title']?>集<?php endif;?></div>
                                        <div>观看至<?=$watchlog['watch_percent']?>%</div>
                                        <div>
                                            <span><?=$watchlog['time_diff']?></span>
                                            <!--<span>天前</span>-->
                                        </div>
                                    </a>
                                </li>
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php endforeach;?>
                    </ul>
                    <div class="LSmenuBottom" style="<?=$data['login_show']?>">
                        <div class="LSmenuBottom-lf" onclick="removetab('watchlog');">
                            &nbsp;清除历史
                        </div>
                        <div class="LSmenuBottom-rg">
                            <a href="<?= Url::to(['/video/personal', 'ptab' => 'watchlog'])?>">查看更多&nbsp;》</a>
                        </div>
                    </div>
                <?php endif;?>
            </div>
            <div id="XX-tabBox-favorite">
                <?php if(!$data['favorite']):?>
                    <div class="LSmenu-No">暂无历史</div>
                <?php else:?>
                    <ul class="LSmenu " name="zt">
                    <?php foreach ($data['favorite'] as $key=>$f):?>
                        <?php if($key < 5):?>
<!--                        <a class="XX-a" href="--><?//= Url::to(['detail', 'video_id' => $f['video_id']])?><!--" >-->
<!--                            <div class="XX-adiv">-->
<!--                                --><?php //$favoStr = '';
//                                if($f['type']=='favorite'){
//                                    $favoStr = "您收藏的<span> 《".$f['video_name']."》 </span>已更新至 <span>".$f['chapter_title']."</span>";
//                                }//关注消息等上传视频后再加
//                                ?>
<!--                                <div>--><?//=$favoStr?><!--</div>-->
<!--                                <div>--><?//=$f['time_diff']?><!--</div>-->
<!--                            </div>-->
<!--                        </a>-->
                        <li>
                            <a href="<?= Url::to(['detail', 'video_id' => $f['video_id']])?>">
                                <div><?=$f['video_name']?>&nbsp;&nbsp</div>
                                <div><?=$f['is_finished']==1? '完结' : '更新中' ?></div>
                                <div>
                                    <?php if($f['is_finished']==1):?>
                                        <span></span>
                                    <?php else:?>
                                        <span><?=$f['flag']?></span>
                                    <?php endif;?>
                                    <!--<span>天前</span>-->
                                </div>
                            </a>
                        </li>
                        <?php endif;?>
                    <?php endforeach;?>
                    </ul>
                    <div class="LSmenuBottom">
                        <div class="LSmenuBottom-lf" onclick="removetab('favorite');">
                            &nbsp;清除历史
                        </div>
                        <div class="LSmenuBottom-rg">
                            <a href="<?= Url::to(['/video/personal', 'ptab' => 'favorite'])?>">查看更多&nbsp;》</a>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<!--未登录显示-->
<div class="navTopLogon" id="notloggedin" style="<?=$data['notlogin_show']?>">
    <div class="navTopLogonImg-no">
        <img src="/images/Index/user.png" />
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
            $avatar = '/images/Index/user_c.png';
        }?>
        <img id="user_headimg" src="<?=$avatar?>" onerror="javascript:this.src='/images/Index/user_c.png';" />
    </div>
    <div class="navTopLogonName " name="zt">
<!--        --><?//=$data['user']['nickname'];?>
        瓜子用户
    </div>
    <div class="navTopLogon-GRXX " name="zt">
        <ul class="navTopLogon-box03">
            <li>
                <a class="navTopLogon-A" href="<?= Url::to(['/video/personal'])?>">个人中心</a></li>
            <li><span class="navTopLogon-btn" id="logout">退出登录</span></li>
        </ul>
    </div>
</div>
<script>
$(function(){
    //查看历史记录
    $(".J_history").click(function(){
        var uid = finduser();
        if(!isNaN(uid) && uid!="") {
            $(".LSmenuBox").show();
        } else {
            showloggedin();
        }
    });
    //未登录状态-登录
    $("#notloggedin").click(function(){
        showloggedin();
    });
    //账号密码登录
    $("#login_submit").click(function(){
        var account = $("#login_account").val();
        var prefix_phone = $("#login_prefix_phone").attr('data');
        var pwd = $("#login_pwd").val();
        var tab = true;
        var arrIndex = {};
        if(account==""){
            $("#login_account").parent().addClass("wor");
            $(".J_login_warning").text("账号不能为空");
            $(".J_login_warning").show();
            tab = false;
            $("#login_submit").removeClass("login-loading");
            return false;
        }else{
            var ismobile = isMobilePhone(account);
            if(!ismobile){
                $("#login_account").parent().addClass("wor");
                $(".J_login_warning").text("账号格式错误");
                $(".J_login_warning").show();
                tab = false;
                return false;
            }else{
                arrIndex['mobile'] = account;
                arrIndex['mobile_areacode'] = prefix_phone;
            }
        }
        if(pwd==""){
            $("#login_pwd").parent().addClass("wor");
            $(".J_login_warning").text("密码不能为空");
            $(".J_login_warning").show();
            tab = false;
            return false;
        }else{
            arrIndex['password'] = pwd;
        }
        if(!$("#xy").hasClass("act")){
            $(".J_login_warning").text("请阅读并同意《用户协议》和《隐私政策》");
            $(".J_login_warning").show();
            tab = false;
            return false;
        }
        if(tab){
            arrIndex['flag'] = 0;//flag: 0-密码；1-短信验证码
            console.log(arrIndex);
            $.get('/site/new-login',arrIndex,function(res){
                // console.log(res);
                $("#login_submit").removeClass("login-loading");
                if(res.errno==0 && res.data){
                    //登陆成功,页面刷新
                    var zd = $("#zd").hasClass("act")? 1:0;
                    if(!isNaN(res.data) && res.data!=""){
                        saveuser(res.data,zd);
                    }
                    location.reload();
                }else{
                    $("#login_account").parent().addClass("wor");
                    $("#login_pwd").parent().addClass("wor");
                    $(".J_login_warning").text("账号或密码错误");
                    $(".J_login_warning").show();
                }
            });
        }
    });
    //发送短信验证码
    $('.J_sms_code').click(function(){
        sendyzm($(this));
    });
    //用ajax提交到后台的发送短信接口
    function sendyzm(obj){
        var prefix_phone = $(obj).parent().siblings('.J_tel').find('.J_prefix_phone').attr('data');
        var account = $(obj).parent().siblings('.J_tel').find('.J_account').val();
        var send_source = $(obj).attr('source');
        var tab = true;
        var arrIndex = {};
        if(account==""){
            $(obj).parent().siblings('.J_tel').addClass("wor");
            $(obj).parent().siblings(".loginTip").text("账号不能为空");
            $(obj).parent().siblings(".loginTip").show();
            tab = false;
            return false;
        }else{
            var ismobile = isMobilePhone(account);
            if(!ismobile){
                $(obj).parent().siblings('.J_tel').addClass("wor");
                $(obj).parent().siblings(".loginTip").text("账号格式错误");
                $(obj).parent().siblings(".loginTip").show();
                tab = false;
                return false;
            }
        }
        if(tab) {
            arrIndex['mobile_areacode'] = prefix_phone;
            arrIndex['mobile'] = account;
            console.log('发送短信验证码参数---',arrIndex);
            $.get('/video/send-code', arrIndex, function(res) {
                console.log('发送短信验证码结果---',res);
                if(res.errno==0){
                    //注册成功,页面刷新
                    var zd = $("#zd").hasClass("act")? 1:0;
                    if(!isNaN(res.data.uid) && res.data.uid!=""){
                        saveuser(res.data.uid,zd);
                    }
                    setTime(obj,send_source);//开始倒计时
                }else{
                    var mes = "";
                    if(res.data!=''){
                        mes = res.data.message;
                    }else{
                        mes = '发送失败';
                    }
                    $(obj).parent().addClass("wor");
                    $(obj).parent().siblings(".loginTip").text(mes);
                    $(obj).parent().siblings(".loginTip").show();
                }
            });
        }
    }

    //60s倒计时实现逻辑
    var countdown = 60;
    var countdown1 = 60;
    function setTime(obj,send_source) {
        if(send_source == 'sms'){
            var timer = setInterval(function(){
                obj.prop('disabled', true);
                obj.val(countdown+"s") ;
                countdown--;
                if (countdown==0){
                    countdown = 60;
                    obj.prop('disabled', false);
                    obj.val("获取验证码");
                    clearInterval(timer);
                }
            },1000);
        }
        if(send_source == 'reg'){
            var timer1 = setInterval(function(){
                obj.prop('disabled', true);
                obj.val(countdown1+"s") ;
                countdown1--;
                if (countdown1==0){
                    countdown1 = 60;
                    obj.prop('disabled', false);
                    obj.val("获取验证码");
                    clearInterval(timer1);
                }
            },1000);
        }
    }
    //验证码登录
    $("#login_sms_submit").click(function(){
        var account = $("#login_sms_account").val();
        var prefix_phone = $('#sms_prefix_phone').attr('data');
        var code = $("#smscode").val();
        var tab = true;
        var arrIndex = {};
        if(account==""){
            $("#login_sms_account").parent().addClass("wor");
            $(".J_login_warning1").text("账号不能为空");
            $(".J_login_warning1").show();
            tab = false;
            return false;
        }else{
            var ismobile = isMobilePhone(account);
            if(!ismobile){
                $("#login_sms_account").parent().addClass("wor");
                $(".J_login_warning1").text("账号格式错误");
                $(".J_login_warning1").show();
                tab = false;
                return false;
            }else{
                arrIndex['mobile'] = account;
                arrIndex['mobile_areacode'] = prefix_phone;
            }
        }
        if(code==""){
            $("#smscode").parent().addClass("wor");
            $(".J_login_warning1").text("验证码不能为空");
            $(".J_login_warning1").show();
            tab = false;
            return false;
        }else{
            arrIndex['code'] = code;
        }
        if(!$("#xy").hasClass("act")){
            $(".J_login_warning1").text("请阅读并同意《用户协议》和《隐私政策》");
            $(".J_login_warning1").show();
            tab = false;
            return false;
        }
        if(tab){
            arrIndex['flag'] = 1;//flag: 0-密码；1-短信验证码
            console.log('短信登录参数---',arrIndex);
            $.get('/site/new-login',arrIndex,function(res){
                // console.log(res);
                console.log('短信登录结果---',res);
                // $("#login_submit").removeClass("login-loading");
                if(res.errno==0 && res.data){
                    //登陆成功,页面刷新
                    var zd = $("#zd").hasClass("act")? 1:0;
                    if(!isNaN(res.data) && res.data!=""){
                        saveuser(res.data,zd);
                    }
                    location.reload();
                }else{
                    $("#login_sms_account").parent().addClass("wor");
                    $("#smscode").parent().addClass("wor");
                    $(".J_login_warning1").text("账号或验证码错误");
                    $(".J_login_warning1").show();
                }
            });
        }
    });
    //提交注册
    $("#reg_submit").click(function(){
        var prefix_phone = $("#reg_prefix_phone").attr("data");
        var phone = $("#reg_account").val();
        var code = $("#reg_smscode").val();
        var tab = true;
        var arrIndex = {};
        if(phone==""){
            $("#reg_account").parent().addClass("wor");
            $(".J_login_warning2").text("手机号不能为空");
            $(".J_login_warning2").show();
            tab = false;
            return false;
        }else{
            var ismobile = isMobilePhone(phone);
            if(!ismobile){
                $("#reg_account").parent().addClass("wor");
                $(".J_login_warning2").text("手机号格式错误");
                $(".J_login_warning2").show();
                tab = false;
                return false;
            }else{
                arrIndex['mobile_areacode'] = prefix_phone;
                arrIndex['mobile'] = phone;
            }
        }
        if(code==""){
            $("#reg_smscode").parent().addClass("wor");
            $(".J_login_warning2").text("验证码不能为空");
            $(".J_login_warning2").show();
            tab = false;
            return false;
        }else{
            arrIndex['code'] = code;
        }
        if(!$("#xy").hasClass("act")){
            $(".J_login_warning2").text("请阅读并同意《用户协议》和《隐私政策》");
            $(".J_login_warning2").show();
            tab = false;
            return false;
        }
        if(tab){
            console.log('注册接口参数------',arrIndex);
            $.get('/video/register', arrIndex, function(res) {
                console.log('注册接口------',res);
                if(res.errno==0){
                    //注册成功,页面刷新
                    var zd = $("#zd").hasClass("act")? 1:0;
                    if(!isNaN(res.data.uid) && res.data.uid!=""){
                        saveuser(res.data.uid,zd);
                    }
                    location.reload();
                }else{
                    var mes = "";
                    if(res.data!=''){
                        mes = res.data.message;
                    }else{
                        mes = '注册失败';
                    }
                    $("#reg_account").parent().addClass("wor");
                    $("#reg_smscode").parent().addClass("wor");
                    $(".J_login_warning2").text(mes);
                    $(".J_login_warning2").show();
                }
            });
        }
    });
    //登录状态-退出
    $("#logout").click(function(){
        $.get('/site/logout', {}, function(res) {
            console.log(res);
            if(res.errno==0){
                $("#login_id").val("");
                $("#notloggedin").show();
                $("#loggedin").hide();
                removeuser();
                location.reload();
            }
        });
        return false;
    });
    $("#loggedin").click(function(){
        window.location.href="/video/personal";
        return false;
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
                $("#LSmenuBox_div .LSmenuBottom").hide();
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
                $("#XX-tabBox-favorite .LSmenuBottom").hide();
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
                $("#XX-tabBox-message .LSmenuBottom").hide();
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
