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
    /*????????????????????????*/
    .dplayer.dplayer-mobile .dplayer-controller .dplayer-icons .dplayer-full .dplayer-full-in-icon{
        display: none !important;
    }

    #player-load1-warn{
        color:#fff;
        z-index:5;
        position:absolute;
        top:5px;
        width:100%;
        text-align:center;
        font-size: 13px;
    }
    #player-load1-warn span{
        color:#FF556E
    }

    #pause-img{
        position:absolute;
        width: 60%;
        height: 60%;
        left: 20%;
        top: 20%;
        box-sizing: border-box;
        border: solid 1px #FFFFFF;
        border: none;
        z-index:6;
        display: flex;
        align-items: center;
    }

    #pause-img a{
        display: block;
        width: 100%;
        max-height: 100%;
        overflow: hidden;
        position: relative;
    }
    #pause-img img.aposition-img{
        width: 100%;
        /*height: 100%;*/
        align-items: center;
    }
    #pause-img .close-pause-div{
        position: absolute;
        color: #f4f4f4;
        font-size: 14px;
        background-color: hsla(0, 0%, 0%, 0.42);
        padding: 2px 4px;
        margin: 4px;
        border-radius: 3px;
        right: 0;
    }
</style>

<img id="load1-img" src="/images/video/Dplayer_before.gif" />

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
<script src="/DPlayer/v-h/js/jquery.js?v=1" type="text/javascript" charset="utf-8"></script>
<script src="/DPlayer/v-h/js/hls.min.js?v=1" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var dp1;
    function initialPlayer(e) {
        dp1 = new DPlayer({
            element: document.getElementById('player1'),
            theme: '#FF556E',
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

        //1?????????1080????????????720?????????2?????????720?????????1080??????????????????????????????????????????????????????????????????????????????
        var strtext = "<div id='player-load1-warn'>??????????????????????????????</div>";
        var source_count = <?=count($source)?>;
        if(source_count > 1){
            <?php if($source_id=="17" || $source_id=="19") : ?>
                strtext = "<div id='player-load1-warn'>?????????????????????<span>??????</span>?????????<span>720P</span>??????</div>";
            <?php else : ?>
                strtext = "<div id='player-load1-warn'>?????????????????????<span>??????</span>?????????<span>1080P</span>??????</div>";
            <?php endif;?>
        }
        $("#player1").prepend(strtext);
        setTimeout(function(){
            $("#player-load1-warn").hide();
        },20000);

        dp1.on('loadstart', function () {
            dp1.controller.show();
        });

        dp1.on('playing', function () {
            dp1.controller.hide();
        });

        dp1.on("pause", function(){
            dp1.controller.show();
            if(dp1.video.duration > 0){
                $("#pause-img").show();
            }
        });
        dp1.on("play", function(){
            $("#pause-img").hide();
        });

        //??????????????????
        var seconds_flag = true;//??????????????????????????????
        dp1.on('timeupdate',function(){//??????????????????
            if(seconds_flag){
                seconds_flag = false;
                //??????10?????????1???
                setTimeout( function timer() {
                    var watchTime = dp1.video.currentTime;
                    var totalTime = dp1.video.duration;
                    addwatchlog(watchTime,totalTime);//??????????????????
                    seconds_flag = true;
                }, 10000 );
            }
        });

        $("#player1").on('click', '.dplayer-video-current, .dplayer-controller-mask', function() {
            if(dp1.paused){
                dp1.play();
            }
        });
    }

</script>
<script>
    console.log(" %c ???????????????Dplayer.js", 'color:red');
    var dp;
    $(document).ready(function () {
        var req = new XMLHttpRequest();
        req.open('GET', '/images/video/icon-fh-1.png', false);
        req.send(null);
        var cf_ray = req.getResponseHeader('cf-Ray');//??????cf-Ray??????
        var cf_cache_status = req.getResponseHeader('cf-cache-status');//??????cf-cache-status??????
        var citycode = '';
        if(cf_cache_status == 'HIT'){
            citycode = cf_ray.substring(cf_ray.length-3);
        }else{
            req.open('GET', document.location, false);
            req.send(null);
            cf_ray = req.getResponseHeader('cf-Ray');//??????cf-Ray??????
            if(cf_ray && cf_ray.length>3){
                citycode = cf_ray.substring(cf_ray.length-3);
            }
        }
        // citycode = 'MEL';
        // console.log(citycode);
        var advert = {};
        advert['ad_type'] = '';
        advert['ad_url'] = '';
        advert['ad_link'] = '';
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
            timeout: 4000,
            success:function(res) {
                if(res.errno == 0){
                    //?????????
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

                    var ad = {};
                    if(res.data.advert.playstop.ad_image){
                        ad = res.data.advert.playstop;
                        var pausehtml = '<div id="pause-img" style="display:none;">'+
                            '<a href="'+ad.ad_skip_url+'" target="_blank">'+
                            '<div class="close-pause-div" onclick="closePauseAD();">??????</div>'+
                            '<img src="'+ad.ad_image+'" class="aposition-img" />'+
                            '</a></div>';
                        $("#player1").prepend(pausehtml);
                    }
                }else{
                    advertinfo(advert);
                }
            },
            error : function() {
                advertinfo(advert);
            },
            complete:function(XHR,TextStatus){
                if(TextStatus=='timeout'){ //?????????????????????
                    console.log("???????????????");
                }
            }
        });
    });
    function advertinfo(advert){

        //?????? player1
        var ini_video = {
            url: '<?php echo $type;?>',
            pic: '',
            type: 'auto',
        };
        initialPlayer(ini_video);
        dp1.pause();

        //?????? player_ad
        dp = new DPlayer({
            element: document.getElementById('player_ad'),
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
            //console.log('img??????');
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

            $("#player_ad").append('<div id="link" style="height: 100%" class="add-box">' +
                '<a href="'+ l +'" target="_blank" class="btn-add-detail ad_url_link">' +
                '????????????????????????<i class="ad-arrow-wrapper ad-arrow"></i></a>' +
                '<a href="'+ l +'" target="_blank" class="ad_url_link">' +
                '<div id="time_div" href="'+ l +'" target="_blank" class="video-play-left-cover ad_url_link">' +
                '<img src="" onerror="this.src=\'/images/video/load.gif\'" id="video-cover" class="video-play-btn-iframe"' +
                'style="width: 100%; height: 100%;"></div></a>' +
                '<a class="btn-add-play" href="javascript:void(0);" id="hide-add">' +
                '<span id="time_ad" style="color:#FF556E;margin-right: 10px;">10</span>' +
                '??????????????????</a></div>' +
                '<div class="ADMask" id="ADMask"></div>');

            $("#ADMask").click(function() {
                // document.getElementById('link').click();
                document.getElementById('link').getElementsByTagName("a").item(0).click();
            });
            dp.on("error", function() {
                $("#player_ad .dplayer-notice").hide();
                dp.controller.hide();
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
                        $("#player_ad").hide();
                        $("#player1").show();
                        IsShow(self);
                        dp1.play();
                        //var ini_video = {
                        //    url: '<?php //echo $type;?>//',
                        //    pic: '',
                        //    type: 'auto',
                        //};
                        //initialPlayer(ini_video);
                    }
                }, 1000);
            }, 1);
        }else if(advert['ad_type']=='mp4'){
            var adslists = dp.options.bbslist;
            console.log(adslists);
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
            //5??????????????????NaN???????????????????????????
            setTimeout(function(){
                if(!playflag){
                    $('#load1-img').remove();
                    $("#player_ad").hide();
                    dp.destroy();
                    $("#player1").show();
                    dp1.play();
                }
            },5000);

            $("#player_ad").append('<div id="link" style="height: 100%" class="add-box">' +
                '<a href="'+ l +'" target="_blank" class="btn-add-detail ad_url_link">' +
                '????????????????????????<i class="ad-arrow-wrapper ad-arrow"></i></a>' +
                '<a href="'+ l +'" target="_blank" class="ad_url_link">' +
                '<div id="time_div" href="'+ l +'" target="_blank" class="video-play-left-cover ad_url_link">' +
                '<img src="" onerror="this.src=\'/images/video/load.gif\'" id="video-cover" class="video-play-btn-iframe"' +
                'style="width: 100%; height: 100%;"></div></a>' +
                '<a class="btn-add-play" href="javascript:void(0);" id="hide-add">' +
                '<span id="time_ad" style="color:#FF556E;margin-right: 10px;">10</span>' +
                '??????????????????</a></div>' +
                '<div class="ADMask" id="ADMask"></div>');

            $("#ADMask").on('click', function() {
                // document.getElementById('link').click();
                document.getElementById('link').getElementsByTagName("a").item(0).click();
                $('#link').trigger('click');
            });

            dp.on('loadedmetadata', function () {
                document.getElementById('time_ad').innerText = Math.floor(dp.video.duration);
                playflag = true;
                $('#load1-img').remove();
                dp.controller.show();
                dp.play();
            });
            dp.on('timeupdate', function () {
                if(document.getElementById('time_ad'))
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
                $("#player_ad").hide();
                $("#player1").show();
                IsShow(self);
                dp1.play();
                //var ini_video = {
                //    url: '<?php //echo $type;?>//',
                //    pic: '',
                //    type: 'auto',
                //};
                //initialPlayer(ini_video);
            });
        }else if(advert['ad_type']==''){
            dp.destroy();
            $('#load1-img').remove();
            $("#player_ad").hide();
            $("#player1").show();
            IsShow(self);
            dp1.play();
            //var ini_video = {
            //    url: '<?php //echo $type;?>//',
            //    pic: '',
            //    type: 'auto',
            //};
            //initialPlayer(ini_video);
        }
    }


    //??????????????????
    $(document).ready(function () {
        //??????????????????????????????
        $(window).bind("beforeunload", function () {
            var watchTime = dp1.video.currentTime;
            var totalTime = dp1.video.duration;
            addwatchlog(watchTime,totalTime);
        });
    });
    function addwatchlog(watchTime,totalTime){
        var uid = finduser();
        if(!isNaN(uid) && uid!=""){
            var arrindex = {};
            arrindex['video_id'] = '<?=$videos[0]['video_id']?>';
            arrindex['chapter_id'] = '<?=$play_chapter_id?>';
            arrindex['watchTime'] = parseInt(watchTime);
            arrindex['totalTime'] = parseInt(totalTime);
            if(arrindex['totalTime']>0){
                // console.log(arrindex);
                $.get('/video/add-watchlog',arrindex,function(res){
                    console.log(res.data);
                });
            }
        }
    }
    function IsShow(_self){
        var int=_self.setInterval(function(){
            if($("#player1").is(":visible"))
            {
                // 2022-04-12 Jason??????
                canSwitch = true;
                $("#player1 .dplayer-play-icon").trigger("click");
                if(dp1.paused){
                    dp1.play();
                }
                clearInterval(int);
            }
        },100);
    }
    //??????????????????
    function closePauseAD(){
        $("#pause-img").hide();
        eventStop();
    }

    function eventStop(){
        var evt = evt || window.event; //??????event??????
        if (evt.preventDefault) {
            evt.preventDefault(); //???IE?????????
        } else {
            evt.returnValue = false; //????????????IE?????????
        }
        event.stopPropagation ? event.stopPropagation() : (event.cancelBubble = true); //??????????????????
        window.event.cancelBubble = true;
        return false;
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