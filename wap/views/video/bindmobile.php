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
    $("#login_sms_account").focus(function(){
        $(".sms-code").addClass("act");
        // $("#login-sms").addClass("act");
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
    //绑定手机号
    $("#login-sms").click(function(){
        var prefix_phone = $('#sms_prefix_phone').attr('data');
        var account = $('#login_sms_account').val();
        var code = $("#smscode").val();
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
            }else{
                arrIndex['mobile'] = account;
                arrIndex['mobile_areacode'] = prefix_phone;
            }
        }
        if(code==""){
            $(".J_login_warning").text("验证码不能为空");
            $(".J_login_warning").show();
            tab = false;
            return false;
        }else{
            arrIndex['code'] = code;
        }
        if(tab){
            $(".J_login_warning").text("正在绑定中...");
            $(".J_login_warning").show();
            arrIndex['flag'] = 'mobile';//flag: 1-短信验证码
            console.log('修改手机参数---',arrIndex);
            $.get('/video/modify-userinfo',arrIndex,function(res){
                console.log('修改手机结果---',res);
                if(res.errno==0){
                    $(".J_login_warning").hide();
                    $("#pop-tip").text("绑定成功");
                    $("#pop-tip").show().delay(1500).fadeOut();
                    
                    window.location.href=document.referrer;
                }else{
                    $(".J_login_warning").text("手机号或验证码错误");
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
});
JS;

$this->registerJs($js);

?>
<style>
    .inp{width: calc(100% - 105px);height: 1rem;line-height: 1rem;box-sizing: border-box;}
    input.inp::-webkit-input-placeholder{color: #B2B2B2;}
    .sms-code{width: 100px;height: 100%;color: #B2B2B2;cursor: pointer;-webkit-appearance: none;background-color: #FFFFFF;}
    .sms-code.act{color: #FF556E;}
    .sms-phone{padding-left: 20px;}
    .sms-bottom{position: absolute;bottom: 0px;text-align: center;font-size: 12px;}
    #login-sms{width: 100%;height: 100%;background-color: #FBFBFB;border-radius: 0.5rem;color:#7A7A7A;}
    #login-sms.act{background-color: #FF556E;color:#FFFFFF;}
    .border-bottom1{border-bottom: 1px solid #EFEFEF;}
    .opJ{display: none;position: absolute;border-radius: 5px;background: #FFFFFF;box-shadow: 0px 1px 7px 0px rgb(180 180 180 / 35%);width: 100px;max-height: 180px;overflow-x: hidden;overflow-y: auto;top: 0;left: 0;padding: 10px 5px;z-index: 2;}
    .opJ.act {display: block;}
    .opJ>li {display: block;width: 100%;height: 30px;line-height: 30px;font-size: 12px;margin-left: 15px;cursor: pointer;}
    .selectJ{width:100px;background-color: #FFFFFF;background-image: url(../images/video/arrow_down.png);background-position: 60px center;background-repeat: no-repeat;background-size: 8px;}
    .loginTip {display: none;font-size: 12px;font-weight: 400;color: #FF556E;}
</style>

<div class="display-flex outer-div sms-title pink" >
    <a class="div-box position-r white-arrow" href="javascript:window.location.href=document.referrer;">
        <img src="/images/video/icon-fh-1.png">
    </a>
    <div class="text-center title-width"><?= (isset($data['title'])? $data['title'] : '绑定手机号'); ?></div>
    <div class="div-box position-r"></div>
</div>
<div class="outer-div display-flex position-r border-bottom1 sms-phone">
    <ul class="opJ">
        <?php
        $selectVal = '';
        $selectData = '';
        foreach ($data['country'] as $country){
            if($country['mobile_areacode']!=''){
                $selectVal = $country['country_name'] . '+' . $country['mobile_areacode'];
                $selectData = '+' . $country['mobile_areacode'];
                break;
            }
        }
        ?>
        <?php if(!empty($data['country'])) :?>
            <?php foreach ($data['country'] as $country): ?>
                <?php if($country['mobile_areacode']!=''):?>
                    <li data="<?=$country['country_name']?>+<?=$country['mobile_areacode']?>"><?=$country['country_name']?><span>+<?=$country['mobile_areacode']?></span></li>
                <?php endif;?>
            <?php endforeach;?>
        <?php endif;?>
    </ul>
    <input type="button" class="selectJ text-left font12" id="sms_prefix_phone" value="<?=$selectVal?>" data="<?=$selectData?>"/>
    <input type="text" class="inp font12 J_account" name="" placeholder="请输入手机号" id="login_sms_account" value="" />
</div>
<div class="line" ></div>
<div class="outer-div display-flex position-r border-bottom1" style="padding-left: 20px;">
    <input type="text" class="inp font12 J_code_input" name="" placeholder="请输入验证码" value="" id="smscode" onkeyup="value=value.replace(/[^0-9]/i,'')" />
    <input type="button" class="sms-code font12 J_sms_code" value="获取验证码" />
</div>
<div class="line" ></div>
<div class="loginTip mt20 ml20 J_login_warning">请输入手机号</div>
<div class="outer-div mt20">
    <button id="login-sms" class="fontW7 font14 act" >绑定</button>
</div>
