<?php

define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('FCPATH', str_replace("\\", "/", str_replace(SELF, '', __FILE__)));
error_reporting(E_ALL ^ E_NOTICE);
require_once FCPATH . './admin/user.php';
$origin = isset($_SERVER['HTTP_ORIGIN']) ?$_SERVER['HTTP_ORIGIN']: $_SERVER['HTTP_REFERER'];
$allow_origin = array('http://www.360apitv.com','http://wap-video-test.aizaihehuan.com','http://360apitv.com');

if (in_array($origin, $allow_origin)) {
    header("Access-Control-Allow-Origin:" . $origin);
}

define('REFERER_URL',  $user['fd']); 
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: x-requested-with,content-type");
header("Access-Control-Allow-Methods: GET, POST");
//header("Access-Control-Allow-Origin: *");
header("Cache-Control: no-cache, no-store, max-age=0, must-revalidate");
header("Connection: keep-alive");
header("Transfer-Encoding: chunked");
$loading_pic=$user['jhpic'];
@$url = htmlspecialchars($_GET['url'] ? $_GET['url'] : $_GET['vid']);
if(!isset($_GET['url'])){

    exit('<html><meta name="robots" content="noarchive"><head><title>'.$user['title'].'</title></head><style>h1{color:#00A0E8; text-align:center; font-family: Microsoft Jhenghei;}p{color:#f90; font-size: 1.2rem;text-align:center;font-family: Microsoft Jhenghei;}</style><body bgcolor="#000000"><table width="100%" height="100%" align="center"><td align="center"><h1>欢迎使用本站解析系统</h1><p>如有任何问题请联系管理员处理，本站第一时间为您解决后顾之忧</p></table></body></html>');
} else if (isset($_GET['url']) && $_GET['url'] == '') {
    exit('<html><meta name="robots" content="noarchive"><head><title>'.$user['title'].'</title></head><style>h1{color:#00A0E8; text-align:center; font-family: Microsoft Jhenghei;}p{color:#f90; font-size: 1.2rem;text-align:center;font-family: Microsoft Jhenghei;}</style><body bgcolor="#000000"><table width="100%" height="100%" align="center"><td align="center"><h1>请输入视频链接地址</h1><p>欢迎使用本站解析服务，如有任何问题请联系管理员</p></table></body></html>');
}
if(strstr($url,'miguvideo.com')==true){
    preg_match('|cid=(\d+?)|U',$url,$cid);
    $url=$cid['1'].'@miguvideo';
}
elseif (strstr($url, 'm.v.qq.com')==true){
    parse_str(str_replace('?', '&', $_SERVER['QUERY_STRING']),$list);
    if ($list['vid'] && $list['cid']){
    $url='https://v.qq.com/x/cover/'.$list['cid'].'/'.$list['vid'].'.html';
    }elseif ($list['vid']){
    $url='https://v.qq.com/x/cover/'.$list['vid'].'/'.$list['vid'].'.html';
    }elseif ($list['cid']){
    $url='https://v.qq.com/x/cover/'.$list['cid'].'.html';
    }
}
elseif (strstr($url, 'm.fun.tv')==true){
    parse_str(str_replace('?', '&', $_SERVER['QUERY_STRING']),$list);
    if ($list['mid'] && $list['vid']){
    $url='https://www.fun.tv/vplay/g-'.$list['mid'].'.v-'.$list['vid'];
    }elseif($list['mid']){
    $url='https://www.fun.tv/vplay/g-'.$list['mid'].'/';
    }elseif($list['vid']){
    $url='https://www.fun.tv/vplay/v-'.$list['vid'].'/';
    }
}

?>
<?php

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

?>



<!DOCTYPE html><html><head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta charset="UTF-8">
    <title><?php echo $user['title'];?></title>
    <link rel="shortcut icon" href="<?php echo '/favicon.ico';?>" type="image/x-icon">
    <link rel="stylesheet" href="jianghu/assets/css/indexCss.css">
</head>
<body>
<div class="loading" id="my-loading">
    <div class="pic"></div>
</div><?php 
if ($url) {
	?>
            <iframe src="jianghu.php?v=<?php echo $url;?>" class="iframeStyle" id="myiframe" ></iframe>
            <script>
           
               window.setTimeout(function(){
                   var myLoading = document.getElementById("my-loading");
                   if(myLoading){
                        myLoading.parentNode.removeChild(myLoading);
                   }
               },10000);
            </script>
        <?php 
}
?></body></html>
