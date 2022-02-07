<?php
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('FCPATH', str_replace("\\", "/", str_replace(SELF, '', __FILE__)));
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);

require_once  './request.php';

$origin = isset($_SERVER['HTTP_ORIGIN']) ?$_SERVER['HTTP_ORIGIN']: $_SERVER['HTTP_REFERER'];
// $allow_origin = array('http://360api.guazitv8.com','http://wap-video-test.aizaihehuan.com','http://360api.guazitv8.com');
// if (in_array($origin, $allow_origin)) {
//     header("Access-Control-Allow-Origin:" . $origin);
// }
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods:OPTIONS, GET, POST'); // 允许option，get，post请求
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: x-requested-with,content-type");
//header("Access-Control-Allow-Origin: *");
header("Cache-Control: no-cache, no-store, max-age=0, must-revalidate");
header("Connection: keep-alive");
header("Transfer-Encoding: chunked");

$url = $_GET["v"];
$preg = "/^http(s)?:\\/\\/.+/";
$type = "";

if (preg_match($preg, $url)) {
	if (strstr($url, ".m3u8") == true || strstr($url, ".mp4") == true || strstr($url, ".flv") == true) {
		$type = $url;
		$metareferer = "origin";
	}
    
}

if (strstr($url, "qq.com") == true) {
	$fh = get_url("http://guazitv.tv/jx/?url=" . $url);
	$jx = json_decode($fh, true);
	$type = $jx["url"];
	$metareferer = $jx["metareferer"];
	if ($metareferer == "") {
		$metareferer = "never";
	}
}


if (strstr($url, "iqiyi.com") == true) {
	$fh = get_url("https://cache2.jhdyw.vip:8090/jhqiyi.php?url=" . $url);
	$jx = json_decode($fh, true);
	$type = $jx["url"];
	$metareferer = $jx["metareferer"];
	if ($metareferer == "") {
		$metareferer = "never";
	}
}

if (strstr($url, "http") === false) {
	$fh = get_url("http://guazitv.tv/app.php?url=" . $url);
	$jx = json_decode($fh, true);
	$type = $jx["url"];
	$metareferer = $jx["metareferer"];
	if ($metareferer == "") {
		$metareferer = "never";
	}
}


if ($type == "") {
    $fh = get_url("http://guazitv.tv/jx/?url=" . $url);
	$jx = json_decode($fh, true);
	$type = $jx["url"];
	$metareferer = $jx["metareferer"];
	if ($metareferer == "") {
		$metareferer = "never";
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>播放器</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="referrer" content="<?php echo $metareferer;?>">
    <meta name="x5-fullscreen" content="true" />
    <meta name="x5-page-mode" content="app"  /> <!-- X 全屏处理 -->
    <meta name="full-screen" content="yes" />
    <meta name="browsermode" content="application" />  <!-- UC 全屏应用模式 -->
    <meta name="apple-mobile-web-app-capable" content="yes "/> 
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> <!--  苹果全屏应用模式 --> 
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/DPlayer.min.css">
    <style>
        body, html{
            height: 100%;
            width: 100%;
            padding: 0px;
            margin: 0px;
            overflow-x: hidden;
            overflow-y: hidden;
        }
        
        .Dplayer_box
        {
            height: 100% !important;
        }
        
        .player_av{
            height: 100% !important;
        }
        
        .dplayer{
            height: 100% !important;
        }
    </style>
</head>
<body>
<div class="Dplayer_box">
    <div class="player_av">
        <div class="box" id="player1"></div>
    </div>
<!--<div>-->
<!--    <input type="button" onclick="send()">-->
<!--</div>-->
</div>
<script src="js/jquery.js"></script>
<script src="js/hls.min.js"></script>
<script src="js/DPlayer.min.js"></script>
<script>
    console.log(" %c 该项目基于Dplayer.js",'color:red')
    var dp = new DPlayer({
        element: document.getElementById('player1'),
        theme: '#FADFA3',
        loop: true,
        lang: 'zh-cn',
        hotkey: true,
        preload: 'auto',
        volume: 0.7,
        autoplay: false,
        // live: true,
        playbackSpeed:[0.5, 0.75, 1, 1.25, 1.5, 2,2.5,3,5,7.5,10],
        video: {
            // url: 'index2.mp4',
            url: "<?php echo $type?>",
            pic: 'load.gif'
        },
        // quality: [
        //     {
        //         name: 'HD',
        //         url: 'index.mp4',
        //         type: 'normal',
        //     },
        //     {
        //         name: 'SD',
        //         url: 'index.mp4',
        //         type: 'normal',
        //     },
        // ],
        // defaultQuality: 0,
        pic: 'load.gif',
        thumbnails: 'load.gif',
    });


    // function send(){
    //     dp.danmaku.draw({
    //         text: 'DIYgod is amazing',
    //         color: '#fff',
    //         type: 'top',
    //     });
    // }
    
    $("#player1").click(function(){
        dp.play();
    });
    $("#player1").trigger('click');
</script>
</body>
</html>