<?php
use yii\helpers\Url;

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = '瓜子TV|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv - guazitv.tv';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片']);

$js = <<<JS
$(function (){
	var is_click = true;
    //修改昵称
    $('#nickname').click(function(){
        $('.shadow-edit').show();
        $(".nickname-edit").show();
    });
    $('#J_nickname').click(function(){
		if(!is_click){
			return false;
		}
        var arrIndex = {};
        var nickname = $("#nickname_input").val();
        if(nickname.trim() == ""){
            $("#pop-tip").text("昵称不能为空");
            $("#pop-tip").show().delay(1500).fadeOut();
			return false;
        }else{
            arrIndex['flag_value'] = nickname;
        }
        arrIndex['flag'] = 'nickname';//flag: 1-短信验证码
        is_click = false;
        $.get('/video/modify-userinfo',arrIndex,function(res){
            is_click = true;
            closeedit();
            if(res.errno==0){
                $("#nickname div").text(nickname);
                $("#pop-tip").text("昵称修改成功");
                $("#pop-tip").show().delay(1500).fadeOut();
            }else{
                $("#pop-tip").text("昵称修改失败");
                $("#pop-tip").show().delay(1500).fadeOut();
            }
        });
    });
    
    //修改性别
    $('#gender').click(function(){
        $('.shadow-edit').show();
        $(".gender-edit").show();
    });
    $('.J_gender').click(function(){
		if(!is_click){
			return false;
		}
        var arrIndex = {};
        var gender = $(this).attr("data-value");
        var gender_name = $(this).text();
        if(gender.trim() == ""){
            $("#pop-tip").text("性别不能为空");
            $("#pop-tip").show().delay(1500).fadeOut();
			return false;
        }else{
            arrIndex['flag_value'] = gender;
        }
        arrIndex['flag'] = 'gender';//flag: 1-短信验证码
        is_click = false;
        $.get('/video/modify-userinfo',arrIndex,function(res){
            is_click = true;
            closeedit();
            if(res.errno==0){
                $("#gender div").text(gender_name);
                $("#pop-tip").text("性别修改成功");
                $("#pop-tip").show().delay(1500).fadeOut();
            }else{
                $("#pop-tip").text("性别修改失败");
                $("#pop-tip").show().delay(1500).fadeOut();
            }
        });
    });
    
    //关闭
    $(".comment-shadow").click(function (){
        closeedit();
    });
});

JS;

$this->registerJs($js);
?>
<style>
    body{background-color:#F1F5F8;font-family: PingFangSC;}
    .shadow-edit, .nickname-edit, .gender-edit{display: none;}
    input::-webkit-input-placeholder{color: #919191;}
    #nickname_input{background-color: #F6F6F6;padding-left: 5px;height: 100%;width: 100%;}
    .nickname-edit{width: 250px;height: 3rem;border-radius: 10px}
    .nickname-edit-title{font-size: 14px;border-top-left-radius: 10px;border-top-right-radius: 10px;}
    .nickname-edit-button{display: grid;grid-template-columns: 1fr 1fr;grid-gap: 10px;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;}
    .nickname-edit-button button:first-of-type{background-color: #FFFFFF;color: #707070;}
    .nickname-edit-button button:nth-of-type(2){background-color: #FFFFFF;color: #FF556E;}
    .gender-edit{position: absolute;z-index: 1000;background-color: #FFFFFF;opacity: 1;width: 100%;height: auto;left: 50%;bottom: 0px;-webkit-transform: translate(-50%, 0%);transform: translate(-50%, 0%);}
    .gender-edit .line5{height:5px;background-color: #707070;opacity: 0.5;}
</style>
<div class="display-flex outer-div sms-title pink" >
    <a class="div-box position-r white-arrow" href="<?= Url::to(['/video/personal'])?>">
        <img src="/images/video/icon-fh-1.png">
    </a>
    <div class="text-center title-width">个人资料</div>
    <div class="div-box position-r"></div>
</div>
<div class="outer-div" style="height:1.5rem;line-height: 1.5rem;">
    <span class="font14">头像</span>
    <div class="display-flex fr" style="margin-top: 0.25rem;">
        <img style="width: 1rem;height: 1rem;" src="/images/video/touxiang.png" />
        <img class="user-arrow ml10"  src="/images/video/right_gray.png" />
    </div>
</div>
<div class="line" ></div>
<div class="outer-div">
    <span class="font14">昵称</span>
    <div class="display-flex fr" id="nickname">
        <div class="font14 colorB2"><?=$data['user']['nickname']?></div>
        <img class="user-arrow ml10"  src="/images/video/right_gray.png" />
    </div>
</div>
<div class="line" ></div>
<div class="outer-div">
    <span class="font14">性别</span>
    <div class="display-flex fr" id="gender">
        <?php
            if($data['user']['gender']=='1'){
                $gender = '女';
            }else if($data['user']['gender']=='2'){
                $gender = '男';
            }else if($data['user']['gender']=='3'){
                $gender = '保密';
            }else{
                $gender = '未设置';
            }
        ?>
        <div class="font14 colorB2"><?=$gender?></div>
        <img class="user-arrow ml10"  src="/images/video/right_gray.png" />
    </div>
</div>
<div class="line" ></div>
<div class="outer-div">
    <span class="font14">手机号</span>
    <?php
    if($data['user']['mobile']){
        $mobile = '已绑定';
        $mtab = "modify";
    }else{
        $mobile = '未绑定';
        $mtab = "bind";
    }
    ?>
    <a class="display-flex fr" href="<?= Url::to(['/video/bind-mobile', 'mtab'=>$mtab])?>">
        <div class="font14 colorB2"><?=$mobile?></div>
        <img class="user-arrow ml10"  src="/images/video/right_gray.png" />
    </a>
</div>
<div class="line" ></div>
<div class="outer-div">
    <span class="font14">ID</span>
    <div class="display-flex fr">
        <div class="font14 colorB2"><?=$data['user']['uid']?></div>
        <img class="user-arrow ml10"  src="/images/video/right_gray.png" />
    </div>
</div>
<div class="line" ></div>
<div class="comment-shadow shadow-edit"></div>
<div class="comment-description nickname-edit" >
    <div class="outer-div text-center fontW7 nickname-edit-title" >修改昵称</div>
    <div class="outer-div">
        <input id="nickname_input" class="font14 " type="text" placeholder="请输入昵称" style="" />
    </div>
    <div class="outer-div nickname-edit-button" style="">
        <button class="font14 fontW7" onclick="closeedit();">取消</button>
        <button class="font14 fontW7" id="J_nickname" >确定</button>
    </div>
</div>

<div class="gender-edit" >
    <div class="outer-div text-center J_gender" data-value="2">男</div>
    <div class="line" ></div>
    <div class="outer-div text-center J_gender" data-value="1">女</div>
    <div class="line" ></div>
    <div class="outer-div text-center J_gender" data-value="3">保密</div>
    <div class="line5"></div>
    <div class="outer-div text-center" onclick="closeedit();">取消</div>
</div>

<script src="/js/video/jquery.min.1.11.1.js"></script>
<script>
    function closeedit(){
        $(".shadow-edit").hide();
        $(".nickname-edit").hide();
        $(".gender-edit").hide();
    }
</script>
