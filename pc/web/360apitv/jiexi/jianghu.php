
<?php
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('FCPATH', str_replace("\\", "/", str_replace(SELF, '', __FILE__)));
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
include "tj.php";
require_once FCPATH . './admin/user.php';
require_once FCPATH . './admin/data.php';
require_once FCPATH . './func/func.php';
define('REFERER_URL',  $user['fd']); 

$origin = isset($_SERVER['HTTP_ORIGIN']) ?$_SERVER['HTTP_ORIGIN']: $_SERVER['HTTP_REFERER'];
$allow_origin = array('http://www.360apitv.com','http://wap-video-test.aizaihehuan.com','http://360apitv.com');
if (in_array($origin, $allow_origin)) {
    header("Access-Control-Allow-Origin:" . $origin);
}
header("Access-Control-Allow-Origin: http://360apitv.com");
header('Access-Control-Allow-Methods:OPTIONS, GET, POST'); // 允许option，get，post请求
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: x-requested-with,content-type");
//header("Access-Control-Allow-Origin: *");
header("Cache-Control: no-cache, no-store, max-age=0, must-revalidate");
header("Connection: keep-alive");
header("Transfer-Encoding: chunked");

define('ERROR', '<html><meta name="robots" content="noarchive"><head><title>'.$user['title'].'</title></head><style>h1{color:#C7636C; text-align:center; font-family: Microsoft Jhenghei;}p{font-size: 1.2rem;text-align:center;font-family: Microsoft Jhenghei;}</style><body><table width="100%" height="100%" align="center"><td align="center"><h1>本站已开启API接口防盗</h1><p>'.$user['fdhost'].'</p></table></body></html>');
if(!empty(REFERER_URL))
{
    @$referer = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : base64_decode($_POST['referer']);
    $refererhost = parse_url($referer, PHP_URL_HOST);
    if(!in_array(strtolower($refererhost),explode("|", strtolower(REFERER_URL))))
    {
        header('HTTP/1.1 403 Forbidden');
        exit(ERROR);
    }
}   
$uid = $user['uid'];
$token = $user['token'];
$color = $yzm['color'];
$tj=$user['tongji'];
$right_wenzi=$user['wenzi'];
$right_link=$user['link'];
$p2p  = $user['p2p'];
$color= $yzm['color'];
$api2=$user['api'];//
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


if ($type == "") {
    $fh = get_url("http://guazitv.tv/jx/?url=" . $url);
	$jx = json_decode($fh, true);
	$type = $jx["url"];
	$metareferer = $jx["metareferer"];
	if ($metareferer == "") {
		$metareferer = "never";
	}
}

/**
if ($type == "") 
{
     
    try {
        $dsn = 'mysql:host=127.0.0.1;port=3306;dbname=cms123';
        $username = 'cms123';
        $password = 'cms123';
        $driver_options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8',);
        $pdo = new PDO($dsn,$username,$password,$driver_options);
        $pdo->beginTransaction();
        
        $urlTile = "";
        $urlSql = "SELECT vod_name as Title FROM mac_vod where vod_play_url like '%".$url."%'";
        $stmt = $pdo->prepare($urlSql);
        $stmt->execute();
        $result_title_info = $stmt->fetchAll(PDO::FETCH_BOTH);
        if(count($result_title_info) > 0){
            $urlTile = $result_title_info[0]['Title'];
        }

        $sql = "INSERT INTO mac_fail_log (Url, Title)
            VALUES (:Url, :Title)";
        $query = $pdo->prepare($sql);
        $query->bindValue(':Url', $url);
        $query->bindValue(':Title', $urlTile);
        $query->execute();
        $pdo->commit();
    }
    catch(PDOException $e)
    {
        exit($e->getMessage());
    }
     
    $conn = null;
	exit('<html><meta name="robots" content="noarchive">
				<style>h1{color:#FFFFFF; text-align:center; font-family: Microsoft Jhenghei;}p{color:#CCCCCC; font-size: 1.2rem;text-align:center;font-family: Microsoft Jhenghei;}</style>
				<body bgcolor="#000000"><table width="100%" height="100%" align="center"><td align="center"><h1>'.$user['jxsb'].'</font><font size="2"></font></p></table></body></html>');
}
*/

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta charset="UTF-8">
<meta name="referrer" content="<?php echo $metareferer;?>">
<meta name="x5-fullscreen" content="true" /><meta name="x5-page-mode" content="app"  /> <!-- X 全屏处理 -->
<meta name="full-screen" content="yes" /><meta name="browsermode" content="application" />  <!-- UC 全屏应用模式 -->
<meta name="apple-mobile-web-app-capable" content="yes "/> <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> <!--  苹果全屏应用模式 -->   
<link rel="stylesheet" href="jianghu/assets/css/yzmplayer.css?v=13">
<style>
    .yzmplayer-setting-speeds:hover .title, .yzmplayer .yzmplayer-controller .yzmplayer-icons.yzmplayer-comment-box .yzm-yzmplayer-send-icon {
    	background-color: <?php echo $color;?> !important;
    }
    .showdan-setting .yzmplayer-toggle input+label, .yzmplayer-volume-bar-inner, .yzmplayer-thumb, .yzmplayer-played, .yzmplayer-comment-setting-box .yzmplayer-setting-danmaku .yzmplayer-danmaku-bar-wrap .yzmplayer-danmaku-bar .yzmplayer-danmaku-bar-inner, .yzmplayer-controller .yzmplayer-icons .yzmplayer-toggle input+label, .yzmplayer-controller .yzmplayer-icons.yzmplayer-comment-box .yzmplayer-comment-setting-box .yzmplayer-comment-setting-type input:checked+span  {
        background: <?php echo $color;?> !important;
    }
</style>
<script src="jianghu/js/jhplayer.js"></script>
<script src="jianghu/assets/js/jquery.min.js"></script>
<script src="jianghu/js/setting.js?v=14"></script>
<?php 
if ($p2p == "1") {
	?>
	<script type="text/javascript" src="jianghu/assets/js/hls.p2p.js"></script>
	<?php 
} else {
	?>
	<script type="text/javascript" src="jianghu/assets/js/hls.min.js"></script>
	<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/Zrahh/JsDelivr_CDN/assets/js/hls.min.js"></script> -->
<?php 
}
?>

<script src="jianghu/assets/js/layer.js"></script>

</head>
<body>
<div id="player"></div>
<div id="ADplayer"></div>
<div id="ADtip"></div>

</body></html>
<script type="text/javascript" src="<?php echo $tj;?>"></script>
<script>

    var up = {
        "usernum": "<?php echo $users_online;?>", //在线人数
        "mylink": "", //播放器路径，用于下一集
        "diyid": [0, "游客", 1] //自定义弹幕id
    }
    
    var config = {
        "api": "/dmku/", //弹幕接口
        "av": "<?php echo $_GET["av"];?>", //B站弹幕id 45520296
        "url": "<?php echo $type;?>", //视频链接
    	"id":"<?php echo substr(md5($_GET["v"]), -20);?>",//视频id
    	"sid":"<?php echo $_GET["sid"];?>",//集数id
    	"pic":"<?php echo $_GET["pic"];?>",//视频封面
    	"title":"",//视频标题
    	// "next": "",//下一集链接
    	"user": "",//用户名
    	"group": "",//用户组
    }
    YZM.start();
    
    var _clearTimer = window.setInterval(function(){
        
        var _rightWenzi = "<?php echo $right_wenzi;?>";
        var _rightLink  = "<?php echo $right_link;?>";
        var _menuItemDom= $(".yzmplayer-menu .yzmplayer-menu-item").eq(1);
        
        if(_menuItemDom.html().length > 0){
        
            window.clearInterval(_clearTimer);
            
            _menuItemDom.find("a").attr("href",_rightLink);
            _menuItemDom.find("a").html(_rightWenzi);
            
        }
        
    },1000);
    
</script>