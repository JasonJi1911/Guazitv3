<?php
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

//initialUrl($url);

?>

<link rel="stylesheet" href="/MyPlayer/css/base.css">
<link rel="stylesheet" href="/MyPlayer/css/DPlayer.min.css?v=2">
<script src="/MyPlayer/js/DPlayer.min-1.7.js?v=5" type="text/javascript" charset="utf-8"></script>
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
<script src="/MyPlayer/js/jquery-1.11.0.js" type="text/javascript" charset="utf-8"></script>
<script src="/MyPlayer/js/hls.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    // console.log(<?= json_encode($videos)?>);
    var selected_id = <?=$play_chapter_id?>;
    var txt1 = "<div class='palyer-js'>选集</div>";
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
                    $epiAct = $play_chapter_id == $value['chapter_id'] ? 'act' : '';
                    $resource_arr = $value['resource_url'];
                    $tmp_src = array_column($source, null, 'source_id');
                    $quality = [];
                    foreach ($resource_arr as $k => $v)
                        $quality[] = $tmp_src[$k]['name'].'#'.$v;

                    $quality_str = implode('$$$', $quality);

                    echo "<a class='".$epiAct."' href='javascript:;' attr-id='".$value['chapter_id']."' attr-quality='".$quality_str."'>".$value['title']."</a>";
                }
            }
            echo "</div>";
        }
        ?>";
    var txt6 = "<div class='palyer-js-alt-right' style='z-index:100;'></div>";
    var QXDvip = "<div class='QXD-vip'><div class='QXD-vip-01'>去广告.享高清</div><div class='QXD-vip-02'><a class='QXD-vip-02-a1' href='#'>开通VIP</a><a class='QXD-vip-02-a2' href='#'>金币开通</a></div></div>";

    //  快进快退
    var FastF="<div class='icon-forward'><div class='Fast-alt'>快进5秒</div><svg t='1628040141304' viewBox='0 0 1024 1024' version='1.1' xmlns='http://www.w3.org/2000/svg'><path d='M478.146133 458.110578L154.680178 234.984533C109.549511 213.396622 56.888889 242.187378 56.888889 285.368889v453.437155c0 43.1872 52.660622 71.977956 97.791289 50.384356l323.465955-230.3168C500.715378 548.076089 512 528.283022 512 508.489956c0-19.792356-11.284622-39.584711-33.853867-50.379378zM933.257244 458.110578L609.791289 234.984533C564.660622 213.396622 512 242.187378 512 285.368889v453.436444c0 43.1872 52.660622 71.977956 97.791289 50.384356l323.465955-230.3168c45.138489-21.5936 45.138489-79.172978 0-100.762311z'></path></svg></div>";
    var FastR="<div class='icon-rewind'><div class='Fast-alt'>快退5秒</div><svg t='1628040141304' viewBox='0 0 1024 1024' version='1.1' xmlns='http://www.w3.org/2000/svg'><path d='M478.146133 458.110578L154.680178 234.984533C109.549511 213.396622 56.888889 242.187378 56.888889 285.368889v453.437155c0 43.1872 52.660622 71.977956 97.791289 50.384356l323.465955-230.3168C500.715378 548.076089 512 528.283022 512 508.489956c0-19.792356-11.284622-39.584711-33.853867-50.379378zM933.257244 458.110578L609.791289 234.984533C564.660622 213.396622 512 242.187378 512 285.368889v453.436444c0 43.1872 52.660622 71.977956 97.791289 50.384356l323.465955-230.3168c45.138489-21.5936 45.138489-79.172978 0-100.762311z'></path></svg></div>";

    let dp1;
    $(document).keyup(function(e){
        switch(e.keyCode) {
            case 32:
                e.preventDefault();
                dp1.toggle();
                break;
        }
    });
    function initialPlayer(e) {
        dp1 = new DPlayer({
            element: document.getElementById('player1'),
            theme: '#FF5722',
            loop: false,
            lang: 'zh-cn',
            hotkey: true,
            preload: 'auto',
            logo: '/MyPlayer/img/logo.png',
            volume: 0.7,
            autoplay: true,
            playbackSpeed: [0.5, 0.75, 1, 1.25, 1.5, 2, 2.5, 3, 5, 7.5, 10],
            video: e,
        });

        $("#player1 .dplayer-icons-left").append(txt1);
        $("#player1 .dplayer-video-wrap").append(txt2, txt6);
        $("#player1 .palyer-js-alt").append(txt3, txt4);
        $("#player1 .player-tab-Box").append(txt5);
        $("#player1 .dplayer-icons.dplayer-icons-left").append(FastR ,FastF);

        //清晰度列表内生成VIP广告
        $("#player1 .dplayer-quality-list").prepend(QXDvip);

        //清晰度带vip标识    紧紧演示  可删除
        $("#player1 .dplayer-quality-item").addClass("QXDvip");
        $("#player1 .player-box-JS>a").each(function(){
            $(this).removeClass("act");
            var tm1_id = $(this).attr('attr-id');
            if(selected_id == tm1_id)
            {
                $(this).addClass("act");
            }
        });
        // $('.dplayer-video-wrap').trigger('click');
        dp1.play();
    }

    //快进5秒
    $("#player1").on('click', '.icon-forward', function() {
        dp1.seek(dp.video.currentTime + 5);
    });
    //后退5秒
    $("#player1").on('click', '.icon-rewind', function() {
        dp1.seek(dp.video.currentTime - 5);
    });

    //  集数alert 显示隐藏
    $("#player1").on('click', '.palyer-js', function() {
        $("#player1 .palyer-js-alt").toggleClass("act");
        $("#player1 .palyer-js-alt-right").toggleClass("act");
        event.stopPropagation();
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
    $("#player1").on('click', '.player-box-JS>a', function() {
        $(this).addClass("act").siblings().removeClass("act");
        event.stopPropagation();
        selected_id = $(this).attr('attr-id');
        var quality = $(this).attr('attr-quality');
        var quality_arr = quality.split('$$$');
        var new_video = { quality:[], pic: '', defaultQuality: 0, };
        for (x in quality_arr){
            var tmp_qua=quality_arr[x];
            var tmp_arr = tmp_qua.split('#');
            new_video['quality'].push({
                'name': tmp_arr[0],
                'url': tmp_arr[1],
                'type': 'auto',
            });
        }
        dp1.destroy();
        initialPlayer(new_video);
        $(".GNbox-JS>a").each(function(){
            $(this).removeClass("act");
            var tm1_id = $(this).attr('attr-id');
            if(selected_id == tm1_id)
            {
                $(this).addClass("act");
            }
        });
    });

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

</script>
<script>
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
                    quality: [
                        <?php
                        $default_qua = 0;
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
                            $src_id = $src['source_id'];
                            $src_url = $src_array[$src_id];
                            $type = initialUrl($src_url);
                            echo "{
                                        name: '".$src['name']."',
                                        url: '".$type."',
                                        type: 'auto',
                                    },";
                        }
                        ?>
                    ],
                    url: '<?php echo $type;?>',
                    pic: '',
                    defaultQuality: <?php echo $default_qua;?>,
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
                quality: [
                    <?php
                    $default_qua = 0;
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
                        $src_id = $src['source_id'];
                        $src_url = $src_array[$src_id];
                        $type = initialUrl($src_url);
                        echo "{
                                    name: '".$src['name']."',
                                    url: '".$type."',
                                    type: 'auto',
                                },";
                    }
                    ?>
                ],
                pic: '',
                defaultQuality: <?php echo $default_qua;?>,
            };
            initialPlayer(ini_video);
        });
    <?php elseif (empty($ad_type)) :?>
    dp.destroy();
    var ini_video = {
        quality: [
            <?php
            $default_qua = 0;
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
                $src_id = $src['source_id'];
                $src_url = $src_array[$src_id];
                $type = initialUrl($src_url);
                echo "{
                            name: '".$src['name']."',
                            url: '".$type."',
                            type: 'auto',
                        },";
            }
            ?>
        ],
        pic: '',
        defaultQuality: <?php echo $default_qua;?>,
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