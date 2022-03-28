<?php
use yii\helpers\Url;
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('FCPATH', Yii::$app->BasePath);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
require_once FCPATH . '/web/MyPlayer/func.php';

function initialUrl($url)
{
    $url = urldecode($url);
    $preg = "/^http(s)?:\\/\\/.+/";
    $type = "";
    if (preg_match($preg, $url)) {
        if (strstr($url, ".m3u8") == true || strstr($url, ".mp4") == true || strstr($url, ".flv") == true) {
            $type = $url;
            $metareferer = "never";//	$metareferer = "origin";
        }

    }

    if (strstr($url, "qq.com") == true && strstr($url, "shcdn-qq") == false) {
        $fh = get_url("https://cache4.jhdyw.vip:8091/jhcs.php?url=" . $url);
        $jx = json_decode($fh, true);
        $type = $jx["url"];
        $metareferer = $jx["metareferer"];
        if ($metareferer == "") {
            $metareferer = "never";
        }
    }


    if (strstr($url, "iqiyi.com") == true) {
        $fh = get_url("https://cache4.jhdyw.vip:8091/jhcs.php?url=" . $url);
        $jx = json_decode($fh, true);
        $type = $jx["url"];
        $metareferer = $jx["metareferer"];
        if ($metareferer == "") {
            $metareferer = "never";
        }
    }


    if ($type == "") {
        $fh = get_url("https://cache4.jhdyw.vip:8091/jhcs.php?url=" . $url);
        $jx = json_decode($fh, true);
        $type = $jx["url"];
        $metareferer = $jx["metareferer"];
        if ($metareferer == "") {
            $metareferer = "never";
        }
    }

    return $type;
}

//initialUrl($url);

?>

<link rel="stylesheet" href="/MyPlayer/css/base.css">
<link rel="stylesheet" href="/MyPlayer/css/DPlayer.min.css?v=2">
<script src="/MyPlayer/js/DPlayer.min-1.7.js?v=6" type="text/javascript" charset="utf-8"></script>
<style>
    .selected_quantity{
        color: #FF556E;
    }

    .box {
        height: 500px;
    }
    /*-------快进快退------*/

    .icon-forward,
    .icon-rewind {
        padding: 7px;
        display: inline-block;
        position: relative;
        width: 41px;
        text-align: center;
        opacity: 0.8;
        cursor: pointer;
    }

    .icon-forward:hover,
    .icon-rewind:hover {
        opacity: 1;
    }

    .icon-forward>svg {
        margin-bottom: -17px;
    }

    .icon-rewind {
        transform: rotate(180deg);
        margin-right: 0px;
    }

    .icon-rewind>svg {
        margin-top: -15px;
    }

    .Fast-alt {
        display: none;
        position: absolute;
        left: 50%;
        margin-left: -40px;
        width: 80px;
        height: 30px;
        line-height: 30px;
        text-align: center;
        font-size: 12px;
        color: #FFFFFF;
        border-radius: 3px;
        background-color: rgba(17, 17, 17, 0.9);
    }

    .icon-forward>.Fast-alt {
        top: -30px;
    }

    .icon-forward:hover>.Fast-alt {
        display: block;
    }

    .icon-rewind>.Fast-alt {
        bottom: -30px;
        transform: rotate(180deg);
    }

    .icon-rewind:hover>.Fast-alt {
        display: block;
    }
    /*------广告倒计时   查看详情-------*/

    .ADMask{
        height: 70% !important;
        display: inline-block;
        width: 100%;
        height: 85%;
        color: #fff;
        overflow: hidden;
        position: absolute;
        z-index: 2;
        top: 0px;
        left: 0px;
        cursor: pointer;;
    }

    .AD-box {
        position: absolute;
        top: 30px;
        right: 20px;
        height: 30px;
        border-radius: 30px;
        overflow: hidden;
        background-color: rgba(51, 51, 51, 1);
        opacity: 0.5;
        z-index: 1;
        cursor: pointer;
    }

    .AD-box:hover {
        opacity: 1;
    }

    .AD-box>a {
        display: block;
        height: 30px;
        line-height: 30px;
        padding: 0px 20px;
        font-size: 14px;
        color: #FFFFFF;
    }

    .AD-box>a>span {
        display: inline-block;
        min-width: 16px;
        color: #FF556E;
        text-align: center;
    }

    .ADxq-box {
        position: absolute;
        bottom: 100px;
        right: 20px;
        height: 30px;
        border-radius: 30px;
        overflow: hidden;
        background-color: #FF556E;
        opacity: 0.6;
    }

    .ADxq-box:hover {
        opacity: 1;
    }

    .ADxq-box>a {
        display: block;
        height: 30px;
        line-height: 30px;
        padding: 0px 20px;
        font-size: 14px;
        color: #FFFFFF;
    }

    .ADxq-box>a:hover {
        color: rgba(255, 255, 255, 1);
    }

    .ADxq-box>a>svg {
        margin-left: 5px;
        width: 20px;
        margin-bottom: -11px;
        overflow: hidden;
    }

    .ADxq-box>a>svg>path {
        width: 30px;
        overflow: hidden;
    }
    /*-----声音------*/

    .dplayer .dplayer-controller .dplayer-icons .dplayer-icon {
        width: 45px;
        margin-right: 0px;
    }
    .dplayer .dplayer-controller .dplayer-icons .dplayer-icon {
        width: 45px;
    }

    .dplayer .dplayer-controller .dplayer-icons .dplayer-icon.dplayer-volume-icon {
        width: 45px;
    }
    /*选集样式*/
    .palyer-js {
        position: relative;
        top: 3px;
        display: inline-block;
        margin: 0 5px;/*20px*/
        width: auto;/*50px*/
        height: 100%;
        font-size: 16px;
        text-align: center;
        color: rgba(255, 255, 255, 0.8);
        cursor: pointer;
    }

    .palyer-js:hover {
        /*color: rgba(255, 255, 255, 1);*/
        color: #FF556E;
    }

    .player-next-chapter:hover {/*无效上一集样式*/
        color: rgba(255, 255, 255, 0.8);
    }

    .palyer-js-alt {
        position: absolute;
        bottom: 0;
        right: -800px;
        margin-left: -100px;
        width: 470px;
        height: 100%;
        padding: 0px 30px 20px 40px;
        box-sizing: border-box;
        overflow-y: auto;
        background-color: rgba(28, 28, 28, 0.9);
        z-index: 3;
    }

    .palyer-js-alt-right {
        position: absolute;
        right: -40px;
        top: 50%;
        margin-top: -40px;
        width: 20px;
        height: 80px;
        background-color: rgba(0, 0, 0, 0.5);
        background-image: url(/MyPlayer/img/right-W.png);
        background-position: center;
        background-repeat: no-repeat;
        background-size: 14px auto;
        z-index: 4;
    }

    .palyer-js-alt.act {
        animation-name: DH03;
        animation-duration: 0.5s;
        animation-fill-mode: forwards;
    }

    .palyer-js-alt-right.act {
        animation-name: DH04;
        animation-duration: 0.5s;
        animation-fill-mode: forwards;
    }

    @keyframes DH03 {
        0% {
            right: -800px;
        }
        100% {
            right: -20px;
        }
    }

    @keyframes DH04 {
        0% {
            right: -370px;
        }
        100% {
            right: 430px;
        }
    }

    .palyer-js-alt-right:hover {
        background-color: rgba(0, 0, 0, 0.7);
        background-image: url(/MyPlayer/img/right-O.png);
    }

    .player-tab {
        position: relative;
        margin-top: 20px;
        padding: 10px;
        height: 40px;
        line-height: 40px;
        font-size: 16px;
        color: rgba(255, 255, 255, 0.8);
        background-color: rgba(0, 0, 0, 0.5);
        overflow: hidden;
    }

    .player-tab.player-all {
        height: auto;
    }

    .player-tab>div.player-tab-a {
        float: left;
        margin-right: 10px;
        margin-left: 10px;
        text-aliplayer-: center;
        cursor: pointer;
    }

    .player-tab>div.player-tab-a:hover {
        color: #FF556E;
    }

    .player-tab>div.act {
        color: #FF556E;
    }

    .player-tab-all,
    .player-tab-sq {
        margin-left: 10px;
        float: right;
        padding-right: 20px;
        height: 40px;
        line-height: 40px;
        color: #999999;
        background-position: right center;
        background-repeat: no-repeat;
        background-size: 16px;
        overflow: hidden;
        cursor: pointer;
    }

    .player-tab-all {
        background-image: url(/MyPlayer/img/icon-down.png);
    }

    .player-tab-all:hover {
        color: #FF556E;
        background-image: url(/MyPlayer/img/icon-down-o.png);
    }

    .player-tab-sq {
        display: none;
        background-image: url(/MyPlayer/img/up.png);
    }

    .player-tab-sq:hover {
        color: #FF556E;
        background-image: url(/MyPlayer/img/up-o.png);
    }

    .player-box-TJ-K {
        display: none;
        min-height: 150px;
        margin-top: 20px;
    }

    .player-box-JS {
        display: none;
        margin-top: 20px;
        flex-wrap: wrap;
        -webkit-box-pack: justify;
    }

    .player-box-JS.act {
        display: -webkit-flex;
        display: flex;
    }

    .player-box-JS>a {
        display: block;
        box-sizing: border-box;
        padding: 0px 20px;
        min-width: calc((100% - 50px)/5);
        height: 50px;
        line-height: 50px;
        text-align: center;
        font-size: 16px;
        text-aliplayer-: center;
        color: rgba(255, 255, 255, 0.8);
        background-color: rgba(0, 0, 0, 0.5);
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .player-box-JS>a:hover {
        color: #FF556E;
    }

    .player-box-JS>a.act {
        color: #FFFFFF;
        background-color: #FF556E;
    }

    .QXD-vip {
        background-color: #2a2a32;
        /*background-color: #1c1d2f;*/
        padding-bottom: 10px;
        margin-bottom: 5px;
    }

    .QXD-vip-01 {
        height: 40px;
        line-height: 40px;
        font-size: 14px;
        color: #FF556E;
        text-align: center;
    }

    .QXD-vip-02 {
        text-align: center;
        height: 30px;
        line-height: 30px;
    }

    .QXD-vip-02>a {
        display: inline-block;
        padding: 0px 10px;
        margin: 0px 5px;
        color: #FF556E;
        font-size: 12px;
        box-sizing: border-box;
    }

    .QXD-vip-02-a1 {
        background: linear-gradient(#fdeec7, #ffc1a2);
        border: solid 1px #1c1d2f;
    }

    .QXD-vip-02-a2 {
        border: solid 1px #FF556E;
    }

    .QXD-vip-02-a2:hover {
        background-color: #FF556E;
        color: #FFFFFF;
    }

    .dplayer-quality-item.QXDvip {
        background-image: url(/MyPlayer/img/QXDvip.png);
        background-repeat: no-repeat;
        background-position: 20px center;
    }
    /*--------倍速----------*/

    .BSbox input {
        font-family: "微软雅黑";
        appearance: none;
        border: none;
        border-radius: 0;
        background-color: rgba(0, 0, 0, 0);
        -webkit-border-radius: 0;
        -webkit-border: none;
        outline: none;
    }

    .BSbox {
        position: relative;
        display: inline-block;
        cursor: pointer;
        height: 100%;
    }

    .BSbth {
        display: inline-block;
        padding: 8px;
        font-size: 16px;
        margin-right: 5px;
        color: #fff;
        opacity: 0.8;
        line-height: 22px;
        vertical-align: middle;
        font-weight: 500;
    }

    .BSbth:hover,
    .BSbth.act {
        opacity: 1;
        color: #FF556E;
    }

    .BSlist {
        display: none;
        position: absolute;
        left: 50%;
        margin-left: -35px;
        bottom: 38px;
        width: 70px;
        padding: 10px 0px;
        border-radius: 3px;
        background-color: rgba(28, 28, 28, 0.9);
        z-index: 3;
    }

    .BSlist.act {
        display: block;
    }

    .BSlist>input {
        display: block;
        width: 100%;
        height: 40px;
        font-size: 14px;
        color: #EEEEEE;
        cursor: pointer;
    }

    .BSlist>input:hover {
        background-color: rgba(51, 51, 51, 1);
        color: #FF556E;
    }

    .Dplayer_box, .player_av, .box{
        height: 100%;
    }
    #load1-img {
        position:absolute;
        width: 1189px;
        height: 775px;
        box-sizing: border-box;
        border: solid 1px #FFFFFF;
        border: none;
        z-index:6;
        background-color: #000;
        display: flex;
        align-items: center;
    }
    #load1-img img{
        width: 100%;
        height: auto;
        align-items: center;
    }

    @media screen and (max-width:1910px) {
        #load1-img {
            width: 1025px;
            height: 640px;
        }
    }

    @media screen and (max-width:1525px) {
        #load1-img {
            width: 857px;
            height: 500px;
        }
    }
    #player-load1-warn{
        color:#fff;
        z-index:5;
        position:absolute;
        top:20px;
        width:100%;
        text-align:center;
    }
    #player-load1-warn span{
        color:#FF556E
    }
    #last-play-time{
        color: #fff;
        font-size: 14px;
        border-radius: 2px;
        padding: 7px 20px;
        background: rgba(28, 28, 28, .9);
        opacity: 0.8;
        position: absolute;
        z-index: 5;
        bottom: 90px;
        left: 20px;
    }
    #last-play-time span{
        display: inline-block;
        color:  #FF556E ;
        cursor: pointer;
        text-decoration: none;
    }

    .icon-forward:hover svg path,.icon-rewind:hover svg path {
        fill: #FF556E;
    }

    /*.dplayer .dplayer-controller {*/
    /*    line-height: 90px;*/
    /*}*/

    .dplayer .dplayer-controller .dplayer-icons .dplayer-icon.dplayer-volume-icon:hover svg path {
        fill: #FF556E;
    }

    .dplayer .dplayer-controller .dplayer-icons .dplayer-icon.dplayer-setting-icon:hover svg path {
        fill: #FF556E;
    }

    .dplayer .dplayer-controller .dplayer-icons .dplayer-icon.dplayer-full-icon:hover svg path {
        fill: #FF556E;
    }

    .dplayer .dplayer-controller .dplayer-icons .dplayer-full .dplayer-full-in-icon:hover svg path {
        fill: #FF556E;
    }
    .dplayer .dplayer-controller .dplayer-icons .dplayer-icon.dplayer-quality-icon{
        font-size: 16px;
    }

    .dplayer .dplayer-controller .dplayer-icons .dplayer-icon.dplayer-quality-icon:hover,
    .dplayer .dplayer-controller .dplayer-icons .dplayer-icon.dplayer-quality-icon.act{
        opacity: 1;
        color: #FF556E;
    }

    .selected_quantity{
        color: #FF556E;
    }

    .dplayer .dplayer-controller .dplayer-icons {
        height: 90px;
    }
    .dplayer .dplayer-controller .dplayer-icons .dplayer-volume .dplayer-volume-bar-wrap .dplayer-volume-bar{
        top: 43px;
    }
    /*@media only screen and (min-device-width : 768px) and (max-device-width : 1024px){*/
    /*    .dplayer-mobile-play{*/
    /*        left: 5% !important;*/
    /*        top: 75% !important;*/
    /*    }*/
    /*}*/
    .dplayer-fulled-icon{
        display: none !important;
    }

    .dplayer-fullfilled .dplayer-unfull-icon{
        display: none !important;
    }

    .dplayer-fullfilled .dplayer-fulled-icon{
        display: inline-block !important;
    }

    .dplayer-full-in-icon{
        display: none !important;
    }
</style>
<div id="load1-img">
    <img src="/images/video/load.gif" />
</div>
<div class="Dplayer_box">
    <div class="player_av">
        <div class="box" id="player_ad">
        </div>
        <div class="box" id="player1" style="display: none;">
        </div>
    </div>
</div>

<div>
    <input type="button" onclick="send()">
</div>
<script src="/MyPlayer/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
<script src="/MyPlayer/js/hls.min.js?v=2" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    // console.log(<?= json_encode($videos)?>);
    var selected_id = <?=$play_chapter_id?>;
    var player_last_chapter = '';//无上一集样式
    var last_chapter = parseInt('<?=$last_chapter?>');
    if(last_chapter == 0){
        player_last_chapter = 'player-next-chapter';
    }
    var player_next_chapter = '';//无下一集样式
    var next_chapter = parseInt('<?=$next_chapter?>');
    if(next_chapter == 0){
        player_next_chapter = 'player-next-chapter';
    }
    var txt1 = "<div class='palyer-js' data-index='choose' style='margin:0 5px 0 15px;'>选集</div><div class='palyer-js "+player_last_chapter+"' data-index='last'>上一集</div><div class='palyer-js "+player_next_chapter+"' data-index='next'>下一集</div>";
    var txt2 = "<div class='palyer-js-alt' style='z-index:100;'></div>";
    var txt3 = "<?php
        if(count($videos) > 200){
            echo "<div class='player-tab'><div class='player-tab-all'>全部</div><div class='player-tab-sq'>收起</div>";
        }
        else {
            echo "<div class='player-tab'>";
        }
        $page = ceil(count($videos)/50);
        $count = count($videos);
        $ontab = 0;
        foreach ($videos as $index => $value){
            if ($play_chapter_id != $value['chapter_id'])
                continue;

            $ontab = ceil(($index+1) / 50);
            break;
        }
        for($k=0; $k<$page; $k++){
            $tabAct = $k+1 == $ontab? 'act': '';
            echo "<div class='player-tab-a ".$tabAct."'>".($k*50 + 1)."-".(($k == ($page -1))? $count:$k*50 + 50)."</div>";
        }
        echo "</div>";
        ?>";
    var txt4 = "<div class='player-tab-Box'></div>";
    var txt5 = "<?php
        for($i=0; $i<$page; $i++){
            $epiTabAct = (($i+1) == $ontab)? 'act': '';
            echo "<div class='player-box-JS ".$epiTabAct."'>";
            foreach ($videos as $index => $value){
                if($index>=$i*50 && $index < ($i*50+50)){
                    // $epiAct = "22";
                    $epiAct = ($play_chapter_id == $value['chapter_id']) ? "act" : "22";
                    $resource_arr = $value['resource_url'];
                    // $tmp_src = array_column($source, null, 'source_id');
                    $quality = [];
                    foreach ($source as $key => $src) {
                        if (empty(trim($resource_arr[$src['source_id']]))) { // source_id不在视频里面或者没有视频播放连接
                            continue;
                        }
                        $src_id = $src['source_id'];
                        $src_url = $resource_arr[$src_id];
                        $quality[] = $src['name'].'#'.$src_url;
                    }
                    // foreach ($resource_arr as $k => $v)
                    //     $quality[] = $tmp_src[$k]['name'].'#'.$v;

                    $quality_str = implode('$$$', $quality);
                    echo "<a class='{$epiAct}' data-test='{$epiAct}' href='".Url::to(['video/detail', 'video_id'=>$value['video_id'], 'chapter_id'=>$value['chapter_id']])."'>".$value['title']."</a>";
                }
            }
            echo "</div>";
        }
        ?>";
    var txt6 = "<div class='palyer-js-alt-right' style='z-index:100;'></div>";
    var QXDvip = "<div class='QXD-vip'><div class='QXD-vip-01'>去广告.享高清</div><div class='QXD-vip-02'><a class='QXD-vip-02-a1' href='#'>开通VIP</a><a class='QXD-vip-02-a2' href='#'>金币开通</a></div></div>";

    //  快进快退
    // var FastF = "<div class='icon-forward'><div class='Fast-alt'>快进5秒</div><svg t='1628216546598' viewBox='0 0 1024 1024' version='1.1' xmlns='http://www.w3.org/2000/svg'><path d='M924.8 334.7c-22.5-53.1-54.6-100.8-95.6-141.8-40.9-40.9-88.6-73.1-141.8-95.6C632.4 74 574 62.2 513.8 62.2s-118.5 12-173.5 35.2C287.2 119.9 239.5 152 198.5 193c-40.9 40.9-73.1 88.6-95.6 141.8-23.3 55-35.1 113.4-35.1 173.6S79.7 627 103 682c22.5 53.1 54.6 100.8 95.6 141.8 40.9 40.9 88.6 73.1 141.8 95.6 55 23.3 113.4 35.1 173.6 35.1s118.6-11.8 173.6-35.1c53.1-22.5 100.8-54.6 141.8-95.6 40.9-40.9 73.1-88.6 95.6-141.8 23.3-55 35.1-113.4 35.1-173.6s-12-118.7-35.3-173.7zM770.9 765.3C702.2 834 611 871.8 513.9 871.8s-188.3-37.8-257-106.4c-68.6-68.6-106.4-159.9-106.4-257s37.8-188.3 106.4-257c68.6-68.6 159.9-106.4 257-106.4s188.3 37.8 257 106.4c68.6 68.6 106.4 159.9 106.4 257s-37.8 188.3-106.4 256.9z'></path><path d='M692.5 491.5l-77.7-50.9-77.7-50.9c-14.6-9.6-32.9 2.4-32.9 21.6v57.1l-42.5-27.8-77.7-50.9c-14.6-9.6-32.9 2.4-32.9 21.6l0.1 101.9 0.1 101.9c0 19.2 18.3 31.2 32.9 21.6l77.6-51 42.4-27.9v57.3c0 19.2 18.3 31.2 32.9 21.6l77.6-51 77.6-51c14.9-9.6 14.9-33.6 0.2-43.2z'></path></svg></div>";
    // var FastR = "<div class='icon-rewind'><div class='Fast-alt'>快退5秒</div><svg t='1628216546598' viewBox='0 0 1024 1024' version='1.1' xmlns='http://www.w3.org/2000/svg'><path d='M924.8 334.7c-22.5-53.1-54.6-100.8-95.6-141.8-40.9-40.9-88.6-73.1-141.8-95.6C632.4 74 574 62.2 513.8 62.2s-118.5 12-173.5 35.2C287.2 119.9 239.5 152 198.5 193c-40.9 40.9-73.1 88.6-95.6 141.8-23.3 55-35.1 113.4-35.1 173.6S79.7 627 103 682c22.5 53.1 54.6 100.8 95.6 141.8 40.9 40.9 88.6 73.1 141.8 95.6 55 23.3 113.4 35.1 173.6 35.1s118.6-11.8 173.6-35.1c53.1-22.5 100.8-54.6 141.8-95.6 40.9-40.9 73.1-88.6 95.6-141.8 23.3-55 35.1-113.4 35.1-173.6s-12-118.7-35.3-173.7zM770.9 765.3C702.2 834 611 871.8 513.9 871.8s-188.3-37.8-257-106.4c-68.6-68.6-106.4-159.9-106.4-257s37.8-188.3 106.4-257c68.6-68.6 159.9-106.4 257-106.4s188.3 37.8 257 106.4c68.6 68.6 106.4 159.9 106.4 257s-37.8 188.3-106.4 256.9z'></path><path d='M692.5 491.5l-77.7-50.9-77.7-50.9c-14.6-9.6-32.9 2.4-32.9 21.6v57.1l-42.5-27.8-77.7-50.9c-14.6-9.6-32.9 2.4-32.9 21.6l0.1 101.9 0.1 101.9c0 19.2 18.3 31.2 32.9 21.6l77.6-51 42.4-27.9v57.3c0 19.2 18.3 31.2 32.9 21.6l77.6-51 77.6-51c14.9-9.6 14.9-33.6 0.2-43.2z'></path></svg></div>";

    //  倍速
    var BSbox = "<div class='BSbox'><div class='BSbth'>倍速</div><div class='BSlist'><input type='button' value='0.5' /><input type='button' value='0.75' /><input type='button' value='正常' /><input type='button' value='1.25' /><input type='button' value='1.5' /></div></div>";
    let dp1;
    //空格键切换播放暂停状态
    $(document).keyup(function(e){
        switch(e.keyCode) {
            case 32:
                e.preventDefault();
                // dp.toggle();
                dp1.toggle();
                break;
        }
    });

    //点击隐藏倍速框
    $(document).click(function(e) {
        var $target = $(e.target);
        // 点击下拉菜单以外的地方切换样式
        if(!$target.is('.BSbox *') && !$target.is('.BSbox')) {
            $('#player1 .BSbth').removeClass("act");
            $('#player1 .BSlist').removeClass("act");
        }
    });

    function initialPlayer(e) {
        dp1 = new DPlayer({
            element: document.getElementById('player1'),
            theme: '#FF556E',
            loop: false,
            lang: 'zh-cn',
            hotkey: true,
            preload: 'auto',
            // logo: '/MyPlayer/img/logo.png',
            volume: 0.7,
            autoplay: false,
            playbackSpeed: [0.5, 0.75, 1, 1.25, 1.5, 2, 2.5, 3, 5, 7.5, 10],
            video: e,
        });

        dp1.on('fullscreen', function () {
            $('#player1').addClass('dplayer-fullfilled');
        });

        dp1.on('fullscreen_cancel', function () {
            $('#player1').removeClass('dplayer-fullfilled');
        });

        $('#player1 .dplayer-fulled-icon').click(function(){
            dp1.fullScreen.cancel();
        });

        $("#player1 .dplayer-icons-left").append(txt1);
        $("#player1").append(txt2, txt6);
        $("#player1 .palyer-js-alt").append(txt3, txt4);
        $("#player1 .player-tab-Box").append(txt5);
        // $("#player1 .dplayer-icon.dplayer-play-icon").after(FastR ,FastF);
        $("#player1 .dplayer-quality").before(BSbox);
        $("#player1 .dplayer-quality-icon").text('播放路线');

        //清晰度列表内生成VIP广告
        // $("#player1 .dplayer-quality-list").prepend(QXDvip);

        //清晰度带vip标识    紧紧演示  可删除
        // $("#player1 .dplayer-quality-item").addClass("QXDvip");
        $("#player1 .dplayer-quality-item").each(function(){
            var index = $(this).attr("data-index");
            var limit = $(this).attr("data-limit");
            if(limit==1){
                $(this).addClass("QXDvip");
            }
        });
        // $("#player1 .player-box-JS>a").each(function(){
        //     $(this).removeClass("act");
        //     var tm1_id = $(this).attr('attr-id');
        //     if(selected_id == tm1_id)
        //     {
        //         $(this).addClass("act");
        //     }
        // });

        $("#player1 .dplayer-quality-item").each(function(){
            var data_index = $(this).attr('data-index');
            if(data_index == "0")
                $(this).addClass("selected_quantity");
        });
        //清晰度带vip标识    紧紧演示  可删除
        dp1.on('quality_start', function (e) {
            $("#player1 .dplayer-quality-item").removeClass('selected_quantity');
            $("#player1 .dplayer-quality-item").each(function(){
                var qua_name = $(this).text();
                if(qua_name == e.name)
                    $(this).addClass("selected_quantity");
            });
        });
        $("#player1 .dplayer-quality-item").click(function(){
            var index = $(this).attr("data-index");
            var limit = $(this).attr("data-limit");
            sourceLimit(index,limit);
        });
        sourceLimit(0,e.defaultPlayLimit);//先验证再播放，替代 dp1.play();
        // $('.dplayer-video-wrap').trigger('click');
        // dp1.play();

        var strtext = "<div id='player-load1-warn'>如果卡顿，可以通过<span>播放路线</span>切换到其他线路</div>";
        $("#player1").prepend(strtext);
        setTimeout(function(){
            $("#player-load1-warn").hide();
        },10000);
        dp1.on('loadedmetadata', function () {
            var totaltime = parseInt(dp1.video.duration);
            if(totaltime>0){
                $("#player-load1-warn").hide();
            }
        });

        dp1.on('quality_end',function(){
            dp1.play();
        });

        //添加播放记录
        var seconds_flag = true;//执行添加播放记录标志
        dp1.on('timeupdate',function(){//视频播放事件
            if(seconds_flag){
                seconds_flag = false;
                //每隔10秒执行1次
                setTimeout( function timer() {
                    addwatchlog();//添加播放记录
                    seconds_flag = true;
                }, 10000 );
            }
        });

        //加载播放时间
        var watchflag = true;
        dp1.on('playing',function(){
            if(watchflag){
                watchflag = false;
                var arrIndex = {};
                arrIndex['video_id'] = '<?=$videos[0]['video_id']?>';
                arrIndex['chapter_id'] = '<?=$play_chapter_id?>';
                // console.log(arrIndex);
                $.ajax({
                    url:'/video/last-playinfo',
                    data:arrIndex,
                    type:'get',
                    cache:false,
                    dataType:'json',
                    success:function(res) {
                        // console.log(res)
                        if(res.errno==0){
                            var time = res.data.lastPlayTime;
                            if(time > 0){
                                // dp1.notice('您上次播放到 '+res.data.playtime+' <a style="display: inline-block;color:  #03c8d4 ;cursor: pointer;text-decoration: none;z-index:111111;">继续观看</a>', 500000);
                                var strtext = '<div id="last-play-time">您上次播放到 '+res.data.playtime+' <span onclick="keepwatch('+time+');">继续观看</span></div>';
                                $("#last-play-time").remove();
                                $("#player1").prepend(strtext);
                                $('#last-play-time').show().delay(5000).fadeOut();
                            }
                        }
                    },
                    error : function() {
                        console.log("播放记忆时间加载失败");
                    }
                });
            }
        });
    }
    //继续观看
    function keepwatch(last_play_time){
        if(last_play_time > 0){
            dp1.seek(last_play_time);
            $('#last-play-time').hide();
        }
    }
    //验证视频播放权限
    function sourceLimit(index,limit){
        if(limit==0){
            //直接切换
            dp1.switchQuality(index);
        }else{
            var uid = finduser();
            if(!isNaN(uid) && uid!=""){
                //已登录，判断vip
                $.get('/video/uservip',{},function(res){
                    if(res.errno==0 && res.data){
                        //是vip,直接切换
                        dp1.switchQuality(index);
                    }else{
                        //不是，弹框提示
                        $("#mvip-title").text("您可在播放路线那里，选择其他免费线路");
                        $("#altvip").show();
                        return false;
                    }
                });
            }else{
                //弹框登录
                showloggedin();
                return false;
            }
        }
    }

    //快进5秒
    $("#player1").on('click', '.icon-forward', function() {
        dp1.seek(dp1.video.currentTime + 5);
    });
    //后退5秒
    $("#player1").on('click', '.icon-rewind', function() {
        dp1.seek(dp1.video.currentTime - 5);
    });

    //  集数alert 显示隐藏
    $("#player1").on('click', '.palyer-js', function() {
        var index = $(this).attr('data-index');
        if(index=='choose'){
            $("#player1 .palyer-js-alt").toggleClass("act");
            $("#player1 .palyer-js-alt-right").toggleClass("act");
            event.stopPropagation();
        }else if(index=='last'){
            if(last_chapter>0){
                var videoid = '<?=$videos[0]['video_id']?>'
                window.location.href = "/video/detail?video_id="+videoid+"&chapter_id="+last_chapter;
            }
        }else if(index=='next'){
            if(next_chapter>0){
                var videoid = '<?=$videos[0]['video_id']?>'
                window.location.href = "/video/detail?video_id="+videoid+"&chapter_id="+next_chapter;
            }
        }
    });
    $("#player1").on('click', '.palyer-js-alt-right', function() {
        $("#player1 .palyer-js-alt").toggleClass("act");
        $("#player1 .palyer-js-alt-right").toggleClass("act");
        event.stopPropagation();
    });
    $("#player1").on('click', '.palyer-js-alt', function() {
        event.stopPropagation();
    });
    //  集数切换效果
    // $("#player1").on('click', '.player-box-JS>a', function() {
    //     $(this).addClass("act").siblings().removeClass("act");
    //     event.stopPropagation();
    //     selected_id = $(this).attr('attr-id');
    //     var quality = $(this).attr('attr-quality');
    //     var quality_arr = quality.split('$$$');
    //     var new_video = { quality:[], pic: '', defaultQuality: 0, };
    //     for (x in quality_arr){
    //         var tmp_qua=quality_arr[x];
    //         var tmp_arr = tmp_qua.split('#');
    //         new_video['quality'].push({
    //             'name': tmp_arr[0],
    //             'url': tmp_arr[1],
    //             'type': 'auto',
    //         });
    //     }
    //     dp1.destroy();
    //     initialPlayer(new_video);
    //     $(".GNbox-JS>a").each(function(){
    //         $(this).removeClass("act");
    //         var tm1_id = $(this).attr('attr-id');
    //         if(selected_id == tm1_id)
    //         {
    //             $(this).addClass("act");
    //         }
    //     });
    // });

    //  集数tab 全部显示

    $("#player1").on('click', '.player-tab-all', function() {
        event.stopPropagation();
        $(this).hide().parents(".player-tab").addClass("player-all");
        $("#player1 .player-tab-sq").show();
    });
    $("#player1").on('click', '.player-tab-sq', function() {
        $(this).hide().parents(".player-tab").removeClass("player-all");
        $("#player1 .player-tab-all").show();
        event.stopPropagation();
    });

    // 集数tab切换

    $("#player1").on('click', '.player-tab>.player-tab-a', function() {
        var tabNum = $(this).index() - 2;
        $(this).addClass("act").siblings(".player-tab-a").removeClass("act");
        $("#player1 .player-tab-Box>div").eq(tabNum).addClass("act").siblings().removeClass("act");
        event.stopPropagation();
    });

    // 点击弹出倍速框
    $("#player1").on('click', '.BSbth', function() {
        $(this).toggleClass("act");
        $("#player1 .BSlist").toggleClass("act");
    });

    //选择倍速以后，隐藏倍速框
    $("#player1").on('click', '.BSlist>input', function() {
        var speed = $(this).attr('value');
        if(speed == '正常')
            speed = 1;
        dp1.speed(speed);
        dp1.notice('视频速率已调整到' + speed + "倍", 2000);
        $("#player1 .BSbth").toggleClass("act");
        $("#player1 .BSlist").toggleClass("act");
    });
</script>
<script>
    $(document).ready(function () {
        var req = new XMLHttpRequest();
        req.open('GET', document.location, false);
        req.send(null);
        var cf_ray = req.getResponseHeader('cf-Ray');//指定cf-Ray的值
        var citycode = '';
        if(cf_ray && cf_ray.length>3){
            citycode = cf_ray.substring(cf_ray.length-3);
        }
        // citycode = 'MEL';
        // console.log(citycode);
        var arrIndex = {};
        arrIndex['citycode'] = citycode;
        arrIndex['page'] = 'detail';
        arrIndex['chapterId'] = '<?=$play_chapter_id?>';

        var advert = {};
        advert['ad_type'] = '';
        advert['ad_url'] = '';
        advert['ad_link'] = '';
        $.ajax({
            url:'/video/advert-info',
            data:arrIndex,
            type:'get',
            cache:false,
            dataType:'json',
            success:function(res) {
                if(res.errno == 0){
                    if(res.data.advert.playbefore.ad_image){
                        advert['ad_url'] = res.data.advert.playbefore.ad_image;
                        advert['ad_link'] = res.data.advert.playbefore.ad_skip_url;
                        if(res.data.advert.playbefore.ad_image.indexOf('.mp4')>=0){
                            advert['ad_type'] = 'mp4';
                        }else if(res.data.advert.playbefore.ad_image.indexOf('.m3u8')>=0){
                            advert['ad_type'] = 'mp4';
                        }else{
                            advert['ad_type'] = 'img';
                        }
                    }
                    defaultAdvertInfo(advert);
                    var ad = {};
                    if(res.data.advert.videotop.ad_image){
                        ad = res.data.advert.videotop;
                        $("#videotop").html('<div class="play-box video-add-column video-detail-ad"><a href="'+ad.ad_skip_url+'" target="_blank"><img src="'+ad.ad_image+'" /></a></div>')
                    }
                    if(res.data.advert.videoright.ad_image){
                        ad = res.data.advert.videoright;
                        $("#videoright").html('<div class="video-right-ad-img"><a href="'+ad.ad_skip_url+'" target="_blank"><img src="'+ad.ad_image+'"></a></div>');
                    }
                    if(res.data.advert.videobottom.ad_image){
                        ad = res.data.advert.videobottom;
                        $("#videobottom").html('<div class="play-box video-add-column video-detail-ad"><a href="'+ad.ad_skip_url+'" target="_blank" class="video-bottom-add"><img src="'+ad.ad_image+'"></a></div>');
                    }
                }else{
                    defaultAdvertInfo(advert);
                }
            },
            error : function() {
                defaultAdvertInfo(advert);
            }
        });
    });
    function defaultAdvertInfo(advert){
        var qualitystr = '';
        <?php
        $qstr = '';
        foreach ($videos as $k => $val){
            if($val['chapter_id'] == $play_chapter_id){
                $chapter = $val;
                $src_array = $val['resource_url'];
            }
        }
        foreach ($source as $key => $src) {
            if (empty($src_array[$src['source_id']])) { // source_id不在视频里面或者没有视频播放连接
                continue;
            }
            $src_url = $src['resource_url'];
            $type = initialUrl($src_url);
            $qstr .= "{name: '".$src['name']."',url: '".$type."',type: 'auto',limit: '".$src['play_limit']."'},";
        }
        ?>
        qualitystr = "["+"<?=$qstr?>"+"]";
        advertinfo(advert,qualitystr);
    }
    function advertinfo(advert,qualitystr){

        //视频 player1
        <?php $default_qua = 0;?>
        var ini_video = {
            quality: eval('(' + qualitystr + ')'),
            pic: '',
            defaultQuality: <?php echo $default_qua;?>,
            defaultPlayLimit:'<?php echo $source[$default_qua]['play_limit'];?>'
        };
        initialPlayer(ini_video);
        dp1.pause();

        //广告 player_ad
        var dp = new DPlayer({
            element: document.getElementById('player_ad'),
            theme: '#FF556E',
            loop: false,
            lang: 'zh-cn',
            hotkey: true,
            preload: 'auto',
            // logo: '/MyPlayer/img/logo.png',
            volume: 0.7,
            autoplay: true,
            playbackSpeed: [0.5, 0.75, 1, 1.25, 1.5, 2, 2.5, 3, 5, 7.5, 10],
            video: {
                url: '',
                pic: ''
            },
            bbslist: [
                {
                    "link": advert['ad_link'],
                    "pic": (advert['ad_type'] == 'img' ? advert['ad_url'] : ''),
                    "video": (advert['ad_type'] == 'mp4' ? advert['ad_url'] : '')
                },
            ],
        });

        dp.on('fullscreen', function () {
            $('#player_ad').addClass('dplayer-fullfilled');
        });

        dp.on('fullscreen_cancel', function () {
            $('#player_ad').removeClass('dplayer-fullfilled');
        });

        $('#player_ad .dplayer-fulled-icon').click(function(){
            dp.fullScreen.cancel();
        });

        if(advert['ad_type']=='img'){
            var bb1 = dp.options.bbslist[0];
            var l = bb1.link;
            console.log("image: "+bb1.pic);

            dp.switchVideo(
                {
                    url: '',
                    pic: bb1.pic,
                }
            );
            $('#load1-img').remove();

            $("#player_ad").append('<div class="AD-box" id="AD-box"><a href="' + l +'">广告剩余：<span id="time_ad">10</span>S</a></div>' +
                '<div class="ADxq-box" id="ADxq-box"><a id="link" target="_blank" href="' + l + '">查看详情<svg t="1628136750461" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M572.197 505.905a19.707 19.707 0 0 1-5.976 13.397L300.215 785.31c-3.438 3.438-8.558 5.705-13.129 5.705s-9.728-2.304-13.129-5.705l-28.562-28.562c-3.438-3.438-5.705-8.558-5.705-13.129s2.304-9.728 5.705-13.129L469.98 505.905 245.395 281.32c-3.438-3.438-5.705-8.558-5.705-13.129s2.304-9.728 5.705-13.129l28.562-28.562c3.438-3.438 8.558-5.705 13.129-5.705s9.728 2.304 13.129 5.705l266.277 266.277a19.534 19.534 0 0 1 5.714 13.465z m219.428 0a19.707 19.707 0 0 1-5.976 13.397L519.643 785.31c-3.438 3.438-8.558 5.705-13.129 5.705s-9.728-2.304-13.129-5.705l-28.562-28.562c-3.438-3.438-5.705-8.558-5.705-13.129s2.304-9.728 5.705-13.129l224.585-224.585L464.823 281.32c-3.438-3.438-5.705-8.558-5.705-13.129s2.304-9.728 5.705-13.129l28.562-28.562c3.438-3.438 8.558-5.705 13.129-5.705s9.728 2.304 13.129 5.705L785.92 492.777a19.534 19.534 0 0 1 5.714 13.465z"></path></svg></a></div>' +
                '<div class="ADMask" id="ADMask"></div>');

            $("#ADMask").click(function() {
                document.getElementById('link').click();
            });

            var span = document.getElementById("time_ad");
            var num = span.innerHTML;
            var timer = null;
            setTimeout(function() {
                timer = setInterval(function() {
                    num--;
                    span.innerHTML = num;
                    if (num == 0) {
                        clearInterval(timer);
                        $('#AD-box').remove();
                        $('#ADxq-box').remove();
                        $('#ADMask').remove();
                        dp.fullScreen.cancel();
                        dp.destroy();
                        $("#player_ad").hide();
                        $("#player1").show();
                        dp1.play();
<!--                        --><?php //$default_qua = 0;?>
//                        $('#load1-img').remove();
//                        var ini_video = {
//                            quality: eval('(' + qualitystr + ')'),
//                            pic: '',
//                            defaultQuality: <?php //echo $default_qua;?>//,
//                            defaultPlayLimit:'<?php //echo $source[$default_qua]['play_limit'];?>//'
//                        };
//                        initialPlayer(ini_video);
                    }
                }, 1000);
            }, 1);
        }else if(advert['ad_type']=='mp4'){
            var adslists = dp.options.bbslist;
            console.log(adslists)
            var bb1 = adslists[0];
            var l = bb1.link;

            dp.switchVideo(
                {
                    url: bb1.video,
                    pic: '',
                    type: 'auto'
                }
            );
            var playflag = false;
            //3秒执行，广告NaN直接删除，播放视频
            setTimeout(function(){
                if(!playflag){
                    $('#load1-img').remove();
                    $("#player_ad").hide();
                    dp.destroy();
                    $("#player1").show();
                    dp1.play();
                }
            },3000);

            $("#player_ad").append('<div class="AD-box" id="AD-box"><a href="' + l +'">广告剩余：<span id="time_ad">10</span>S</a></div>' +
                '<div class="ADxq-box" id="ADxq-box"><a id="link" target="_blank" href="' + l + '">查看详情<svg t="1628136750461" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M572.197 505.905a19.707 19.707 0 0 1-5.976 13.397L300.215 785.31c-3.438 3.438-8.558 5.705-13.129 5.705s-9.728-2.304-13.129-5.705l-28.562-28.562c-3.438-3.438-5.705-8.558-5.705-13.129s2.304-9.728 5.705-13.129L469.98 505.905 245.395 281.32c-3.438-3.438-5.705-8.558-5.705-13.129s2.304-9.728 5.705-13.129l28.562-28.562c3.438-3.438 8.558-5.705 13.129-5.705s9.728 2.304 13.129 5.705l266.277 266.277a19.534 19.534 0 0 1 5.714 13.465z m219.428 0a19.707 19.707 0 0 1-5.976 13.397L519.643 785.31c-3.438 3.438-8.558 5.705-13.129 5.705s-9.728-2.304-13.129-5.705l-28.562-28.562c-3.438-3.438-5.705-8.558-5.705-13.129s2.304-9.728 5.705-13.129l224.585-224.585L464.823 281.32c-3.438-3.438-5.705-8.558-5.705-13.129s2.304-9.728 5.705-13.129l28.562-28.562c3.438-3.438 8.558-5.705 13.129-5.705s9.728 2.304 13.129 5.705L785.92 492.777a19.534 19.534 0 0 1 5.714 13.465z"></path></svg></a></div>' +
                '<div class="ADMask" id="ADMask"></div>');

            $("#ADMask").on('click', function() {
                document.getElementById('link').click();
                $('#link').trigger('click');
            });

            dp.on('loadedmetadata', function () {
                document.getElementById('time_ad').innerText = Math.floor(dp.video.duration);
                playflag = true;
                $('#load1-img').remove();
                $('#ADMask').hide()
                dp.controller.show();
                dp.play();
            });
            dp.on('timeupdate', function () {
                document.getElementById('time_ad').innerText = Math.floor(dp.video.duration - dp.video.currentTime);
            });
            // dp.play();
            $('.dplayer-video-wrap').trigger('click');
            dp.on('ended', function () {
                console.log('bbs player ended');
                $('#AD-box').remove();
                $('#ADxq-box').remove();
                $('#ADMask').hide();
                $('#ADMask').append('<span id="time_ad" style="color:#FF556E">10</span>')
                dp.destroy();
            });
            dp.on('destroy', function () {
                dp.fullScreen.cancel();
                $("#player_ad").hide();
                $("#player1").show();
                dp1.play();
<!--                --><?php //$default_qua = 0;?>
//                $('#load1-img').remove();
//                var ini_video = {
//                    quality: eval('(' + qualitystr + ')'),
//                    pic: '',
//                    defaultQuality: <?php //echo $default_qua;?>//,
//                    defaultPlayLimit:'<?php //echo $source[$default_qua]['play_limit'];?>//'
//                };
//                initialPlayer(ini_video);
            });
        }else if(advert['ad_type']==''){
            dp.destroy();
            $('#load1-img').remove();
            $("#player_ad").hide();
            $("#player1").show();
            dp1.play();
<!--            --><?php //$default_qua = 0;?>
//            $('#load1-img').remove();
//            var ini_video = {
//                quality: eval('(' + qualitystr + ')'),
//                pic: '',
//                defaultQuality: <?php //echo $default_qua;?>//,
//                defaultPlayLimit:'<?php //echo $source[$default_qua]['play_limit'];?>//'
//            };
//            initialPlayer(ini_video);
        }
    }
</script>
<script>
    function send() {
        dp.danmaku.draw({
            text: 'DIYgod is amazing',
            color: '#fff',
            type: 'top',
        });
    }
</script>
