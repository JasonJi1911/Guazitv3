<?php
use yii\helpers\Url;

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = '瓜子TV|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv - guazitv.tv';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片']);

$js = <<<JS
$(function (){
    //首次进入
    $("#sum-money").text($(".vip-goods-div.act").find(".vip-goods-money").text());
    $("input[name='WIDsubject']").val($(".vip-goods-div.act").find(".vip-goods-title").text());
    $("input[name='WIDtotal_fee']").val($(".vip-goods-div.act").find(".vip-goods-money").text().replaceAll("¥",""));
    $("input[name='goodsId']").val($(".vip-goods-div.act").attr("data-id"));
    
    
    $(".vip-goods-div").click(function(){
        $(this).addClass("act").siblings().removeClass("act");
        $("#sum-money").text($(this).find(".vip-goods-money").text());
        $("input[name='WIDsubject']").val($(this).find(".vip-goods-title").text());
        $("input[name='WIDtotal_fee']").val($(this).find(".vip-goods-money").text().replaceAll("¥",""));
        $("input[name='goodsId']").val($(this).attr("data-id"));
    });
    console.log($("input[type='radio']:checked").val());
});

JS;

$this->registerJs($js);
?>
<style>
    body{background-color:#F1F5F8;font-family: PingFangSC;}
    .vip-head{background-color: #2D2D2F;color: #EABA73;}
    .white-div{background-color: #FFFFFF;}
    .user-box{height: 95px;padding: 25px 15px 0;border-top: 1px #2D2D2F solid;margin-top: -1px;}
    .user-title{height: 70px;background-color: #2D2D2F;padding: 0 15px;display: flex;align-items: center;flex-direction: row;background-image: url(/images/video/pay_user_vip_bg.png);background-size: 100% 100%;}
    .user-title img.user-avatar{width: 1rem;height: 1rem;}
    .user-title .div-username{height:0.5rem;margin-left: 15px;font-size: 16px;color: #363636;font-weight: bold;}

    .vip-goods{display: flex;align-items: center;flex-direction: row;padding: 0 15px;}
    .vip-goods-div{width:33%;height:120px;position: relative;margin: 10px 10px;text-align: center;border-radius:5px;border: 1px solid #D3D3D3;}
    .vip-goods-title{font-weight: bold;font-size: 14px;line-height: 30px;margin-top: 10px;color: #656565;}
    .vip-goods-money{color: #EABA73;font-weight: bold;font-size: 24px;line-height: 50px;}
    .vip-goods-del-money{color: #939393;font-size: 12px;line-height: 20px;}
    .vip-goods-div.act{border: 1px solid #DFAE67;background-color: #FFF7EB;}
    .vip-goods-div.act .vip-goods-title{color:#583000;}
    .vip-goods-div.act .vip-goods-del-money{color:#826A50;}

    .pay-div{width:100%;height:1rem;padding: 0 15px;}
    .pay-div .pay-img{width: 0.6rem;height:0.6rem;margin: 0.2rem 0.2rem 0.2rem 0;}
    .pay-div .pay-span{width: calc( 100% - 1rem - 15px );}
    input[type='radio'] {position: relative;cursor: pointer;width: 15px;height: 15px;background: url(/images/video/pay_channel_failure.png) no-repeat;background-size: 15px;}
    input[type='radio']:checked::after {position: absolute;display: inline-flex;justify-content: center;align-items: center;width: 15px;height: 15px;content: '';color: #fff;background: url(/images/video/pay_channel_success.png) no-repeat;background-size: 15px;border-radius: 2px;}

    .vip-right{display: grid;grid-template-columns: 1fr 1fr 1fr 1fr;grid-gap: 5px;margin:0 15px;text-align: center;}
    .vip-right li .vip-right-img{width:0.8rem;margin:0 auto;}
    .vip-right li .vip-right-text{height: 30px;line-height: 30px;font-size: 12px;}

    .pay-sum{width: calc(100% - 150px);line-height: 1rem;padding-left: 15px;}
    .pay-sum span{color: #EABA73;}
    .pay-btn{width:150px;height: 100%;background-color: #EABA73;color: #583301;font-weight: bold;}
</style>
<div class="display-flex outer-div sms-title vip-head" >
    <a class="div-box position-r white-arrow" href="<?= Url::to(['/video/personal'])?>">
        <img src="/images/video/icon-fh-1.png">
    </a>
    <div class="text-center title-width">会员中心</div>
    <div class="div-box position-r"></div>
</div>
<form name="alipayment" action="/video/create-order" method="get" >
    <input name="uid" type="hidden" value="<?=$data['uid']?>"/>
    <input  type="hidden" name="WIDsubject" value="" />
    <input  type="hidden" name="WIDtotal_fee" value="" />
    <input  type="hidden" name="goodsId" value="" />
<div class="user-box vip-head">
    <div class="user-title">
        <img class="user-avatar" src="<?=$data['user_info']['avatar']?>" onerror="this.src='/images/video/touxiang.png'" />
        <div style="padding-top: 15px;">
            <div class="div-username">
                <div style="display: inline-block;"><?=$data['user_info']['username']?></div>
                <?php $vip_imgurl = "";
                    if($data['user_info']['vip_status']==1){
                        $vip_imgurl = "/images/video/icon_isvip.png";
                    }else if($data['user_info']['vip_status']==0){
                        $vip_imgurl = "/images/video/icon_novip.png";
                    }
                ?>
                <img style="display: inline-block;height: 12px;" src="<?=$vip_imgurl?>">
            </div>
            <div class="div-username" style="color: #EABA73;font-size: 12px"><?=$data['user_info']['desc']?></div>
        </div>
    </div>
</div>
<div class="white-div">
    <div class="vip-goods">
        <?php if($data['goods_list']): ?>
            <?php foreach ($data['goods_list'] as $key=>$goods ): ?>
            <div class="vip-goods-div <?= ($key==0)? 'act' : ''; ?>" data-id="<?=$goods['goods_id']?>">
                <div class="vip-goods-title"><?=$goods['title']?></div>
                <div class="vip-goods-money"><?=$goods['current_price']?></div>
                <del class="vip-goods-del-money"><?=$goods['original_price']?></del>
            </div>
            <?php endforeach;?>
        <?php endif;?>
    </div>
</div>
<div class="white-div font14" style="margin: 10px 0;">
    <div class="outer-div" style="padding: 0 15px;font-size: 14px;">支付方式</div>
    <div class="line" ></div>
    <?php if($data['goods_list']): ?>
        <?php foreach ($data['goods_list'] as $key=>$goods ): ?>
            <?php if($goods['pay_channel']) {?>
                <?php foreach ($goods['pay_channel'] as $i=>$paychannel ): ?>
                <label>
                    <div class="display-flex pay-div" style="">
                        <img class="pay-img" src="<?=$paychannel['icon']?>" onerror="this.src='/images/video/touxiang.png'">
                        <span class="pay-span"><?=$paychannel['title']?></span>
                        <input type="radio" value="<?=$paychannel['channel_code']?>" name="type" <?= ($i==0)? 'checked' : ''; ?> />
                    </div>
                </label>
                <?php endforeach;?>
            <?php break; }?>
        <?php endforeach;?>
    <?php endif;?>
</div>
<div class="white-div font14" style="margin: 10px 0;">
    <div class="outer-div" style="padding: 0 15px;font-size: 14px;">会员特权</div>
    <ul class="vip-right" style="">
        <li>
            <img class="vip-right-img" src="/images/video/08.png" />
            <div class="vip-right-text">广告特权</div>
        </li>
        <li>
            <img class="vip-right-img" src="/images/video/01.png" />
            <div class="vip-right-text">院线新片</div>
        </li>
        <li>
            <img class="vip-right-img" src="/images/video/02.png" />
            <div class="vip-right-text">热剧抢先看</div>
        </li>
        <li>
            <img class="vip-right-img" src="/images/video/03.png" />
            <div class="vip-right-text">海量大片</div>
        </li>
        <li>
            <img class="vip-right-img" src="/images/video/06.png" />
            <div class="vip-right-text">会员折扣</div>
        </li>
        <li>
            <img class="vip-right-img" src="/images/video/04.png" />
            <div class="vip-right-text">尊贵标识</div>
        </li>
        <li>
            <img class="vip-right-img" src="/images/video/07.png" />
            <div class="vip-right-text">边下边播</div>
        </li>
        <li>
            <img class="vip-right-img" src="/images/video/05.png" />
            <div class="vip-right-text">会员福利</div>
        </li>
    </ul>
</div>
<div style="width:100%;height:1rem;"></div>
<div class="bottom-navi display-flex font14">
    <div class="pay-sum">总计：<span id="sum-money">￥0</span></div>
    <button class="pay-btn" type="submit">立即支付</button>
</div>
</form>
