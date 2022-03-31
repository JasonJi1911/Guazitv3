<?php
use yii\helpers\Url;

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = '瓜子TV|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv - guazitv.tv';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片']);

?>
<style>
    #agreement{width: 100%;height:calc(100% - 1rem);}
</style>
<div class="display-flex outer-div sms-title pink" >
    <a class="div-box position-r white-arrow" href="<?= Url::to(['/video/aboutus'])?>">
        <img src="/images/video/icon-fh-1.png">
    </a>
    <div class="text-center title-width">软件许可及服务协议</div>
    <div class="div-box position-r"></div>
</div>
<iframe id="agreement" src="<?=$data['about'][0]['content']?>" align="center" width="100%" scrolling="auto" frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no"></iframe>
<script>
    function setIframeHeight(iframe) {
        if (iframe) {
            var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
            if (iframeWin.document.body) {
                iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
            }
        }
    };

    window.onload = function () {
        setIframeHeight(document.getElementById('agreement'));
    };
</script>