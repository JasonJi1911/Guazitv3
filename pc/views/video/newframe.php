<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

switch ($pageTab) {
    case "newdetail" :
        $this->registerMetaTag(['name' => 'keywords', 'content' => $data['info']['video_name'].','.$data['info']['year'].','.$data['info']['area'].','.$data['info']['director'].' - '.LOGONAME.'TV,澳洲'.LOGONAME.'tv,新西兰'.LOGONAME.'tv,澳新'.LOGONAME.'tv,'.LOGONAME.'视频,'.LOGONAME.'影视,电影,电视剧,榜单,综艺,动画,记录片']);
        $this->registerMetaTag(['name' => 'description', 'content' => $data['info']['video_name'].','.$data['info']['year'].','.$data['info']['area'].','.$data['info']['director'].' - '.LOGONAME.'TV是澳大利亚、新西兰华人影视视频分享平台，网站包含最新的电视剧、美剧、日韩剧、华语电影、好莱坞电影、以及各种动漫和重大体育赛事直播。在这里，一定有你想看的一切！']);
        $this->title = $data['info']['video_name'].' - '.LOGONAME. 'TV - 澳新华人在线视频分享平台,海量高清视频在线观看';
        break;
    default :
        $this->registerMetaTag(['name' => 'keywords', 'content' => LOGONAME.'TV,澳洲'.LOGONAME.'tv,新西兰'.LOGONAME.'tv,澳新'.LOGONAME.'tv,'.LOGONAME.'视频,'.LOGONAME.'影视,电影,电视剧,榜单,综艺,动画,记录片']);
        $this->registerMetaTag(['name' => 'description', 'content' => LOGONAME.'TV是澳大利亚、新西兰华人影视视频分享平台，网站包含最新的电视剧、美剧、日韩剧、华语电影、好莱坞电影、以及各种动漫和重大体育赛事直播。在这里，一定有你想看的一切！']);
        $this->title = LOGONAME. 'TV - 澳新华人在线视频分享平台,海量高清视频在线观看';
}
NewIndexStyleAsset::register($this);

$js = <<<SCRIPT
$(function(){
    $('#backToTop').click(function() {
        $('html,body').stop(true, false).animate({
            scrollTop: 0
        })
    });      
});
                        
SCRIPT;
$this->registerJs($js);

header('X-Frame-Options:Deny');
header("Access-Control-Allow-Origin:*");
?>
<!DOCTYPE html>
<html id="topMD">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=1336, maximum-scale=1, user-scalable=no">
</head>
<style>
    /*登录/注册 加载*/
    .login-loading{
        background-image:url(/images/newindex/loading.gif);
        background-position: 65% center;
        background-repeat: no-repeat;
        background-size: 30px;
    }
    /*统一提示框背景图*/
    .alt05-p{
        background-image:url(/images/newindex/alt05_back.png);
        background-position: center center;
        background-repeat: no-repeat;
        padding: 130px 20px 10px 20px;
        margin-bottom:20px;
        text-align: center;
        color:#696969;
    }
    /*非vip不可播放提示alert*/
    .altvip-box{
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -150px;
        margin-top: -200px;
        width:300px;
        height:400px;
    }
    .altvip-title{
        width:100%;
        height:150px;
        background-color: rgba(0, 0, 0, 0);
        background-image: url(../images/newindex/1-b.png);
        background-repeat: no-repeat;
        background-size: 100% 100%;
        background-position: center center;
    }
    .altvip-title div{
        position:absolute;
        top:100px;
        width:100%;
        text-align:center;
        font-weight:bold;
        font-size:18px;
        color:#ffffff;
    }
    .altvip-middle{
        background-color:#fff;
        padding:10px 0;
    }
    .altvip-middle .middle01{
        height:40px;
        line-height:40px;
        color:#797979;
        font-size:16px;
        text-align:center;
    }
    .altvip-middle .middle02 img{
        width:100px;
        margin:10px 100px;
    }
    .altvip-middle .middle03{
        height: 40px;
        line-height: 40px;
        font-size: 16px;
        text-align: center;
    }
    .altvip-middle .middle03 input.middle03-btn{
        padding: 10px 20px;
        height: 40px;
        font-size: 16px;
        width:150px;
        border-radius: 20px;
        color: #FFFFFF;
        background-color:#E4AC49;
    }
</style>
<script src="/js/jquery.js"></script>
<script src="/js/video/newindex.js"></script>
<script src="/js/video/searchHistory.js"></script>
<!--<script src="/js/video/gVerify.js"></script>-->
<script>
    $(document).ready(function(){
        var pagetab = "<?=$pageTab?>";
        if(pagetab == "newindex"){
            $("[name='zt']").addClass("ZT-black");
        }
        var mobile_flag = isMobile();
        if(mobile_flag){
            window.location = '<?=WAP_HOST_PATH?>';
        }
        $('#v_navTopLogo').click(function(){
            window.location.href = '/video/index';
        });

        var uid = finduser();
        var pagetab = '<?=$pageTab?>';
        var ar = {};
        ar['uid'] = uid;
        $.get('/video/userall',ar,function(res){
            $("#navTopBtnBox").html(res);
            ztBlack();
            if(pagetab=="newdetail" && !isNaN(uid) && uid!=""){
                $("#det_login").parent().parent().hide();
            }
        });
        $("#keywords").focus(function(){
            if(window.localStorage.hasOwnProperty("searchwords")){
                searchwords = window.localStorage.getItem("searchwords");
                if(searchwords.length > 0){
                    $("#searchHtitle").css("display","block");
                }else{
                    $("#searchHtitle").css("display","none");
                }
            }else{
                $("#searchHtitle").css("display","none");
            }
            $(".searchMenuBox").css('display','block');
        });
        $("#keywords").blur(function(){
            setTimeout(function(){
                $(".searchMenuBox").css('display','none');
            }, 1000);
        });
    });

    function isMobile() {
        var userAgentInfo = navigator.userAgent;
        var mobileAgents = [ "Android", "iPhone", "SymbianOS", "Windows Phone"];//, "iPad","iPod"
        var mobile_flag = false;
        //根据userAgent判断是否是手机
        for (var v = 0; v < mobileAgents.length; v++) {
            if (userAgentInfo.indexOf(mobileAgents[v]) > 0) {
                mobile_flag = true;
                break;
            }
        }
        var screen_width = window.screen.width;
        var screen_height = window.screen.height;
        //根据屏幕分辨率判断是否是手机
        if(screen_width < 500 && screen_height < 800){
            mobile_flag = true;
        }
        return mobile_flag;
    }

    //视频封面图片没有的，根据背景色显示默认图片
    function imgerrorUrl(that, position){
        var bodycolor = $("body").attr("class");
        if(bodycolor.indexOf("ZT-black")>=0){
            if(position=="H"){//横向、黑色
                that.src = "../../images/newindex/znwuC-b.png"
            }else{//纵向-V、黑色
                that.src = "../../images/newindex/znwuG-b.png"
            }
        }else{
            if(position=="H"){//横向、白色
                that.src = "../../images/newindex/znwuC-g.png"
            }else{//纵向-V、白色
                that.src = "../../images/newindex/znwuG-g.png"
            }
        }
    }

    function showloggedin(){
        $(".c_login").addClass("act");
        $("#login_account").val("");
        $("#login_pwd").val("");
        $(".sms_login").removeClass("act");
        $("#login_sms_account").val("");
        $("#smscode").val("");
        $(".c_register").removeClass("act");
        $("#reg_account").val("");
        $("#reg_smscode").val("");
        $('.loginTip').hide();
        $('.inp-box').removeClass('wor');
        $("#alt01").show();
    }
</script>

<!--登录弹出层-->
<div class="alt alt01" id="alt01">
    <div class="alt01—box">
        <div class="alt-logon">
            <div class="alt_login_d J_alt_login">
                <ul class="tab-nav" name="zt">
                    <li class="c_login act">
                        账号登录
                    </li>
                    <li class="sms_login">短信登录</li>
                </ul>
                <div class="tab-box">
                    <div class="c_login act">
                        <div class="inp-box sltJ mb-25 tel J_tel">
                            <ul class="opJ">
                                <?php
                                $selectVal = '';
                                $selectData = '';
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
                            <input type="button" class="selectJ" id="login_prefix_phone" value="<?=$selectVal?>" data="<?=$selectData?>"/>
                            <input type="text" class="J_account" name="" placeholder="请输入手机号" id="login_account" value="" />
                        </div>
                        <!--    报错样式 wor-->
                        <div class="inp-box mb-16 pasbox J_codebox">
                            <input type="password" class="inp pas J_code_input" name="" placeholder="请输入密码" id="login_pwd" value="" onKeyUp="value=value.replace(/[^(\w-*\.*)]/g,'')" />
                            <input type="button" class="eye"  value="" />
                        </div>
                        <ul class="gn-box">
                            <li class="c_register J_c_register">立即注册</li>
                            <li>
                                <a href="<?= Url::to(['/video/help', 'tab' => 'pwd'])?>">忘记密码</a>
                            </li>
                        </ul>
                        <div class="loginTip J_login_warning">请输入手机号</div>
                        <div class="bttn-box mb-30">
                            <input type="button" id="login_submit" value="登录" />
                        </div>
                    </div>
                    <div class="sms_login">
                        <!--    报错样式 wor-->
<!--                        <div class="inp-box mb-25">-->
<!--                            <input type="text" name="" placeholder="请输入手机号" id="login_account" value="" />-->
<!--                        </div>-->
                        <div class="inp-box sltJ mb-25 tel J_tel">
                            <ul class="opJ">
                                <?php
                                $selectVal = '';
                                $selectData = '';
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
                            <input type="button" class="selectJ J_prefix_phone" id="sms_prefix_phone" value="<?=$selectVal?>" data="<?=$selectData?>"/>
                            <input type="text" class="J_account" name="" placeholder="请输入手机号" id="login_sms_account" value="" />
                        </div>
                        <!--    报错样式 wor-->
                        <div class="inp-box mb-25 smsbox J_codebox">
                            <input type="text" class="inp J_code_input" name="" placeholder="请输入验证码" value="" id="smscode"  onKeyUp="value=value.replace(/[^0-9]/i,'')" />
                            <input type="button" class="sms_code J_sms_code"  value="获取验证码" source="sms"/>
                        </div>
                        <div class="loginTip J_login_warning1">请输入手机号</div>
                        <div class="bttn-box mb-30">
                            <input type="button" id="login_sms_submit" value="登录" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="alt_register J_alt_register" style="display:none;">
                <div class="alt-reback J_alt_reback">返回</div>
                <ul class="tab-nav" name="zt">
                    <li class="user_register">
                        注册账号
                    </li>
                </ul>
                <div class="tab-box">
                    <div class="user_register act">
                        <!--    报错样式 wor-->
<!--                        <div class="inp-box mb-25">-->
<!--                            <input type="text" name="" placeholder="请输入手机号" id="login_account" value="" />-->
<!--                        </div>-->
                            <div class="inp-box sltJ mb-25 tel J_tel">
                                <ul class="opJ">
                                    <?php
                                    $selectVal = '';
                                    $selecData = '';
                                    foreach ($channels['country_info'] as $country){
                                        if($country['mobile_areacode']!=''){
                                            $selectVal = $country['country_name'] . '+' . $country['mobile_areacode'];
                                            $selecData = '+' . $country['mobile_areacode'];
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
                                <input type="button" class="selectJ J_prefix_phone" id="reg_prefix_phone" value="<?=$selectVal?>" data="<?=$selecData?>"/>
                                <input type="text" name="" placeholder="请输入手机号" id="reg_account" value="" class="J_account"/>
                            </div>
                        <!--    报错样式 wor-->
                        <div class="inp-box mb-25 smsbox J_codebox">
                            <input type="text" class="inp J_code_input" name="" placeholder="请输入验证码" value="" id="reg_smscode"  onKeyUp="value=value.replace(/[^0-9]/i,'')" />
                            <input type="button" class="sms_code J_sms_code"  value="获取验证码" source="reg"/>
                        </div>
                        <div class="loginTip J_login_warning2">手机号已注册，请勿重复注册</div>
                        <div class="bttn-box mb-30">
                            <input type="button" id="reg_submit" value="注册" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="bowbox" name="zt">
                <input type="radio" name="xy" value="">
                <label for="xy" id="xy" class="chebox act">同意<a href="/video/help?tab=terms" target="_blank">《用户协议》</a>和<a href="/video/help?tab=terms" target="_blank">《隐私政策》</a></label>
            </div>
            <!--关闭按钮-->
<!--            <input class="alt-GB" type="button" style="background-color:black;">-->
        </div>
    </div>
    <div>
        <input class="alt-GB" type="button">
    </div>

</div>

<!--非vip不可播放提示alert-->
<div class="alt" id="altvip">
    <div class="altvip-box" name="zt" >
        <div class="altvip-title">
            <div>您还不是vip！</div>
        </div>
        <div class="altvip-middle">
            <div class="middle01" id="mvip-title" >
                您还不是vip呦！赶紧联系客服吧
            </div>
            <div class="middle02">
                <img src="/images/newindex/<?=KFQRCODE?>" />
            </div>
            <div class="middle01" >
                扫码加客服领取会员
            </div>
            <div class="seek-bottom middle03" >
                <input class="middle03-btn" type="button" id="closealtvip" value="确定" />
            </div>
        </div>
    </div>
</div>
<?php
$headclass = "";
$bodyid = "";
switch ($pageTab){
    case "newindex" : case "channel" : case "help" : case "hotplay" : case "adcenter" :
    $bodyid    = "indexTS";
    $headclass = "bkgBlack";
    break;
    case "list" : case "searchresult" : case "seek" : case "newdetail" : case "personal" : case "otherhome" :
    $bodyid    = "";
//    $headclass = "bkgWhite";
    break;
}
?>
<body id="<?= $bodyid?>" <?php if($is_show_background == 1):?>name="zt"<?php endif;?>>
<!-- 顶部导航 begin -->
<?php
$name_zt = "";
$class_zt_black = "";
$footer_color = "font-color-FFFFFF";
$footer_bg_color = "";
//if($pageTab != "newdetail") {//顶部导航默认透明或白色
//    $name_zt = "zt";
//    $class_zt_black = " ";
//}else{//顶部导航默认黑色
//    $name_zt = "";
//    $class_zt_black = " ZT-black";
//}
if(empty($is_show_background) || $is_show_background != 1){
    $name_zt = "zt";
    $class_zt_black = " navTopbgColor";
    $footer_bg_color = " qy-footer-bg-color";
    $footer_color = " font-color-000000";
}
?>
<div class="navTopBox <?= $headclass?> <?= $class_zt_black?>" name="<?= $name_zt?> "
     <?php if($rightnav_type == 1):?> id="J_navTopBox" <?php endif;?> >
    <ul class="navTop">
        <li class="navTopLogo" id="v_navTopLogo">
            <a class="logo-link" href="/video/index" title="瓜子TV">
                <img src="/images/NewVideo/logo.png" alt="">
                瓜子TV
            </a>
        </li>
        <li class="navTopMenuBox">
            <div class="navTopMenu">
                <!--导航菜单--一级-->
                <span class="navTopMenu-text" name="zt">
                <a href="<?= Url::to(['/video/index'])?>" >
                    推荐
                </a>
            </span>
                <?php if(!empty($channels)) :?>
                    <?php foreach ($channels['channeltags'] as $key=>$channel) :?>
                        <?php if ($key < 6) :?>
                            <span class="navTopMenu-text" name="zt">
                        <?php if($channel['channel_name'] != '首页'): ?>
                            <a href="<?= Url::to(['/video/channel', 'channel_id' => $channel['channel_id']])?>">
                                <?= $channel['channel_name']?>
                            </a>
                        <?php endif;?>
                    </span>
                        <?php endif;?>
                    <?php endforeach;?>
                <?php endif;?>
                <span class="navTopMenu-text-choice" name="zt">
                    <p class="navTopMenu-text-choice-all">全部</p>
                    <ul class="navTopMenu-one J_navtop_menu">
                    <!--导航菜单--一级-->
                    <li class="" name="zt">
                        <a href="<?= Url::to(['/video/index'])?>" >
                            推荐
                        </a>
                    </li>
                    <?php if(!empty($channels)) :?>
                        <?php foreach ($channels['channeltags'] as $channel) :?>
                            <li class="" name="zt">
                                <?php if($channel['channel_name'] != '首页'): ?>
                                    <a class="
                                " href="<?= Url::to(['/video/channel', 'channel_id' => $channel['channel_id']])?>" >
                                        <?= $channel['channel_name']?>
                                    </a>
                                <?php endif;?>
                            </li>
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>
                </span>
            </div>
        </li>
        <li class="navTopSearchBox-r">
            <div class="navTopSearch <?= $class_zt_black?>" name="<?= $name_zt?>">
                <input type="text" class="navTopSearchText" id="keywords" placeholder="<?= empty($hotword['tab'][0]['list'][0]['video_name']) ? '': $hotword['tab'][0]['list'][0]['video_name']?>" />
                <input type="hidden" id="v_keywords0" value="<?= empty($hotword['tab'][0]['list'][0]['video_name']) ? '': $hotword['tab'][0]['list'][0]['video_name']?>"
                <!--输入框点击弹出菜单-->
                <ul class="searchMenuBox " name="zt" style="display: none;">
                    <li class="clrGrey" id="searchHtitle" style="display: none;">
                        搜索历史：
                        <input class="clrGrey-btn" type="button" onclick="clearwords()" value="清空历史" />
                    </li>
                    <li class="clrGrey-list " name="zt"" id="searchHistory">
                    <!--                        <a href="javascript:;">测试搜索历史</a>-->
                    </li>
                    <li class="clrGrey">热门搜索：</li>
                    <?php if(!empty($hotword['tab'])) :?>
                        <?php foreach ($hotword['tab'] as $key => $tab): ?>
                            <?php if($key == 0) :?>
                                <?php foreach ($tab['list'] as $key => $list): ?>
                                    <?php $clr = "";
                                    if($key<3) {
                                        $clr = "clr01";
                                    }
                                    ?>
                                    <?php if($key < 10) :?>
                                        <li class="searchMenu " name="zt" >
                                            <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>">
                                                <span class="searchMenu-sapn <?=$clr?> "><?= $key + 1?></span><?= $list['video_name']?>
                                            </a>
                                        </li>
                                    <?php endif;?>
                                <?php endforeach;?>
                            <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>
                <div class="navTopSearchRight">
                    <a href="<?= Url::to(['/video/hot-play'])?>" class="navTop-search-hot" name="zt">
                        <span class="navTopSearchA"></span>
                        <span class="hotSearch">热播榜</span>&nbsp;
                    </a>
                    <div class="navTopSearchB-response" onclick="savewords();"></div>
                    <div class="verticalLine"></div>
                    <div class="navTopSearchBoxB" onclick="savewords();">
                        <div class="navTopSearchB"></div>
                        <div class="navTopSearchBText">搜索</div>
                    </div>
                </div
            </div>
        </li>
        <li class="navTopBtnBox" id="navTopBtnBox"></li>
    </ul>
</div>

<!-- 顶部导航 end -->
<?php switch ($pageTab) {
    case "newindex":
        echo $this->render('newindex',[
            'data'          => $data,
            'channels'      => $channels,
            'channel_id'    => $channel_id,
            'hotword'       => $hotword,
            'tick'          => $tick,
            'tvpath'        => $version['tvdata'],
            'city'          => $city,
            'pageTab'       => $pageTab ,
            'is_show_background' => $is_show_background,//是否显示背景 1-显示 2-不显示
            'is_show_navmenu' => $is_show_navmenuv,//是否显示顶部分类导航 1-显示 2-不显示
            'rightnav_type' => $rightnav_type
        ]);
        break;
    case "list":
        echo $this->render('list', [
            'info'      => $info,
            'hotword'   => $hotword,
            'channel_id'=> $channel_id,
            'keyword'   => $keyword,
            'advert'    => $advert
        ]);
        break;
    case "searchresult":
        echo $this->render('searchresult',[
            'info'          => $info,
            'keyword'       => $keyword,
            'channels'      => $channels,
            'channel_id'    => $channel_id,
            'hotword'       => $hotword,
            'advert'        => $advert
        ]);
        break;
    case "seek":
        echo $this->render('seek',[
            'data'      => $data,
            'channels'  => $channels,
            'hotword'   => $hotword
        ]);
        break;
    case "channel":
        echo $this->render('channel',[
            'data'          => $data,
            'channels'      => $channels,
            'channel_id'    => $channel_id,
            'hotword'       => $hotword,
            'info'          => $info,
        ]);
        break;
    case "newdetail":
        echo $this->render('newdetail', [
            'data'          => $data,
            'channels'      => $channels,
            'hotword'       => $hotword,
            'source_id'     => $source_id,
            'channelName'  => $channelName,
            'channel_id'    => $channel_id,
            'feedbackinfo'  => $feedbackinfo
        ]);
        break;
    case "hotsearch":
        echo $this->render('hotsearch', [
            'data' => $data,
            'channels'  => $channels,
        ]);
        break;
    case "hotplay":
        echo $this->render('hotplay',[
            'data'          => $data,
            'channels'      => $channels,
            'channel_id'    => $channel_id,
            'hotword'       => $hotword
        ]);
        break;
    case "map":
        echo $this->render('map',[
            'channels'      => $channels,
        ]);
        break;
    case "collaboration":
        echo $this->render('collaboration',[
            'data'          => $data,
            'channels'      => $channels,
            'channel_id'    => $channel_id,
            'hotword'       => $hotword,
        ]);
        break;
    case "help":
        echo $this->render('help',[
            'channels'      => $channels,
            'feedbackinfo'  => $feedbackinfo,
            'helptab'       => $helptab,
            'appversion'    => $appversion
        ]);
        break;
    case "adcenter" :
        echo $this->render('adcenter',[
            'data'  => $data
        ]);
        break;
    case "personal" :
        echo $this->render('personal',[
            'data'     => $data,
            'channels' => $channels,
            'ptab'      => $ptab,
            //'task'  => $task
        ]);
        break;
    case "otherhome" :
        echo $this->render('otherhome',[
            'data'  => $data
        ]);
        break;
} ?>
<!--底部导航-->
<footer class="qy-footer <?= $footer_bg_color?>">
    <div class="wp">
        <a class="browser <?= $footer_color?>" href="<?= Url::to(['collaboration'])?>">商务合作</a>
        <span class="<?= $footer_color?>">|</span>
<!--        <a class="browser1" href="###"></a>-->
<!--        <a class="browser --><?//= $footer_color?><!--" href="--><?//= Url::to(['map'])?><!--">网站地图</a>-->
<!--        <span class="--><?//= $footer_color?><!--">|</span>-->
        <a class="browser1" href="###"></a>
        <a class="browser <?= $footer_color?>" href="<?=WAP_HOST_PATH?>">手机端</a>
        <span class="<?= $footer_color?>">|</span>
        <a class="browser1" href="###"></a>
        <a class="browser <?= $footer_color?>" href="<?=PC_HOST_PATH?>">电脑端</a>
        <span class="<?= $footer_color?>">|</span>
        <a class="browser1" href="###"></a>
        <a class="browser <?= $footer_color?>" href="<?= Url::to(['site/share-down'])?>">APP下载</a>
        <span class="<?= $footer_color?>">|</span>
        <a class="browser1" href="###"></a>
        <!--<a class="browser" href="http://app.guazitv6.com/guazi-tv-1.0.1-debug.apk">电视TV版下载</a>-->
        <a class="browser <?= $footer_color?>" href="<?= !empty($tvpath["file_path"])?$tvpath["file_path"]:"###" ?>">电视TV版下载</a>
    </div>
    <div class="wp">
        <p>本网站为非赢利性站点，所有内容均由机器人采集于互联网，或者网友上传，本站只提供WEB页面服务，本站不存储、不制作任何视频，不承担任何由于内容的合法性及健康性所引起的争议和法律责任。<br />若本站收录内容侵犯了您的权益，请附说明联系邮箱，本站将第一时间处理。站长邮箱：guazitv@163.com</p>
    </div>
</footer>
<!--右侧导航-->
<?php if($rightnav_type && $rightnav_type == 1):?>
<div class="qy-float-anchor det-nav" style="" id="det-nav">
    <ul class="anchor-list">
        <?php if(!empty($channels)) : ?>
            <?php foreach ($channels['list'] as $key => $channel): ?>
                <?php if($channel['channel_id'] != 0) : ?>
                    <li class="list-item"><a data-id="#section<?= $channel['channel_id']?>" class="list-link"><?= $channel['channel_name']?></a></li>
                <?php endif;?>
            <?php endforeach ?>
        <?php endif;?>
<!--        <li class="list-item"><a href="--><?//= Url::to(['collaboration'])?><!--" class="list-link">为您推荐</a></li>-->
        <li class="list-item"><a href="<?= Url::to(['help', 'tab' => 'contact'])?>" class="list-link">联系客服</a></li>
        <li class="list-item"><a href="javascript:scroll(0,0)" class="list-link backToTop"><svg class="back-top-svg" viewBox="0 0 20 12" xmlns="https://www.w3.org/2000/svg"><path d="M10.784 2.305l6.91 6.911a1.045 1.045 0 1 1-1.477 1.478L10 4.477l-6.217 6.217a1.045 1.045 0 0 1-1.478-1.478l6.911-6.91c.189-.189.43-.29.677-.305h.214c.246.014.488.116.677.304z"></path></svg>顶部</a></li>
    </ul>
</div>
<?php else: ?>
    <div class="rigNav" name="zt">
        <div class="rigNav-icon01">
            <span onclick="rightUrl('seek')">在线求片</span>
            <a href="<?= Url::to(['/video/seek'])?>" target="_blank">&nbsp;</a>
        </div>
        <div class="rigNav-icon02">
            <span onclick="rightUrl('help','contact')">联系客服</span>
            <a href="<?= Url::to(['/video/help', 'tab' => 'contact'])?>">&nbsp;</a>
        </div>
        <div class="rigNav-icon03">
            <span onclick="rightUrl('personal')">个人中心</span>
            <a href="<?= Url::to(['/video/personal'])?>">&nbsp;</a>
        </div>
        <div class="rigNav-icon04">
            <span onclick="rightUrl('help')">帮助中心</span>
            <a href="<?= Url::to(['/video/help', 'tab' => ''])?>">&nbsp;</a>
        </div>
        <div class="rigNav-top" id="backToTop">
            <span>返回顶部</span>
            <a href="javascript:;">&nbsp;</a>
        </div>
    </div>
<?php endif;?>

<!--VIP弹出层 id="alt02"-->
<div class="alt">
    <div class="alt02-box" name="zt">
        <ul class="alt02-top" name="zt">
            <li class="alt02-topLi01"><img src="/images/newindex/logon.png" /></li>
            <li class="alt02-topLi02">测试用户名</li>
            <li class="alt02-topLi03"> VIP剩余 0 天 </li>
            <li class="alt02-topLi04">
                <a href="javascript:;">为他充值</a>
            </li>
            <li class="alt02-topLi04">
                <a href="javascript:;">VIP特权</a>
            </li>
        </ul>

        <div class="alt02-xz" name="zt">
            <ul class="alt02-bdr">
                <li>30 天</li>
                <li> (€0.5/天) </li>
                <li> 原价€15 </li>
                <li>€8.8</li>
                <li>￥69</li>
                <li><img src="/images/newindex/VIP-1.png" />黄金VIP</li>
            </ul>
            <ul>
                <li>30 天</li>
                <li> (€0.5/天) </li>
                <li> 原价€15 </li>
                <li>€8.8</li>
                <li>￥69</li>
                <li><img src="/images/newindex/VIP-1.png" />黄金VIP</li>
            </ul>
            <ul>
                <li>30 天</li>
                <li> (€0.5/天) </li>
                <li> 原价€15 </li>
                <li>€8.8</li>
                <li>￥69</li>
                <li><img src="/images/newindex/VIP-2.png" />黄金VIP</li>
            </ul>
            <ul>
                <li>30 天</li>
                <li> (€0.5/天) </li>
                <li> 原价€15 </li>
                <li>€8.8</li>
                <li>￥69</li>
                <li><img src="/images/newindex/VIP-3.png" />黄金VIP</li>
            </ul>
        </div>

        <ul class="alt02-tabA" name="zt">
            <li class="tabA">信用卡支付</li>
            <li>聚合支付 </li>
            <li>其他支付 </li>
        </ul>
        <!--未登录显示-->
        <div class="alt02-tabBox" style="display: none;">
            <div class="alt02-no">
                您还未登录，请登录后再继续充值<br />
                <a href="javascript:;">登录</a>
            </div>
        </div>
        <div class="paybox">
            <!--信用卡支付-->
            <div class="paybox01 act">
                <div class="paybox01-L">
                    <div>
                        <img src="/images/newindex/mastercard.png" />
                    </div>
                    <div>
                        <img src="/images/newindex/visacard.png" />
                    </div>
                </div>
                <div class="paybox01-R">
                    <div>
                        信用卡付款须知(必读)：
                    </div>
                    <ul>
                        <li>1.您的账单地址所在国家必须与发卡银行所在国家一致，否则将付款失败。</li>
                        <li>2.账单地址所在国家不能为中国。</li>
                        <li>3.请如实填写您的账单地址，否则将被标记为欺诈交易。</li>
                        <li>4.相同IP在一周内只能支付一次。</li>
                        <li>5.如付款不成功请换用其它付款方式。</li>
                        <li>6.付款成功却未开通VIP，
                            <a href="javascript:;">请联系客服</a>。</li>
                    </ul>
                </div>
                <div class="paybtn01">
                    <input type="button" name=""  value="开始支付" />
                </div>
            </div>
            <!--聚合支付-->
            <div class="paybox02">
                <div class="paybox02-L">
                    <div class="paybox02-L-text">
                        请选择付款方式：
                    </div>
                    <div class="paybox02-fs" name="zt">
                        <div>
                            <input type="radio" name="pay" id="pay01" value="" />
                            <label class="pay01" for="pay01">支付宝</label>
                        </div>

                        <div>
                            <input type="radio" name="pay" id="pay02" value="" />
                            <label class="pay02" for="pay02">微信</label>
                        </div>

                        <div>
                            <input type="radio" name="pay" id="pay03" value="" />
                            <label class="pay03" for="pay03">Paypal-€</label>
                        </div>

                        <div>
                            <input type="radio" name="pay" id="pay04" value="" />
                            <label class="pay04" for="pay04">Paypal-$</label>
                        </div>

                        <div>
                            <input type="radio" name="pay" id="pay05" value="" />
                            <label class="pay05" for="pay05">TGC余额</label>
                        </div>
                    </div>
                </div>
                <div class="paybox02-R">
                    <div class="paybox02-je">
                        约<span>15欧元</span> (15TGC)
                    </div>
                    <div class="paybox02-zh" name="zt">
                        充值账号：<span>tianye1987001@gmail.com</span>
                    </div>
                    <div class="paybox02-R-text">
                        *充值后十分钟后到账
                    </div>
                    <div class="paybox02-btn">
                        <!--禁用和可用样式不同-->
                        <input type="button" name=""  disabled="disabled" value="授权支付" />
                    </div>
                </div>
                <div class="paybox02-B">
                    <a href="javascript:;"><img src="/images/newindex/navlf-bzO.png" /></a>
                    <a href="javascript:;"><img src="/images/newindex/tgclogo_light.png" /></a>
                </div>
            </div>
            <!--其他支付-->
            <div class="paybox03">
                <div class="paybox03-L">
                    <div>
                        <img src="/images/newindex/ewm.jpg" />
                    </div>
                    <div name="zt">
                        微信号：<span id="wexinhao">y1019868671</span>
                        <!--复制到剪贴版  功能没实现-->
                        <input class="paybox03-L-btn" type="button" name=""  value="复制" />
                    </div>
                </div>
                <div class="paybox03-R">
                    人工充值，微信添加<br /> 在线：北京时间晚11点-- 次日早11点<br /> 微信不定期更换，每次充值前请来此处确认
                </div>
            </div>
        </div>
        <div class="alt02-foot">
            充值即表示您已阅读并同意
            <a href="javascript:;">《VIP会员服务条款》</a>
        </div>
        <!--关闭按钮-->
        <input class="alt-GB" type="button"  />
    </div>
</div>

<!--开发中alert-->
<div class="alt" id="alt07" style="display: none;">
    <div class="alt-box07">
        <div class="alt-p">
            <img src="/images/newindex/development.png"/>
        </div>
        <!--最大宽度500px  最小360px 会员-->
        <div class="alt-content" name="zt">
            <div class="alt-content-text" name="zt">
                <h3>功能暂未开放</h3>
                <p>功能努力开发中，敬请期待！</p>
            </div>
            <div class="alt-bth-box02" name="zt">
                <!--这里的按钮最多两个    多余的可删除   隐藏-->
                <input class="bth-off" type="button"  onclick="closewarning();" value="离开" />
                <input class="bth-on" type="button"  onclick="closewarning();" value="确认" />
            </div>
        </div>
    </div>
</div>
<!--提交成功弹出层-->
<div class="alt" id="alt05">
    <div class="alt05-box" name="zt" style="border-radius:20px;">
        <!--报错也用这个弹出层-->
        <p class="alt-title alt05-p" name="zt">提交成功</p>
        <!--多余的可以删除-->
        <div class="alt-bth-box" name="zt" style="background-color:#FF556E;">
            <!--            <input class="alt-bth-off closealt05" type="button" name=""  value="取消" />-->
            <input class="alt-bth-on" type="button" name="" id="closealt05" value="确定" style="color:#fff;"/>
        </div>
    </div>
    <!--关闭按钮-->
    <!--    <input class="alt-GB" type="button"  value="X" />-->
</div>
<!--成功弹出层（新）-->
<div class="pop-tip" id="pop-tip">成功</div>

<script>
    $(function(){
        $("#keywords").focus(function(){
            findwords();
        });

        //关闭vip提示框
        $("#closealtvip").click(function(){
            $("#altvip").hide();
        });
    });

    //提示功能开发中
    function showwarning(){
        $("#alt07").css("display","block");
    }
    //关闭提示
    function closewarning(){
        $("#alt07").css("display","none");
    }
    //右侧链接
    function rightUrl(urlid,tab=''){
        if(urlid=='seek'){
            // window.location.href = '/video/seek';
            window.open('/video/seek');
        }else if(urlid=='help'){
            window.location.href = '/video/help?tab='+tab;
        }else if(urlid=='personal'){
            window.location.href = '/video/personal?tab='+tab;
        }
    }
    function isvip(){
        $.get('/video/uservip', {}, function(res) {
            //console.log(res);
            if(res.errno<0){
                $("#user_isvip").html("还不是vip会员");
            }
        });
    }

    //详情
    function XQ(videoId){
        var ar = {};
        ar['videoId'] = videoId;
        $.get('/video/user-favorite', ar, function(res) {
            //console.log(res);
            if(res.errno==0 && res.data==1){
                $("#alt03"+videoId+" .XQ-btn input").addClass("act");
            }
            $("#alt03"+videoId).show();
        });
        eventStop();
    }
    //收藏
    function addfavors(videoId){
        var uid = finduser();
        if(!isNaN(uid) && uid!=""){
            var ar = {};
            ar['videoid'] = videoId;
            $.get('/video/change-favorite',ar,function(res){
                $("#alt03"+videoId+" .XQ-btn input").toggleClass("act");
            });
        }else{//弹框登录
            showloggedin();
            $("#alt03"+videoId).hide();
        }
    }

    //回车搜索
    $('#keywords').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            savewords();
        }
    });
</script>
</body>
</html>
