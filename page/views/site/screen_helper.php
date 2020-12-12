<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>投屏助手</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <style>
        @media screen and (min-width: 768px){
            body, html {
                max-width: 414px;
                margin: 0 auto;
                position: relative;
            }
        }
        html, body {
            width: 100%;
            height: 100%;
            text-align: center;
            cursor: default;
            overflow-y:auto;
            margin:0 auto;
        }
        p,h3,ul,li{
            margin:0;
            padding:0;
        }
        h1,h4{
            font-weight:400;
        }
        ul{
            list-style: none;
        }
        .assi-content{
            width: 100%;
            margin: 0.3rem auto;
            height: 100vh;
            padding-left: 0.3rem;
            padding-right: 0.3rem;
            box-sizing: border-box;
            background: #fff;
            overflow: hidden;
        }
        ::-webkit-scrollbar-track-piece {
            background-color: transparent;
            -webkit-border-radius: 0;
        }

        ::-webkit-scrollbar {
            width: 0px;
            height: 0px;
        }

        ::-webkit-scrollbar-thumb {
            height: 50px;
            background-color: #7cbaef;
            -webkit-border-radius: 4px;
        // outline: 2px solid #fff;
            outline: 0;
            outline-offset: -2px;
        // border: 2px solid #fff;
        }

        ::-webkit-scrollbar-thumb:hover {
            height: 50px;
            background-color: #9f9f9f;
            -webkit-border-radius: 4px;
        }
        .operation{
            /*padding-top:0.35rem;*/
            box-sizing: border-box;
        }
        .operation-title{
            height:0.45rem;
            display: flex;
            align-items: center;
        }
        .dot{
            width:0.2rem;
            height:0.2rem;
            border-radius:60%;
            background-color:#a32c04;
            margin-right:0.19rem;
        }
        .operation-title h4{
            font-size:0.32rem;
            color:#333333;
        }
        .oper-content{
            width:100%;
            margin:0.5rem auto;
            text-align: left;
        }
        .oper-content p{
            font-size:0.25rem;
            color:#666666;
        }
        .oper-img1{
            display: block;
            margin:0.5rem auto 0;
            width:4.72rem;
            height:1.92rem;
        }
        .oper-img2{
            display: block;
            width: 3.74rem;
            margin:0.5rem auto 0rem;
            height:1.65rem;
        }
        .seperate{
            width:100vw;
            height:0.19rem;
            background: #f3f3f3;
        }
        .question{
            width: 100%;
            text-align: left;
            margin-top: .4rem;
        }
        .question h1{
            font-size:0.32rem;
            color:#333;
        }
        .question ul{
            width: 100%;
        }
        .question ul li{
            font-size: 0.26rem;
            color:#666;
        }
    </style>
</head>
<body>
<div class="assi-content">
    <div class='operation'>
        <div class="operation-title">
            <div class="dot"></div>
            <h4>网络连接</h4>
        </div>
        <div class="oper-content">
            <p>点击播放器上的投屏按钮，在设备列表页面选择您的投屏设备，即可将手机上的视频投射到电视上</p>
            <img src="/images/screen/1.png" alt="" class="oper-img1">
        </div>
    </div>
    <div class='operation'>
        <div class="operation-title">
            <div class="dot"></div>
            <h4>投屏播放</h4>
        </div>
        <div class="oper-content">
            <p>打开智能电视，智能电视盒或电视果等投屏设备，连接网络，并确保您的手机和投屏设备连接同一个Wi-Fi。</p>
            <img src="/images/screen/2.png" alt="" class="oper-img2">
        </div>
    </div>
    <div class='operation'>
        <div class="operation-title">
            <div class="dot"></div>
            <h4>手机遥控</h4>
        </div>
        <div class="oper-content">
            <p>投屏成功后可用手机控制视频播放进度条、清晰度、音量和选集。同时可在手机上观看其他视频、聊天、浏览。网页等。</p>
        </div>
    </div>
    <div class="seperate"></div>
    <div class="question">
        <h1>为什么搜索不到设备？</h1>
        <ul>
            <li>1. 确保设备支持DLNA或AirPlay协议。</li>
            <li>2. 确认后，再检查手机和设备是否连接同一个WiFi。</li>
        </ul>
    </div>
</div>

<script>
    //界面rem初始化
    (function(doc, win) {
        var docEl = doc.documentElement,
            resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
            recalc = function() {
                var clientWidth = docEl.clientWidth
                if (!clientWidth) {
                    return
                }
                const size = 100 * (clientWidth / 720)
                if (size > 54) {
                    docEl.style.fontSize = 54 + 'px'
                } else {
                    docEl.style.fontSize = size + 'px'
                }


            }
        if (!doc.addEventListener) return
        win.addEventListener(resizeEvt, recalc, false)
        doc.addEventListener('DOMContentLoaded', recalc, false)
    })(document, window)
</script>
</body>
</html>
