<?php
use yii\helpers\Html;
use wap\assets\ShareAsset;
ShareAsset::register($this);

$iospath = "";
$andpath ="";
if(!empty($data["iosdata"]))
{
    $iospath = $data["iosdata"]["file_path"];
}

if(!empty($data["androiddata"]))
{
    $andpath = $data["androiddata"]["file_path"];
}

$js = <<<JS
$(function(){
    $(".download").click(function(){
        var u = navigator.userAgent;
        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
        var iospath = $("#iospath").val();
        var andpath = $("#andpath").val();
        
        if (isiOS)
        {
            if (iospath != ""){
                window.location = iospath;
            } else {
                alert("无可用IOS应用");  
            }
            return false;
        }
        
        if (isAndroid)
        {
            if (andpath != ""){
                window.location = andpath;
            } else {
                alert("无可用安卓应用");  
            }
            return false;
        }
        return false;
    });
});
JS;

$this->registerJs($js);
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title></title>
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<!--link href="https://cdn.bootcdn.net/ajax/libs/element-ui/2.15.0/theme-chalk/index.css" rel="stylesheet"-->
	<style>
	    body{
	        max-width: 100%;
	    }
	    
        .wechatApp {
            width: 100%;
            -webkit-tap-highlight-color: rgba(255, 255, 255, 0);
            display: block;
        }
	</style>
</head>
<body>
	<div class="bg">
        <?php if ($iswechat) { ?>
            <img class="wechatApp" alt="notice" src="/images/ShareDown/notice.png">
        <?php } ?>
        <input type="hidden" id="iospath" value="<?= $iospath?>">
        <input type="hidden" id="andpath" value="<?= $andpath?>">
		<!-- 第一层 -->
		<div class="title-box">
			<h1 >
				<p>瓜子TV</p>
				<p>追剧神器</p>
			</h1>
			<div class="search-box">
				<input type="text" placeholder="www.guazitv.tv">
				<button class="search-button"></button>
			</div>
			<div class="one-bk-box">
				<img src="/images/ShareDown/one-bk.png" >
			</div>
			<a href="" class="download">
				<button class="download-button">
					<i class="el-icon-download download-button-icon"></i>
					下载手机瓜子TV
				</button>
			</a>
		</div>
		
		<!-- 第二层 -->
		<div class="box-style" style="margin-top: 0;">
			<div class="box-content">
				<h4 class="box-content-title">片源超级全</h4>
				<div class="paragraph-box">
					<p>无论是国内最火的电视剧、综艺</p>
					<p>还是日剧、韩剧、英剧、美剧、各种电影、</p>
					<p>纪录片、动漫等等</p>
				</div>
				<div class="two-bk-box">
					<img src="/images/ShareDown/two-bk.png" >
				</div>
				<div class="box-style-footer">瓜子TV<span><a href="">（WWW.GUAZITV.TV）</a></span>都应有尽有</div>
			</div>
		</div>
		<!-- 第三层 -->
		<div class="box-style">
			<div class="box-content">
				<h4 class="box-content-title">更新特别快</h4>
				<div class="paragraph-box">
					<p>在瓜子TV<span><a href="">（WWW.GUAZITV.TV）</a></span></p>
					<p>基本上所有热门都综艺和电视剧和国内的</p>
					<p>更新速度都是同步的</p>
				</div>
				<div class="three-bk-box">
					<img src="/images/ShareDown/three-bk.png" >
					<span>演员请就位第二季</span>
					<span>隐秘而伟大</span>
					<span>我和我的家乡</span>
				</div>
			</div>
		</div>
		<!-- 第四层 -->
		<div class="box-style">
			<div class="box-content">
				<h4 class="box-content-title">没有广告</h4>
				<div class="paragraph-box">
					<p>瓜子TV<span><a href="">（WWW.GUAZITV.TV）</a></span></p>
					<p>没有任何广告，想看啥，点进去直接看</p>
					<p>就是这么简单粗暴省时省事</p>
				</div>
				<div class="four-bk-box">
					<img src="/images/ShareDown/four-bk.png" >
				</div>
			</div>
		</div>
		<!-- 第五层 -->
		<div class="box-style" style="margin-bottom: 1rem;">
			<div class="box-content" style="padding-bottom: 2rem;">
				<h4 class="box-content-title">各种直播随心看</h4>
				<div class="paragraph-box">
					<p>无论是湖南卫视、江苏卫视、CCTV</p>
					<p>还是各种体育赛事，都可以随时</p>
					<p>在瓜子TV看直播</p>
					<p>让你享受不一样都直播体验</p>
				</div>
				<div class="five-bk-box">
					<img src="/images/ShareDown/five-bk.png" >
					<span>CCTV</span>
					<span>湖南卫视</span>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
