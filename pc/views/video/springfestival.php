<?php
use yii\helpers\Url;
use pc\assets\StyleSpring;

$this->title = '瓜子TV-澳新华人在线视频分享网站';
StyleSpring::register($this);

$cctv1src = ['http://ivi.bupt.edu.cn/hls/cctv1hd.m3u8', 'http://223.110.245.159/ott.js.chinamobile.com/PLTV/3/224/3221225852/index.m3u8', 'http://shbu.live.bestvcdn.com.cn:8080/live/program/live/cctv1hd/2300000/mnf.m3u8','http://shbu.live.bestvcdn.com.cn:8080/live/program/live/cctv1hd/4000000/mnf.m3u8', 'http://shbu.live.bestvcdn.com.cn:8080/live/program/live/cctv1/1300000/mnf.m3u8'];

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

        .tvmenu{
            overflow-y: scroll;
            height: 440px;
        }
    </style>
</head>
<body>
<div class="loading-email">
    <div class="gallery-star">
        <div class="nav-top">
            <ul class="flex-L">
                <!--安徽卫视-->
                <li><a id="defaultLink" href="#dcctvd" data-url="/360apitv/jiexi/jianghu.php?v=http://zbbf2.ahtv.cn/live/749.m3u8">春晚直播1</a></li>
                <!--河北卫视-->
                <li><a href="#dcctve" data-url="/360apitv/jiexi/jianghu.php?v=http://live2.plus.hebtv.com/hbwsx/hd/live.m3u8">春晚直播2</a></li>
                <!--cctv4-->
                <li><a href="#dcctv4" data-url="/360apitv/jiexi/jianghu.php?v=http://shbu.live.bestvcdn.com.cn:8080/live/program/live/cctv4/1300000/mnf.m3u8">春晚直播3</a></li>
                <!--cctv1-->
                <li><a href="#dcctva" data-url="/360apitv/jiexi/jianghu.php?v=http://shbu.live.bestvcdn.com.cn:8080/live/program/live/cctv1/1300000/mnf.m3u8">春晚直播4</a></li>
                <!--湖南卫视-->
                <li><a href="#dcctvb" data-url="/360apitv/jiexi/jianghu.php?v=http://shbu.live.bestvcdn.com.cn:8080/live/program/live/hnwshd/2300000/mnf.m3u8">春晚直播5</a></li>
                <!--浙江卫视-->
                <li><a href="#dcctvc" data-url="/360apitv/jiexi/jianghu.php?v=http://hw-m-l.cztv.com/channels/lantian/channel01/1080p.m3u8">春晚直播6</a></li>
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
                <ul class="tvmenu">
                    <li><span>开场贺岁歌曲《年》</span></li>
                    <li><span>歌曲联唱《回娘家》《牡丹之歌》《滚滚长江东逝水》</span></li>
                    <li><span>武术《国魂》</span></li>
                    <li><span>儿歌《听我说》</span></li>
                    <li><span>歌曲《百年》</span></li>
                    <li><span>歌曲《亲戚》</span></li>
                    <li><span>小品《观后感》</span></li>
                    <li><span>歌曲《我在长寿之乡等你》</span></li>
                    <li><span>抖音红包互动</span></li>
                    <li><span>歌舞+走秀《新百家姓》</span></li>
                    <li><span>歌曲《此心安处是吾乡》</span></li>
                    <li><span>歌曲《mojito》</span></li>
                    <li><span>歌曲《寻根黄姚》</span></li>
                    <li><span>歌舞《霓裳羽衣曲》</span></li>
                    <li><span>小品《租女友回家过年》</span></li>
                    <li><span>小品《吉祥如意》</span></li>
                    <li><span>歌舞《唐人恋曲》</span></li>
                    <li><span>相声《歌声飘过三十年》</span></li>
                    <li><span>歌曲《邯郸记》 </span></li>
                    <li><span>小品《对牛弹琴》</span></li>
                    <li><span>张国立讲述归国文物</span></li>
                    <li><span>杂技《麒麟送子》</span></li>
                    <li><span>歌舞《张》</span></li>
                    <li><span>小品《阳台》</span></li>
                    <li><span>歌曲《李清照》</span></li>
                    <li><span>魔术小品《牛转乾坤》</span></li>
                    <li><span>歌曲《内蒙》</span></li>
                    <li><span>歌曲《飞天逐梦》</span></li>
                    <li><span>戏曲《天下梨园》</span></li>
                    <li><span>歌曲《背影》</span></li>
                    <li><span>歌曲《妈妈的味道》</span></li>
                    <li><span>歌曲《武汉加油，世界加油》</span></li>
                    <li><span>歌曲《中国欢迎你》</span></li>
                    <li><span>歌曲《难忘今宵》</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>
