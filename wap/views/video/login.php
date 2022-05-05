<?php
use yii\helpers\Url;

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = '瓜子TV|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv - guazitv.tv';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片']);

$js = <<<JS
$(function (){
    //隐藏下拉菜单
    $(document).click(function(e) {
        var targets = $(e.target);
        // 点击下拉菜单以外的地方切换样式
        if(!targets.is('.sms-phone *') && !targets.is('.sms-phone .opJ')) {
            $('.sms-phone .opJ').removeClass("act");
        }
    });
	//假下拉菜单
	$(".sms-phone .selectJ").click(function() {
		$('.sms-phone .opJ').addClass("act");
	});
    $(".sms-phone .opJ>li").click(function() {
        var opJval=$(this).find("span").text();
        var selectVal=$(this).attr('data');
        $(this).addClass("act").siblings("li").removeClass("act");
        $(this).parents(".sms-phone").find(".selectJ").addClass("act").val(selectVal);
        $(this).parents(".sms-phone").find(".selectJ").attr('data',opJval);
        $('.sms-phone .opJ').removeClass("act");
    });
    $("#login_sms_account, #smscode, #password").focus(function(){
        $(".sms-code").addClass("act");
        $("#login-sms").addClass("act");
    });
    
    //发送短信验证码
    $('.J_sms_code').click(function(){
	    $(".J_login_warning").hide();
        sendyzm($(this));
    });
    //用ajax提交到后台的发送短信接口
    function sendyzm(obj){
        var prefix_phone = $('#sms_prefix_phone').attr('data');
        var account = $('#login_sms_account').val();
        var tab = true;
        var arrIndex = {};
        if(account==""){
            $(".J_login_warning").text("手机号不能为空");
            $(".J_login_warning").show();
            tab = false;
            return false;
        }else{
            account = valimobile(account,prefix_phone);
            if(account == ""){
                $(".J_login_warning").text("手机号格式错误");
                $(".J_login_warning").show();
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
                    setTime(obj);//开始倒计时
                }else{
                    var mes = "";
                    if(res.data!=''){
                        mes = res.data.msg;
                    }else{
                        mes = '发送失败';
                    }
                    $(".J_login_warning").text(mes);
                    $(".J_login_warning").show();
                }
            });
        }
    }

    //60s倒计时实现逻辑
    var countdown = 60;
    function setTime(obj) {
        var timer = setInterval(function(){
            obj.prop('disabled', true);
            obj.css("color","#FF556E");
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
    //登录/注册
    $("#login-sms").click(function(){
        var prefix_phone = $('#sms_prefix_phone').attr('data');
        var account = $('#login_sms_account').val();
        var code = $("#smscode").val();
        var pwd = $("#password").val();
        var tab = true;
        var arrIndex = {};
        //新增登录方式
        var login_type = ""; 
        if(account==""){
            $(".J_login_warning").text("手机号不能为空");
            $(".J_login_warning").show();
            tab = false;
            return false;
        }else{
            account = valimobile(account,prefix_phone);
            if(account == ""){
                $(".J_login_warning").text("手机号格式错误");
                $(".J_login_warning").show();
                tab = false;
                return false;
            }else{
                arrIndex['mobile'] = account;
                arrIndex['mobile_areacode'] = prefix_phone;
            }
        }
        
        if($("#logintitle").text()=="短信登录"){
            arrIndex['flag'] = 1;            
            if(code==""){
                $(".J_login_warning").text("验证码不能为空");
                $(".J_login_warning").show();
                tab = false;
                return false;
            }else{
                arrIndex['code'] = code;
            }
        }else{
            arrIndex['flag'] = 0;
            if(pwd==""){
                $(".J_login_warning").text("密码不能为空");
                $(".J_login_warning").show();
                tab = false;
                return false;
            }else{
                arrIndex['password'] = pwd;
            }
        }
        if(tab){
            $(".J_login_warning").text("正在登录中...");
            $(".J_login_warning").show();
            console.log('登录参数---',arrIndex);
            $.get('/site/new-login',arrIndex,function(res){
                console.log('登录结果---',res);
                if(res.errno==0 && res.data){
                    $(".J_login_warning").hide();
                    $("#pop-tip").text("登录成功");
                    $("#pop-tip").show().delay(1500).fadeOut();
                    
                    //登陆成功,页面刷新
                    if(!isNaN(res.data) && res.data!=""){
                        saveuser(res.data);
                    }
                    // console.log("js获取上(前)一页url"+document.referrer); 
                    window.location.href=document.referrer;
                    // location.reload();
                }else{
                    var msg = "登录失败";
                    if(res.error!=""){
                        msg = res.error;
                    }
                    $(".J_login_warning").text(msg);
                    $(".J_login_warning").show();
                }
            });
        }
    });
    //手机判断+澳洲
    function valimobile(mobile,mobile_areacode){
        var reg = /^[0-9]*$/;
        if (mobile =='' || !reg.test(mobile)) {
            mobile = "";
        } else {
            if(mobile_areacode == "+61"){
                if((mobile.length==10 && mobile.indexOf("04")==0)){
                    mobile = mobile.substring(1);
                }
                if(!(mobile.length==9 && mobile.indexOf("4")==0)){
                    mobile = "";
                }
            }
        }
        return mobile;
    }    
    //登录方式切换
    $("#changelogin").click(function() {
        $("#smscode").parent().toggleClass("divhidden");
        $("#password").parent().toggleClass("divhidden");
        var text = $("#changelogin a").text();
            $("#logintitle").text(text);
        if(text=="短信登录"){//切换至短信登录
            $("#changelogin a").text("账号登录");
            $("#login-sms").text("登录 / 注册")
        }else{//切换至密码登录
            $("#changelogin a").text("短信登录");
            $("#login-sms").text("登录")
        }
    });
    //密码是否可见
    $(".eye").click(function() {
		var eyeOn=$(this).attr("class")
		if(eyeOn=="eye") {
			$(this).addClass("act");
			$(this).siblings(".inp").removeClass("pas").attr("type", "text");
		} else {
			$(this).removeClass("act");
			$(this).siblings(".inp").addClass("pas").attr("type", "password");
		}
	});
});
JS;

$this->registerJs($js);

?>
<style>
    .inp{width: calc(100% - 105px);height: 1rem;line-height: 1rem;box-sizing: border-box;}
    input.inp::-webkit-input-placeholder{color: #B2B2B2;}
    .sms-code{width: 100px;height: 100%;color: #B2B2B2;cursor: pointer;-webkit-appearance: none;background-color: #FFFFFF;}
    .sms-code.act{color: #FF556E;}
    .sms-title a.div-box img{position: absolute;width:10px;height:16px;top: 50%;left: 0;margin-top: -8px;}
    .sms-phone{margin-top: 40px;padding-left: 20px;}
    .sms-bottom{position: absolute;bottom: 0px;text-align: center;font-size: 12px;}
    #login-sms{width: 100%;height: 100%;background-color: #FBFBFB;border-radius: 0.5rem;color:#7A7A7A;}
    #login-sms.act{background-color: #FF556E;color:#FFFFFF;}
    .border-bottom1{border-bottom: 1px solid #EFEFEF;}
    .opJ{display: none;position: absolute;border-radius: 5px;background: #FFFFFF;box-shadow: 0px 1px 7px 0px rgb(180 180 180 / 35%);width: 100px;max-height: 180px;overflow-x: hidden;overflow-y: auto;top: 0;left: 0;padding: 10px 5px;z-index: 2;}
    .opJ.act {display: block;}
    .opJ>li {display: block;width: 100%;height: 30px;line-height: 30px;font-size: 12px;margin-left: 15px;cursor: pointer;}
    .selectJ{width:100px;background-color: #FFFFFF;background-image: url(../images/video/arrow_down.png);background-position: 60px center;background-repeat: no-repeat;background-size: 8px;}
    .loginTip {display: none;font-size: 12px;font-weight: 400;color: #FF556E;}
    #changelogin{text-align: center;}
    #changelogin a{display: inline-block;width:auto;height: 100%;margin:0 auto;color: #7A7A7A;font-size: 14px;font-weight: bold;}
    .divhidden{display: none;}
    .eye{position: absolute;top: 5px;right: 25px;width: 30px;height: 30px;background-image: url(../images/video/yanjing-3.png);background-position: center;background-repeat: no-repeat;background-color: rgba(255, 255, 255, 0);}
    .eye.act {background-image: url(../images/video/yanjing.png);}
</style>
<div class="display-flex outer-div sms-title" >
    <a class="div-box position-r" href="javascript:window.location.href=document.referrer;">
        <img src="/images/video/left_gray.png">
    </a>
    <div id="logintitle" class="text-center" style="width: calc(100% - 2rem);">账号登录</div>
    <div class="div-box position-r"></div>
</div>
<div class="outer-div display-flex position-r border-bottom1 sms-phone">
    <ul class="opJ">
        <?php
        $selectVal = '';
        $selectData = '';
        foreach ($countrys as $country){
            if($country['mobile_areacode']!=''){
                $selectVal = $country['country_name'] . '+' . $country['mobile_areacode'];
                $selectData = '+' . $country['mobile_areacode'];
                break;
            }
        }
        ?>
        <?php if(!empty($countrys)) :?>
            <?php foreach ($countrys as $country): ?>
                <?php if($country['mobile_areacode']!=''):?>
                    <li data="<?=$country['country_name']?>+<?=$country['mobile_areacode']?>"><?=$country['country_name']?><span>+<?=$country['mobile_areacode']?></span></li>
                <?php endif;?>
            <?php endforeach;?>
        <?php endif;?>
    </ul>
    <input type="button" class="selectJ text-left font12" id="sms_prefix_phone" value="<?=$selectVal?>" data="<?=$selectData?>"/>
    <input type="text" class="inp font12 J_account" name="" placeholder="请输入手机号" id="login_sms_account" value="" />
</div>
<div class="outer-div display-flex position-r border-bottom1 mt20 divhidden" style="padding-left: 20px;">
    <input type="text" class="inp font12" name="" placeholder="请输入验证码" value="" id="smscode" onkeyup="value=value.replace(/[^0-9]/i,'')" />
    <input type="button" class="sms-code font12 J_sms_code" value="获取验证码" />
</div>
<div class="outer-div display-flex position-r border-bottom1 mt20" style="padding-left: 20px;">
    <input type="password" class="inp font12" name="" placeholder="请输入密码" value="" id="password" onkeyup="value=value.replace(/[^(\w-*\.*)]/g,'')" />
    <input type="button" class="eye" value="">
</div>
<div class="loginTip mt20 ml20 J_login_warning">请输入手机号</div>
<div class="outer-div mt20">
    <button id="login-sms" class="fontW7 font14" >登录</button>
</div>
<div id="changelogin" class="outer-div mt20" >
    <a>短信登录</a>
</div>

<div class="outer-div sms-bottom" >
    点击登录即表示已同意「瓜子tv」<span style="color: #FF556E;">《用户协议》</span>
</div>
<script src="/js/video/jquery.min.1.11.1.js"></script>
<script src="/js/video/searchHistory.js"></script>
