<?php
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('FCPATH', Yii::$app->BasePath);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
require_once FCPATH . '/web/DPlayer/v-h/request.php';

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

    if (strstr($url, "http") == false) {
        $fh = get_url("http://guazitv.tv/app.php?url=" . $url);
        $jx = json_decode($fh, true);
        $type = $jx["url"];
        $metareferer = $jx["metareferer"];
        if ($metareferer == "") {
            $metareferer = "never";
        }
    }

    if (strstr($url, "alizy") == true) {
        $fh = get_url("https://jx.cqzyw.net:8655/analysis/index/?uid=130&token=cmryAGHKLOPQUYZ026&url=" . $url);
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

    return $type;
}

$type =initialUrl($url);

?>

<!--<link rel="stylesheet" href="/DPlayer/v-h/css/base.css">-->
<link rel="stylesheet" href="/DPlayer/v-h/css/DPlayer.min.css">
<script src="/DPlayer/v-h/js/DPlayer.min.js" type="text/javascript" charset="utf-8"></script>
<style>
    .box {
        height: 500px;
    }

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

    .ADtip{
        height: 100%;
        width: 100%;
    }

    .Dplayer_box, .player_av, .box{
        height: 100%;
    }

    video {
        object-fit: fill;
    }
</style>

<div class="Dplayer_box">
    <div class="player_av">
        <div class="box" id="player1">
        </div>
    </div>
</div>

<div>
    <input type="button" onclick="send()">
</div>
<script src="/DPlayer/v-h/js/jquery.js" type="text/javascript" charset="utf-8"></script>
<script src="/DPlayer/v-h/js/hls.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

    function initialPlayer(e) {
        dp = new DPlayer({
            element: document.getElementById('player1'),
            theme: '#FF5722',
            loop: false,
            lang: 'zh-cn',
            hotkey: true,
            preload: 'auto',
            volume: 0.7,
            autoplay: false,
            playbackSpeed: [0.5, 0.75, 1, 1.25, 1.5, 2, 2.5, 3, 5, 7.5, 10],
            video: e,
        });

        $('.dplayer-icons-left').trigger('click');
        // dp.play();
    }

</script>
<script>
    console.log(" %c 该项目基于Dplayer.js", 'color:red')
    var dp = new DPlayer({
        element: document.getElementById('player1'),
        theme: '#FF5722',
        loop: false,
        lang: 'zh-cn',
        hotkey: true,
        preload: 'auto',
        logo: '/MyPlayer/img/logo.png',
        volume: 0.7,
        autoplay: false,
        playbackSpeed: [0.5, 0.75, 1, 1.25, 1.5, 2, 2.5, 3, 5, 7.5, 10],
        video: {
            url: '',
            pic: ''
        },
        bbslist: [
            {
                "link": "<?php echo $ad_link;?>",
                "pic": "<?php echo($ad_type == 'img' ? $ad_url : '');?>",
                "video": "<?php echo $ad_type == 'mp4' ? $ad_url : '';?>"
            },
        ],
    });

    <?php if($ad_type == 'img') :?>
    var bb1 = dp.options.bbslist[0];
    var l = bb1.link;
    console.log("image: "+bb1.pic);
    dp.switchVideo(
        {
            url: '',
            pic: bb1.pic,
        }
    );

    $("#player1").append('<div id="time_div" style="top: 10px;text-align: center;line-height: 40px;width: 200px;' +
        'background: rgb(51, 51, 51);position: absolute;right: 10px;opacity: 0.8;z-index: 999;border-radius: 30px;">' +
        '<div style="font-size:13px;line-height:28px;"><a class="ad_url_link" href="'+ l +'" target="_blank" style="' +
        'color:#fff;">广告剩余：<span id="time_ad" style="color:#FF556E">10</span></a></div></div>' +
        '<a href="'+ l +'" target="_blank" class="ad_url_link btn-add-detail" id="link" style="top: 50px;right:10px;' +
        'background-color: rgb(255, 85, 110);position: absolute;color: white;width: 100px;height: auto;text-align: center;' +
        'padding: 8px;border-radius: 20px;">查看详情 ></a><div class="ADMask" id="ADMask"></div>');

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
                $('#ADtip').remove();
                $('#link').remove();
                $('#ADMask').remove();
                dp.destroy();
                var ini_video = {
                    // quality: [
                    //     <?php
                    //     $default_qua = 0;
                    //     foreach ($videos as $k => $val){
                    //         if($val['chapter_id'] == $play_chapter_id){
                    //             $chapter = $val;
                    //             $src_array = $val['resource_url'];
                    //         }
                    //     }
                    //     foreach ($source as $key => $src) {
                    //         $src_id = $src['source_id'];
                    //         $src_url = $src_array[$src_id];
                    //         $type = initialUrl($src_url);
                    //         echo "{
                    //                     name: '".$src['name']."',
                    //                     url: '".$type."',
                    //                     type: 'auto',
                    //                 },";
                    //     }
                    //     ?>
                    // ],
                    url: '<?php echo $type;?>',
                    pic: '',
                    type: 'auto',
                    // defaultQuality: <?php echo $default_qua;?>,
                };
                initialPlayer(ini_video);
            }
        }, 1000);
    }, 1);
    <?php elseif ($ad_type == 'mp4') :?>
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

    $("#player1").append('<div id="time_div" style="top: 10px;text-align: center;line-height: 40px;width: 200px;' +
        'background: rgb(51, 51, 51);position: absolute;right: 10px;opacity: 0.8;z-index: 999;border-radius: 30px;">' +
        '<div style="font-size:13px;line-height:28px;"><a class="ad_url_link" href="'+ l +'" target="_blank" style="' +
        'color:#fff;">广告剩余：<span id="time_ad" style="color:#FF556E">10</span></a></div></div>' +
        '<a href="'+ l +'" target="_blank" class="ad_url_link btn-add-detail" id="link" style="top: 50px;right:10px;' +
        'background-color: rgb(255, 85, 110);position: absolute;color: white;width: 100px;height: auto;text-align: center;' +
        'padding: 8px;border-radius: 20px;">查看详情 ></a><div class="ADMask" id="ADMask"></div>');

    $("#ADMask").on('click', function() {
        document.getElementById('link').click();
        $('#link').trigger('click');
    });

    dp.on('loadedmetadata', function () {
        document.getElementById('time_ad').innerText = Math.floor(dp.video.duration);
    });
    dp.on('timeupdate', function () {
        document.getElementById('time_ad').innerText = Math.floor(dp.video.duration - dp.video.currentTime);
    });
    // dp.play();
    $('.dplayer-video-wrap').trigger('click');
    dp.on('ended', function () {
        console.log('bbs player ended');
        $('#time_div').remove();
        $('#link').remove();
        $('#ADMask').hide();
        $('#ADMask').append('<span id="time_ad" style="color:#FF556E">10</span>')
        dp.destroy();
    });
    dp.on('destroy', function () {
        var ini_video = {
            // quality: [
            //     <?php
            //     $default_qua = 0;
            //     foreach ($videos as $k => $val){
            //         if($val['chapter_id'] == $play_chapter_id){
            //             $chapter = $val;
            //             $src_array = $val['resource_url'];
            //         }
            //     }
            //     foreach ($source as $key => $src) {
            //         $src_id = $src['source_id'];
            //         $src_url = $src_array[$src_id];
            //         $type = initialUrl($src_url);
            //         echo "{
            //                     name: '".$src['name']."',
            //                     url: '".$type."',
            //                     type: 'auto',
            //                 },";
            //     }
            //     ?>
            // ],
            url: '<?php echo $type;?>',
            pic: '',
            type: 'auto',
            // defaultQuality: <?php echo $default_qua;?>,
        };
        initialPlayer(ini_video);
    });
    <?php elseif (empty($ad_type)) :?>
    var ini_video = {
        // quality: [
        //     <?php
        //     $default_qua = 0;
        //     foreach ($videos as $k => $val){
        //         if($val['chapter_id'] == $play_chapter_id){
        //             $chapter = $val;
        //             $src_array = $val['resource_url'];
        //         }
        //     }
        //     foreach ($source as $key => $src) {
        //         $src_id = $src['source_id'];
        //         $src_url = $src_array[$src_id];
        //         $type = initialUrl($src_url);
        //         echo "{
        //                     name: '".$src['name']."',
        //                     url: '".$type."',
        //                     type: 'auto',
        //                 },";
        //     }
        //     ?>
        // ],
        url: '<?php echo $type;?>',
        pic: '',
        type: 'auto',
        // defaultQuality: <?php echo $default_qua;?>,
    };
    initialPlayer(ini_video);
    <?php endif;?>

    function send() {
        dp.danmaku.draw({
            text: 'DIYgod is amazing',
            color: '#fff',
            type: 'top',
        });
    }
</script>