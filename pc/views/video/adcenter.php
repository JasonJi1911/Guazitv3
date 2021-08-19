<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

NewIndexStyleAsset::register($this);
?>
<style>
    .ADbzhidden{display:none;}
</style>
<!--广告中心标题-->
<div class="RANbox-title AD">
    <div class="RANbox-title-icon"> <img src="/images/newindex/ADicon_10.png" /> </div>
    <div class="RANbox-title-name"> —— 广告中心 —— </div>
    <ul class="RANbox-tab">
        <li class="act">广告介绍</li>
        <li>广告设计</li>
        <li class="ADjsq id_calculator" >价格计算器</li>
        <li>付款方式</li>
        <li class="id_adterms">服务条款</li>
        <li>常见问题</li>
        <li style="display: none;">黑名单</li>
    </ul>
    <ul class="ADcurrency">
        <li>选择货币：</li>
        <li>
            <input class="act" type="button" id="" value="€" />
        </li>
        <li>
            <input type="button" id="" value="$" />
        </li>
        <li>
            <input type="button" id="" value="¥" />
        </li>
    </ul>
</div>
<div class="RANbox ADbox">

    <!--广告介绍-->
    <div class="RANbox-box02 act">
        <!--右侧锚点导航-->
        <div class="AD-navR" name="zt">
            <a class="act" href="#ADjf">计费广告</a>
            <a href="#ADym">页面广告</a>
        </div>
        <!--计费广告-->
        <div class="AD-title" id="ADjf">
            <div class="AD-title-01" name="zt"> <img src="/images/newindex/ADicon-01.png" />计费广告 </div>
            <div class="AD-title-02"> 根据展示率和点击率收费，用户每一次点击广告都能产生实际效益，保证每分钱都花在刀刃上！ </div>
        </div>
        <ul class="AD-ul01">
            <li><img src="/images/newindex/ADimg-01.png" /></li>
            <li>
                <div class="AD-text01" name="zt"> PI：短视频广告 </div>
                <p class="AD-p01"> 展示方式：视频每播放10-20分钟随机插播1个20秒的短视频广告（VIP可过滤，使用金币可跳过) </p>
                <p class="AD-p01"> 扣费方式：详细计费方式，请联系客服 </p>
                <div class="AD-text02"> 广告特点： </div>
                <ul class="AD-text03" name="zt">
                    <li>视频相比图片更直观、视觉冲击力更强</li>
                    <li>投放量可控，广告商自行设定每日播放次数（最低10000次）</li>
                    <li>可随时暂停投放，灵活机动</li>
                    <li>广告精确推送到指定人群，不花冤枉钱</li>
                    <li>余额不足可随时按需充值（首次充值800欧元起）</li>
                </ul>
                <p class="AD-p01">支持设备：PC、Mac、iPad、手机</p>
                <div class="AD-bth-box">
                    <input class="bth-l c_calculator " type="button" id="" value=" 价格计算器 " />
                    <input class="bth-r" type="button" id="" value="  立即预定  " />
                </div>
            </li>
            <li>
                <div class="AD-list">
                    <div class="top" name="zt"> 常见问题 </div>
                    <ul class="bow" name="zt">
                        <li>
                            <a href="#">如何充值余额？</a>
                        </li>
                        <li>
                            <a href="#">需要给账户充值多少金额？</a>
                        </li>
                        <li>
                            <a href="#">能否设置每天展示次数？</a>
                        </li>
                        <li>
                            <a href="#">中途能否暂停投放？</a>
                        </li>
                        <li>
                            <a href="#">广告视频由我自己提供？还是你们会帮我制作？</a>
                        </li>
                        <li>
                            <a href="#">我自己提供视频的话，要提供什么规格的？</a>
                        </li>
                        <li>
                            <a href="#">能否指定一天中某一个时间段播放？</a>
                        </li>
                        <li>
                            <a href="#">能否投放到特定人群？比如只针对女性，或者只针对学生？</a>
                        </li>
                        <li>
                            <a href="#">能否指定投放某一个城市？</a>
                        </li>
                        <li>
                            <a href="#">能否指定投放到某一类视频？</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <ul class="AD-ul01">
            <li><img src="/images/newindex/ADimg-02.png" /></li>
            <li>
                <div class="AD-text01" name="zt"> PZ：暂停广告 </div>
                <p class="AD-p01"> 展示方式：视频播放时用户点击暂停出现图片广告（VIP可过滤） </p>
                <p class="AD-p01"> 扣费方式：详细计费方式，请联系客服 </p>
                <div class="AD-text02"> 广告特点： </div>
                <ul class="AD-text03" name="zt">
                    <li>投放量可控，广告商自行设定每日播放次数（最低20000次）</li>
                    <li>可随时暂停投放，灵活机动</li>
                    <li>广告精确推送到指定人群，不花冤枉钱</li>
                    <li>余额不足可随时按需充值（首次充值800欧元起）</li>
                </ul>
                <p class="AD-p01">支持设备：PC、Mac、iPad（仅APP）、手机（仅APP）</p>
                <div class="AD-bth-box">
                    <input class="bth-l c_calculator " type="button" id="" value=" 价格计算器 " />
                    <input class="bth-r" type="button" id="" value="  立即预定  " />
                </div>
            </li>
            <li>
                <div class="AD-list">
                    <div class="top" name="zt"> 常见问题 </div>
                    <ul class="bow" name="zt">
                        <li>
                            <a href="#">如何充值余额？</a>
                        </li>
                        <li>
                            <a href="#">需要给账户充值多少金额？</a>
                        </li>
                        <li>
                            <a href="#">能否设置每天展示次数？</a>
                        </li>
                        <li>
                            <a href="#">中途能否暂停投放？</a>
                        </li>
                        <li>
                            <a href="#">广告视频由我自己提供？还是你们会帮我制作？</a>
                        </li>
                        <li>
                            <a href="#">我自己提供视频的话，要提供什么规格的？</a>
                        </li>
                        <li>
                            <a href="#">能否指定一天中某一个时间段播放？</a>
                        </li>
                        <li>
                            <a href="#">能否投放到特定人群？比如只针对女性，或者只针对学生？</a>
                        </li>
                        <li>
                            <a href="#">能否指定投放某一个城市？</a>
                        </li>
                        <li>
                            <a href="#">能否指定投放到某一类视频？</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <!--页面广告-->
        <div class="AD-title mt-80" id="ADym">
            <div class="AD-title-01" name="zt"> <img src="/images/newindex/ADicon-02.png" />页面广告 </div>
            <div class="AD-title-02"> 页面广告按月或按天收取固定价格。一次性投放3个月优惠10%，一次性投放6个月优惠20%。 </div>
        </div>
        <ul class="AD-ul02">
            <li><img src="/images/newindex/ADimg-03.png" /></li>
            <li>
                <div class="AD-text01" name="zt"> IS：主页幻灯广告 </div>
                <p class="AD-p01"> 第一幅出现，停留10秒 </p>
                <p class="AD-p01"> 支持设备：PC、Mac、iPad、手机 </p>
                <div class="AD-bth">
                    <input class="bth-r" type="button" id="" value="  立即预定  " />
                </div>
            </li>
            <li>
                <table class="AD-table01" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>地区</th>
                        <th>美国</th>
                        <th>加拿大</th>
                        <th>英国</th>
                        <th>意大利</th>
                        <th>马来西亚</th>
                        <th>德国</th>
                        <th>法国</th>
                        <th>西班牙</th>
                        <th>日本</th>
                        <th>澳洲</th>
                        <th>全球(其它)</th>
                    </tr>
                    <tr>
                        <td><span>5</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>10</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>15</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                </table>
            </li>
        </ul>
        <ul class="AD-ul03">
            <li>
                <div class="AD-text01" name="zt"> MT：启动APP/移动版网站开屏广告 </div>
                <p class="AD-p01"> 支持设备：iPhone、iPad、安卓手机 </p>
                <div class="AD-bth">
                    <input class="bth-r" type="button" id="" value="  立即预定  " />
                </div>
            </li>
            <li><img src="/images/newindex/ADimg-04.png" /></li>
            <li>
                <table class="AD-table01" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>地区</th>
                        <th>美国</th>
                        <th>加拿大</th>
                        <th>英国</th>
                        <th>意大利</th>
                        <th>马来西亚</th>
                        <th>德国</th>
                        <th>法国</th>
                        <th>西班牙</th>
                        <th>日本</th>
                        <th>澳洲</th>
                        <th>全球(其它)</th>
                    </tr>
                    <tr>
                        <td><span>5</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>10</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>15</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                </table>
            </li>
        </ul>
        <ul class="AD-ul02">
            <li><img src="/images/newindex/ADimg-05.png" /></li>
            <li>
                <div class="AD-text01" name="zt"> MPB：APP/移动版视频播放页底部横幅 </div>
                <p class="AD-p01"> 支持设备：iPhone、iPad、安卓手机 </p>
                <div class="AD-bth">
                    <input class="bth-r" type="button" id="" value="  立即预定  " />
                </div>
            </li>
            <li>
                <table class="AD-table01" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>地区</th>
                        <th>美国</th>
                        <th>加拿大</th>
                        <th>英国</th>
                        <th>意大利</th>
                        <th>马来西亚</th>
                        <th>德国</th>
                        <th>法国</th>
                        <th>西班牙</th>
                        <th>日本</th>
                        <th>澳洲</th>
                        <th>全球(其它)</th>
                    </tr>
                    <tr>
                        <td><span>5</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>10</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>15</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                </table>
            </li>
        </ul>
        <ul class="AD-ul03">
            <li>
                <div class="AD-text01" name="zt"> FB：APP/移动版弹窗广告 </div>
                <p class="AD-p01"> 支持设备：iPhone、iPad、安卓手机 </p>
                <div class="AD-bth">
                    <input class="bth-r" type="button" id="" value="  立即预定  " />
                </div>
            </li>
            <li><img src="/images/newindex/ADimg-06.png" /></li>
            <li>
                <table class="AD-table01" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>地区</th>
                        <th>美国</th>
                        <th>加拿大</th>
                        <th>英国</th>
                        <th>意大利</th>
                        <th>马来西亚</th>
                        <th>德国</th>
                        <th>法国</th>
                        <th>西班牙</th>
                        <th>日本</th>
                        <th>澳洲</th>
                        <th>全球(其它)</th>
                    </tr>
                    <tr>
                        <td><span>5</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>10</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>15</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                </table>
            </li>
        </ul>
        <ul class="AD-ul02">
            <li><img src="/images/newindex/ADimg-07.png" /></li>
            <li>
                <div class="AD-text01" name="zt"> PR：电脑版视频播放页右侧海报 </div>
                <p class="AD-p01"> 支持设备：PC、MAC </p>
                <div class="AD-bth">
                    <input class="bth-r" type="button" id="" value="  立即预定  " />
                </div>
            </li>
            <li>
                <table class="AD-table01" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>地区</th>
                        <th>美国</th>
                        <th>加拿大</th>
                        <th>英国</th>
                        <th>意大利</th>
                        <th>马来西亚</th>
                        <th>德国</th>
                        <th>法国</th>
                        <th>西班牙</th>
                        <th>日本</th>
                        <th>澳洲</th>
                        <th>全球(其它)</th>
                    </tr>
                    <tr>
                        <td><span>5</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>10</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>15</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                </table>
            </li>
        </ul>
        <ul class="AD-ul03">
            <li>
                <div class="AD-text01" name="zt"> PB：电脑版视频播放页横幅 </div>
                <p class="AD-p01"> 支持设备：PC、MAC </p>
                <div class="AD-bth">
                    <input class="bth-r" type="button" id="" value="  立即预定  " />
                </div>
            </li>
            <li><img src="/images/newindex/ADimg-08.png" /></li>
            <li>
                <table class="AD-table01" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>地区</th>
                        <th>美国</th>
                        <th>加拿大</th>
                        <th>英国</th>
                        <th>意大利</th>
                        <th>马来西亚</th>
                        <th>德国</th>
                        <th>法国</th>
                        <th>西班牙</th>
                        <th>日本</th>
                        <th>澳洲</th>
                        <th>全球(其它)</th>
                    </tr>
                    <tr>
                        <td><span>5</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>10</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>15</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                </table>
            </li>
        </ul>
        <ul class="AD-ul02">
            <li><img src="/images/newindex/ADimg-09.png" /></li>
            <li>
                <div class="AD-text01" name="zt"> SS：筛选框右侧海报 </div>
                <p class="AD-p01"> 搜索页和列表页筛选框右侧展示广告 </p>
                <p class="AD-p01"> 支持设备：PC、MAC </p>
                <div class="AD-bth">
                    <input class="bth-r" type="button" id="" value="  立即预定  " />
                </div>
            </li>
            <li>
                <table class="AD-table01" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>地区</th>
                        <th>美国</th>
                        <th>加拿大</th>
                        <th>英国</th>
                        <th>意大利</th>
                        <th>马来西亚</th>
                        <th>德国</th>
                        <th>法国</th>
                        <th>西班牙</th>
                        <th>日本</th>
                        <th>澳洲</th>
                        <th>全球(其它)</th>
                    </tr>
                    <tr>
                        <td><span>5</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>10</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>15</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                </table>
            </li>
        </ul>
        <ul class="AD-ul03">
            <li>
                <div class="AD-text01" name="zt"> DL：登录框左侧海报 </div>
                <p class="AD-p01"> 支持设备：PC、MAC </p>
                <div class="AD-bth">
                    <input class="bth-r" type="button" id="" value="  立即预定  " />
                </div>
            </li>
            <li><img src="/images/newindex/ADimg-10.png" /></li>
            <li>
                <table class="AD-table01" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>地区</th>
                        <th>美国</th>
                        <th>加拿大</th>
                        <th>英国</th>
                        <th>意大利</th>
                        <th>马来西亚</th>
                        <th>德国</th>
                        <th>法国</th>
                        <th>西班牙</th>
                        <th>日本</th>
                        <th>澳洲</th>
                        <th>全球(其它)</th>
                    </tr>
                    <tr>
                        <td><span>5</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>10</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                    <tr>
                        <td><span>15</span><span>天</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                        <td><span>€</span><span>2,500</span></td>
                    </tr>
                </table>
            </li>
        </ul>
    </div>

    <!--广告设计-->
    <div class="RANbox-box02">
        <div class="AD-text01" name="zt">
            <img src="/images/newindex/ADicon-04.png" />广告设计规格表
        </div>

        <table class="AD-table02" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th scope="col"> 分类 </th>
                <th scope="col"> 广告图种类 </th>
                <th scope="col"> 广告位编号 </th>
                <th scope="col"> 支持设备 </th>
                <th scope="col"> 尺寸(像素) </th>
                <th scope="col"> 最大容量 </th>
                <th scope="col"> 广告文件格式 </th>
                <th scope="col"> 设计费(欧元) </th>
                <th scope="col"> 备注 </th>
            </tr>
            <tr>
                <th rowspan="2" scope="row"> 计费广告 </th>
                <td> 短视频广告（20秒） </td>
                <td>PI</td>
                <td>全设备</td>
                <td>860*480</td>
                <td>4000KB</td>
                <td>MP4</td>
                <td>200</td>
                <td>
                    必须带音轨，不得静音</br> 不允许使用几副图片切换的幻灯片</br>
                    <a href="#">点击查看安全区</a>
                </td>
            </tr>
            <tr>
                <td>暂停广告</td>
                <td>PZ</td>
                <td>全设备</td>
                <td>640*360</td>
                <td>300KB</td>
                <td>JPG</td>
                <td>100</td>
                <td>-</td>
            </tr>
            <tr>
                <th rowspan="9" scope="row">页面广告</th>
                <td>主页幻灯广告</td>
                <td>IS</td>
                <td>全设备</td>
                <td>1903*666</td>
                <td>500KB</td>
                <td>JPG</td>
                <td>100</td>
                <td>
                    <a href="#">点击查看安全区</a>
                </td>
            </tr>
            <tr>
                <td rowspan="2">启动APP/移动版网站开屏广告</td>
                <td>MT-横屏</td>
                <td rowspan="2">iPhone、iPad、安卓手机</td>
                <td>1680*720</td>
                <td rowspan="2">500KB</td>
                <td rowspan="2">JPG</td>
                <td rowspan="2">100</td>
                <td>
                    <a href="#">点击查看安全区</a>
                </td>
            </tr>
            <tr>
                <td>MT-竖屏</td>
                <td>720*1680</td>
                <td>
                    <a href="#">点击查看安全区</a>
                </td>
            </tr>
            <tr>
                <td>APP/移动版视频播放页底部横幅</td>
                <td>MPB</td>
                <td>iPhone、iPad、安卓手机</td>
                <td>1920*192</td>
                <td>300KB</td>
                <td>JPG</td>
                <td>100</td>
                <td>
                    <a href="#">点击查看安全区</a>
                </td>
            </tr>
            <tr>
                <td>APP/移动版弹窗广告</td>
                <td>FB</td>
                <td>iPhone、iPad、安卓手机</td>
                <td>540*720</td>
                <td>300KB</td>
                <td>JPG</td>
                <td>100</td>
                <td>-</td>
            </tr>
            <tr>
                <td>电脑版视频播放页右侧海报</td>
                <td>PR</td>
                <td>PC、MAC</td>
                <td>379*545</td>
                <td>300KB</td>
                <td>JPG</td>
                <td>100</td>
                <td>-</td>
            </tr>
            <tr>
                <td>电脑版视频播放页横幅</td>
                <td>PB</td>
                <td>PC、MAC</td>
                <td>1364*137</td>
                <td>300KB</td>
                <td>JPG</td>
                <td>100</td>
                <td>-</td>
            </tr>
            <tr>
                <td>筛选框右侧海报</td>
                <td>SS</td>
                <td>PC、MAC</td>
                <td>438*333</td>
                <td>500KB</td>
                <td>JPG</td>
                <td>100</td>
                <td>-</td>
            </tr>
            <tr>
                <td>登录框左侧海报</td>
                <td>DL</td>
                <td>PC、MAC</td>
                <td>380*540</td>
                <td>500KB</td>
                <td>JPG</td>
                <td>100</td>
                <td>-</td>
            </tr>
            <tr>
                <th scope="row">海报</th>
                <td>点击广告后跳转的海报</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>1MB</td>
                <td>JPG</td>
                <td>100</td>
                <td>-</td>
            </tr>
        </table>

        <div class="AD-text01" name="zt">
            <img src="/images/newindex/ADicon-05.png" />广告设计说明
        </div>

        <ul class="AD-ul04" name="zt">
            <li>本站设计广告图一律收取设计费。</li>
            <li>广告内容需由客户自行提供，包括图片、文字资料、广告词、联系方式等，本站不提供广告文案及翻译服务。</li>
            <li>广告内容必须符合广告商户和用户所在国家法律。</li>
            <li>我们不接受以下广告内容：反动、政治、诈骗、病毒、木马、钓鱼、游戏、私服、VPN、视频平台、主播平台、音乐软件、社交网络等，以及任何与平台业务冲突的行业。</li>
            <li>以下行业只能投放在午夜版：成人用品、风俗店、按摩服务、彩票类。</li>
            <li>客户提供的广告链接内容(URL)不得含有挂马、钓鱼；以及上述第3条和第4条所述内容，否则一经发现立即撤除广告，已付款项不予退还。</li>
            <li>设计完成后的广告文件格式为JPG,MP4，点击后链接到顾客指定网站，若顾客没有网站，则需要制作一幅海报。</li>
            <li>广告图设计时间，根据广告内容和尺寸大小，需1至3个工作日不等。</li>
            <li>客户在本站投放广告并已支付设计费的前提下，本站才会开始广告图设计，广告图设计完成并交由客户审核通过后才会正式发布。</li>
            <li>若客户单方面要求终止已经在设计过程中的广告，设计费将不予退还。</li>
            <li>若客户投放视频前置类广告，需由客户自行提供符合要求的MP4视频文件；或提供广告素材，由本站制作成动画并转换成MP4视频。</li>
        </ul>
        <div class="AD-text01" name="zt">
            <img src="/images/newindex/ADicon-06.png" />广告修改
        </div>
        <ul class="AD-ul04" name="zt">
            <li>广告一旦定稿并发布后，客户要求修改文字内容、更换二维码等，均为免费修改，不限次数。</li>
            <li>修改广告总体布局；调整文字风格；更改或移动图片等，则视为重新设计，将收取相应的设计费用。</li>
            <li>若客户自行设计广告图，广告有效期内可随时更换，不限次数。</li>
        </ul>
    </div>

    <!--价格计算器-->
    <div class="RANbox-box02 id_calculator">
        <div class="AD-text06" name="zt">
            价格计算器
        </div>
        <!--报错ul添加class="wrg" 文字可用在li内添加<div class="ADbz">-->
        <ul class="ADjsq-box">
            <li>
                <div class="seekbox02-text" name="zt"> 广告所属行业： </div>
            </li>
            <li>
                <div class="seekbox-ipt seek-bottom">
                    <select class="seek-slk c_blur" name="zt" id="cu_industry">
                        <option value="">请选择</option>
                        <?php if(!empty($data['industry'])) :?>
                            <?php foreach ($data['industry'] as $industry): ?>
                                <option value="<?=$industry['industry_id']?>"><?=$industry['industry_name']?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                </div>
            </li>
            <li>
                <div class="ADbz">
                    请如实选择行业，若行业和广告内容不符将无法通过审核
                </div>
            </li>
        </ul>
        <!--报错ul添加class="wrg" 文字可用在li内添加<div class="ADbz">-->
        <ul class="ADjsq-box">
            <li>
                <div class="seekbox02-text" name="zt"> 广告位： </div>
            </li>
            <li>
                <div class="seekbox-ipt seek-bottom">
                    <select class="seek-slk c_blur" name="zt" id="cu_adtype">
                        <option value="">请选择</option>
                        <option value="PI">PI-短视频广告</option>
                        <option value="PZ">PZ-视频暂停广告</option>
                        <option value="IS">IS-主页幻灯广告</option>
                        <option value="MT">MT-启动APP/移动版网站开屏广告</option>
                        <option value="MPB">MPB-APP/移动版视频播放页底部横幅</option>
                        <option value="PR">PR-电脑版视频播放页右侧海报</option>
                        <option value="PB">PB-电脑版视频播放页横幅</option>
                        <option value="SS">SS-搜索结果页广告</option>
                        <option value="DL">DL-登录页面广告</option>
                    </select>
                </div>
            </li>
            <li>
                <div class="ADbz">
                    <span class="xingH">*</span>
                </div>
            </li>
        </ul>
        <!--报错ul添加class="wrg"-->
        <ul class="ADjsq-box02">
            <li>
                <div class="seekbox02-text" name="zt"> 投放地区：</div>
            </li>
            <li class="upl-btn-list02" name="zt">
                <?php if(!empty($data['country'])) :?>
                    <?php foreach ($data['country'] as $key => $country): ?>
                        <?php if($key<8):?>
                        <input type="button" class="cu_country" value="<?=$country['country_name']?>" />
                        <?php endif;?>
                    <?php endforeach;?>
                <?php endif;?>
                <span>
                    <span class="xingH">*</span>多选
                </span>
            </li>
        </ul>
        <!--报错ul添加class="wrg" 文字可用在li内添加<div class="ADbz">-->
        <ul class="ADjsq-box">
            <li>
                <div class="seekbox02-text" name="zt"> 投放周期： </div>
            </li>
            <li>
                <div class="seekbox-ipt seek-bottom">
                    <select class="seek-slk c_blur" name="zt" id="cu_days">
                        <option value="">请选择</option>
                        <option value="5">5天</option>
                        <option value="7">7天</option>
                        <option value="10">10天</option>
                        <option value="15">15天</option>
                    </select>
                </div>
            </li>
            <li>
                <div class="ADbz">
                    <span class="xingH">*</span>
                </div>
            </li>
        </ul>
        <!--报错ul添加class="wrg" 文字可用在li内添加<div class="ADbz">-->
        <ul class="ADjsq-box">
            <li>
                <div class="seekbox02-text" name="zt"> 是否需要设计广告图/视频？ </div>
            </li>
            <li>
                <div class="seekbox-ipt seek-bottom">
                    <select class="seek-slk c_blur" name="zt" id="cu_adimg">
                        <option value="0">不需要，我自行提供广告图</option>
                        <option value="1">需要</option>
                    </select>
                </div>
            </li>
            <li>
                <div class="ADbz">
                    <span class="xingH">*</span>
                </div>
            </li>
        </ul>
        <!--报错ul添加class="wrg" 文字可用在li内添加<div class="ADbz">-->
        <ul class="ADjsq-box">
            <li>
                <div class="seekbox02-text" name="zt"> 顾客点击广告后，希望能： </div>
            </li>
            <li>
                <div class="seekbox-ipt seek-bottom">
                    <select class="seek-slk c_blur" name="zt" id="cu_url">
                        <option value="1">跳转到我的网站</option>
                        <option value="2">跳转到一副海报，由你们设计</option>
                        <option value="3">跳转到一副海报，我自行提供</option>
                        <option value="0">不跳转</option>
                    </select>
                </div>
            </li>
            <li>
                <div class="ADbz">
                    <span class="xingH">*</span>
                </div>
            </li>
        </ul>
        <div class="ADjsq-box03">
            <div class="AD-bth-box">
                <input class="bth-l" type="button" id="cu_clear" value="清除 ">
                <input class="bth-r" type="button" id="cu_cal" value="计算">
            </div>
        </div>
        <!--计算结果  class 添加act 显示-->
        <div class="ADjsq-box04">
            <h2>您需要支付的全部广告费为：<span>5000欧元或40000人民币或6000美元</span></h2>
            <p>
                备注：欧元兑换人民币汇率按<span>1：8.0</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;欧元兑换美元汇率按<span>1：1.2</span>
            </p>
        </div>
    </div>

    <!--付款方式-->
    <div class="RANbox-box02">

        <div class="AD-box05">
            <div class="AD-text07" name="zt">
                付款方式：
            </div>
            <div class="AD-p02">
                <img src="/images/newindex/ADicon-07.png" />
            </div>
            <div class="AD-text08" name="zt">
                银行转账<br /> (加收5%服务费)
            </div>

            <div class="AD-text07" name="zt">
                计费广告：
            </div>
            <div class="AD-title-03"> 用户需注册成为广告商户，并给账户充值，广告费按流量从账户余额中扣取，首次充值不低于800欧元。 </div>

            <div class="AD-text07" name="zt">
                页面广告：
            </div>
            <div class="AD-title-03"> 广告发布前一次性支付全款，若客户单方要求终止投放，已付款项不予退还 </div>

            <div class="AD-text07" name="zt">
                关于增值税(VAT)：
            </div>
            <div class="AD-title-03"> 注！所有广告价格不包含增值税（VAT），若商户使用银行转账方式付款，必须开具增值税发票并加收5%服务费。 </div>

        </div>

    </div>

    <!--服务条款-->
    <div class="RANbox-box02 id_adterms">
        <div class="AD-title-03">
            广告平台（包括网站、APP等，以下简称“平台”），在此特别提醒您，在成为平台广告商户（以下简称“商户”）之前，请认真阅读本 《广告商户服务条款》（以下简称“协议”），确保您充分理解本协议中各条款。请您审慎阅读并选择接受或不接受本协议。除非您接受本协议所有条款，否则您无权在投放广告、注册、登录广告管理系统或使用本协议所涉广告服务。
        </div>
        <div class="AD-title-03">
            本协议约定平台与商户之间关于在（网站及APP）投放广告的权利义务。商户是指注册、登录、使用本服务的企业或个人。本协议可由平台随时更新，更新后的协议条款一旦公布即代替原来的协议条款，恕不再另行通知，商户可在本网站查阅最新版协议条款。
        </div>
        <div class="AD-title-03">
            在平台修改协议条款后，若商户不接受修改后的条款，请立即停止使用平台提供的广告服务，商户继续使用平台提供的广告服务将被视为接受修改后的协议。
        </div>

        <div class="AD-text09" name="zt">
            双方的权利与义务
        </div>

        <div class="AD-text07" name="zt">
            一、基本：
        </div>

        <div class="AD-box06">

            <div class="AD-title-03">
                1-1.商户在平台投放广告之前，平台默认为商户已仔细查看并了解平台广告业务所有细则：包括广告位价格、形式、投放规则等所有细节；已认真阅读并充分理解此服务条款的各项内容。
            </div>
            <div class="AD-title-03">
                1-2.商户在平台投放的广告不具有唯一性，其它商户均可在平台投放相同类型、相同行业的广告。1-1.商户在平台投放广告之前，平台默认为商户已仔细查看并了解平台广告业务所有细则：包括广告位价格、形式、投放规则等所有细节；已认真阅读并充分理解此服务条款的各项内容。
            </div>
            <div class="AD-title-03">
                1-3.平台不得将商户的私密联系方式、广告图/视频设计原稿、广告投放数据或其它商业机密透露给第三方。
            </div>
        </div>

        <div class="AD-text07" name="zt">
            二、广告位预定：
        </div>

        <div class="AD-box06">

            <div class="AD-title-03">
                2-1.商户预定计费广告，须保证账户内余额不低于800欧元，否则预定无效。
            </div>
            <div class="AD-title-03">
                2-2.商户预定页面广告须保证账户内有充足的余额，并将广告位全款划拨到此广告订单，否则预定无效，平台没有义务为商户保留此广告位。
            </div>
            <div class="AD-title-03">
                2-3.商户预定页面广告位后，如果在广告发布前放弃此广告位，将扣除30%广告费作为违约金，仅退还70%广告费，退还的广告费自动进入账户余额。
            </div>
            <div class="AD-title-03">
                2-4.商户预定某广告位后，平台不得私自变更广告位置、广告形式、投放时间等，若因平台改版等技术性原因不得不变更的，平台须提供等价的广告位作为补偿。
            </div>
        </div>

        <div class="AD-text07" name="zt">
            三、充值和付款：
        </div>

        <div class="AD-box06">

            <div class="AD-title-03">
                3-1.商户给账户充值，首次充值金额不得低于800欧元，之后每次充值不得低于500欧元。
            </div>
            <div class="AD-title-03">
                3-2.账户内余额有效期为6个月，逾期不使用余额将自动清零。
            </div>
            <div class="AD-title-03">
                3-3.商户充值后，商户要求平台将账户余额退还，平台概不受理。
            </div>

            <div class="AD-title-03">
                3-4.商户使用欧元或美元付款，须转账至平台指定的银行账户，因转账双方银行都会产生手续费，商户转账时必须选择：双方银行的手续费都由汇款方承担。
            </div>
            <div class="AD-title-03">
                3-5.若因商户转账时遗漏了手续费、或因汇率问题导致平台没有收到如数的广告费，则商户应通过其它方式补足余额，否则平台将按缺少的金额减少相应的账户余额或广告投放时间。
            </div>
            <div class="AD-title-03">
                3-6.商户使用人民币付款，须转账至平台指定的微信号、支付宝帐号、汇率按欧元兑换人民币汇率1:8结算。
            </div>

            <div class="AD-title-03">
                3-7.若商户使用银行转账方式付款，须汇款至平台指定的公司账户，平台开具欧元或美元发票并加收5%服务费。商户使用人民币付款无法开具任何发票或其它凭证。
            </div>
        </div>

        <div class="AD-text07" name="zt">
            四、广告图的设计与修改：
        </div>

        <div class="AD-box06">

            <div class="AD-title-03">
                4-1.若商户自行提供广告图/视频，则应在广告发布日期前2个工作日及时上传广告图/视频，或发送至平台指定的邮箱，否则因此造成的延误由商户自行承担。
            </div>
            <div class="AD-title-03">
                4-2.商户自行提供的广告图/视频规格必须符合平台的“广告设计规格表”上的规格，否则平台拒绝使用。
            </div>
            <div class="AD-title-03">
                4-3.商户自行提供的广告图/视频须接受平台审核，若广告存在违规内容或制作水平低下，平台有权拒绝使用。
            </div>

            <div class="AD-title-03">
                4-4.商户在平台投放计费广告，须保证账户内余额不低于500欧元并支付设计费的前提下，平台才会提供广告图/视频的设计服务，设计完成并交由商户审核通过后才会正式发布。
            </div>
            <div class="AD-title-03">
                4-5.广告图须由平台工作人员人工发布，或商户登录广告管理系统自行发布（须接受平台审核），不接受引用URL的方式或其它方式发布。
            </div>
            <div class="AD-title-03">
                4-6.若商户委托平台设计广告图/视频，应在广告发布日期之前5个工作日将广告素材发送到平台指定的邮箱，不接受其它方式。广告内容需由商户自行提供，包括文案、图片、LOGO、联系方式、二维码等，平台不提供广告文案撰写及翻译服务。否则因此造成的延误由商户自行承担。
            </div>

            <div class="AD-title-03">
                4-7.商户在平台投放页面广告并已全款支付广告费及设计费的前提下，平台才会提供广告图的设计服务，设计完成并交由商户审核通过后才会正式发布。
            </div>
            <div class="AD-title-03">
                4-8.若商户单方面要求终止已经在设计过程中的广告图/视频，平台不予退还设计费。
            </div>
            <div class="AD-title-03">
                4-9.平台制作图片广告需要2个工作日，制作视频广告需要3个工作日，无法提前完成制作。
            </div>

            <div class="AD-title-03">
                4-10.广告图/视频发布之前，商户可以随时要求平台设计师修改直到满意为止，但如果因为商户的不合理要求造成广告发布延误，将由商户自行承担责任。
            </div>
            <div class="AD-title-03">
                4-11.广告一旦定稿并发布后，商户要求修改广告整体布局、调整字体风格、更换或移动图片等，均视为重新设计，将收取相应的设计费。修改文字内容、更换二维码等，均为免费修改，不限次数。
            </div>
            <div class="AD-title-03">
                4-12.节假日商户要求紧急更换二维码或其他联系方式，须征得美工人员同意加班的前提下，支付 100 欧元/天的加班费。
            </div>

            <div class="AD-title-03">
                4-13.对于商户自行提供的广告图/视频，平台无法修改，也没有修改的义务。
            </div>
            <div class="AD-title-03">
                4-14.由平台设计的广告图/视频，平台享有此广告图/视频的著作版权，未经允许，商户不得在其它网站或媒体使用。
            </div>
        </div>
        <div class="AD-text07" name="zt">
            五、关于广告内容：
        </div>

        <div class="AD-box06">

            <div class="AD-title-03">
                5-1.一个广告订单或广告位只能投放一个业务，不允许投放多个业务，多个广告商不得共用一个广告位。
            </div>

            <div class="AD-title-03">
                5-2.广告及点击广告后跳转的链接（URL）内不得出现：反动、政治、诈骗、病毒、木马、钓鱼、游戏、私服、VPN、视频平台、主播平台、音乐软件、社交网络等，以及任何与平台业务冲突的行业。一经发现立即撤除广告，并冻结商户帐号，所有已付款项不予退还。
            </div>

            <div class="AD-title-03">
                5-3.广告上不得出现有明显抄袭其它广告的行为，包括广告整体布局、广告文案、设计风格、图片等。
            </div>

            <div class="AD-title-03">
                5-4.广告上不得出现“用户优惠”“通过添加打折”等误导用户以为平台与广告商有某种合作的假象。
            </div>

            <div class="AD-title-03">
                5-5.对于复刻/高仿类行业，须加收50%广告费，广告上必须写明“复刻、高仿、定制、高定”等准确描述商品性质的词汇，绝不允许作为正品出售，否则视为诈骗广告，一经发现永久撤除广告。
            </div>

            <div class="AD-title-03">
                5-6.对于棋牌、博彩类行业，须加收50%广告费。
            </div>

            <div class="AD-title-03">
                5-7.广告上不允许使用任何明星、艺人等带有肖像权的图片。
            </div>

            <div class="AD-title-03">
                5-8.对于按摩/会所/成人用品等行业，只能在平台旗下的“午夜版”网站投放广告。
            </div>

            <div class="AD-title-03">
                5-9.若平台发现商户有刻意隐瞒自身行业从而逃避支付额外广告费的行为，商户须在5日内补足差价，并缴纳广告费的30%作为罚金（广告位原价*50%*30%），否则平台有权：1.永久撤除此广告；2.所有已付广告费不予退款；3.永久禁止该商户在平台投放广告；4.将此商户及其业务添加到“广告黑名单”公之于众。
            </div>

            <div class="AD-title-03">
                5-10.若平台用户投诉广告存在欺诈内容，平台在核实后，平台有权：1.永久撤除此广告；2.所有已付广告费不予退款；3.永久禁止该商户在平台投放广告；4.将此商户及其业务添加到“广告黑名单”公之于众。
            </div>

        </div>
        <div class="AD-text07" name="zt">
            六、广告发布：
        </div>

        <div class="AD-box06">

            <div class="AD-title-03">
                6-1.广告发布后，商户可登录广告管理系统更换广告图/视频（须接受平台审核），或者向平台提供新的广告图/视频要求更换，不限次数，平台须在2个工作日内完成更换。
            </div>

            <div class="AD-title-03">
                6-2.广告发布后，商户要求更改位置和投放时间，平台概不受理请求。
            </div>

            <div class="AD-title-03">
                6-3.广告发布后，商户要求平台临时性撤除广告并择日再发布，广告撤除期间损失的广告投放时间由商户自行承担，平台没有义务为商户补充时间。在此期间平台不得将广告位租赁给第三方。
            </div>

            <div class="AD-title-03">
                6-4.广告发布后，商户单方面要求终止投放广告，商户所有已付款项将不予退还。
            </div>

            <div class="AD-title-03">
                6-5.若商户认为广告效益不佳，要求平台退还广告费或提供其它补偿，平台概不受理。
            </div>

        </div>
        <div class="AD-text07" name="zt">
            七、广告续费：
        </div>

        <div class="AD-box06">

            <div class="AD-title-03">
                7-1.平台拥有对广告业务的最终解释权，若广告到期后，有任何广告位形式或价格的变动，平台没有对商户先行通知的义务。
            </div>

            <div class="AD-title-03">
                7-2.除非商户购买了某个广告位的“优先续费权”，否则平台没有义务为商户保留此广告位，广告到期之前其它商户可随时预定此广告位。若广告到期之前商户没有及时续费，则“优先续费权”自动失效。
            </div>

            <div class="AD-title-03">
                7-3.“优先续费权”的价格为广告订单价格的30%，广告发布后，商户无法再追加购买“优先续费权”。
            </div>
        </div>
        <div class="AD-text07" name="zt">
            八、责任免除：
        </div>

        <div class="AD-box06">

            <div class="AD-title-03">
                8-1.因战争、自然灾害、政府行政管制等不可抗力因素导致平台长期无法正常访问，平台不承担任何法律上和其它方式的责任，平台退还商户剩余广告投放时间的70%广告费，本协议自动终止。
            </div>

            <div class="AD-title-03">
                8-2.因互联网灾难、网络运营商故障、平台服务器故障、平台遭受网络攻击等原因导致平台暂时性无法正常访问，平台不承担任何法律上和其它方式的责任，但必须按故障时长同等延长商户的广告投放时长。
            </div>

            <div class="AD-title-03">
                8-3.对于计费广告，商户设定的展示量和实际展示量存在10%以内的误差属于正常现象。若因不可抗力因素（留学生考试、华人回国高峰期、演唱会、大型体育赛事等）导致差异超出10%，平台不承担任何法律上和其它方式的责任。
            </div>

            <div class="AD-title-03">
                8-4.因浏览器广告过滤插件、手机过滤广告APP等原因造成商户广告无法正常显示，平台不承担任何法律上和其它方式的责任。
            </div>

            <div class="AD-title-03">
                8-5.对于商户和平台用户进行交易而产生的纠纷，平台不承担任何责任，也没有义务帮助调解。
            </div>
        </div>

        <div class="AD-time" name="zt">
            2018.6.25
        </div>

    </div>

    <!--常见问题-->
    <div class="RANbox-box02">

        <div class="AD-text07" name="zt">
            前期咨询
        </div>
        <div class="AD-box06">
            <ul class="AD-text10" name="zt"  name="zt">
                <li>1.你们的访问量有多少？</li>
                <li>截至2019年1月1日，本站访问量已达到每日10,000,000PV（点击量），800,000个IP，6,000,000访客。</li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li>2.哪个广告位效果最好？</li>
                <li>
                    价格最高的效果肯定最好。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 3.哪个广告位性价比最高？</li>
                <li>
                    我们的广告位都是根据广告效果来定价的，效果越好的价格自然越高，不存在某个位置性价比特别高的情况。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 4.哪个位置既便宜效果又好？</li>
                <li>
                    广告效果和您投入的广告费永远是成正比的，您只花了1000欧元的广告费，那就不可能得到2000欧元的效果。又想马儿跑又想马儿不吃草是不可能的。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li>5.计费广告很不错，但是VIP会员可过滤，我很纠结。 </li>
                <li>
                    VIP会员只占我们全部用户数的0.5%，您完全可忽略此问题。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 6.计费广告可以设置每天展示多少次吗？</li>
                <li>
                    可以，您可在广告管理后台设置。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 7.计费广告中途可暂停投放吗？</li>
                <li>
                    可以，您在广告管理后台将展示率设置为0即可。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 8.计费广告能否指定一天中某一个时间段播放？</li>
                <li>
                    无法指定时间段，广告是随机分配到24小时的，白天低峰期播的少，晚上高峰期播的多。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 9.计费广告能否指定特定的人群播放？比如只针对女性，或者只针对学生等等？</li>
                <li>
                    暂时不支持按人群投放。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 10.计费广告能否指定投放某一个城市？</li>
                <li>
                    只能按国家投放，无法精确到城市。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 11.计费广告能否指定投放到某一类视频？</li>
                <li>
                    不能，默认投放全部视频。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 12.短视频广告为什么有时候是插播，有时候是前置播放？</li>
                <li>
                    电脑版网站、电脑版客户端、手机APP是插播；移动版网站是前置。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 13.我投了计费广告，设置每天展示1万次，为什么我自己总是看不到广告？</li>
                <li>
                    系统每地区每天的广告展示量至少有20万次，设置1万次，广告出现几率仅为5%。而且每天1万次是系统允许的最低展示量，效果非常有限。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 14.我投了计费广告，但是出现几率太低了，我自己经常看不到，我担心用户也看不到，怎么办？</li>
                <li>
                    您登录广告管理系统，看到展示数和点击量产生，表示有如数的用户看到了广告，说明已经产生广告效益了。您自己看不到不代表其它用户看不到，您纠结的是为什么平台不是无时无刻在播放您的广告。您每天只投放了一点点费用，却要求平台给予无限制播放并期望每次都能看到您的广告，这个世界不存在这种事的。铁一般的定律：广告效果永远是和您投入的广告费成正比的。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 15.我设置了每天展示XXXXX次，为什么系统中显示没有达到？</li>
                <li>
                    展示率受客观条件影响较大，例如留学生考试、华人回国高峰期、演唱会、大型体育赛事等等，都会影响系统的播放量，偶尔达不到属于正常现象。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 16.计费广告能否只按展示次数收费，不要按点击收费？</li>
                <li>
                    点击收费是为了保证广告产生实际的效益，精确投放到指定人群，商户不花冤枉钱。用户点击表示对广告有兴趣，希望了解详细内容，说明此广告产生了效益，产生效益后，平台合理收取费用。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 17.计费广告能否只按点击收费，不要按展示次数收费？</li>
                <li>
                    您想的是尽量让用户扫广告中的二维码，最好不要去点广告，这样就不产生费用了。您能想到的我们都能想到，我们不会留下这种漏洞让人钻的。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 18.其它视频网站可以只按点击收费，为什么你们不行？</li>
                <li>
                    其它视频网站比如YouTube、爱奇艺等，都有竞价机制，由广告商自己设定每次点击扣费金额，设定金额越高广告播放的几率也越高，某些行业投放的广告较多，竞争比较激烈，每次点击费用可能高达几美元一次！我们还是希望以更实惠的方式让商户投放广告，难道您希望我们也改成那样吗？
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 19.我投了计费广告，如果有人不停恶意点击怎么办？</li>
                <li>
                    每台设备（手机、ipad、电脑等）1小时内不管点击多少次，平台都只记录1次点击，所以有人不停恶意点击也不会产生费用。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 20.系统中显示我的广告每天有XXX人点击，我如何证实？</li>
                <li>
                    如果广告点击后是跳转您的网站，只需登录网站后台查看访问量和点击量是否一致，如果是跳转到海报，海报上留有微信二维码，每天有没有人加您总知道吧？
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 21.为什么系统的点击量和我网站后台的不符？</li>
                <li>
                    可能是算法不同，平台用户每天重复点击几次就算几次（1小时内重复点不算），您的网站可能只算1次。或者您的网站记录的是IP，而不是点击。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 22.短视频广告可以使用图片吗？</li>
                <li>
                    不允许使用图片，视频必须严格按
                    <a href="#">《广告设计规格表》</a> 的规格提供。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 23.暂停广告可以使用视频吗？</li>
                <li>
                    无法使用视频，图片必须严格按
                    <a href="#">《广告设计规格表》</a> 的规格提供。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 24.投放计费广告，需要给账户充值多少金额？</li>
                <li>
                    首次充值不低于800欧元，之后可充值任意金额，余额不足可随时追加充值。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 25.我投了某个广告位，每天会有多少人点击？</li>
                <li>
                    不同行业、不同的广告文案、不同的广告设计，都会造成广告导入量的巨大差异，完全无法预测。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 26.我可以看到我的广告位每天有多少人点击吗？</li>
                <li>
                    可以，请使用您的帐号登录我们的广告管理系统即可。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 27.我先做一个最便宜的广告位，如果效果不错，再做个大的，可以吗？</li>
                <li>
                    当然可以，但是你也说了是最便宜的广告位，那就不应该期望有多大的效果。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 28.我对你们的广告效果没有信心，能否先免费试一个月吗？觉得好我马上预定长期的！</li>
                <li>
                    假如有个人去肯德基对店员说："我对你们的炸鸡是否好吃没有信心，能否先给我免费尝一个，觉得好我马上买个全家桶！"，大家一定会觉得他有病，你说对嘛？
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 29.广告位太贵了，价格还可以商量吗？</li>
                <li>
                    网站页面有限，广告位寸土寸金，当你在讨价还价的时候，别人甚至愿意出双倍价格来抢占，请问我们有什么理由要把广告位便宜卖给你？我们不会坐地起价，也不接受任何形式的讨价还价。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 30.你们给我设计的广告图/视频，我能在其它网站上使用吗？</li>
                <li>
                    对于我们设计的广告，我方拥有广告图/视频的著作版权，不允许在其它任何渠道使用。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 31.我的业务是针对国内市场的，可以投放广告吗？</li>
                <li>
                    本站用户全都是海外华人，国内的访问量为零，投了也没有任何效果。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 32.我投放了广告后，你们能答应不接我同行或我竞争对手的广告吗？</li>
                <li>
                    您的竞争对手也是客户，所有客户我们一视同仁。如果不想竞争对手来做，唯一的办法是把全部广告位租下来。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li>33.我付多少钱你们可以把我竞争对手的广告撤除？ </li>
                <li>
                    多少钱都不够，这不是钱的问题。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 34.你们是不是骗子？会不会收了钱不给我登广告？</li>
                <li>
                    能问出这种问题来，说明你早已经轮不到我们来骗了。
                </li>
            </ul>

            <div class="AD-text07" name="zt">
                广告内容相关问题
            </div>
            <ul class="AD-text10" name="zt" >
                <li>1.不管什么内容的广告都可以登吗？ </li>
                <li>
                    我们不接受以下广告内容：反动、政治、诈骗、病毒、木马、钓鱼、游戏、私服、VPN、视频平台、主播平台、音乐软件、社交网络等，以及任何与平台业务冲突的行业。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 2.我的广告图上不会出现你们禁止的内容，但是点击广告后跳转的网站或海报里可以有吗？</li>
                <li>
                    任何环节都不允许出现禁止内容。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 3.我是做按摩业/会所/成人用品这类行业的，可以投放广告吗？</li>
                <li>
                    可以，但是必须投放在成人版块。正常版块不得出现任何成人内容。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 4.我是做高仿/复刻之类的业务，可以投放广告吗？</li>
                <li>
                    可以，此类行业须加收50%广告费，广告上必须写明“复刻、高仿、定制、高定”等准确描述商品性质的词汇，绝不允许作为正品出售，否则视为诈骗广告，一经发现永久撤除广告。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 5.如果我违反了以上规定，你们如何惩罚？</li>
                <li>
                    若我们发现您有刻意隐瞒自身行业从而逃避支付额外50%广告费的行为，您须在5日内补足差价，并缴纳广告费的30%（广告位原价*50%*30%）作为罚金，否则平台有权：1.永久撤除此广告；2.所有已付广告费不予退款；3.永久禁止该商户在平台投放广告；4.将此商户及其业务添加到“广告黑名单”公之于众。
                </li>
            </ul>

            <div class="AD-text07" name="zt">
                预定和付款
            </div>

            <ul class="AD-text10" name="zt" >
                <li> 1.我看中了某个广告位，你们能先帮我保留吗？过几日我再付款，或者有人想订这个位置，你们能马上通知我吗？</li>
                <li>
                    我们只有收到广告费全款才能保证您预定此广告位，否则我们没有义务为您保留，其他人要预定，我们也不会通知。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 2.预定广告位，需要支付多少预付款？</li>
                <li>
                    预定计费广告，须保证账户内余额不低于800欧元，否则预定无效。预定页面广告需要支付全款，如果在广告发布前客户放弃此广告位，将扣除30%广告费作为违约金，仅退还70%广告费。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 3.我可以在年初预定下半年或明后年的广告吗？</li>
                <li>
                    您可预定即日起6个月之内的任何广告位。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 4.我想预定半年的广告，但是我想按月付款可以吗？</li>
                <li>
                    必须支付全款，不支持按月付款模式。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 5.页面广告一定要按月投放吗？可以按天投放吗？</li>
                <li>
                    IS、MT可按天投放并且至少5天起做，其它页面广告都必须按一至三个月投放。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 6.我看预定三个月页面广告可以优惠10%，半年广告可以优惠20%，如果我按月付款，还能有这个优惠吗？</li>
                <li>
                    必须支付全款，不支持按月付款模式。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li>7.能否先发布我的广告，事后我再付款？ </li>
                <li>
                    除非我们收到全款，否则没有任何可能性会先发布广告。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 8.我预定了某个广告位后还能改位置吗？</li>
                <li>
                    预定了就不能更换，所以预定时请务必先想好。如果一定要更换我们只能当做退款处理，将扣除30%广告费作为违约金。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 9.我的广告已发布，还能改位置吗？</li>
                <li>
                    广告一旦发布就不能再更改到其它位置，也不能退款。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 10.使用银行转账付款，转账手续费由哪方承担？</li>
                <li>
                    国际转账的付款方银行和收款方银行都会产生手续费，客户转账时必须选择：承担双方银行的手续费
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 11.我可以使用人民币付款吗？你们以什么汇率结算？</li>
                <li>
                    可以，欧元兑换人民币汇率按1:8结算。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 12.你们接受哪些人民币付款方式？</li>
                <li>
                    我们接受支付宝和微信收款。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 13.现在欧元兑换人民币汇率不到8，为什么你们还按8结算？</li>
                <li>
                    我们系统中有成百上千个广告客户，为了便于管理，不可能每个客户都按当天汇率来结算，只能统一取一个固定整数值。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 14.你们的汇率不合理，能按当天汇率结算吗？</li>
                <li>
                    我们不会与客户协商汇率问题，如不接受，请使用欧元付款。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 15.投放广告之前你们会跟我签订一份合同吗？</li>
                <li>
                    您投放广告必须无条件遵守我们的<a href="#"></a>，此条款等同于合约，我们不提供任何书面形式的合约。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 16.你们能开发票吗？</li>
                <li>
                    可以开具欧元和美元发票，客户须提供公司名称、地址、税号，按照我方提供的Proforma Invoice（账单）汇款至我方公司账户，产生的增值税（VAT）由客户自行承担。人民币付款无法开具发票。
                </li>
            </ul>

            <div class="AD-text07" name="zt">
                广告设计相关问题
            </div>

            <ul class="AD-text10" name="zt" >
                <li>1.我投放广告，你们会帮忙设计吗？ </li>
                <li>
                    我们设计广告的费用是：JPG或GIF广告图100欧元，MP4视频广告200欧元，点击广告跳转的海报100欧元。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 2.我可以自行设计广告吗？</li>
                <li>
                    可以，必须符合我们的“广告设计规格表”上的规格。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 3.我提供几幅图片，你们帮我合成GIF动画，需要付费吗？</li>
                <li>
                    美工人员帮您合成GIF动画，需要调整图片尺寸、时间轴等，工作量等同于设计，所以也需收取设计费。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 4.如果交由你们设计广告，我需要提供什么资料呢？</li>
                <li>
                    需要提供广告词、联系方式、LOGO、产品图片、二维码等。请将所有资料发到我们指定的邮箱：<span>ads@ifsp.tv</span>
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 5.你们能帮我想想广告词，或者帮我找找产品图片吗？</li>
                <li>
                    我们不提供广告文案服务，我们作为非专业人士，完全不了解您的行业和产品，无法帮您想广告文案。而且您要是连自己的产品图片都没有，如何开店做生意呢？
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 6.我手头只有外语的广告资料，你们能帮忙翻译成中文吗？</li>
                <li>
                    我们不接手任何翻译工作，请找当地的专业翻译，或者去万能的淘宝。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 7.广告字数/图片多少有限制吗？</li>
                <li>
                    没限制，但是用户的耐心是极度有限的，用户的眼睛只会在广告上停留1-2秒，您的长篇大论没有任何人会去看的，您应该做的是如何让他在1-2秒内看完广告、产生兴趣然后点击广告，详细内容可放在点击后的链接或海报内。所以内容越多=浏览时间越长=广告效果越差。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 8.广告需要多久才能设计好？</li>
                <li>
                    图片广告需要2个工作日，视频广告需要3个工作日，无法提前完成。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 9.顾客点击广告后，可以跳转到我自己的网站吗？</li>
                <li>
                    当然可以，这是最基本的功能。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 10.我没有网站，点击广告后应该链接到哪里？</li>
                <li>
                    您可以制作一副海报，海报上写更详细的内容，点击广告后跳转到海报上即可，海报设计费为100欧元/次。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 11.可以使用引用URL的方式来发布广告图吗？</li>
                <li>
                    处于安全考虑，不支持这种方式，必须将广告图通过邮件形式发给我们，由我们人工发布。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 12.一个广告位可以放多个业务吗？</li>
                <li>
                    一个广告位/订单仅允许投放一个业务。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 13.我跟我朋友可以共用一个广告位吗，每次打开网站能显示不同的广告吗？</li>
                <li>
                    一个广告位/订单仅允许一个广告商使用。不允许多人共用一个广告位。
                </li>
            </ul>

            <div class="AD-text07" name="zt">
                修改广告
            </div>

            <ul class="AD-text10" name="zt" >
                <li>1.我将广告图交由你们设计，广告发布后，我可以要求修改广告内容吗？ </li>
                <li>
                    广告发布之前，您可以随时要求设计师修改直到您满意为止，但如果因为客户的不合理要求造成广告发布延误，将由客户自行承担责任。广告一旦定稿并发布后，修改广告总体布局、调整字体风格、更换或移动图片等，均视为重新设计，将收取相应的设计费。修改文字内容、更换二维码等，均为免费修改，不限次数。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 2.如果是节假日，要求紧急更换微信号或二维码等，美工人员会帮忙修改吗？</li>
                <li>
                    美工人员节假日加班费为100欧元/天，在征得美工人员同意，并支付加班费的前提下，可以修改。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 3.如果是我自己设计的广告图，可以随时更换吗？</li>
                <li>
                    您可以随时登录广告管理系统自行更换（须接受平台审核）。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 4.我自己或我朋友帮忙设计的广告图，你们可以修改吗？</li>
                <li>
                    第三方提供的广告图我们无法修改
                </li>
            </ul>

            <div class="AD-text07" name="zt">
                广告到期续费
            </div>

            <ul class="AD-text10" name="zt" >
                <li> 1.我的广告到期后，我享有优先续费的权力吗？</li>
                <li>
                    没有，除非你购买了"广告位优先续费权"。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 2.什么是优先续费权？</li>
                <li>
                    这是我们为避免客户因争抢广告位而产生纠纷，推出的一项服务。拥有优先续费权，你可以：<br /> *此广告位只有您可以续费
                    <br /> *其它客户无法提前预定您的广告位
                    <br /> *除非您主动放弃，或者广告到期后您没有及时续费，否则此广告位永远属于您！
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 3.我没有优先续费权，我就不能续费了吗？</li>
                <li>
                    不是，没有优先续费权，可能你的广告还没到期，下一轮的就已经被人预定了，到时你如何能续费呢？假如一直都没人预定你的广告位，当然也可以续费了。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 4.什么情况下我需要购买优先续费权？</li>
                <li>
                    1.您觉得某个广告位非常有价值，不想被其他人抢走<br /> 2.您不确定到期后是否要续费，但又不想丢失此广告位
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li>5.购买优先续费权的价格是多少？ </li>
                <li>
                    优先续费权的价格为广告位价格的30%
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 6.我当下不想购买优先续费权，今后可以再补吗？</li>
                <li>
                    理论上您的广告可能才刚刚发布不久，下一轮的就被人预定了，此时再补优先续费权已经没有意义了。
                </li>
            </ul>

            <div class="AD-text07" name="zt">
                其它问题
            </div>

            <ul class="AD-text10" name="zt" >
                <li>1.我使用XX浏览器，发现页面上的广告都被屏蔽了，怎么办？ </li>
                <li>
                    所有网站对这个问题都很头疼，其它网站也同样没办法。需要明白一点，你的广告是不可能推送到所有人的，90%的人能看到广告就行了，剩下那10%，谁都没办法。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li>2.我投了很贵的广告位，为什么却没效果？ </li>
                <li>
                    您可以登录广告管理系统查看广告的点击量，假如点击量很低，可能是文案或广告图设计有问题；如果点击量很高效果却很差，可能您的业务或产品本身有问题。例如您租了一个人流量很大的店面，却没人进来买东西，可能是门面或装潢出了问题；进来的人多买的却少，那可能是您的商品本身就有问题，比如商品不够吸引人、定价过高、质量差等等原因。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 3.投放广告有赠送VIP帐号吗？</li>
                <li>
                    从2017年开始，不再赠送VIP帐号
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li>4.我发现网站上的广告存在欺诈内容，如何举报？ </li>
                <li>
                    可以向我们的广告微信客服举报，我们在核实后将会撤除广告。
                </li>
            </ul>
            <ul class="AD-text10" name="zt" >
                <li> 5.我被网站上的欺诈广告骗了，你们负责赔偿吗？</li>
                <li>
                    我们核实其欺诈行为后会撤除广告，但对于用户和广告商之间进行交易而产生的纠纷，我们不承担任何责任，也没有义务帮助调解。
                </li>
            </ul>

        </div>
    </div>

    <!--黑名单-->
    <div class="RANbox-box02" style="display:none;">
        <table class="AD-table03" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>Header</th>
                <th>Header</th>
                <th>Header</th>
                <th>Header</th>
                <th>Header</th>
            </tr>
            <tr>
                <td>Data</td>
                <td>Data</td>
                <td>Data</td>
                <td>Data</td>
                <td>Data</td>
            </tr>
        </table>
    </div>
</div>
<div class="AD-bow">
    <div> <img src="/images/newindex/ADkefu.png" /> </div>
    <div class="AD-text05"> 更多问题请咨询微信客服 <img src="/images/newindex/ADicon-03.png" /> </div>
    <div> <img src="/images/newindex/ewm02.jpg" /> </div>
</div>

<!--广告商户信息登记-->
<div class="alt" id="alt08">
    <div class="alt-box07">
        <div class="alt-content02" name="zt">
            <div class="AD-text01" name="zt"> 注册成为广告商户 </div>
            <div class="seekbox02-text02" name="zt"> <span>为了您能顺利投放广告，以及我们能更好的为您服务，请如实填写以下信息：</span> </div>
            <ul class="hexa">
                <!--错误提示  给li附class="wrg" 文字可用在li内添加<div class="ADbz"> -->
                <li>
                    <div class="seekbox02-text" name="zt"> 您是公司还是个人 </div>
                    <div class="seekbox-ipt seek-bottom">
                        <select class="seek-slk" name="zt" id="v_type">
                            <option value="个人">个人</option>
                            <option value="公司">公司</option>
                        </select>
                    </div>
                </li>
                <!--错误提示  给li附class="wrg" 文字可用在li内添加<div class="ADbz"> -->
                <li>
                    <div class="seekbox02-text" name="zt"> 联系人姓名 </div>
                    <div class="seekbox-ipt seek-bottom">
                        <input class="c_blur" type="text" name="zt" id="v_realname" placeholder="联系人姓名" value="">
                    </div>
                    <div class="ADbz ADbzhidden"> 请填写联系人姓名 </div>
                </li>
                <!--错误提示  给li附class="wrg" 文字可用在li内添加<div class="ADbz"> -->
                <li>
                    <div class="seekbox02-text" name="zt"> 手机号 </div>
                    <div class="seekbox-ipt seek-bottom">
                        <input class="c_blur" type="text" name="zt" id="v_telephone" placeholder="联系手机号" value="">
                    </div>
                    <div class="ADbz ADbzhidden"> 请填写手机号 </div>
                </li>
            </ul>
            <ul class="hexb">
                <!--错误提示  给li附class="wrg" 文字可用在li内添加<div class="ADbz"> -->
                <li>
                    <div class="seekbox02-text" name="zt"> 所在国家 </div>
                    <div class="seekbox-ipt seek-bottom">
                        <select class="seek-slk c_blur" name="zt" id="v_country">
                            <option value="">请选择</option>
                            <?php if(!empty($data['country'])) :?>
                                <?php foreach ($data['country'] as $country): ?>
                                    <option value="<?=$country['country_id']?>"><?=$country['country_name']?></option>
                                <?php endforeach;?>
                            <?php endif;?>
                        </select>
                    </div>
                    <div class="ADbz ADbzhidden"> 请选择国家 </div>
                </li>
                <!--错误提示  给li附class="wrg" 文字可用在li内添加<div class="ADbz"> -->
                <li class="">
                    <div class="seekbox02-text" name="zt"> 详细地址 </div>
                    <div class="seekbox-ipt seek-bottom">
                        <input class="c_blur" type="text" name="zt" id="v_address" placeholder="输入详细地址" value="">
                    </div>
                    <div class="ADbz ADbzhidden"> 请填写详细地址 </div>
                </li>
            </ul>
            <ul class="hexc">
                <!--错误提示  给li附class="wrg" 文字可用在li内添加<div class="ADbz"> -->
                <li>
                    <div class="seekbox02-text" name="zt"> 所属行业 </div>
                    <div class="seekbox-ipt seek-bottom">
                        <select class="seek-slk c_blur" name="zt" id="v_industry">
                            <option value="">请选择</option>
                            <?php if(!empty($data['industry'])) :?>
                                <?php foreach ($data['industry'] as $industry): ?>
                                    <option value="<?=$industry['industry_id']?>"><?=$industry['industry_name']?></option>
                                <?php endforeach;?>
                            <?php endif;?>
                        </select>
                    </div>
                    <div class="ADbz ADbzhidden"> 请如实选择行业，若行业和广告内容不符，将无法通过审核 </div>
                </li>
                <!--错误提示  给li附class="wrg" 文字可用在li内添加<div class="ADbz"> -->
                <li class="">
                    <div class="seekbox02-text" name="zt"> 微信号 </div>
                    <div class="seekbox-ipt seek-bottom">
                        <input class="c_blur" type="text" name="zt" id="v_wechatNO" placeholder="输入微信号" value="">
                    </div>
                    <div class="ADbz ADbzhidden"> 请填写微信号 </div>
                </li>
                <!--错误提示  给li附class="wrg" 文字可用在li内添加<div class="ADbz"> -->
                <li>
                    <div class="seekbox02-text" name="zt"> 邮箱 </div>
                    <div class="seekbox-ipt seek-bottom">
                        <input class="c_blur" type="text" name="zt" id="v_email" placeholder="输入邮箱" value="">
                    </div>
                    <div class="ADbz ADbzhidden"> 邮箱用于接收系统邮件，邮箱必须真实有效 </div>
                </li>
            </ul>
            <div class="ADS-xieyi">
                <input type="checkbox" checked="checked" name="ADS-xieyi" id="ADS-xieyi" value="" />
                <label class="ADS act" for="ADS-xieyi"></label>
                <a href="javascript:void(0);" id="v_adterms">我已阅读并同意《广告商户服务条款》</a>
            </div>
            <div class="alt-bth-box02" name="zt">
                <!--这里的按钮最多两个    多余的可删除   隐藏-->
                <input class="bth-on" type="button" id="v_submit" value="注册成为广告商户" />
            </div>
            <!--关闭按钮-->
            <input class="alt-GB" type="button" id="" value="" />
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    //广告介绍-价格计算器跳转
    $(".c_calculator").click(function(){
        $("#alt08").hide();
        $(".ADbzhidden").removeClass("ADbzhidden");
        $(".id_calculator").addClass("act").siblings().removeClass("act");
        $('html,body').animate({
            scrollTop: $(".RANbox-tab").offset()
        })
    });
    //广告介绍-服务条款跳转
    $("#v_adterms").click(function(){
        $("#alt08").hide();
        $(".ADbzhidden").removeClass("ADbzhidden");
        $(".id_adterms").addClass("act").siblings().removeClass("act");
    });
    //广告介绍-立即预定-暂时注册，具体流程待定
    $("ul .bth-r").click(function() {
        $("#alt08").show();
    });
    //广告介绍-提交注册
    $("#v_submit").click(function(){
        var tab = true;
        var ar = {};
        var type = $("#v_type").val();
        var realname = $("#v_realname").val();
        var telephone = $("#v_telephone").val();
        var country = $("#v_country").val();
        var address = $("#v_address").val();
        var industry = $("#v_industry").val();
        var wechatNO = $("#v_wechatNO").val();
        var email = $("#v_email").val();

        ar['type'] = type;
        if(realname == ""){
            tab = false;
            showwrg("v_realname",true);
        }else{
            ar['realname'] = realname;
        }
        if(telephone == "" || isNaN(telephone)){
            tab = false;
            showwrg("v_telephone",true);
        }else{
            ar['telephone'] = telephone;
        }
        if(country == ""){
            tab = false;
            showwrg("v_country",true);
        }else{
            ar['country'] = country;
        }
        if(address == ""){
            tab = false;
            showwrg("v_address",true);
        }else{
            ar['address'] = address;
        }
        if(industry == ""){
            tab = false;
            showwrg("v_industry",true);
        }else{
            ar['industry'] = industry;
        }
        if(wechatNO == ""){
            tab = false;
            showwrg("v_wechatNO",true);
        }else{
            ar['wechatNO'] = wechatNO;
        }
        if(email == ""){
            tab = false;
            showwrg("v_email",true);
        }else{
            ar['email'] = email;
        }
        var ADSxieyi = $("#ADS-xieyi").prop("checked")
        if(!ADSxieyi){
            alert("请阅读并同意《广告商户服务条款》");
        }
        if(tab){
            console.log(ar);
            $.get("/video/save-adcenter",ar,function(res){
                if(res.errno == "0") {
                    console.log(res.data);
                    alert("注册成功");
                    $("#v_type").find("option").eq(0).prop("selected",true);
                    $("#v_realname").val("");
                    $("#v_telephone").val("");
                    $("#v_country").find("option").eq(0).prop("selected",true);
                    $("#v_address").val("");
                    $("#v_industry").find("option").eq(0).prop("selected",true);
                    $("#v_wechatNO").val("");
                    $("#v_email").val("");
                    $("#alt08").hide();
                }else{
                    alert("注册失败");
                }
            });
        }
    });
    //广告介绍-注册信息检验
    $(".c_blur").blur(function(){
        if($(this).val()==""){
            showwrg($(this).attr("id"),true);
        }else{
            hiddenwrg($(this).attr("id"),true);
        }
    });
    //价格计算器-计算
    $("#cu_cal").click(function(){
        var tab = true;
        var cu_industry = $("#cu_industry").val();
        var cu_adtype = $("#cu_adtype").val();
        var cu_days = $("#cu_days").val();
        var cu_adimg = $("#cu_adimg").val();
        var cu_url = $("#cu_url").val();
        var cu_countrys = "";
        $(".cu_country").each(function(){
            if($(this).hasClass("act")){
                cu_countrys = $(this).val()+",";
            }
        });
        if(cu_industry==""){
            tab = false;
            showwrg("cu_industry",false);
        }else{
            hiddenwrg("cu_industry",false);
        }
        if(cu_adtype==""){
            tab = false;
            showwrg("cu_adtype",false);
        }else{
            hiddenwrg("cu_adtype",false);
        }
        if(cu_countrys.length>0){
            cu_countrys = cu_countrys.substring(0,cu_countrys.length-1);
            $(".cu_country").parent().parent().removeClass("wrg");
        }else{
            tab = false;
            $(".cu_country").parent().parent().addClass("wrg");
        }
        if(cu_days==""){
            tab = false;
            showwrg("cu_days",false);
        }else{
            hiddenwrg("cu_days",false);
        }
        if(cu_adimg==""){
            tab = false;
            showwrg("cu_adimg",false);
        }else{
            hiddenwrg("cu_adimg",false);
        }
        if(cu_url==""){
            tab = false;
            showwrg("cu_url",false);
        }else{
            hiddenwrg("cu_url",false);
        }
        if(tab){
            //计算公式 待定
            $(".ADjsq-box04").addClass("act");
        }
    });
    //价格计算器-清除
    $("#cu_clear").click(function(){
        $("#cu_industry").find("option").eq(0).prop("selected",true);
        $("#cu_adtype").find("option").eq(0).prop("selected",true);
        $(".cu_country").removeClass("act")
        $("#cu_days").find("option").eq(0).prop("selected",true);
        $("#cu_adimg").find("option").eq(0).prop("selected",true);
        $("#cu_url").find("option").eq(0).prop("selected",true);
        $(".id_calculator").find(".wrg").removeClass("wrg");
        $(".ADjsq-box04").removeClass("act");
    });

    $(".cu_country").click(function() {
        $(this).toggleClass("act");
    });
});
function showwrg(id,type){
    $("#"+id).parent().parent().addClass("wrg");
    if(type){
        $("#"+id).parent().parent().find(".ADbz").removeClass("ADbzhidden");
    }
}
function hiddenwrg(id,type){
    $("#"+id).parent().parent().removeClass("wrg");
    if(type){
        $("#"+id).parent().parent().find(".ADbz").addClass("ADbzhidden");
    }
}
</script>
