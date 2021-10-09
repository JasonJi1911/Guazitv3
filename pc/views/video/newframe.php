<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

$this->registerMetaTag(['name' => 'keywords', 'content' => LOGONAME.'视频,澳洲'.LOGONAME.'视频,新西兰'.LOGONAME.'视频,澳新'.LOGONAME.'视频,'.LOGONAME.'影视,电影,电视剧,榜单,综艺,动画,记录片']);

switch ($pageTab) {
    case "newdetail" :
        $this->title = $data['info']['video_name'] . '-' . LOGONAME . '视频';
        break;
    default :
        $this->title = LOGONAME. '视频';
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
<script src="/js/jquery.js"></script>
<script src="/js/video/newindex.js"></script>
<script src="/js/video/searchHistory.js"></script>
<script src="/js/video/gVerify.js"></script>
<script>
    $(document).ready(function(){
        var mobile_flag = isMobile();
        if(mobile_flag){
            window.location = '<?=WAP_HOST_PATH?>';
        }
        $('#v_navTopLogo').click(function(){
            window.location.href = '/video/index';
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
        $("#login_yzm").val("");
        $(".c_register").removeClass("act");
        $("#reg_email").val("");
        $("#reg_prefix_phone").val("+86");
        $("#reg_prefix_phone").removeClass("act")
        $("#reg_phone").val("");
        $("#reg_newpwd").val("");
        $("#quertion_value").val("密保问题");
        $("#quertion_value").removeClass("act")
        $("#reg_answer").val("");
        $("#alt01").show();
    }
</script>

<!--登录弹出层-->
<div class="alt" id="alt01" style="display: none;">
    <div class="alt01—box" name="zt">
        <div class="alt01-GG">
            <?php if(!empty($channels['login_advert'])) :?>
                <?php foreach ($channels['login_advert'] as $advert): ?>
                    <a href="<?=$advert['ad_skip_url']?>" target="_blank">
                        <img src="<?=$advert['ad_image']?>" />
                    </a>
                <?php endforeach;?>
            <?php else :?>
                <a href="javascript:;"><img src="/images/newindex/GG03.png" /></a>
            <?php endif;?>
            <div class="GGtext">
                广告
            </div>
        </div>
        <div class="alt-logon">
            <ul class="tab-nav" name="zt">
                <li class="c_login act">
                    账号登录
                </li>
                <li class="c_register">立即注册</li>
            </ul>
            <div class="tab-box">
                <div class="c_login act">
                    <!--报错样式 wor-->
                    <div class="inp-box mb-30" name="zt">
                        <img class="icon" src="/images/newindex/logon-icon-01.png" />
                        <input type="text" name="" placeholder="邮箱/手机号" id="login_account" value="" />
                    </div>
                    <!--报错样式 wor-->
                    <div class="inp-box mb-30 pasbox" name="zt">
                        <img class="icon" src="/images/newindex/logon-icon-02.png" />
                        <input type="password" class="inp pas" name="" placeholder="密码" id="login_pwd" value="" />
                        <input type="button" class="eye"  value="" />
                    </div>
                    <!--报错样式 wor-->
                    <div class="inp-box mb-30 yzmbox" name="zt">
                        <img class="icon" src="/images/newindex/logon-icon-03.png" />
                        <input type="text" name="" placeholder="验证码" id="login_yzm" value="" />
                        <div class="yzm" id="picyzm" style="width:100px;"></div>
                        <!--                        <img class="yzm" src="/images/newindex/logon-yzm.png" />-->
                        <input type="button" class="sx" id="v_refresh" value="" />
                    </div>
                    <div class="bttn-box mb-30">
                        <input type="button" id="login_submit" value="登录" />
                    </div>
                    <ul class="gn-box" name="zt">
                        <li><input type="checkbox" name="zd" value="" /><label class="chebox act" id="zd" for="zd">自动登录</label></li>
                        <li>
                            <a href="<?= Url::to(['/video/help', 'tab' => 'pwd'])?>">忘记密码?</a>
                        </li>
                    </ul>
                </div>
                <div class="c_register">
                    <!--报错样式 wor-->
                    <div class="inp-box mb-20" name="zt">
                        <img class="icon" src="/images/newindex/logon-icon-01.png" />
                        <input type="text" name="" placeholder="邮箱" id="reg_email" value="" />
                    </div>
                    <!--报错样式 wor-->
                    <div class="inp-box sltJ mb-20 tel " name="zt">
                        <img class="icon" src="/images/newindex/logon-icon-06.png" />
                        <input type="button" class="selectJ" id="reg_prefix_phone" value="+86" />
                        <ul class="opJ">
                            <li>中国 <span>+86</span></li>
                            <?php if(!empty($channels['country_info'])) :?>
                                <?php foreach ($channels['country_info'] as $country): ?>
                                    <?php if($country['mobile_areacode']!=''):?>
                                        <li><?=$country['country_name']?> <span>+<?=$country['mobile_areacode']?></span></li>
                                    <?php endif;?>
                                <?php endforeach;?>
                            <?php endif;?>
                        </ul>
                        <input type="text" name="" placeholder="手机号" id="reg_phone" value="" />
                    </div>
                    <!--报错样式 wor-->
                    <div class="inp-box mb-20 pasbox" name="zt">
                        <img class="icon" src="/images/newindex/logon-icon-02.png" />
                        <input type="password" class="inp pas" name="" placeholder="新密码" id="reg_newpwd" value="" />
                        <input type="button" class="eye"  value="" />
                    </div>
                    <!--报错样式 wor-->
                    <div class="inp-box sltJ mb-20 " name="zt">
                        <img class="icon" src="/images/newindex/logon-icon-07.png" />
                        <input type="button" class="selectJ" id="quertion_value" value="密保问题" />
                        <input type="hidden" id="reg_question" value="" />
                        <div class="opJ">
                            <?php if(!empty($channels['question_info'])) :?>
                                <?php foreach ($channels['question_info'] as $question): ?>
                                    <input type="button" data-value="<?=$question['id']?>" value="<?=$question['message']?>" />
                                <?php endforeach;?>
                            <?php endif;?>
                        </div>
                    </div>
                    <!--报错样式 wor-->
                    <div class="inp-box mb-20 " name="zt">
                        <img class="icon" src="/images/newindex/logon-icon-08.png" />
                        <input type="text" name="" placeholder="密保问题答案" id="reg_answer" value="" />
                    </div>
                    <div class="bttn-box mb-20">
                        <input type="button" id="reg_submit" value="注册" />
                    </div>
                </div>
            </div>
            <div class="bowbox" name="zt">
                <input type="radio" name="xy" value="" />
                <label for="xy" id="xy" class="chebox act">我已阅读并同意<a href="<?= Url::to(['/video/help', 'tab' => 'terms'])?>">《用户协议》</a></label>
            </div>
            <!--关闭按钮-->
            <input class="alt-GB" type="button"  />
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
        $headclass = "bkgWhite";
        break;
}
?>
<body id="<?= $bodyid?>" name="zt" >
<!-- 顶部导航 begin -->
<?php
$name_zt = "";
$class_zt_black = "";
if($pageTab != "newdetail") {//顶部导航默认透明或白色
    $name_zt = "zt";
    $class_zt_black = " ";
}else{//顶部导航默认黑色
    $name_zt = "";
    $class_zt_black = " ZT-black";
}?>
<div class="navTopBox <?= $headclass?> <?= $class_zt_black?>" name="<?= $name_zt?>">
    <ul class="navTop">
        <li class="navTopLogo" id="v_navTopLogo">
            <a href="/video/index">
                <span id="head-city" class="navTopWZ" style="display: none;"></span>
                <script src="https://pv.sohu.com/cityjson?ie=utf-8"></script>
                <script src="/js/video/country.js"></script>
<!--                <script>-->
<!--                    $.get('/video/get-city', [], function(res) {-->
<!--                        console.log(JSON.stringify(res));-->
<!--                        if(res.data.city.trim()!=""){-->
<!--                            $("#head-city").text(res.data.city);-->
<!--                        }-->
<!--                    });-->
<!--                </script>-->
            </a>
        </li>
        <li class="navTopMenuBox">
            <div class="navTopMenu">
                <div class="navTopMenu-text" name="zt">
                    导&nbsp;航
                </div>
                <div class="navTopMenu-oneTop" name="zt">
                    &nbsp;
                </div>
                <ul class="navTopMenu-one">
                    <!--导航菜单--一级-->
                    <li class="" name="zt">
                        <a href="<?= Url::to(['/video/index'])?>" >
                            首页
                        </a>
                    </li>
                    <?php if(!empty($channels)) :?>
                        <?php foreach ($channels['channeltags'] as $channel) :?>
                            <li class="" name="zt">
                                <?php if($channel['channel_name'] != '首页'): ?>
                                    <a class="
                                    <?if(!empty($channel['tags'])) :?>
                                        navTopMenu-oneRig
                                    <?php endif;?>
                                    " href="<?= Url::to(['/video/list', 'channel_id' => $channel['channel_id']])?>" >
                                        <?= $channel['channel_name']?>
                                    </a>
                                    <!--导航菜单--二级-->
                                    <ul class="navTopMenu-two " name="zt">
                                        <?php foreach ($channel['tags'] as $tag) :?>
                                            <li><a href="<?= Url::to(['list', 'channel_id' => $channel['channel_id'], 'tag' => $tag['cat_id']])?>"><?= $tag['name']?></a></li>
                                        <?php endforeach;?>
                                    </ul>
                                <?php endif;?>
                            </li>
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>
            </div>
        </li>
        <li class="navTopSearchBox">
            <div class="navTopSearch " name="zt">
                <input type="text" class="navTopSearchText" id="keywords" placeholder="<?= empty($hotword['tab'][0]['list'][0]['video_name']) ? '': $hotword['tab'][0]['list'][0]['video_name']?>" />
                <input type="hidden" id="v_keywords0" value="<?= empty($hotword['tab'][0]['list'][0]['video_name']) ? '': $hotword['tab'][0]['list'][0]['video_name']?>"
                <!--输入框点击弹出菜单-->
                <ul class="searchMenuBox " name="zt" style="display: none;">
                    <li class="clrGrey" id="searchHtitle" style="display:none;">
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
                                        if($key==0){
                                            $clr = "clr01";
                                        }else if($key==1){
                                            $clr = "clr02";
                                        }else if($key==2){
                                            $clr = "clr03";
                                        }else{
                                            $clr = "";
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
                <a href="<?= Url::to(['/video/hot-play'])?>" class="navTopSearchA " name="zt">&nbsp;</a>
                <input type="button" class="navTopSearchBtn " name="zt" onclick="savewords();"  value="" />
            </div>
        </li>
        <li class="navTopBtnBox">
            <input type="hidden" id="login_id" value="" />
            <!--升级vip-->
            <div id="vipbtn" class="navTopBtn " onclick="showwarning();">
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
            <div class="navTopBtn" onclick="showwarning();">
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
                <div class="LSmenuBox " name="zt">
                    <!--未登录   显示-->
                    <div class="LSmenu-No">
                        暂无历史
                    </div>
                    <!--登录显示-->
                    <ul class="LSmenu " name="zt">
                        <li>
                            <a href="javascript:;">
                                <div>爱，死亡和机器人第2季</div>
                                <div>测试集数</div>
                                <div>
                                    <span>5</span>
                                    <span>天前</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <div>测试名称</div>
                                <div>测试集数</div>
                                <div>
                                    <span>5</span>
                                    <span>天前</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <div>测试名称</div>
                                <div>测试集数</div>
                                <div>
                                    <span>5</span>
                                    <span>天前</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <div>测试名称</div>
                                <div>测试集数</div>
                                <div>
                                    <span>5</span>
                                    <span>天前</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="LSmenuBottom">
                        <div class="LSmenuBottom-lf">
                            &nbsp;
                        </div>
                        <div class="LSmenuBottom-rg">
                            <a href="javascript:;">查看更多&nbsp;》</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--通知-->
            <div class="navTopBtn" onclick="showwarning();">
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
                <div class="LSmenuBox lf " name="zt" style="display: none;">
                    <ul class="XX-tabA " name="zt">
                        <li class="tabA">消息</li>
                        <li>关注&收藏</li>
                    </ul>
                    <div class="XX-tabBox">
                        <div class="tabBox">
                            <div class="LSmenu-No">
                                暂无历史1
                            </div>
                        </div>
                        <div>
                            <div class="LSmenu-No">
                                暂无历史2
                            </div>
                        </div>
                    </div>

                    <div class="LSmenuBottom">
                        <div class="LSmenuBottom-lf">
                            &nbsp;
                        </div>
                        <div class="LSmenuBottom-rg">
                            <a href="javascript:;">更多&nbsp;》</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--未登录显示-->
            <div class="navTopLogon" id="notloggedin">
                <div class="navTopLogonImg-no">
                    <img src="/images/newindex/logon.png" />
                </div>
                <div class="navTopLogonName " name="zt">
                    登录
                </div>
            </div>
            <!--登录显示-->
            <div class="navTopLogon" id="loggedin" style="display:none;">
                <div class="navTopLogonImg">
                    <img id="user_headimg" src="/images/newindex/logon.png" onerror="javascript:this.src='/images/newindex/logon.png';" />
                </div>
                <div class="navTopLogon-GRXX " name="zt">
                    <div class="navTopLogon-GRXX-box">
                        <ul class="navTopLogon-box01">
                            <li class="navTopLogon-name" id="user_name"></li>
                            <li class="navTopLogon-Gender"><img src="/images/newindex/nan.png" /></li>
                        </ul>
                        <ul class="navTopLogon-box02">
                            <li class="navTopLogon-icon01"><img src="/images/newindex/jinbi.png" /></li>
                            <li class="navTopLogon-text" class="user_score">0</li>
                            <li class="navTopLogon-text" id="user_isvip"></li>
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
                $(function(){
                    var uid = finduser();
                    var pagetab = '<?=$pageTab?>';
                    if(!isNaN(uid) && uid!=""){
                        //login
                        var ar = {};
                        ar['uid'] = uid;
                        $.get('/video/userinfo',ar,function(res){
                            if(res.errno==0){
                                if(pagetab=="newdetail"){
                                    $("#det_login").parent().parent().hide();
                                }
                                showlogin(res.data.user);
                                if(res.data.isvip!=1){
                                    $("#user_isvip").html("还不是vip会员");
                                }else{
                                    $("#user_isvip").html("");
                                }
                                $("#login_id").val(uid);
                            }else{
                                $("#loggedin").hide();
                                $("#notloggedin").show();
                            }
                        });
                    }else{
                        //notlogin
                        $("#loggedin").hide();
                        $("#notloggedin").show();
                    }
                });
            </script>
        </li>
    </ul>
</div>

<!-- 顶部导航 end -->
<?php switch ($pageTab) {
    case "newindex":
        echo $this->render('newindex',[
            'data'          => $data,
            'channels'      => $channels,
            'channel_id'    => $channel_id,
            'hotword'       => $hotword
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
            'feedbackinfo'  => $feedbackinfo,
            'helptab'       => $helptab
        ]);
        break;
    case "adcenter" :
        echo $this->render('adcenter',[
            'data'  => $data
        ]);
        break;
    case "personal" :
        echo $this->render('personal',[
            'data'  => $data,
            'channels'  => $channels,
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
<div class="foot" name="zt">
    <div class="footBox">
        <div>
            <ul class="footNav">
                <li>
                    <a href="javascript:;" style="display: none;">
                        <img src="/images/newindex/dizi.png" />
                        <img id="v_countryimg" src="" />
                        <span id="v_countryname"></span>
                    </a>
                </li>
                <li>
                    <a href="https://rysp.tv/sitemap.html" title="<?=LOGONAME?>视频"target="_blank"><strong><?=LOGONAME?>视频</strong></a>
                </li>
                <li>
                    <a href="<?= Url::to(['/video/help', 'tab' => 'aboutUs'])?>">关于我们</a>
                </li>
                <li>
                    <a href="<?= Url::to(['/video/help', 'tab' => 'question'])?>">常见问题</a>
                </li>
                <li>
                    <a href="<?= Url::to(['/video/help', 'tab' => 'feedback'])?>">在线反馈</a>
                </li>
                <li>
                    <a href="<?= Url::to(['/video/adcenter'])?>">广告投放</a>
                </li>
                <li>
                    <a href="<?= Url::to(['/video/help', 'tab' => 'contact'])?>">联系我们</a>
                </li>
                <li>
                    <a href="<?= Url::to(['/video/help', 'tab' => 'terms'])?>">服务条款</a>
                </li>
<!--                <li>-->
<!--                    <a href="javascript:;">充值中心</a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="javascript:;">充值协议</a>-->
<!--                </li>-->
            </ul>
            <div class="footSM">
                版权声明：如果来函说明本网站提供内容本人或法人版权所有。本网站在核实后，有权先行撤除，以保护版权拥有者的权益。<br /> 邮箱地址：
                <?=EMAIL_NAME?> &nbsp;
                <?=PC_HOST_NAME?> 版权所有，未经授权禁止链接、复制或建立
            </div>
            <div class="footPH">
                Copyright 2020-2021 <?=PC_HOST_NAME?> 版权所有，未经授权禁止链接、复制或建立
            </div> Allrights Reserved.
            </div>
        </div>

        <div class="footKF">
            <a href="<?= Url::to(['/video/help', 'tab' => 'contact'])?>">
                <img src="/images/newindex/kefu.png" /><br /> 联系客服
            </a>
        </div>

        <div class="footXZ">
            <a href="javascript:void(0)" onclick="showwarning();"><img src="/images/newindex/android.png" /></a>
            <a href="javascript:void(0)" onclick="showwarning();"><img src="/images/newindex/ios.png" /></a>
        </div>
    </div>
</div>
<!--右侧导航-->
<div class="rigNav" name="zt">
    <div class="rigNav-top" id="backToTop">
        <span>返回顶部</span>
        <a href="javascript:;">&nbsp;</a>
    </div>
    <div class="rigNav-icon01" id="HF">
        <span>一键换肤</span>
        <a href="javascript:;">&nbsp;</a>
    </div>
    <div class="rigNav-icon04"><!--求片-->
        <span onclick="rightUrl('seek')">求片</span>
        <a href="<?= Url::to(['/video/seek'])?>">&nbsp;</a>
    </div>
    <div class="rigNav-icon05"><!--帮助中心-->
        <span onclick="rightUrl('help')">帮助中心</span>
        <a href="<?= Url::to(['/video/help', 'tab' => ''])?>">&nbsp;</a>
    </div>
    <div class="rigNav-icon02"><!--app下载 tab=>appdownload-->
        <span onclick="showwarning();">下载APP</span>
        <a href="javascript:void(0)" onclick="showwarning();">&nbsp;</a>
    </div>
    <div class="rigNav-icon03"><!--升级vip-->
        <span>功能开发中</span>
        <a href="javascript:;">&nbsp;</a>
    </div>
</div>

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
<style>
    .alt05-p{
        background-image:url(/images/newindex/alt05_back.png);
        background-position: center center;
        background-repeat: no-repeat;
        padding: 130px 20px 10px 20px;
        margin-bottom:20px;
        text-align: center;
        color:#696969;
    }
</style>
<!--提交成功弹出层-->
<div class="alt" id="alt05">
    <div class="alt05-box" name="zt" style="border-radius:20px;">
        <!--报错也用这个弹出层-->
        <p class="alt-title alt05-p" name="zt">提交成功</p>
        <!--多余的可以删除-->
        <div class="alt-bth-box" name="zt" style="background-color:#FF5722;">
<!--            <input class="alt-bth-off closealt05" type="button" name=""  value="取消" />-->
            <input class="alt-bth-on" type="button" name="" id="closealt05" value="确定" style="background-color:#FF5722;color:#fff;"/>
        </div>
    </div>
    <!--关闭按钮-->
<!--    <input class="alt-GB" type="button"  value="X" />-->
</div>
<script>
//初始化验证码
var verifyCode = new GVerify({
    id : "picyzm",
    type : "blend"
});
$(function(){
    isvip();
    // console.log(document.cookie);
    // console.log(window.localStorage);
    $("#keywords").focus(function(){
        findwords();
    });
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
            return false;
        }
        if(!$("#xy").hasClass("act")){
            $(".alt-title").text("请阅读并同意《用户协议》");
            $("#alt05").show();
            verifyCode.refresh();
            tab = false;
            return false;
        }
        if(tab){
            $.get('/site/login',arrIndex,function(res){
                // console.log(res);
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
            return false;
        }else{
            var isemail = isEmail(email);
            if(!isemail){
                $("#reg_email").parent().addClass("wor");
                $(".alt-title").text("邮箱格式错误");
                $("#alt05").show();
                tab = false;
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
            return false;
        }else{
            var ismobile = isMobilePhone(phone);
            if(!ismobile){
                $("#reg_phone").parent().addClass("wor");
                $(".alt-title").text("手机号格式错误");
                $("#alt05").show();
                tab = false;
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
            return false;
        }else{
            arrIndex['newpwd'] = newpwd;
        }
        if(answer==""){
            $("#reg_answer").parent().addClass("wor");
            $(".alt-title").text("密保答案不能为空");
            $("#alt05").show();
            tab = false;
            return false;
        }else{
            arrIndex['question'] = question;
            arrIndex['answer'] = answer;
        }
        if(!$("#xy").hasClass("act")){
            $(".alt-title").text("请阅读并同意《用户协议》");
            $("#alt05").show();
            tab = false;
            return false;
        }
        if(tab){
            $.get('/video/register', arrIndex, function(res) {
                //console.log(res);
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
function rightUrl(urlid){
    if(urlid=='seek'){
        window.location.href = '/video/seek';
    }else if(urlid=='help'){
        window.location.href = '/video/help';
    }else if(urlid=='personal'){
        window.location.href = '/video/personal';
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
//收藏
function addfavors(that){
    var uid = $("#login_id").val();
    if(!isNaN(uid) && uid!=""){
        var arrindex = {};
        arrindex['videoid'] = '<?=$data['info']['play_video_id']?>';
        $.get('/video/change-favorite',arrindex,function(res){
            $(that).toggleClass("act");
            if(res.errno==0){
                if(res.data.status==0){
                    $("#id_favors").val(--total_favors);
                }else{
                    $("#id_favors").val(++total_favors);
                }
            }
        });
    }else{//弹框登录
        showloggedin();
    }
}
</script>
</body>
</html>