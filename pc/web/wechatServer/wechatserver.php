<?php

define("TOKEN", "jp123456");

function checkSignature()
{
    //从get参数中获取三个字段的值
    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];

    //读取预定义的TOKEN
    $token = TOKEN;
    //对数组进行排序
    $tmpArr = array($token, $timestamp, $nonce);
    sort($tmpArr, SORT_STRING);

    //对三个字段进行sha1运算
    $tmpStr = implode($tmpArr);
    $tmpStr = sha1($tmpStr);

    // 判断我方的计算结果和微信计算结果是否一致
    // 只有微信断的signature和 我方根据token生产的结果一致，才能判断访问来自微信官方
    if ($signature = $tmpStr)
    {
        return true;
    }else
    {
        return false;
    }
}

$postStr = file_get_contents("php://input"); //获取xml数据包

// libxml_disable_entity_loader(true);
//禁止xml实体解析, 防止xml注入

$msg = simplexml_load_string($postStr, "SimpleXMLElement", LIBXML_NOCDATA);

if(strtolower($msg->MsgType) == 'event'){
    if(strtolower($msg->Event) == 'subscribe'){
        $toUser		= $msg->FromUserName;
        $fromUser	= $msg->ToUserName;
    }
}

if ($msg->MsgType == "text") {
    $scene = $msg->Content;
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6381);
    $redis->auth("guazity1987");
    $redis->setex($scene,3600,"gotted");
    file_put_contents("/www/wwwlogs/scenlog.txt",$scene,FILE_APPEND);
}


if (isset($_GET['echostr'])) {
    if (checkSignature()) {
        echo $_GET["echostr"];
    }
    else
        echo "error";
}
else{

}

?>