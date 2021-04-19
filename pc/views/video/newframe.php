<?php

use yii\helpers\Url;
use pc\assets\StyleInAsset;

// $this->title = '瓜子TV-澳新华人在线视频分享网站';

StyleInAsset::register($this);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style>
        .wp .browser{
            padding: 0 10px;
        }
    
        .wp .browser1:after{
            content: '|';
            position: relative;
            /*left: 10px;*/
            color: hsla(0,0%,100%,.3);
        }
    
        .wp .browser:hover{
            color: #FF556E;
            border-right: #0c203a;
        }
    </style>
    
</head>
<body>

<?php
$channelName = '';
$subTitle = '';
$searchTip = '';
if(isset($channel_id))
{
    foreach ($channels['list'] as $s_k => $s_v) {
        if($s_v['channel_id'] == $channel_id) {
            $channelName = $s_v['channel_name'];
        }
    }
}
else
{
    $channelName = '热搜';
}
$subTitle = ' · '.$channelName;
$subTitle = $pageTab == "hotplay"? " · 热播":$subTitle;
$subTitle = $pageTab == "list"? "":$subTitle;
$subTitle = $pageTab == "searchresult"? "":$subTitle;
$subTitle = $pageTab == "collaboration"? " · 商务合作":$subTitle;

if ($channel_id == '0')
    $channelName = "热搜";

if (isset($hotword))
{
    foreach ($hotword['tab'] as $key => $tab){
        if($tab['title'] == $channelName)
            $searchTip = empty($tab['list'][0]['video_name']) ? '' : $tab['list'][0]['video_name'];
    }
}

$version = Yii::$app->api->get('/search/app-version');
$tvpath = $version['tvdata'];

?>
<header class="qy-header home2020 aura2">
    <div class="header-wrap">
        <div class="header-inner">
            <div id="nav_logo" class="qy-logo">
                <a href="/video/index" class="logo-link" title="瓜子TV"><img src="/images/NewVideo/logo.png" alt="">
                    瓜子TV<?= $subTitle?></a>
            </div>
            <div class="qy-nav">
                <div class="nav-channel">
                    <?php if(!empty($channels)) :?>
                        <?php foreach ($channels['list'] as $channel) :?>
                            <?php if($channel['channel_name'] != "首页") :?>
                                <a href="<?= Url::to(['/video/channel', 'channel_id' => $channel['channel_id']])?>"
                                   class="nav-link nav-index J-nav-channel"><?= $channel['channel_name']?></a>
                            <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
            <div class="qy-search">
                <div class="search-box">
                    <input type="hidden" id="is-keyword" value="<?= $keyword?>">
                    <span class="search-box-in">
                         <input id="keywords" autocomplete="off"
                                placeholder="<?= $searchTip?>"
                                type="text" class="search-box-input" value="<?= $keyword?>"></a>
                    </span>
                    <span class="search-box-out">
                        <span id="J-search-btn" type="button"
                              class="search-box-btn">
                            <i class="qy-svgicon qy-svgicon-search"></i>
                            <em class="search-box-btnTxt">搜索</em>
                        </span>
                    </span>
                </div>
                <div id="J-search-result-wrap" class="search-result" style="">
                    <div class="search-result-con">
                        <div id="J-search-result-hot" class="search-result-hot" style="">
                            <div class="search-result-title">热门搜索</div>
                            <?php foreach ($hotword['tab'] as $key => $tab): ?>
                                <?php if($tab['title'] == $channelName) :?>
                                    <?php foreach ($tab['list'] as $key => $list): ?>
                                        <a href="<?= Url::to(['detail', 'video_id' => $list['video_id']])?>"
                                           class="search-result-item">
                                            <div class="search-result-simple">
                                                <em class="search-result-num search-result-num1"><?= $key + 1?></em>
                                                <span class="search-result-text"><?= $list['video_name']?></span>
                                            </div>
                                        </a>
                                    <?php endforeach;?>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<?php switch ($pageTab) {
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
    case "list":
        echo $this->render('list', [
            'info'      => $info,
            'hotword'       => $hotword,
            'channel_id'=> $channel_id,
            'keyword'   => $keyword,
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
    case "searchresult":
        echo $this->render('searchresult',[
            'info'          => $info,
            'keyword'       => $keyword,
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
} ?>

<footer class="qy-footer">
    <div class="wp">
        <a class="browser" href="<?= Url::to(['collaboration'])?>">商务合作</a>
        <a class="browser1" href="###"></a>
        <a class="browser" href="<?= Url::to(['map'])?>">网站地图</a>
        <a class="browser1" href="###"></a>
        <a class="browser" href="http://m.guazitv.tv">手机端</a>
        <a class="browser1" href="###"></a>
        <a class="browser" href="http://www.guazitv.tv">电脑端</a>
        <a class="browser1" href="###"></a>
        <a class="browser" href="<?= Url::to(['site/share-down'])?>">APP下载</a>
        <a class="browser1" href="###"></a>
        <!--<a class="browser" href="http://app.guazitv6.com/guazi-tv-1.0.1-debug.apk">电视TV版下载</a>-->
        <a class="browser" href="<?= !empty($tvpath["file_path"])?$tvpath["file_path"]:"###" ?>">电视TV版下载</a>
    </div>
    <div class="wp">
        <p>本网站为非赢利性站点，所有内容均由机器人采集于互联网，或者网友上传，本站只提供WEB页面服务，本站不存储、不制作任何视频，不承担任何由于内容的合法性及健康性所引起的争议和法律责任。<br />若本站收录内容侵犯了您的权益，请附说明联系邮箱，本站将第一时间处理。站长邮箱：guazitv@163.com</p>
    </div>
</footer>
<script src="/js/jquery.js"></script>
<script src="/js/VideoSearch.js"></script>
</body>
</html>