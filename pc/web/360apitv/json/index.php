
<?php
//江湖智能解析 www.jhdyw.vip   qq群1083938724
include('user.php');
$api1 =  "http://360apitv.com/txjson.php?url=$url";//江湖主线稳定直解
$api2 = "https://vip.jhys.top/analysis/json/?uid=$uid&my=$my&url=$url";//江湖 备用 被攻击 解析不掉线
$api3 = "";//这里可以写你自己的 备用接口
$url = $_GET['v'];
$jiexi = $api1.$url;

$html = httpget($jiexi);

$json = json_decode($html, true);
if($json['code']!=200){
    $jiexi = $api2.$url;
    $html = httpget($jiexi);
    $json = json_decode($html, true);
}

if($json['code']!=200){
    $jiexi = $api3.$url;
    $html = httpget($jiexi);
    $json = json_decode($html, true);
}

if(stripos($json['url'],"JSYPARSE") === 0)
{
    $json['url'] = base64_decode(substr($json['url'],8));
}
die(json_encode($json));

function httpget($url, $timeout = 30)
{
    $ch = curl_init();                                                      //初始化 curl
    curl_setopt($ch, CURLOPT_URL, $url);                                    //要访问网页 URL 地址
    curl_setopt($ch, CURLOPT_NOBODY, false);                                //设定是否输出页面内容
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                         //返回字符串，而非直接输出到屏幕上
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, false);                        //连接超时时间，设置为 0，则无限等待
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);                            //数据传输的最大允许时间超时,设为一小时
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);                       //HTTP验证方法
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                        //不检查 SSL 证书来源
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);                        //不检查 证书中 SSL 加密算法是否存在
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);                         //跟踪爬取重定向页面
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);                            //当Location:重定向时，自动设置header中的Referer:信息
    curl_setopt($ch, CURLOPT_ENCODING, '');                                 //解决网页乱码问题
    curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    
    $httpheaders = array();
    $httpheaders[] = "CLIENT-IP: {$_SERVER['HTTP_CLIENT_IP']}";
    $httpheaders[] = "X-FORWARDED-FOR: {$_SERVER['HTTP_X_FORWARDED_FOR']}";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheaders);
    
    $data = curl_exec($ch);                                                 //运行 curl，请求网页并返回结果
    curl_close($ch);                                                        //关闭 curl
    return $data;
}