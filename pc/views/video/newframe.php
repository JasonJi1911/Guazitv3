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
<script>
    $(document).ready(function(){
        var mobile_flag = isMobile();
        if(mobile_flag){
            window.location = 'https://m.jxsp.tv/';
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
        console.log();
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
</script>
<?php
$headclass = "";
$bodyid = "";
switch ($pageTab){
    case "newindex" : case "channel" : case "help" : case "hotplay" : case "adcenter" :
        $bodyid    = "indexTS";
        $headclass = "bkgBlack";
        break;
    case "list" : case "searchresult" : case "seek" : case "newdetail":
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
                <div class="navTopMenu-text<?= $class_zt_black?>" name="<?= $name_zt?>">
                    导&nbsp;航
                </div>
                <div class="navTopMenu-oneTop<?= $class_zt_black?>" name="<?= $name_zt?>">
                    &nbsp;
                </div>
                <ul class="navTopMenu-one">
                    <!--导航菜单--一级-->
                    <li class="<?= $class_zt_black?>" name="<?= $name_zt?>">
                        <a href="<?= Url::to(['/video/index'])?>" >
                            首页
                        </a>
                    </li>
                    <?php if(!empty($channels)) :?>
                        <?php foreach ($channels['channeltags'] as $channel) :?>
                            <li class="<?= $class_zt_black?>" name="<?= $name_zt?>">
                                <?php if($channel['channel_name'] != '首页'): ?>
                                    <a class="
                                    <?if(!empty($channel['tags'])) :?>
                                        navTopMenu-oneRig
                                    <?php endif;?>
                                    " href="<?= Url::to(['/video/list', 'channel_id' => $channel['channel_id']])?>" >
                                        <?= $channel['channel_name']?>
                                    </a>
                                    <!--导航菜单--二级-->
                                    <ul class="navTopMenu-two <?= $class_zt_black?>" name="<?= $name_zt?>">
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
            <div class="navTopSearch <?= $class_zt_black?>" name="<?= $name_zt?>">
                <input type="text" class="navTopSearchText" id="keywords" placeholder="<?= empty($hotword['tab'][0]['list'][0]['video_name']) ? '': $hotword['tab'][0]['list'][0]['video_name']?>" />
                <input type="hidden" id="v_keywords0" value="<?= empty($hotword['tab'][0]['list'][0]['video_name']) ? '': $hotword['tab'][0]['list'][0]['video_name']?>"
                <!--输入框点击弹出菜单-->
                <ul class="searchMenuBox <?= $class_zt_black?>" name="<?= $name_zt?>" style="display: none;">
                    <li class="clrGrey" id="searchHtitle" style="display:none;">
                        搜索历史：
                        <input class="clrGrey-btn" type="button" onclick="clearwords()" value="清空历史" />
                    </li>
                    <li class="clrGrey-list <?= $class_zt_black?>" name="<?= $name_zt?>"" id="searchHistory">
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
                                    <li class="searchMenu <?= $class_zt_black?>" name="<?= $name_zt?>" >
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
                <a href="<?= Url::to(['/video/hot-play'])?>" class="navTopSearchA <?= $class_zt_black?>" name="<?= $name_zt?>">&nbsp;</a>
                <input type="button" class="navTopSearchBtn <?= $class_zt_black?>" name="<?= $name_zt?>" onclick="savewords();" id="" value="" />
            </div>
        </li>
        <li class="navTopBtnBox">
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
                <ul class="VIPmenuBOX <?= $class_zt_black?>" name="<?= $name_zt?>" style="display: none;">
                    <li class="VIPmenuBOX-li">
                        <div class="VIPmenuBOX-liText">
                            还不是VIP？会员
                        </div>
                        <div class="VIPmenuBOX-liBtn">
                            <input type="button" id="" value="立即开通" />
                        </div>
                    </li>
                    <li class="VIPmenuBOX-A <?= $class_zt_black?>" name="<?= $name_zt?>">
                        <a href="javascript:;">
                            <img src="/images/newindex/adguanggao.png" /> 过滤广告
                        </a>
                    </li>
                    <li class="VIPmenuBOX-A <?= $class_zt_black?>" name="<?= $name_zt?>">
                        <a href="javascript:;">
                            <img src="/images/newindex/hdchaoqing.png" /> 观看超清视频
                        </a>
                    </li>
                    <li class="VIPmenuBOX-A <?= $class_zt_black?>" name="<?= $name_zt?>">
                        <a href="javascript:;">
                            <img src="/images/newindex/xiazai.png" /> 下载视频
                        </a>
                    </li>
                    <li class="VIPmenuBOX-A <?= $class_zt_black?>" name="<?= $name_zt?>">
                        <a href="javascript:;">
                            <img src="/images/newindex/pianku.png" /> 求片
                        </a>
                    </li>
                    <li class="VIPmenuBOX-A <?= $class_zt_black?>" name="<?= $name_zt?>">
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
            <div class="navTopBtn" onclick="showwarning();">
                <div class="navTopBtnImg">
                    &nbsp;
                </div>
                <div class="navTopBtnName">
                    福利
                </div>
                <div class="VIPmenuTop <?= $class_zt_black?>" name="<?= $name_zt?>">
                    &nbsp;
                </div>
                <!--菜单-->
                <ul class="FLmenuBox <?= $class_zt_black?>" name="<?= $name_zt?>" style="display: none;">
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
            <div class="navTopBtn" onclick="showwarning();">
                <div class="navTopBtnImg">
                    &nbsp;
                </div>
                <div class="navTopBtnName">
                    上传
                </div>
                <div class="VIPmenuTop <?= $class_zt_black?>" name="<?= $name_zt?>">
                    &nbsp;
                </div>
                <!--菜单-->
                <ul class="FLmenuBox <?= $class_zt_black?>" name="<?= $name_zt?>" style="display: none;">
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
            <div class="navTopBtn" onclick="showwarning();">
                <div class="navTopBtnImg">
                    &nbsp;
                </div>
                <div class="navTopBtnName">
                    观看历史
                </div>
                <div class="VIPmenuTop <?= $class_zt_black?>" name="<?= $name_zt?>">
                    &nbsp;
                </div>
                <!--菜单-->
                <div class="LSmenuBox <?= $class_zt_black?>" name="<?= $name_zt?>" style="display: none;">
                    <!--未登录   显示-->
                    <div class="LSmenu-No">
                        暂无历史
                    </div>
                    <!--登录显示-->
                    <ul class="LSmenu <?= $class_zt_black?>" name="<?= $name_zt?>" style="display: none;">
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
            <div class="navTopBtn" onclick="showwarning();">
                <div class="navTopBtnImg">
                    &nbsp;
                </div>
                <div class="navTopBtnName">
                    通知
                </div>
                <div class="VIPmenuTop <?= $class_zt_black?>" name="<?= $name_zt?>">
                    &nbsp;
                </div>
                <!--菜单未登录显示-->
                <ul class="FLmenuBox <?= $class_zt_black?>" name="<?= $name_zt?>" style="display: none;">
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
                <div class="LSmenuBox lf <?= $class_zt_black?>" name="<?= $name_zt?>" style="display: none;">
                    <ul class="XX-tabA <?= $class_zt_black?>" name="<?= $name_zt?>">
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
            <div class="navTopLogon" onclick="showwarning();">
                <div class="navTopLogonImg-no">
                    <img src="/images/newindex/logon.png" />
                </div>
                <div class="navTopLogonName <?= $class_zt_black?>" name="<?= $name_zt?>">
                    登录
                </div>
            </div>
            <!--登录显示-->
            <div class="navTopLogon" style="display: none;">
                <div class="navTopLogonImg">
                    <img src="/images/newindex/logon.png" />
                </div>
                <div class="navTopLogon-GRXX <?= $class_zt_black?>" name="<?= $name_zt?>">
                    <div class="navTopLogon-GRXX-box">
                        <ul class="navTopLogon-box01">
                            <li class="navTopLogon-name">用户名称用户名称用户名称用户名称用户名称用户名称</li>
                            <li class="navTopLogon-Gender"><img src="/images/newindex/nan.png" /></li>
                        </ul>
                        <ul class="navTopLogon-box02">
                            <li class="navTopLogon-icon01"><img src="/images/newindex/jinbi.png" /></li>
                            <li class="navTopLogon-text">76</li>
                            <li class="navTopLogon-text">还不是VIP会员</li>
                            <li class="navTopLogon-rank">LV.<span>22</span></li>
                            <li class="navTopLogon-icon01"><img src="/images/newindex/shangsheng.png" /></li>
                            <li class="navTopLogon-Progress">
                                <div>
                                    <div class="Progress">&nbsp;</div>
                                </div>
                            </li>
                            <li class="navTopLogon-experience"><span>76</span>/<span>200</span></li>
                        </ul>
                    </div>
                    <ul class="navTopLogon-box03">
                        <li>
                            <a class="navTopLogon-A" href="javascript:;">个人中心</a>
                        </li>
                        <li><input class="navTopLogon-btn" type="" name="" id="" value="退出" /></li>
                    </ul>
                </div>
            </div>
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
<!--                    <a href="javascript:;">诚聘英才</a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="javascript:;">充值中心</a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="javascript:;">充值协议</a>-->
<!--                </li>-->
            </ul>
            <div class="footSM">
                版权声明：如果来函说明本网站提供内容本人或法人版权所有。本网站在核实后，有权先行撤除，以保护版权拥有者的权益。<br /> 邮箱地址：
                jxsptv@gmail.com &nbsp;
                jxsp.tv 版权所有，未经授权禁止链接、复制或建立
            </div>
            <div class="footPH">
                Copyright 2020-2021 jxsp.tv Allrights Reserved.
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
                <input class="bth-off" type="button" id="" onclick="closewarning();" value="离开" />
                <input class="bth-on" type="button" id="" onclick="closewarning();" value="确认" />
            </div>
        </div>
    </div>
</div>
<script src="/js/video/newindex.js"></script>
<script src="/js/video/searchHistory.js"></script>
<script>
    $(function(){
        $("#keywords").focus(function(){
            findwords();
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
    function rightUrl(urlid){
        if(urlid=='seek'){
            window.location.href = '/video/seek';
        }else if(urlid=='help'){
            window.location.href = '/video/help';
        }
    }
</script>
</body>
</html>