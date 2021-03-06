<?php
use yii\helpers\Url;
?>
<style>
    .XX-a{display:block;}
    .XX-adiv{height:50px;padding:5px 0;}
    .XX-adiv div{
        height:25px;line-height:25px;
        color: #999999;
        text-align:left;
        padding-left:15px;
        overflow: hidden;
        text-overflow:ellipsis;
        white-space: nowrap;
    }
    .XX-adiv span{color:#FF5722;padding:0 5px;}
    .ls-div{margin-left: -250px;}

    *{
        margin:0;
        padding:0;
    }
    ul,ol{
        list-style:none;
    }
    .vip-head{
        height: 140px;
        background: linear-gradient(152deg,#302924,#1a1b1e 91%,#2c2e32);padding: 0 20px;
        position: relative;
    }
    .vip-header-bg{
        background-image: url(/images/Index/cash-icon.png);
        background-position: 0 -120px;
        background-repeat: no-repeat;
        background-size: 720px 720px;
        display: inline-block;
        height: 107px;
        position: absolute;
        right: 0;
        top: 0;
        width: 170px;
    }
    .vip-header-title{
        color: #ffd38b;
        font-size: 14px;
        line-height: 38px;
    }
    .vip-header-user{
        display: flex;
        align-items: center;
        flex-direction: row;
    }
    .vip-head .gold-vip{
        bottom: 0;
        height: 44px;line-height: 44px;
        left: 0;
        position: absolute;
        right: 0;color: #c4751a;
        font-weight: 700;font-size: 14px;
        background-image: url(/images/Index/pay_user_vip_bg.png);
        background-repeat: no-repeat;
        background-size: auto 100%;
        background-position: right;
        background-color: #FEF1C5;
        text-align: center;
    }
    .vip-head .gold-vip svg g path {
        fill: #c4751a;
    }
    .vip-header-user .vip-user-info{
        margin-left: 10px;
    }
    .vip-header-user .vip-user-info>div:nth-of-type(1){
        align-items: center;
        display: flex;
    }
    .vip-header-user .vip-user-info>div:nth-of-type(2){
        color: #858585;
        font-size: 12px;
        white-space: nowrap;
    }
    .vip-header-user .vip-name{
        color: #ffd38b;
        cursor: pointer;
        font-size: 16px;
        line-height: 22px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .vip-header-user .vip-account{
        color: #fff;
        font-size: 14px;margin-left: 8px;
        letter-spacing: 0;
    }
    .vip-header-user .isvip{
        height: 10px;
        margin-left: 8px;
    }
    .vip-body{
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        flex-grow: 1;
        padding: 0 24px 24px;
    }


    .alt02-xz {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-gap: 33.33333px;
        padding: 10px 0px 20px 0px;
        /*background-color: #F9F9F9;*/
        overflow: hidden;
    }

    .alt02-xz>ul {
        width: 100%;/*170px*/
        height: 120px;
        text-align: center;
        overflow: hidden;
        cursor: pointer;
        background-color: #f7f7f7;
    }
    .alt02-xz>ul.act {
        background-image: linear-gradient(134deg,#fff0db,#fadeb7);
    }

    .alt02-xz>ul>li:first-of-type {
        color: rgba(0,0,0,.9);
        margin-top: 17px;
        max-width: 100%;
        overflow: hidden;
        padding: 0 10px;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 16px;
    }

    .alt02-xz>ul>li:nth-of-type(2) {
        color: #884527;
        margin-top: 10px;
        font-size: 22px;
    }

    .alt02-xz>ul>li:last-of-type {
        margin: 11px 10px 0;
        max-width: calc(100% - 20px);
        overflow: hidden;
        padding: 4px 8px;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: rgba(0,0,0,.3);
    }
    .alt02-bdr {
        box-sizing: border-box;
    }
    .alt02-tabA{
        height: 100%;
    }

    .alt02-tabA>li {
        width: 200px;
        color: #000;
        height: 50px;
        line-height: 50px;
        text-align: center;
        cursor: pointer;
        background-color: #fff;
        /*border: solid #e6e6e6;*/
        border-width: 0 1px 1px 0;
    }

    .alt02-tabA>li.tabA{
        background-color: #f0f0f0;
        border-right: none;
    }

    #alt02 .alt-GB {
        margin-top: -296px;
        margin-right: -349px;
    }
    .pay-fee{
        color: #884527;
        font-size: 24px;
        margin-right: 8px;
        font-family: Impact;
    }
    .pay-original-fee {
        color: #e37438;
        font-size: 14px;
        margin-bottom: 1px;
    }
    .impact{
        font-family: Impact;
    }
    .pay-name{
        color: #666;
        font-size: 14px;
    }
    .pay-name.hide{
        display: none;
    }
    .pay-name img{
        width: 20px;
        height: 20px;
        padding: 0 5px 0 70px;
    }
    .paybox03 {
        position: relative;
        height: 100%;
        overflow: hidden;
    }
    .paybox03>div {
        float: left;
        /*margin-top: 40px;*/
        width: 50%;
        text-align: center;
        overflow: hidden;
    }

    .paybox03-L {
        font-size: 12px;
        position: relative;
    }

    .paybox03-L>div {
        margin-bottom: 10px;
    }

    /*.paybox03-L>div>img {*/
    /*    width: 150px;*/
    /*}*/

    .paybox03-L div.J_qrcode_shadow{
        position: absolute;
        width: 150px;
        height: 150px;
        left: 80px;
        background: #000;
        opacity: .6;
    }
    .paybox03-L p.J_qrcode_shadow{
        position: absolute;
        width: 150px;
        line-height:20px;
        left: 80px;
        font-size: 14px;
        top:65px;
        color: #fbfbfb;
        font-weight: 700;
    }
    .paybox03-R {
        padding-top: 15px;
        color: #999999;
    }
    .paybox03-R span{
        line-height: 30px;
    }
    .display-flex{
        display: flex;
        align-items: center;
        flex-direction: row;
    }
    #J_qrcode{
        width:150px;
        height:150px;
        margin-left: 80px;
    }
    #J_qrcode canvas,#J_qrcode img{
        width:100%;
        height??? 100%???}
    }
</style>
<script>
    //tab ??????
    $(document).ready(function() {
        $(".XX-tabA>li").click(function() {
            var tabNum = $(this).index();
            $(this).addClass("tabA").siblings().removeClass("tabA");
            $(this).find(".LSmenu-line").addClass("act");
            $(this).siblings().find(".LSmenu-line").removeClass("act");
            $(".XX-tabBox>div").eq(tabNum).addClass("tabBox").siblings().removeClass("tabBox");
        });
    });
</script>
<input type="hidden" id="login_id" value="<?=$data['main_uid']?>" />
<div id="vipbtn" class="navTopBtn ">
    <div class="navTopBtnImg">
        &nbsp;
    </div>
</div>
<!--????????????/??????-->
<div class="navTopBtn J_history">
    <div class="navTopBtnImg">
        &nbsp;
    </div>
    <!--????????????-->
    <div class="LSmenuBox lf " name="zt" style="<?=$data['login_show']?>">
        <ul class="XX-tabA " name="zt">
            <li class="tabA">
                <p>????????????</p>
                <p class="LSmenu-line act"></p>
            </li>
            <li>
                <p>????????????<p>
                <p class="LSmenu-line"></p>
            </li>
        </ul>
        <div class="XX-tabBox">
            <div class="tabBox" name="zt" id="LSmenuBox_div">
                <?php if(!$data['watchlog']):?>
                    <!--?????????   ??????-->
                    <div class="LSmenu-No">????????????</div>
                <?php else :?>
                    <!--???????????????-->
                    <ul class="LSmenu " name="zt">
                        <?php $i=0;?>
                        <?php foreach ($data['watchlog'] as $watchlist):?>
                            <?php foreach ($watchlist['list'] as $watchlog):?>
                                <?php $i++;?>
                                <?php if($i<6):?>
                                    <li data-video-id="<?=$watchlog['video_id']?>">
                                        <a href="<?= Url::to(['detail', 'video_id' => $watchlog['video_id'],'chapter_id'=>$watchlog['chapter_id']])?>">
                                            <div><?=$watchlog['title']?>&nbsp;&nbsp;<?= is_numeric($watchlog['chapter_title']) ? ('???'.$watchlog['chapter_title'].'???') : $watchlog['chapter_title']?></div>
                                            <div>?????????<?=$watchlog['watch_percent']?>%</div>
                                            <div>
                                                <span><?=$watchlog['time_diff']?></span>
                                                <!--<span>??????</span>-->
                                            </div>
                                        </a>
                                    </li>
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php endforeach;?>
                    </ul>
                    <div class="LSmenuBottom" style="<?=$data['login_show']?>">
                        <div class="LSmenuBottom-lf" onclick="removetab('watchlog');">
                            &nbsp;????????????
                        </div>
                        <div class="LSmenuBottom-rg">
                            <a href="<?= Url::to(['/video/personal', 'ptab' => 'watchlog'])?>">????????????&nbsp;></a>
                        </div>
                    </div>
                <?php endif;?>
            </div>
            <div id="XX-tabBox-favorite">
                <?php if(!$data['favorite']):?>
                    <div class="LSmenu-No">????????????</div>
                <?php else:?>
                    <ul class="LSmenu " name="zt">
                        <?php foreach ($data['favorite'] as $key=>$f):?>
                            <?php if($key < 5):?>
                                <!--                        <a class="XX-a" href="--><?//= Url::to(['detail', 'video_id' => $f['video_id']])?><!--" >-->
                                <!--                            <div class="XX-adiv">-->
                                <!--                                --><?php //$favoStr = '';
//                                if($f['type']=='favorite'){
//                                    $favoStr = "????????????<span> ???".$f['video_name']."??? </span>???????????? <span>".$f['chapter_title']."</span>";
//                                }//????????????????????????????????????
//                                ?>
                                <!--                                <div>--><?//=$favoStr?><!--</div>-->
                                <!--                                <div>--><?//=$f['time_diff']?><!--</div>-->
                                <!--                            </div>-->
                                <!--                        </a>-->
                                <li>
                                    <a href="<?= Url::to(['detail', 'video_id' => $f['video_id']])?>">
                                        <div><?=$f['video_name']?>&nbsp;&nbsp</div>
                                        <div><?=$f['is_finished']==1? '??????' : '?????????' ?></div>
                                        <div>
                                            <?php if($f['is_finished']==1):?>
                                                <span></span>
                                            <?php else:?>
                                                <span><?=$f['flag']?></span>
                                            <?php endif;?>
                                            <!--<span>??????</span>-->
                                        </div>
                                    </a>
                                </li>
                            <?php endif;?>
                        <?php endforeach;?>
                    </ul>
                    <div class="LSmenuBottom">
                        <div class="LSmenuBottom-lf" onclick="removetab('favorite');">
                            &nbsp;????????????
                        </div>
                        <div class="LSmenuBottom-rg">
                            <a href="<?= Url::to(['/video/personal', 'ptab' => 'favorite'])?>">????????????&nbsp;></a>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<!--???????????????-->
<div class="navTopLogon" id="notloggedin" style="<?=$data['notlogin_show']?>">
    <div class="navTopLogonImg-no">
        <img src="/images/Index/user.png" />
    </div>
    <div class="navTopLogonName " name="zt">
        ??????
    </div>
</div>
<!--????????????-->
<div class="navTopLogon" id="loggedin" style="<?=$data['login_show']?>">
    <div class="navTopLogonImg">
        <?php $avatar = '';
        if($data['user']['avatar']==1){
            $avatar = $data['user']['avatar'];
        }else{
            $avatar = '/images/Index/user_c.png';
        }?>
        <img id="user_headimg" src="<?=$avatar?>" onerror="javascript:this.src='/images/Index/user_c.png';" />
    </div>
    <div class="navTopLogonName " name="zt">
        <?=$data['user']['nickname'];?>
    </div>
    <div class="navTopLogon-GRXX " name="zt">
        <ul class="navTopLogon-box03">
            <li>
                <a class="navTopLogon-A" href="<?= Url::to(['/video/personal'])?>">????????????</a></li>
            <li><span class="navTopLogon-btn" id="logout">????????????</span></li>
        </ul>
    </div>
</div>

<!--??????vip-->
<div class="alt" id="alt02" style="z-index:10;">
    <!--VIP????????? id="alt02"-->
    <div class="alt02-box">
        <div class="vip-head">
            <div class="vip-header-bg"></div>
            <div class="vip-header-title">VIP??????</div>
            <div class="vip-header-user">
                <img src="<?=$data['user_info']['avatar']?>" onerror="this.src='/images/Index/user_c.png'" />
                <div class="vip-user-info">
                    <div>
                        <span class="vip-name"><?=$data['user_info']['username']?></span>
                        <?php $vip_imgurl = "";
                        if($data['user_info']['vip_status']==1){
                            $vip_imgurl = "/images/Index/icon_isvip.png";
                        }else{
                            $vip_imgurl = "/images/Index/icon_novip.png";
                        }
                        $hide_account = '';
                        if(strlen($data['user']['mobile']>5) ){
                            $hide_account = '(???????????????'.substr($data['user']['mobile'],0, 3) . '******' . substr($data['user']['mobile'],-2).')';
                        }
                        $desc = '';
                        if($data['user_info']['vip_status']==1){
                            $desc = $data['user_info']['desc'].'??????????????????????????????';
                        }else{
                            $desc = $data['user_info']['desc'];
                        }
                        ?>
                        <img class="isvip" src="<?=$vip_imgurl?>" />
                        <span class="vip-account"><?=$hide_account?></span>
                    </div>
                    <div class="J_desc"><?=$desc?></div>
                </div>
            </div>
            <div class="gold-vip">
                <svg v-if="pidMap[subTab.pid] === 'gold'" width="16px" height="16px" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="??????-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="gold-tab-icon" transform="translate(-234.000000, -398.000000)"><g id="??????????????????" transform="translate(156.000000, 285.000000)"><g id="??????-9" transform="translate(0.000000, 99.000000)"><g id="??????-12" transform="translate(78.000000, 14.000000)"><rect id="??????" x="0" y="0" width="16" height="16"></rect><path d="M8.62771843,2 C8.70358233,2 8.77230881,2.03831549 8.81144951,2.10239296 C8.8504751,2.16636128 8.85024486,2.23993575 8.81075879,2.30434071 L8.81075879,2.30434071 L5.40056714,8.02612065 C5.28728933,8.20951104 5.07708071,8.32347506 4.85202165,8.32347506 C4.80067825,8.32347506 4.74898949,8.31747121 4.69891241,8.30568183 L4.69891241,8.30568183 L2.70526899,7.80681632 C2.57598954,7.77450468 2.45684063,7.8834473 2.48711711,8.00625336 L2.48711711,8.00625336 L3.86740263,13.7897092 L3.87154694,13.8016078 C3.95397266,14.0415435 4.19699041,14.2029926 4.47604062,14.2029926 L4.47604062,14.2029926 L11.6255512,14.2029926 C11.9055224,14.2029926 12.1487704,14.0411069 12.2305054,13.800407 L12.2305054,13.800407 L12.233959,13.7900367 L13.568542,8.03310695 C13.5958253,7.91204747 13.4790939,7.80605219 13.3518866,7.83628978 L13.3518866,7.83628978 L11.5072081,8.30404441 C11.4524112,8.31878114 11.3939303,8.32642241 11.3353344,8.32642241 C11.1162616,8.32642241 10.9156079,8.22217371 10.7985311,8.0475162 L10.7985311,8.0475162 L8.9613354,4.97201581 C8.89778931,4.87802824 8.89744395,4.75784204 8.96052956,4.66363615 L8.96052956,4.66363615 L9.87135683,3.33656658 C9.89829485,3.29464877 9.94595441,3.26954176 9.99833389,3.26954176 C10.0489866,3.26954176 10.0942286,3.29235639 10.1222027,3.3323093 L10.1222027,3.3323093 L11.8331121,6.2378461 L11.8401344,6.24636065 C11.9237113,6.34700704 12.056099,6.40704556 12.1943578,6.40704556 C12.253184,6.40704556 12.3588639,6.3979852 12.4207983,6.37888204 L12.4207983,6.37888204 L15.4379712,5.52284193 C15.4764212,5.51345409 15.5153316,5.50854184 15.5540119,5.50854184 C15.6883566,5.50854184 15.8148732,5.56628798 15.9009827,5.66704353 C15.9872074,5.76768992 16.01852,5.89333417 15.9893947,6.02061582 L15.9893947,6.02061582 L13.8024652,15.4026713 C13.7249897,15.7492573 13.3972438,16 13.0232198,16 L13.0232198,16 L3.03980692,16 C2.66681901,16 2.34782224,15.7603917 2.26401508,15.4174081 L2.26401508,15.4174081 L0.0135395562,6.02629219 C-0.0200754038,5.89780976 0.00962548552,5.76637999 0.0945838435,5.66409619 C0.180693399,5.56039329 0.308476295,5.50090058 0.445353649,5.50090058 C0.481731483,5.50090058 0.518569795,5.50526702 0.554947629,5.51356325 L0.554947629,5.51356325 L3.7522829,6.35879642 C3.80569846,6.37910036 3.87166206,6.39176303 3.92738001,6.40715472 C4.06966799,6.44645266 4.26871,6.2453782 4.35205668,6.14451349 L4.35205668,6.14451349 L4.35850338,6.13665391 L5.68422215,3.98236271 C5.7737853,3.8485314 5.75340911,3.67682123 5.63449043,3.56504043 L5.63449043,3.56504043 L5.0647629,3.00952039 C4.89070188,2.83977513 4.99074092,2.55541087 5.23778785,2.51742287 L5.23778785,2.51742287 L8.58385781,2.00414812 C8.5995141,2.00130993 8.61378894,2 8.62771843,2 Z M6.86834365,9.45932741 C6.93810621,9.45932741 7.00510589,9.48498023 7.05414689,9.53050035 L7.05414689,9.53050035 L7.98408404,10.6192716 C7.99559601,10.6321526 8.0171234,10.6319343 8.02829001,10.6187258 L8.02829001,10.6187258 L8.96697626,9.53890574 C9.01670798,9.48825506 9.0873915,9.45932741 9.1615286,9.45932741 L9.1615286,9.45932741 L10.9225151,9.45932741 C11.0585866,9.45932741 11.1285794,9.60909623 11.0351021,9.70002729 L11.0351021,9.70002729 L8.09287218,12.9178735 C8.04256486,12.9722357 7.95139004,12.9721265 7.90142808,12.9176552 C7.39950607,12.3713047 5.12059597,9.85219764 4.96449362,9.69948149 C4.87147688,9.60844126 4.94181504,9.45932741 5.07765631,9.45932741 L5.07765631,9.45932741 Z" id="????????????" fill="#ffffff"></path></g></g></g></g></g></svg>
                <span>??????VIP</span>
            </div>
        </div>
        <div class="vip-body">
            <div style="color: #3e3e3e;padding: 12px 0 3px;">????????????????????????????????????</div>
            <ul class="alt02-xz">
                <?php if($data['goods_list']): ?>
                    <?php foreach ($data['goods_list'] as $key=>$goods ): ?>
                        <ul class="alt02-bdr <?= ($key==0)? 'act' : ''; ?>" data-id="<?=$goods['goods_id']?>">
                            <li><?=$goods['title']?></li>
                            <li><?=$goods['current_price']?></li>
                            <li><del><?=$goods['original_price']?></del></li>
                        </ul>
                    <?php endforeach;?>
                <?php endif;?>
        </div>
        <div class="display-flex" style="height: 260px;border: 1px solid #ececec;">
            <ul class="alt02-tabA">
                <?php if($data['goods_list']): ?>
                    <?php foreach ($data['goods_list'] as $key=>$goods ): ?>
                        <?php if($goods['pay_channel']) {?>
                            <?php foreach ($goods['pay_channel'] as $i=>$paychannel ): ?>
                                <li class="display-flex <?= ($i==0)? 'tabA' : ''; ?>">
                                    <input type="hidden" class="J_type" value="<?=$paychannel['channel_code']?>" />
                                    <img style="width: 30px;height: 30px;padding: 0 15px 0 45px;" src="<?=$paychannel['icon']?>" onerror="this.src='/images/Index/touxiang.png'">
                                    <span><?=$paychannel['title']?></span>
                                </li>
                            <?php endforeach;?>
                            <?php break; }?>
                    <?php endforeach;?>
                <?php endif;?>
            </ul>
            <div class="paybox" style="width: calc(100% - 260px);">
                <!--????????????-->
                <div class="paybox03 act">
                    <div class="paybox03-L">
                        <div class="J_qrcode_shadow"></div>
                        <p class="J_qrcode_shadow">?????????</p>
                        <div id="J_qrcode">
                            <!--                                <img src="/images/newindex/ewm.jpg" />-->
                        </div>
                    </div>
                    <div class="paybox03-R">
                        <span class="pay-fee J_money">0</span>
                        <span class="pay-original-fee"><span>?????????</span><span class="impact J_money2">0</span></span><br />
                        <?php if($data['goods_list']): ?>
                            <?php foreach ($data['goods_list'] as $key=>$goods ): ?>
                                <?php if($goods['pay_channel']) {?>
                                    <?php foreach ($goods['pay_channel'] as $i=>$paychannel ): ?>
                                        <span class="pay-name display-flex <?= ($i==0)? '' : 'hide'; ?>">
                                                <img src="<?=$paychannel['icon']?>" onerror="this.src='/images/Index/touxiang.png'">
                                                <span><?=$paychannel['title']?></span>
                                            </span>
                                    <?php endforeach;?>
                                    <?php break; }?>
                            <?php endforeach;?>
                        <?php endif;?>
                        <br />
                        <span style="line-height: 15px;">
                                ????????????????????????????????????<br />
                                ???VIP?????????????????????
                            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--????????????-->
    <input class="alt-GB" type="button"  />
</div>
</div>
<!--<script src="/js/jquery.js"></script>-->
<script src="/js/video/qrcode.js"></script>
<script>
    var qrcode = new QRCode(document.getElementById("J_qrcode"), {
        width : 300,
        height : 300,
        correctLevel : 3
    });
    var time1;
    $(function(){
        // clearInterval(time1);
        //??????vip
        $("#vipbtn").click(function(){
            var uid = finduser();
            if(!isNaN(uid) && uid!="") {
                showMoney();
                makeCode();
                $("#alt02").show();
                vipinfo();
            } else {
                showloggedin();
            }
        });
        //??????vip
        $('.alt-GB').click(function() {
            $(this).parents('.alt').hide();

            clearInterval(time1);
        });
        //	??????????????????
        $(".alt02-xz>ul").click(function() {
            $(this).addClass("act").siblings().removeClass("act");
            showMoney();
            makeCode();
        });
        //	??????????????????
        $(".alt02-tabA>li").click(function() {
            var tabNum = $(this).index();
            $(this).addClass("tabA").siblings().removeClass("tabA");
            $(".pay-name").eq(tabNum).removeClass("hide").siblings().addClass("hide");
            makeCode();
        });
        //??????????????????
        $(".J_history").click(function(){
            var uid = finduser();
            if(!isNaN(uid) && uid!="") {
                $(".LSmenuBox").show();
            } else {
                showloggedin();
            }
        });
        //???????????????-??????
        $("#notloggedin").click(function(){
            showloggedin();
        });
        //??????????????????
        $("#login_submit").click(function(){
            var account = $("#login_account").val();
            var prefix_phone = $("#login_prefix_phone").attr('data');
            var pwd = $("#login_pwd").val();
            var tab = true;
            var arrIndex = {};
            if(account==""){
                $("#login_account").parent().addClass("wor");
                $(".J_login_warning").text("??????????????????");
                $(".J_login_warning").show();
                tab = false;
                $("#login_submit").removeClass("login-loading");
                return false;
            }else{
                account = valimobile(account,prefix_phone);
                if(account==""){
                    $("#login_account").parent().addClass("wor");
                    $(".J_login_warning").text("?????????????????????");
                    $(".J_login_warning").show();
                    tab = false;
                    return false;
                }else{
                    arrIndex['mobile'] = account;
                    arrIndex['mobile_areacode'] = prefix_phone;
                }
            }
            if(pwd=="" || pwd.trim().length<6){
                $("#login_pwd").parent().addClass("wor");
                $(".J_login_warning").text("??????????????????6???");
                $(".J_login_warning").show();
                tab = false;
                return false;
            }else{
                arrIndex['password'] = pwd;
            }
            if(!$("#xy").hasClass("act")){
                $(".J_login_warning").text("?????????????????????????????????????????????????????????");
                $(".J_login_warning").show();
                tab = false;
                return false;
            }
            if(tab){
                $(".J_login_warning").text("???????????????...");
                $(".J_login_warning").show();
                arrIndex['flag'] = 0;//flag: 0-?????????1-???????????????
                console.log(arrIndex);
                $.get('/site/new-login',arrIndex,function(res){
                    $(".J_login_warning").text("????????????");
                    $(".J_login_warning").show();
                    $("#login_submit").removeClass("login-loading");
                    if(res.errno==0 && res.data){
                        //????????????,????????????
                        if(!isNaN(res.data) && res.data!=""){
                            saveuser(res.data);
                        }
                        location.reload();
                    }else{
                        $("#login_account").parent().addClass("wor");
                        $("#login_pwd").parent().addClass("wor");
                        $(".J_login_warning").text("?????????????????????");
                        $(".J_login_warning").show();
                    }
                });
            }
        });
        //?????????????????????
        $('.J_sms_code').click(function(){
            changeLogin('code');
            sendyzm($(this));
        });
        //???ajax????????????????????????????????????
        function sendyzm(obj){
            var prefix_phone = $(obj).parent().siblings('.J_tel').find('.J_prefix_phone').attr('data');
            var account = $(obj).parent().siblings('.J_tel').find('.J_account').val();
            $(obj).parent().siblings('.J_tel').find('.J_account').attr('disabled',true);
            var send_source = $(obj).attr('source');
            var tab = true;
            var arrIndex = {};
            if(account==""){
                $(obj).parent().siblings('.J_tel').addClass("wor");
                $(obj).parent().siblings(".loginTip").text("?????????????????????");
                $(obj).parent().siblings(".loginTip").show();
                $(obj).parent().siblings('.J_tel').find('.J_account').attr('disabled',false);
                tab = false;
                return false;
            }else{
                account = valimobile(account,prefix_phone);
                if(account == ""){
                    $(obj).parent().siblings('.J_tel').addClass("wor");
                    $(obj).parent().siblings(".loginTip").text("?????????????????????");
                    $(obj).parent().siblings(".loginTip").show();
                    $(obj).parent().siblings('.J_tel').find('.J_account').attr('disabled',false);
                    tab = false;
                    return false;
                }
            }
            if(tab) {
                var smstime = getCookie("pcsmscode");
                if(smstime!=1){
                    setCookie("pcsmscode",1,(1/1440));//1????????????

                    arrIndex['mobile_areacode'] = prefix_phone;
                    arrIndex['mobile'] = account;
                    // console.log('???????????????????????????---',arrIndex);
                    $.get('/video/send-code', arrIndex, function(res) {
                        // console.log('???????????????????????????---',res);
                        if(res.errno==0){
                            setloginTime(obj,send_source);//???????????????
                        }else{
                            var mes = "";
                            if(res.data.msg && res.data.msg!= ""  && res.data.msg!="undefined"){
                                mes = res.data.msg;
                            }else{
                                mes = '????????????';
                            }
                            $(obj).parent().addClass("wor");
                            $(obj).parent().siblings(".loginTip").text(mes);
                            $(obj).parent().siblings(".loginTip").show();
                        }
                    });
                }else{
                    $(obj).parent().siblings('.J_tel').find('.J_account').attr('disabled',false);
                    $(obj).parent().addClass("wor");
                    $(obj).parent().siblings(".loginTip").text("???????????????????????????????????????1???????????????");
                    $(obj).parent().siblings(".loginTip").show();
                }
            }
        }

        //???????????????
        $("#login_sms_submit").click(function(){
            var account = $("#login_sms_account").val();
            var prefix_phone = $('#sms_prefix_phone').attr('data');
            var code = $("#smscode").val();
            var tab = true;
            var arrIndex = {};
            if(account==""){
                $("#login_sms_account").parent().addClass("wor");
                $(".J_login_warning1").text("?????????????????????");
                $(".J_login_warning1").show();
                tab = false;
                return false;
            }else{
                account = valimobile(account,prefix_phone);
                if(account == ""){
                    $("#login_sms_account").parent().addClass("wor");
                    $(".J_login_warning1").text("?????????????????????");
                    $(".J_login_warning1").show();
                    tab = false;
                    return false;
                }else{
                    arrIndex['mobile'] = account;
                    arrIndex['mobile_areacode'] = prefix_phone;
                }
            }
            if(code==""){
                $("#smscode").parent().addClass("wor");
                $(".J_login_warning1").text("?????????????????????");
                $(".J_login_warning1").show();
                tab = false;
                return false;
            }else{
                arrIndex['code'] = code;
            }
            if(!$("#xy").hasClass("act")){
                $(".J_login_warning1").text("?????????????????????????????????????????????????????????");
                $(".J_login_warning1").show();
                tab = false;
                return false;
            }
            if(tab){
                $(".J_login_warning1").text("???????????????...");
                $(".J_login_warning1").show();
                arrIndex['flag'] = 1;//flag: 0-?????????1-???????????????
                console.log('??????????????????---',arrIndex);
                $.get('/site/new-login',arrIndex,function(res){
                    // console.log(res);
                    $(".J_login_warning1").text("????????????");
                    $(".J_login_warning1").show();
                    console.log('??????????????????---',res);
                    // $("#login_submit").removeClass("login-loading");
                    if(res.errno==0 && res.data){
                        //????????????,????????????
                        if(!isNaN(res.data) && res.data!=""){
                            saveuser(res.data);
                        }
                        location.reload();
                    }else{
                        $("#login_sms_account").parent().addClass("wor");
                        $("#smscode").parent().addClass("wor");
                        $(".J_login_warning1").text("???????????????????????????");
                        $(".J_login_warning1").show();
                    }
                });
            }
        });
        //????????????
        $("#reg_submit").click(function(){
            var prefix_phone = $("#reg_prefix_phone").attr("data");
            var phone = $("#reg_account").val();
            var code = $("#reg_smscode").val();
            var tab = true;
            var arrIndex = {};
            if(phone==""){
                $("#reg_account").parent().addClass("wor");
                $(".J_login_warning2").text("?????????????????????");
                $(".J_login_warning2").show();
                tab = false;
                return false;
            }else{
                phone = valimobile(phone,prefix_phone);
                if(phone==""){
                    $("#reg_account").parent().addClass("wor");
                    $(".J_login_warning2").text("?????????????????????");
                    $(".J_login_warning2").show();
                    tab = false;
                    return false;
                }else{
                    arrIndex['mobile_areacode'] = prefix_phone;
                    arrIndex['mobile'] = phone;
                }
            }
            if(code==""){
                $("#reg_smscode").parent().addClass("wor");
                $(".J_login_warning2").text("?????????????????????");
                $(".J_login_warning2").show();
                tab = false;
                return false;
            }else{
                arrIndex['code'] = code;
            }
            if(!$("#xy").hasClass("act")){
                $(".J_login_warning2").text("?????????????????????????????????????????????????????????");
                $(".J_login_warning2").show();
                tab = false;
                return false;
            }
            if(tab){
                $(".J_login_warning2").text("???????????????...");
                $(".J_login_warning2").show();
                console.log('??????????????????------',arrIndex);
                $.get('/video/register', arrIndex, function(res) {
                    console.log('????????????------',res);
                    if(res.errno==0){
                        //????????????,????????????
                        $(".J_login_warning2").text("????????????");
                        $(".J_login_warning2").show();
                        if(!isNaN(res.data) && res.data!=""){
                            saveuser(res.data);
                        }
                        location.reload();
                    }else{
                        var mes = "";
                        if(res.data!=''){
                            mes = res.error;
                        }else{
                            mes = '????????????';
                        }
                        $("#reg_account").parent().addClass("wor");
                        $("#reg_smscode").parent().addClass("wor");
                        $(".J_login_warning2").text(mes);
                        $(".J_login_warning2").show();
                    }
                });
            }
        });
        //????????????-??????
        $("#logout").click(function(){
            $.get('/site/logout', {}, function(res) {
                console.log(res);
                if(res.errno==0){
                    $("#login_id").val("");
                    $("#notloggedin").show();
                    $("#loggedin").hide();
                    removeuser();
                    location.reload();
                }
            });
            return false;
        });
        $("#loggedin").click(function(){
            window.location.href="/video/personal";
            return false;
        });
    });
    function removetab(tab){
        var arr = {};
        if(tab=='watchlog'){//????????????????????????
            arr ['logid'] = 'all';
            $.get('/video/remove-watchlog',arr,function(res){
                if(res.errno==0){
                    $("#LSmenuBox_div").find("ul.LSmenu").remove();
                    $("#LSmenuBox_div").find("div.LSmenu-No").remove();
                    $("#LSmenuBox_div").prepend("<div class='LSmenu-No'>????????????</div>");
                    $("#LSmenuBox_div .LSmenuBottom").hide();
                    $("#pop-tip").text("????????????????????????");
                    $("#pop-tip").show().delay(1500).fadeOut();
                }else{
                    $("#pop-tip").text("????????????????????????");
                    $("#pop-tip").show().delay(1500).fadeOut();
                }
            });
        }else if(tab=='favorite'){//??????????????????/????????????
            arr ['videoid'] = 'all';
            $.get('/video/change-favorite', arr,function(res){
                if(res.errno==0 && res.data.status==0){
                    $("#XX-tabBox-favorite").find("ul").remove();
                    $("#XX-tabBox-favorite").prepend("<div class='LSmenu-No'>????????????</div>");
                    $("#XX-tabBox-favorite .LSmenuBottom").hide();
                    $("#pop-tip").text("??????????????????");
                    $("#pop-tip").show().delay(1500).fadeOut();
                }else{
                    $("#pop-tip").text("??????????????????");
                    $("#pop-tip").show().delay(1500).fadeOut();
                }
            });
        }else if(tab=='message'){//????????????
            arr['id'] = 'all';
            arr['type'] = 'message';
            $.get('/video/remove-message', arr,function(res){
                if(res.errno==0 && res.data>0){
                    $("#XX-tabBox-message").find("a.XX-a").remove();
                    $("#XX-tabBox-message").find("div.LSmenu-No").remove();
                    $("#XX-tabBox-message").prepend("<div class='LSmenu-No'>????????????</div>");
                    $("#XX-tabBox-message .LSmenuBottom").hide();
                    $(".alt-title").text("??????????????????");
                    $("#alt05").show();
                }else{
                    $(".alt-title").text("??????????????????");
                    $("#alt05").show();
                }
            });
        }
    }
    function showMoney(){
        var obj = $(".alt02-bdr.act").find("li");
        var flag = obj.eq(1).text().replace(/[0-9|\\.]/ig,"");
        var money = parseFloat(obj.eq(1).text().replace(flag,""));
        var delmoney = parseFloat(obj.eq(2).find("del").text().replace(flag,""));
        var money2 = parseFloat((delmoney - money).toFixed(2));
        $(".J_money").text(obj.eq(1).text());
        $(".J_money2").text(flag+money2);
    }

    function makeCode(){
        $("p.J_qrcode_shadow").text("?????????...");
        $(".J_qrcode_shadow").show();
        var obj = $(".alt02-bdr.act").find("li");
        var flag = obj.eq(1).text().replace(/[0-9|\\.]/ig,"");
        var money = parseFloat(obj.eq(1).text().replace(flag,""));
        var type = $(".alt02-tabA .tabA .J_type").val();
        var goodsId = $(".alt02-bdr.act").attr("data-id");

        var ar = {};
        ar['WIDsubject'] = obj.eq(0).text();
        ar['WIDtotal_fee'] = money;
        ar['type'] = type;
        ar['goodsId'] = goodsId;
        $.ajax({
            url: '/video/create-order',
            data: ar,
            type:'get',
            cache:false,
            dataType:'json',
            success:function(res) {
                if(res.data.code==1){
                    qrcode.makeCode(unescape(res.data.qrcode));
                    $(".J_qrcode_shadow").hide();
                }else{
                    var mes = "";
                    if(res.data.msg && res.data.msg!= ""  && res.data.msg!="undefined"){
                        mes = res.data.msg;
                    }else{
                        mes = '????????????';
                    }
                    $("p.J_qrcode_shadow").text(mes);
                }
            },
            error : function() {
                console.log("?????????????????????");
                $("p.J_qrcode_shadow").text("????????????,???????????????");
            }
        });
    }

    //??????vip
    var vip_end = parseInt('<?=$data['vip']['end_time']?>');
    function vipinfo(){
        time1 = setInterval(function (){
            $.ajax({
                url: '/video/vip-info',
                data: {},
                type:'get',
                cache:false,
                dataType:'json',
                success:function(res) {
                    // console.log(res);
                    if(res.errno==0 && res.data.end_time > vip_end){
                        vip_end = res.data.end_time;
                        clearInterval(time1);
                        $(".J_desc").text(res.data.desc);
                        $("#pop-tip").text("????????????");
                        $("#pop-tip").show();
                        setTimeout(function (){
                            $("#alt02").hide();
                            $("#pop-tip").hide();
                        },1500);
                    }
                },
                error : function() {
                    console.log("vip????????????");
                }
            });
        },1000);
    }

</script>
