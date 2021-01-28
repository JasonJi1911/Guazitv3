<?php
use yii\helpers\Url;
use pc\assets\StyleSpring;

$this->title = '瓜子TV-澳新华人在线视频分享网站';
StyleSpring::register($this);

$js = <<<JS
$(function(){
    $("a").click(function(){
		$("#video").css("display", "none");
		$("#cover").css("display", "block");
		
		var tag = $(this).attr("href");
		var url = $(this).data("url");
		$("#myIframe").attr('src', url);
		$("#myIframe").load(function() {
			$("#cover").css("display", "none");
			$("#video").fadeIn();
		});
		
		return false;
	});
	
	$("#defaultLink").trigger("click");
});
JS;

$this->registerJs($js);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <style>
        .nn{
            display: none;
        }

        .dn{
            display: block;
        }
    </style>
</head>
<body>
<div class="loading-email">
    <div class="gallery-star">
        <div class="nav-top">
            <ul class="flex-L">
                <li><a href="#dcctv4" data-url="http://360apitv.com/jiexi/jianghu.php?v=http://ivi.bupt.edu.cn/hls/cctv4.m3u8">CCTV4</a></li>
                <li><a id="defaultLink" href="#dcctva" data-url="http://360apitv.com/jiexi/jianghu.php?v=http://stream4.jlntv.cn/cctv1/sd/live.m3u8">CCTV1</a></li>
                <li><a href="#dcctvb" data-url="https://www.youtube.com/embed/XxJKnDLYZz4">民视NEW</a></li>
                <li><a href="#dcctvc" data-url="https://www.youtube.com/embed/63RmMXCd_bQ">EBC东森</a></li>
                <li><a href="#dcctvd" data-url="https://www.youtube.com/embed/9pWXAEZ5NLs">中天NEW</a></li>
                <li><a href="#dcctve" data-url="https://www.youtube.com/embed/wSKE3A40SIk">新唐人LIVE</a></li>
            </ul>
        </div>
        <div class="images-text clearfix">
            <div class="forum-fl fl" id="cover" style="display: block">
                <img id="defaultCover" src="/images/NewVideo/sprinCover.jpg">
            </div>
            <div class="forum-fl fl" id="video" style="display: none">
                <iframe id="myIframe" width="100%" height="515" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div class="text-sd fl">
                <h2>春晚节目单 </h2>
                <ul>
                    <li><span>20:00</span><span>节目开始</span></li>
                    <li><span>20:00</span><span>节目开始</span></li>
                    <li><span>20:00</span><span>节目开始</span></li>
                    <li><span>20:00</span><span>节目开始</span></li>
                    <li><span>20:00</span><span>节目开始</span></li>
                    <li><span>20:00</span><span>节目开始</span></li>
                    <li><span>20:00</span><span>节目开始</span></li>
                    <li><span>20:00</span><span>节目开始</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>
