<?php
use yii\helpers\Html;

?>
<html>
<head>
    <?= Html::csrfMetaTags() ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>分享落地</title>

</head>
<style>
    ul {
        display: flex;
    }
    ul li {
        width: 50%;
        text-align: center;
    }
    ul li img {
        width: 85%;
    }
</style>
<body>
<div>
    <img width="100%" src="/images/share/share_down_top.jpg">
    <div>
        <ul>
            <li><a href="https://testflight.apple.com/join/hjPAhPiO"><img src="/images/share/ios.png"></a></li>
            <li><a href="http://pack.beiwo-manhua.com/sofaAndroid"><img src="/images/share/android.png"></a></li>
        </ul>
    </div>
    <img width="100%" src="/images/share/share_down_bottom.png">
</div>
</body>
