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
<script src="/DPlayer/v-h/js/DPlayer.min.js?v=1" type="text/javascript" charset="utf-8"></script>
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
        object-fit: contain;
    }
    #load1-img{
        position:absolute;
        width:100%;
        height: 3.8rem;
        box-sizing: border-box;
        z-index: 99
    }
</style>

<img id="load1-img" src="/images/video/Dplayer_before.gif" />
<div class="Dplayer_box">
    <div class="player_av">
        <div class="box" id="player1">
        </div>
    </div>
</div>

<div>
    <input type="button" onclick="send()">
</div>
<script src="/DPlayer/v-h/js/jquery.js?v=1" type="text/javascript" charset="utf-8"></script>
<script src="/DPlayer/v-h/js/hls.min.js?v=1" type="text/javascript" charset="utf-8"></script>
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
            autoplay: true,
            playbackSpeed: [0.5, 0.75, 1, 1.25, 1.5, 2, 2.5, 3, 5, 7.5, 10],
            video: e,
        });

        $('.dplayer-icons-left').trigger('click');
        // dp.play();
    }

</script>
<script>
    console.log(" %c 该项目基于Dplayer.js", 'color:red');
    let dp;
    $(document).ready(function () {
        var req = new XMLHttpRequest();
        req.open('GET', document.location, false);
        req.send(null);
        var cf_ray = req.getResponseHeader('cf-Ray');//指定cf-Ray的值
        var citycode = '';
        if(cf_ray && cf_ray.length>3){
            citycode = cf_ray.substring(cf_ray.length-3);
        }
        citycode = 'SYD';
        // console.log(citycode);
        $.ajax( {
            url:'/video/advert-info',
            data:{
                'citycode' : citycode,
                'page' : 'detail',
                'chapterId' : '<?=$play_chapter_id?>'
            },
            type:'get',
            cache:false,
            dataType:'json',
            success:function(res) {
                if(res.errno == 0){
                    var advert = {};
                    advert['ad_type'] = '';
                    advert['ad_url'] = '';
                    advert['ad_link'] = '';
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
                    advertinfo(advert);
                }else{
                    defaultAdvertInfo();
                }
            },
            error : function() {
                defaultAdvertInfo();
            }
        });
    });
    function defaultAdvertInfo(){
        var advert = {};
        advert['ad_type'] = '';
        advert['ad_url'] = '';
        advert['ad_link'] = '';
        advertinfo(advert);
    }
    function advertinfo(advert){
        dp = new DPlayer({
            element: document.getElementById('player1'),
            theme: '#FF556E',
            loop: false,
            lang: 'zh-cn',
            hotkey: true,
            preload: 'auto',
            logo: '',
            volume: 0.7,
            autoplay: false,
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

        if(advert['ad_type']=='img'){
            $('#load1-img').remove();
            var bb1 = dp.options.bbslist[0];
            var l = bb1.link;
            console.log("image: "+bb1.pic);
            dp.switchVideo(
                {
                    url: '',
                    pic: bb1.pic,
                }
            );
            $("#player1").append('<div id="link" style="height: 100%" class="add-box">' +
                '<a href="'+ l +'" target="_blank" class="btn-add-detail ad_url_link">' +
                '点击查看广告详情<i class="ad-arrow-wrapper ad-arrow"></i></a>' +
                '<a href="'+ l +'" target="_blank" class="ad_url_link">' +
                '<div id="time_div" href="'+ l +'" target="_blank" class="video-play-left-cover ad_url_link">' +
                '<img src="" onerror="this.src=\'/images/video/load.gif\'" id="video-cover" class="video-play-btn-iframe"' +
                'style="width: 100%; height: 100%;"></div></a>' +
                '<a class="btn-add-play" href="javascript:void(0);" id="hide-add">' +
                '<span id="time_ad" style="color:#FF556E;margin-right: 10px;">10</span>' +
                '秒后开始播放</a></div>' +
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
                        $('#ADtip').remove();
                        $('#link').remove();
                        $('#ADMask').remove();
                        dp.destroy();
                        var ini_video = {
                            url: '<?php echo $type;?>',
                            pic: '',
                            type: 'auto',
                        };
                        initialPlayer(ini_video);
                    }
                }, 1000);
            }, 1);
        }else if(advert['ad_type']=='mp4'){
            $('#load1-img').remove();
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

            $("#player1").append('<div id="link" style="height: 100%" class="add-box">' +
                '<a href="'+ l +'" target="_blank" class="btn-add-detail ad_url_link">' +
                '点击查看广告详情<i class="ad-arrow-wrapper ad-arrow"></i></a>' +
                '<a href="'+ l +'" target="_blank" class="ad_url_link">' +
                '<div id="time_div" href="'+ l +'" target="_blank" class="video-play-left-cover ad_url_link">' +
                '<img src="" onerror="this.src=\'/images/video/load.gif\'" id="video-cover" class="video-play-btn-iframe"' +
                'style="width: 100%; height: 100%;"></div></a>' +
                '<a class="btn-add-play" href="javascript:void(0);" id="hide-add">' +
                '<span id="time_ad" style="color:#FF556E;margin-right: 10px;">10</span>' +
                '秒后开始播放</a></div>' +
                '<div class="ADMask" id="ADMask"></div>');

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
                    url: '<?php echo $type;?>',
                    pic: '',
                    type: 'auto',
                };
                initialPlayer(ini_video);
            });
        }else if(advert['ad_type']==''){
            $('#load1-img').remove();
            var ini_video = {
                url: '<?php echo $type;?>',
                pic: '',
                type: 'auto',
            };
            initialPlayer(ini_video);
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