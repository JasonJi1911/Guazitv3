<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

NewIndexStyleAsset::register($this);
?>
<style>
    body {
        background-color: #F9F9F9;
    }
    .more-load{
        color:#888;
        height:40px;
        line-height:40px;
        text-align:center;
        font-size:14px;
    }
</style>
<script>
//首次加载
$(document).ready(function() {
    var tab = '<?=$ptab?>';
    if(tab=='watchlog'){
        $('.c_watchlog').addClass('act');
    }else if(tab=='message'){
        $('.c_message').addClass('act');
    }else if(tab=='favorite'){
        $('.c_favorite').addClass('act');
    }else if(tab=='task'){
        $('.c_task').addClass('act');
    }else if(tab=='upload'){
        $('.c_upload').addClass('act');
    }else if(tab=='relation'){
        $('.c_relation').addClass('act');
    }else{//c_question
        $('.c_upload').addClass('act');
    }
});
</script>
<div class="per-box">
    <!--头部样式-->
    <div class="per-top">
        <!--个人信息-->
        <div class="per-xx">
            <!--头像-->
            <div class="per-h">
                <a href="javascript:;">
                    <img src="/images/newindex/logon.png" />
                </a>
                <!--会员标识-->
                <img class="per-h-vip" src="/images/newindex/VIP-1.png" />
            </div>
            <!--个人信息-->
            <div class="per-j">
                <!--第一行-->
                <div class="per-j-01">
                    <h4 class="per-name"><?=$data['user']['nickname']?></h4>
                    <div class="per-xb">
                        <?php if($data['user']['gender'] == 2):?>
                            <img src="/images/newindex/nan.png" />
                        <?php elseif ($data['user']['gender'] == 1):?>
                            <img src="/images/newindex/nv.png" />
                        <?php endif;?>
                    </div>
                    <div class="per-dj">
                        <img src="/images/newindex/lv_1.png" />
                    </div>
                    <!--<div class="per-dz">
                        <img src="/images/newindex/hlp-dz-w.png" />
                        <span class="per-d">澳大利亚</span>
                    </div>
                    <a class="per-bj" href="javascript:;">编辑</a>-->
                </div>
                <!--第二行-->
                <div class="per-j-02">
                    <div class="per-jb">
                        <img src="/images/newindex/jinbi.png" />
                        <span>0</span>
                    </div>
                    <!--<div class="per-jy">
                        <img src="/images/newindex/shangsheng.png" />
                        <div class="per-jy-box">
                            <div class="per-jy-jd">
                                &nbsp;
                            </div>
                        </div>
                        <div class="per-jyz">
                            <span>585</span>/<span>880</span>
                        </div>
                    </div>-->
                </div>
                <!--第三行  个性签名
                <div class="per-qm">
                    <input type="text" name=""  placeholder="点击此处添加个性签名" value="" />
                </div>-->
            </div>
        </div>
        <!--前往个人主页-->
        <div class="per-zy">
            <a href="<?= Url::to(['/video/other-home'])?>">前往个人主页</a>
        </div>

        <!--tab切换-->
        <ul class="per-tab">
            <li class="c_task" data-value="task">首页</li>
            <li class="c_upload" data-value="uploadvideo">视频</li>
            <li class="c_relation" data-value="relation">关注</li>
            <li class="c_message" data-value="comment">消息</li>
            <li class="c_favorite" data-value="favorite">收藏夹</li>
            <li class="c_watchlog" data-value="watchlog">播放记录</li>
            <li><a href="<?= Url::to(['/video/seek'])?>">求片</a></li>
            <li><a href="javascript:;">安全设置</a></li>
        </ul>
    </div>

    <div class="per-tab-w">
        <!--tab 首页 -->
        <div class="per-tab-box c_task" name="zt">
            <div class="per-vip">
                <!--首页第一行-->
                <div class="per-vip-box01" name="zt">
                    <div class="per-vip-box01-dj" name="zt">
                        <!--会员标识-->
                        <img src="/images/newindex/VIP-1.png" />
                        <span><span>黄金</span>VIP</span>
                    </div>
                    <div class="per-vip-box01-day">
                        <div class="per-vip-box01-day-l">
                            VIP剩余 <span>25</span> 天
                        </div>
                        <div class="per-vip-box01-day-r" name="zt">
                            <span>2021-08-15</span> 到期
                        </div>
                    </div>
                    <div class="per-vip-box01-gg" name="zt">
                        已为您过滤了<span>9</span>条广告
                    </div>
                    <a class="per-vip-t9" href="javascript:;"><img src="/images/newindex/9tq.png" /></a>
                    <a class="per-vip-btn" href="javascript:;">立即续费</a>
                    <a class="per-vip-btn" href="javascript:;">前往VIP中心</a>
                </div>
                <!--首页第2行-->
                <?php if($task['task_menu']):?>
                    <?php foreach ($task['task_menu'] as $tasklist):?>
                        <?php if($tasklist['task_title']=='日常任务'):?>
                            <div class="per-vip-box02" name="zt">
                                <img class="per-mrrw-icon" src="/images/newindex/mrrw.png" />
                                <div class="per-vip-box02-l" name="zt">
                                    <div class="per-vip-box02-l-01">
                                        已完成任务
                                    </div>
                                    <div class="per-vip-box02-l-02">
                                        9 次
                                    </div>
                                    <div class="per-vip-box02-l-03">
                                        累积获得
                                        <img src="/images/newindex/jinbi.png" />
                                        <span><?=$task['info']['score']?></span>
                                    </div>
                                </div>
                                <div class="per-vip-box02-r">
                                    <?php foreach ($tasklist['task_list'] as $t):?>
                                        <div class="per-vip-box02-r-box">
                                            <div class="per-vip-box02-r-box-01">
                                                <img src="<?=$t['task_icon']?>" />
                                            </div>
                                            <div class="per-vip-box02-r-box-02" name="zt">
                                                <?=$t['task_label']?>
                                            </div>
                                            <div class="per-vip-box02-r-box-03" name="zt">
                                                <div>
                                                    <img src="/images/newindex/jinbi.png" /> +
                                                    <span><?=$t['task_award']?></span>
                                                </div>
                                                <!--<div>
                                                    <img src="/images/newindex/shangsheng.png" /> +
                                                    <span>3</span>
                                                </div>-->
                                            </div>
                                            <div class="per-vip-box02-r-box-04">
                                                <a class="per-btn-on act" href="javascript:;">待完成</a>
                                                <a class="per-btn-off" href="javascript:;" style="display: none;">已完成</a>
                                            </div>
                                        </div>
                                    <?php endforeach;?>
                                    <!--
                                    <div class="per-vip-box02-r-box">
                                        <div class="per-vip-box02-r-box-01">
                                            <img src="/images/newindex/qiandao-01.png" />
                                        </div>
                                        <div class="per-vip-box02-r-box-02" name="zt">
                                            每日签到
                                        </div>
                                        <div class="per-vip-box02-r-box-03" name="zt">
                                            <div>
                                                <img src="/images/newindex/jinbi.png" /> +
                                                <span>3</span>
                                            </div>
                                            <div>
                                                <img src="/images/newindex/shangsheng.png" /> +
                                                <span>3</span>
                                            </div>
                                        </div>
                                        <div class="per-vip-box02-r-box-04">
                                            <a class="per-btn-on" href="javascript:;">待签到</a>
                                            <a class="per-btn-off" href="javascript:;" style="display: none;">已签到</a>
                                        </div>
                                    </div>
                                    <div class="per-vip-box02-r-box">
                                        <div class="per-vip-box02-r-box-01">
                                            <img src="/images/newindex/fenxiang.png" />
                                        </div>
                                        <div class="per-vip-box02-r-box-02" name="zt">
                                            分享视频给好友
                                        </div>
                                        <div class="per-vip-box02-r-box-03" name="zt">
                                            <div>
                                                <img src="/images/newindex/jinbi.png" /> +
                                                <span>3</span>
                                            </div>
                                            <div>
                                                <img src="/images/newindex/shangsheng.png" /> +
                                                <span>3</span>
                                            </div>
                                        </div>
                                        <div class="per-vip-box02-r-box-04">
                                            <a class="per-btn-on" href="javascript:;" style="display: none;">待完成</a>
                                            <a class="per-btn-off" href="javascript:;">已完成</a>
                                        </div>
                                    </div>
                                    <div class="per-vip-box02-r-box">
                                        <div class="per-vip-box02-r-box-01">
                                            <img src="/images/newindex/shangchuan.png" />
                                        </div>
                                        <div class="per-vip-box02-r-box-02" name="zt">
                                            上传视频并通过审核
                                        </div>
                                        <div class="per-vip-box02-r-box-03" name="zt">
                                            <div>
                                                <img src="/images/newindex/jinbi.png" /> +
                                                <span>3</span>
                                            </div>
                                            <div>
                                                <img src="/images/newindex/shangsheng.png" /> +
                                                <span>3</span>
                                            </div>
                                        </div>
                                        <div class="per-vip-box02-r-box-04">
                                            <a class="per-btn-on act" href="javascript:;">待完成</a>
                                            <a class="per-btn-off" href="javascript:;" style="display: none;">已完成</a>
                                        </div>
                                    </div>
                                    -->
                                </div>
                            </div>
                        <?php elseif($tasklist['task_title']=='新手任务') : ?>
                            <!--首页第3行-->
                            <div class="per-vip-box03" name="zt">
                                <img class="per-mrrw-icon" src="/images/newindex/xsrw.png" />
                                <h4 class="per-vip-box03-top" name="zt">
                                    <span class="per-vip-box03-top-kua">&nbsp;</span>
                                    完成新手任务，最高可获得约<span>3000</span>金币
                                    <span class="per-vip-box03-top-kua">&nbsp;</span>
                                </h4>
                                <ul class="per-rwlist">
                                    <li>
                                        <?php foreach($tasklist['task_list'] as $i=>$t):?>
                                            <?php if($i%2==1):?>
                                            <div class="per-rwlist-h">
                                                <div class="per-rwlist-h-l" name="zt">
                                                    <?=$t['task_label']?>
                                                </div>
                                                <div class="per-rwlist-h-r">
                                                    <div class="per-rwlist-h-r-01" name="zt">
                                                        <div>
                                                            <img src="/images/newindex/jinbi.png"> +
                                                            <span><?=$t['task_award']?></span>
                                                        </div>
                                                        <!--<div>
                                                            <img src="/images/newindex/shangsheng.png"> +
                                                            <span>50</span>
                                                        </div>-->
                                                    </div>
                                                    <div class="per-rwlist-h-r-02">
                                                        <a class="per-btn-on act" href="javascript:;">去完成</a>
                                                        <a class="per-btn-off" href="javascript:;" style="display: none;">已完成</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        <?php endforeach;?>
                                    </li>
                                    <li name="zt">&nbsp;</li>
                                    <li>
                                        <?php foreach($tasklist['task_list'] as $i=>$t):?>
                                            <?php if($i%2==0):?>
                                                <div class="per-rwlist-h">
                                                    <div class="per-rwlist-h-l" name="zt">
                                                        <?=$t['task_label']?>
                                                    </div>
                                                    <div class="per-rwlist-h-r">
                                                        <div class="per-rwlist-h-r-01" name="zt">
                                                            <div>
                                                                <img src="/images/newindex/jinbi.png"> +
                                                                <span><?=$t['task_award']?></span>
                                                            </div>
                                                            <!--<div>
                                                                <img src="/images/newindex/shangsheng.png"> +
                                                                <span>10</span>
                                                            </div>-->
                                                        </div>
                                                        <div class="per-rwlist-h-r-02">
                                                            <a class="per-btn-on act" href="javascript:;">去完成</a>
                                                            <a class="per-btn-off" href="javascript:;" style="display: none;">已完成</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach;?>
                                    </li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php endforeach;?>
                <?php endif; ?>
            </div>
        </div>

        <!--tab 视频-->
        <div class="per-tab-box c_upload" name="zt">
            <!-- 头部导航 -->
            <div class="per-sp-box">
                <ul class="per-tab02" name="zt">
                    <li class="act">剧集</li>
                    <li>视频</li>
                </ul>
                <!-- 排序 -->
                <div class="per-slt">
                    <div class="per-slt-name" name="zt">
                        <input type="button" name=""  value="最近上传" />
                    </div>
                    <div class="per-slt-list" name="zt">
                        <input class="act" type="button" name=""  value="最近上传" />
                        <input type="button" name=""  value="人气最高" />
                        <input type="button" name=""  value="点赞最多" />
                        <input type="button" name=""  value="点踩最多" />
                    </div>
                </div>
                <!-- 视频类型 -->
                <div class="per-slt">
                    <div class="per-slt-name" name="zt">
                        <input type="button" name=""  value="全部" />
                    </div>
                    <div class="per-slt-list" name="zt">
                        <input class="act" type="button" name=""  value="全部" />
                        <input type="button" name=""  value="转码中" />
                        <input type="button" name=""  value="审核中" />
                        <input type="button" name=""  value="已发布" />
                        <input type="button" name=""  value="错误" />
                        <input type="button" name=""  value="上传中" />
                    </div>
                </div>
                <!-- 搜索 -->
                <div class="per-ss" name="zt">
                    <input type="text" name=""  value="" placeholder="搜索" />
                    <input type="button"  value="" />
                </div>
                <!-- 上传视频 -->
                <div class="per-btn" name="zt" style="display:none;">
                    <a href="javascript:;"><img src="/images/newindex/SC02.png" />上传视频</a>
                    <div class="VIPmenuTop" name="zt">
                        &nbsp;
                    </div>
                    <ul class="FLmenuBox" name="zt">
                        <li class="FLmenuBox-li">
                            <a href="javascript:;">
                                <div class="FLmenuBox-liImg">
                                    <img src="/images/newindex/Sdianying.png" />
                                </div>
                                <div class="FLmenuBox-liText">
                                    上传视频
                                </div>
                            </a>
                        </li>
                        <li class="FLmenuBox-li">
                            <a href="javascript:;">
                                <div class="FLmenuBox-liImg">
                                    <img src="/images/newindex/Sjuji.png" />
                                </div>
                                <div class="FLmenuBox-liText">
                                    上传剧集
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="per-tab-w02">
                <!-- 剧集列表 -->
                <div class="per-tab-box02 act">
                    <h4 class="per-zw" name="zt" >
                        暂无内容
                    </h4>
                    <!--
                    <div class="RANbox-list01" name="zt">
                        <ul class="RANbox-list-xx per-img">
                            <li>
                                <a href="play.html"><img src="/images/newindex/test-03.jpg" /></a>
                            </li>
                            <li>
                                <div class="RANbox-list01-t">
                                    <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>
                                    <div class="GNbox-type" name="zt">
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                    </div>
                                </div>
                                <div class="RANbox-list01-b">
                                    <div>
                                        更新:<span>测试更新文字内容</span> 状态:
                                        <span>发布中</span>
                                    </div>
                                    <div class="per-mtop">
                                        上传:<span>2021年06月28日</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="RANbox-list01-sj per-img">
                            <ul class="SSjgPJ">
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                            </ul>
                        </div>
                        <div class="per-btn-tow" name="zt">
                            <a href="javascript:;">编辑</a>
                            <input type="button" name=""  value="删除" />
                        </div>
                    </div>
                    <div class="RANbox-list01" name="zt">
                        <ul class="RANbox-list-xx per-img">
                            <li>
                                <a href="play.html"><img src="/images/newindex/test-03.jpg" /></a>
                            </li>
                            <li>
                                <div class="RANbox-list01-t">
                                    <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>
                                    <div class="GNbox-type" name="zt">
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                    </div>
                                </div>
                                <div class="RANbox-list01-b">
                                    <div>
                                        更新:<span>测试更新文字内容</span> 状态:
                                        <span>发布中</span>
                                    </div>
                                    <div class="per-mtop">
                                        上传:<span>2021年06月28日</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="RANbox-list01-sj per-img">
                            <ul class="SSjgPJ">
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                            </ul>
                        </div>
                        <div class="per-btn-tow" name="zt">
                            <a href="javascript:;">编辑</a>
                            <input type="button" name=""  value="删除" />
                        </div>
                    </div>
                    <div class="RANbox-list01" name="zt">
                        <ul class="RANbox-list-xx per-img">
                            <li>
                                <a href="play.html"><img src="/images/newindex/test-03.jpg" /></a>
                            </li>
                            <li>
                                <div class="RANbox-list01-t">
                                    <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>
                                    <div class="GNbox-type" name="zt">
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                        <span>爱情</span>
                                    </div>
                                </div>
                                <div class="RANbox-list01-b">
                                    <div>
                                        更新:<span>测试更新文字内容</span> 状态:
                                        <span>发布中</span>
                                    </div>
                                    <div class="per-mtop">
                                        上传:<span>2021年06月28日</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="RANbox-list01-sj per-img">
                            <ul class="SSjgPJ">
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                            </ul>
                        </div>
                        <div class="per-btn-tow" name="zt">
                            <a href="javascript:;">编辑</a>
                            <input type="button" name=""  value="删除" />
                        </div>
                    </div>
                    -->
                </div>

                <!-- 视频列表 -->
                <div class="per-tab-box02 ">
                    <h4 class="per-zw" name="zt" >
                        暂无内容
                    </h4>
                    <!--
                    <div class="RANbox-list01" name="zt">
                        <ul class="RANbox-list-xx">
                            <li>
                                <a href="play.html"><img src="/images/newindex/RDimg.jpg" /></a>
                            </li>
                            <li>
                                <div class="RANbox-list01-t">
                                    <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>

                                </div>
                                <div class="RANbox-list01-b">
                                    <div>
                                        上传:<span>2021年06月28日</span> 状态:
                                        <span>发布中</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="RANbox-list01-sj">
                            <ul class="SSjgPJ">
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                            </ul>
                        </div>
                        <div class="per-btn-tow" name="zt">
                            <a href="javascript">编辑</a>
                            <input type="button" name=""  value="删除" />
                        </div>
                    </div>
                    <div class="RANbox-list01" name="zt">
                        <ul class="RANbox-list-xx">
                            <li>
                                <a href="play.html"><img src="/images/newindex/RDimg.jpg" /></a>
                            </li>
                            <li>
                                <div class="RANbox-list01-t">
                                    <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>

                                </div>
                                <div class="RANbox-list01-b">
                                    <div>
                                        上传:<span>2021年06月28日</span> 状态:
                                        <span>发布中</span>
                                    </div>
                                </div>

                            </li>
                        </ul>
                        <div class="RANbox-list01-sj">
                            <ul class="SSjgPJ">
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                            </ul>
                        </div>
                        <div class="per-btn-tow" name="zt">
                            <a href="javascript">编辑</a>
                            <input type="button" name=""  value="删除" />
                        </div>
                    </div>
                    <div class="RANbox-list01" name="zt">
                        <ul class="RANbox-list-xx">
                            <li>
                                <a href="play.html"><img src="/images/newindex/RDimg.jpg" /></a>
                            </li>
                            <li>
                                <div class="RANbox-list01-t">
                                    <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>

                                </div>
                                <div class="RANbox-list01-b">
                                    <div>
                                        上传:<span>2021年06月28日</span> 状态:
                                        <span>发布中</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="RANbox-list01-sj">
                            <ul class="SSjgPJ">
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                            </ul>
                        </div>
                        <div class="per-btn-tow" name="zt">
                            <a href="javascript">编辑</a>
                            <input type="button" name=""  value="删除" />
                        </div>
                    </div>
                    <div class="RANbox-list01" name="zt">
                        <ul class="RANbox-list-xx">
                            <li>
                                <a href="play.html"><img src="/images/newindex/RDimg.jpg" /></a>
                            </li>
                            <li>
                                <div class="RANbox-list01-t">
                                    <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>
                                </div>
                                <div class="RANbox-list01-b">
                                    <div>
                                        上传:<span>2021年06月28日</span> 状态:
                                        <span>发布中</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="RANbox-list01-sj">
                            <ul class="SSjgPJ">
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                            </ul>
                        </div>
                        <div class="per-btn-tow" name="zt">
                            <a href="javascript">编辑</a>
                            <input type="button" name=""  value="删除" />
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>

        <!--tab 关注-->
        <div class="per-tab-box c_relation" name="zt">
            <!-- 头部导航 -->
            <div class="per-sp-box">
                <ul class="per-tab03" name="zt">
                    <li class="act" data-type="1">关注</li>
                    <li data-type="3">粉丝</li>
                    <li data-type="2">黑名单</li>
                </ul>
                <div class="per-slt">
                    <div class="per-slt-name" name="zt">
                        <input type="button" name=""  value="最近关注" />
                    </div>
                    <div class="per-slt-list per-slt-list-relation" name="zt">
                        <input class="act" type="button" name="" data-value="time" value="最近关注" />
<!--                        <input type="button" name="" data-value="" data-type="" value="最近更新" />-->
                        <input type="button" name="" data-value="fans" value="人气最高" /><!--fans高-->
                        <input type="button" name="" data-value="relations" value="最多关注" /><!--关注多-->
                    </div>
                </div>
                <div class="per-ss" name="zt">
                    <input type="text" name="" id="rela_search" value="" placeholder="搜索" />
                    <input type="button" id="rela_searchbtn" value="" />
                </div>
            </div>
            <div class="per-tab-w03">
                <!-- 关注 -->
                <div class="per-tab-box03 act" name="zt">
                    <?php if(!$data['follow']):?>
                        <h4 class="per-zw" name="zt">
                            暂无内容
                        </h4>
                    <?php else:?>
                        <?php foreach($data['follow'] as $follow):?>
                            <ul class="per-gz-box relations1-<?=$follow['uid']?>-<?=$follow['other_uid']?>" name="zt">
                                <li>
                                    <a class="per-gz-h" href="<?= Url::to(['/video/other-home', 'uid' => $follow['other_uid']])?>">
                                        <?php if($follow['avatar']):?>
                                            <img src="<?=$follow['avatar']?>" />
                                        <?php else:?>
                                            <img src="/images/newindex/logon.png" />
                                        <?php endif;?>
                                    </a>
                                </li>
                                <li>
                                    <div class="per-gz-xx">
                                        <a class="per-gz-name" name="zt" href="<?= Url::to(['/video/other-home', 'uid' => $follow['other_uid']])?>"><?=$follow['nickname']?></a>
                                        <div class="per-gz-xb">
                                            <?php if($follow['gender']==2):?>
                                                <img src="/images/newindex/nan.png" />
                                            <?php elseif($follow['gender']==1):?>
                                                <img src="/images/newindex/nv.png" />
                                            <?php endif;?>
                                        </div>
                                        <div class="per-gz-dz">
<!--                                            <img src="/images/newindex/hlp-dz-g.png" />-->
<!--                                            <span>澳大利亚</span>-->
                                        </div>
                                    </div>
                                    <div class="per-gz-qm">
<!--                                        测试用户个性签名-->
                                    </div>
                                </li>
                                <li>粉丝：<span><?=$follow['fannum']?></span></li>
                                <li>作品：<span>0</span></li>
                                <li>获赞：<span>0</span></li>
                                <li class="per-li-r" name="zt">
                                    <input class="per-btn-x" onclick="changerelations(this);" data-value="<?=$follow['uid']?>-<?=$follow['other_uid']?>" data-type="1" type="button" name="" value="取消关注" />
                                </li>
                            </ul>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
                <!-- 粉丝 -->
                <div class="per-tab-box03" name="zt">
                    <?php if(!$data['fans']):?>
                    <h4 class="per-zw" name="zt" >
                        暂无内容
                    </h4>
                    <?php else:?>
                        <?php foreach($data['fans'] as $fans):?>
                            <ul class="per-gz-box relations3-<?=$fans['uid']?>-<?=$fans['other_uid']?>" name="zt">
                                <li>
                                    <a class="per-gz-h" href="<?= Url::to(['/video/other-home', 'uid' => $fans['uid']])?>">
                                        <?php if($fans['avatar']):?>
                                            <img src="<?=$fans['avatar']?>" />
                                        <?php else:?>
                                            <img src="/images/newindex/logon.png" />
                                        <?php endif;?>
                                    </a>
                                </li>
                                <li>
                                    <div class="per-gz-xx">
                                        <a class="per-gz-name" name="zt" href="<?= Url::to(['/video/other-home', 'uid' => $fans['uid']])?>"><?=$fans['nickname']?></a>
                                        <div class="per-gz-xb">
                                            <?php if($fans['gender']==2):?>
                                                <img src="/images/newindex/nan.png" />
                                            <?php elseif($fans['gender']==1):?>
                                                <img src="/images/newindex/nv.png" />
                                            <?php endif;?>
                                        </div>
                                        <div class="per-gz-dz">
<!--                                            <img src="/images/newindex/hlp-dz-g.png" />-->
<!--                                            <span>澳大利亚</span>-->
                                        </div>
                                    </div>
                                    <div class="per-gz-qm">
<!--                                        测试用户个性签名-->
                                    </div>
                                </li>
                                <li>粉丝：<span><?=$fans['fannum']?></span></li>
                                <li>作品：<span>0</span></li>
                                <li>获赞：<span>0</span></li>
                                <li class="per-li-r" name="zt">
                                    <input class="per-btn-x" onclick="changerelations(this);" data-value="<?=$fans['uid']?>-<?=$fans['other_uid']?>" data-type="3" type="button" name=""  value="<?=$fans['tab']==1?'取消关注':'关注'?>" />
                                </li>
                            </ul>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
                <!-- 黑名单 -->
                <div class="per-tab-box03" name="zt">
                    <?php if(!$data['blacklist']):?>
                        <h4 class="per-zw" name="zt" >
                            暂无内容
                        </h4>
                    <?php else:?>
                        <?php foreach($data['blacklist'] as $bl):?>
                            <ul class="per-gz-box relations2-<?=$bl['uid']?>-<?=$bl['other_uid']?>" name="zt">
                                <li>
                                    <a class="per-gz-h" href="<?= Url::to(['/video/other-home', 'uid' => $bl['other_uid']])?>">
                                        <?php if($bl['avatar']):?>
                                            <img src="<?=$bl['avatar']?>" />
                                        <?php else:?>
                                            <img src="/images/newindex/logon.png" />
                                        <?php endif;?>
                                    </a>
                                </li>
                                <li>
                                    <div class="per-gz-xx">
                                        <a class="per-gz-name" name="zt" href="<?= Url::to(['/video/other-home', 'uid' => $bl['other_uid']])?>"><?=$bl['nickname']?></a>
                                        <div class="per-gz-xb">
                                            <?php if($bl['gender']==2):?>
                                                <img src="/images/newindex/nan.png" />
                                            <?php elseif($bl['gender']==1):?>
                                                <img src="/images/newindex/nv.png" />
                                            <?php endif;?>
                                        </div>
                                        <div class="per-gz-dz">
<!--                                            <img src="/images/newindex/hlp-dz-g.png" />-->
<!--                                            <span>澳大利亚</span>-->
                                        </div>
                                    </div>
                                    <div class="per-gz-qm">
<!--                                        测试用户个性签名-->
                                    </div>
                                </li>
                                <li>粉丝：<span><?=$bl['fannum']?></span></li>
                                <li>作品：<span>0</span></li>
                                <li>获赞：<span>0</span></li>
                                <li class="per-li-r" name="zt">
                                    <input class="per-btn-x" onclick="changerelations(this);" data-value="<?=$bl['uid']?>-<?=$bl['other_uid']?>" data-type="2" type="button" name=""  value="移除" />
                                </li>
                            </ul>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
        </div>

        <!--tab 消息-->
        <div class="per-tab-box c_message" name="zt">
            <!-- 头部导航 -->
            <div class="per-sp-box">
                <ul class="per-tab04" name="zt">
                    <li data-type="comment" class="act">我发表的</li>
                    <li data-type="reply">回复我的</li>
                    <li data-type="system_message">系统通知</li>
<!--                    <li>私信</li>-->
                </ul>
            </div>
            <div class="per-tab-w04">
                <!-- 我发表的 -->
                <div class="per-tab-box04 act" name="zt">
                    <?php if(!$data['comment']):?>
                        <h4 class="per-zw" name="zt">
                            暂无内容
                        </h4>
                    <?php else:?>
                        <?php foreach($data['comment'] as $comment):?>
                            <ul class="per-now-box comment_<?=$comment['comment_id']?>" name="zt">
                                <li class="per-now-h">
                                    <div class="navTopLogonImg">
                                        <a href="javascript">
                                            <?php if($comment['avatar']):?>
                                                <img src="<?=$comment['avatar']?>" />
                                            <?php else:?>
                                                <img src="/images/newindex/logon.png" />
                                            <?php endif;?>
                                        </a>
                                    </div>
                                    <div class="navTopLogon-GRXX" name="zt">
                                        <div class="navTopLogon-GRXX-box">
                                            <ul class="navTopLogon-box01">
                                                <li class="navTopLogon-name"><img src="/images/newindex/VIP-1.png" /><?=$comment['username']?></li>
                                                <li class="navTopLogon-Gender">
                                                    <?php if($comment['gender']==2):?>
                                                        <img src="/images/newindex/nan.png" />
                                                    <?php elseif($comment['gender']==1):?>
                                                        <img src="/images/newindex/nv.png" />
                                                    <?php endif;?>
                                                </li>
                                            </ul>
                                            <ul class="navTopLogon-box02">
                                                <li class="navTopLogon-rank">LV.<span><?=$comment['grade']?></span></li>
                                                <li class="navTopLogon-icon01"><img src="/images/newindex/jinbi.png" /></li>
                                                <li class="navTopLogon-text"><?=$comment['score']?></li>
                                                <li class="per-gz-dz">
<!--                                                    <img src="/images/newindex/hlp-dz-w.png"><span>澳大利亚</span>-->
                                                </li>
<!--                                                <li class="navTopLogon-experience"><span>76</span>/<span>200</span></li>-->
<!--                                                <li class="navTopLogon-icon01"><img src="/images/newindex/shangsheng.png" /></li>-->
<!--                                                <li class="navTopLogon-Progress">-->
<!--                                                    <div>-->
<!--                                                        <div class="Progress">&nbsp;</div>-->
<!--                                                    </div>-->
<!--                                                </li>-->
                                            </ul>
                                        </div>
                                        <ul class="navTopLogon-box03">
                                            <li>
                                                <a class="navTopLogon-A" href="<?=Url::to(['/video/other-home'])?>">个人主页</a>
                                            </li>
                                            <!--<li><input class="per-now-btn" type="" name=""  value="私信" /></li>-->
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="per-now-box-01">
                                        <div>
                                            <?=$comment['username']?>
                                        </div>
                                        <img src="/images/newindex/lv_1.png" />
                                        <a href="<?= Url::to(['detail', 'video_id' => $comment['video_id']])?>"><?=$comment['film_name']?></a>
                                    </div>
                                    <div class="per-now-box-02" name="zt">
                                        <?=$comment['content']?>
                                    </div>
                                    <ul class="per-now-box-03" name="zt">
                                        <li><?=$comment['date']?></li>
                                        <li><input class="per-btn-z" onclick="commentAddlikes(this)" type="button" name="" data-value="<?=$comment['comment_id']?>" value="" /><span><?=$comment['likes_num']?></span></li>
                                        <li><input class="per-btn-s" onclick="removecomment(this)" type="button" name="" data-value="<?=$comment['comment_id']?>" data-type="comment" value="删除" /></li>
                                    </ul>
                                </li>
                            </ul>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
                <!-- 回复我的 -->
                <div class="per-tab-box04" name="zt">
                    <?php if(!$data['reply']):?>
                        <h4 class="per-zw" name="zt">
                            暂无内容
                        </h4>
                    <?php else:?>
                        <?php foreach($data['reply'] as $reply):?>
                            <ul class="per-now-box comment_<?=$reply['comment_id']?>" name="zt">
                                <li class="per-now-h">
                                    <div class="navTopLogonImg">
                                        <a href="javascript">
                                            <?php if($reply['avatar']):?>
                                                <img src="<?=$reply['avatar']?>" />
                                            <?php else:?>
                                                <img src="/images/newindex/logon.png" />
                                            <?php endif;?>
                                        </a>
                                    </div>
                                    <div class="navTopLogon-GRXX" name="zt">
                                        <div class="navTopLogon-GRXX-box">
                                            <ul class="navTopLogon-box01">
                                                <li class="navTopLogon-name"><img src="/images/newindex/VIP-1.png" /><?=$reply['username']?></li>
                                                <li class="navTopLogon-Gender">
                                                    <?php if($reply['gender']==2):?>
                                                        <img src="/images/newindex/nan.png" />
                                                    <?php elseif($reply['gender']==1):?>
                                                        <img src="/images/newindex/nv.png" />
                                                    <?php endif;?>
                                                </li>
                                            </ul>
                                            <ul class="navTopLogon-box02">
                                                <li class="navTopLogon-rank">LV.<span><?=$reply['grade']?></span></li>
                                                <li class="navTopLogon-icon01"><img src="/images/newindex/jinbi.png" /></li>
                                                <li class="navTopLogon-text"><?=$reply['score']?></li>
                                                <li class="per-gz-dz">
<!--                                                    <img src="/images/newindex/hlp-dz-w.png"><span>澳大利亚</span>-->
                                                </li>
<!--                                                <li class="navTopLogon-experience"><span>76</span>/<span>200</span></li>-->
<!--                                                <li class="navTopLogon-icon01"><img src="/images/newindex/shangsheng.png" /></li>-->
<!--                                                <li class="navTopLogon-Progress">-->
<!--                                                    <div>-->
<!--                                                        <div class="Progress">&nbsp;</div>-->
<!--                                                    </div>-->
<!--                                                </li>-->
                                            </ul>
                                        </div>
                                        <ul class="navTopLogon-box03">
                                            <li>
                                                <a class="navTopLogon-A" href="<?=Url::to(['/video/other-home','uid'=>$reply['uid']])?>">个人主页</a>
                                            </li>
                                            <!--<li><input class="per-now-btn" type="" name=""  value="私信" /></li>-->
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="per-now-box-01">
                                        <div>
                                            <?=$reply['username']?>
                                        </div>
                                        <img src="/images/newindex/lv_1.png" />
                                        <a href="<?= Url::to(['detail', 'video_id' => $reply['video_id']])?>"><?=$reply['film_name']?></a>
                                    </div>
                                    <div class="per-now-box-02" name="zt">
                                        <?=$reply['content']?>
                                    </div>
                                    <ul class="per-now-box-03" name="zt">
                                        <li><?=$reply['date']?></li>
                                        <li><input class="per-btn-z" onclick="commentAddlikes(this)" type="button" name="" data-value="<?=$reply['comment_id']?>" value="" /><span><?=$reply['likes_num']?></span></li>
                                        <li><input class="per-btn-s" onclick="removecomment(this)" type="button" name="" data-value="<?=$reply['comment_id']?>" data-type="comment" value="删除" /></li>
                                    </ul>
                                </li>
                            </ul>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
                <!-- 系统通知 -->
                <div class="per-tab-box04" name="zt">
                    <?php if(!$data['system_message']):?>
                        <h4 class="per-zw" name="zt">
                            暂无内容
                        </h4>
                    <?php else:?>
                        <?php foreach($data['system_message'] as $message):?>
                            <ul class="per-now-box message_<?=$message['message_id']?>" name="zt">
                                <li class="per-now-h">
                                    <img src="/images/newindex/admin_avatar.png" />
                                </li>
                                <li>
                                    <div class="per-now-box-01">
                                        <div>
                                            系统管理员
                                        </div>
                                    </div>
                                    <div class="per-now-box-02" name="zt">
                                        <?=$message['content']?>
                                    </div>
                                    <ul class="per-now-box-03" name="zt">
                                        <li><?=$message['date']?></li>
                                        <li><input class="per-btn-s" onclick="removecomment(this)" type="button" name="" data-value="<?=$message['message_id']?>" data-type="message" value="删除" /></li>
                                    </ul>
                                </li>
                            </ul>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
                <!-- 私信 -->
                <div class="per-tab-box04" name="zt">
                    <div class="per-qq-box" name="zt">
                        <div class="per-qq-box-l">
                            <div class="per-qq-list" name="zt">
                                <div class="per-qq-h01" name="zt">
                                    <input class="per-qq-sz act" type="button" name=""  value="" />
                                    <input class="per-qq-bl" type="button" name=""  value="消息设置" />
                                </div>
                                <!--用户列表-->
                                <div class="per-yh-lst act">
                                    <ul class="per-qq-yh act">
                                        <li><img src="/images/newindex/logon.png" /></li>
                                        <li>
                                            <div class="per-qq-name01" name="zt">
                                                测试用户名
                                            </div>
                                            <div class="qer-qq-day01" name="zt">
                                                <span>1991年02月22日</span><span>7:30</span>
                                            </div>
                                        </li>
                                        <li><input class="per-qq-dlt" type="button" name=""  value="X" /></li>
                                    </ul>

                                    <!--用户列表ul多个循环-->
                                    <ul class="per-qq-yh">
                                        <li><img src="/images/newindex/logon.png" /></li>
                                        <li>
                                            <div class="per-qq-name01" name="zt">
                                                测试用户名
                                            </div>
                                            <div class="qer-qq-day01" name="zt">
                                                <span>1991年02月22日</span><span>7:30</span>
                                            </div>
                                        </li>
                                        <li><input class="per-qq-dlt" type="button" name=""  value="X" /></li>
                                    </ul>

                                </div>
                                    <!--消息设置-->
                                <div class="per-qq-xxsz-box">
                                    <ul class="per-qq-xxsz" name="zt">
                                        <li>只接受互关好友私信</li>
                                        <li class="per-qq-xxsz-an" name="zt">
                                            <input type="checkbox" name="perQQ-sz" id="perQQ-sz" value="" style="display:none;" />
                                            <label for="perQQ-sz">
                                                <div>&nbsp;11</div>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--聊天框-->
                        <div class="per-qq-box-r">
                            <div class="per-qq-h02" name="zt">
                                <div class="per-qq-name02" name="zt">
                                    测试用户名称
                                    <input class="per-qq-gz01 act" type="button" name=""  value="已关注" />
                                    <input class="per-qq-gz02" type="button" name=""  value="关注" />
                                </div>
                                <input class="per-qq-sz02" type="button" name=""  value="" />
                            </div>
                            <div class="per-qq-sz02-slc" name="zt">
                                <input type="button" name=""  value="加入黑名单" />
                                <input type="button" name=""  value="清空聊天记录" />
                                <input type="button" name=""  value="举报用户" />
                            </div>
                            <div class="per-qq-lt-box">
                                <div class="per-qq-lt-l">
                                    <ul>
                                        <li><img src="/images/newindex/logon.png"/></li>
                                        <li name="zt">测试聊天内容测试聊天内容测试聊天内容</li>
                                    </ul>
                                </div>
                                <div class="per-qq-lt-r">
                                    <ul>
                                        <li><img src="/images/newindex/logon.png"/></li>
                                        <li>测试聊天内容测试聊天内容测试聊天内容</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="per-qq-text-box" name="zt">
                                <div class="GNbox-PLsr" name="zt">
                                    <textarea placeholder="注意，以下行为将被封号：严重剧透、发布广告、木马链接、宣传同类网站、辱骂工作人员等。"></textarea>
                                    <div class="GNbox-PL-box">
                                        <input class="GNbox-Btnbq" type="button" name=""  value="">
                                        <input class="GNbox-Btnfs" type="button" name=""  value="发送">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--tab 收藏夹-->
        <div class="per-tab-box c_favorite" name="zt">
            <!-- 收藏夹导航 -->
            <div class="per-sp-box">
                <ul class="per-tab05" name="zt">
                    <li class="act">剧集</li>
                    <li>视频</li>
                </ul>
                <div class="per-slt">
                    <div class="per-slt-name" name="zt">
                        <input type="button" name="" value="最近上传" />
                    </div>
                    <div class="per-slt-list per-slt-list-favorite" name="zt">
                        <input class="act" type="button" name="" data-value="time" data-type="order" value="最近上传" />
                        <input type="button" name=""  data-value="view"  data-type="order" value="人气最高" /><!--浏览-->
                        <input type="button" name=""  data-value="favorite"  data-type="order" value="收藏最多" />
<!--                        <input type="button" name=""  value="点赞最多" />-->
<!--                        <input type="button" name=""  value="点踩最多" />-->
                    </div>
                </div>
                <div class="per-slt">
                    <div class="per-slt-name" name="zt">
                        <input type="button" name="" value="全部分类" />
                    </div>
                    <div class="per-slt-list per-slt-list-favorite" name="zt">
                        <input class="act" type="button" name="" data-value="0" data-type="channel" value="全部分类" />
                        <?php if(!empty($channels)) :?>
                            <?php foreach ($channels['channeltags'] as $channel) :?>
                                <?php if($channel['channel_name'] != '首页'): ?>
                                    <input type="button" name="" data-value="<?= $channel['channel_id']?>"  data-type="channel" value="<?= $channel['channel_name']?>" />
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php endif;?>
                    </div>
                </div>
                <div class="per-slt">
                    <div class="per-slt-name" name="zt">
                        <input type="button" name="" value="全部状态" />
                    </div>
                    <div class="per-slt-list per-slt-list-favorite" name="zt">
                        <input class="act" type="button" name="" data-value="0" data-type="is_finished" value="全部状态" />
                        <input type="button" name="" data-value="2" data-type="is_finished" value="连载中" />
                        <input type="button" name="" data-value="1" data-type="is_finished" value="已完结" />
                    </div>
                </div>
                <div class="per-ss" name="zt">
                    <input type="text" name="" id="fav_search" value="" placeholder="搜索" />
                    <input type="button"  value="" id="fav_searchbtn" />
                </div>
                <div class="per-qx" name="zt">
                    <input type="button" name=""  value="批量删除" />
                </div>
            </div>
            <!-- 批量删除 -->
            <div class="per-sp-box02">
                <div class="per-qx-02" name="zt">
                    <input type="button" name=""  value="全选" />
                </div>
                <div class="per-sp-box02-h">
                    已选择 <span class="clrOrangered">0</span>个视频
                </div>
                <div class="per-qx-03" id="btnQX" name="zt">
                    <input type="button" name=""  value="取消" />
                </div>
                <div class="per-qx-03" name="zt">
                    <input type="button" name=""  value="删除" onclick="removefavorite('all');" />
                </div>
            </div>
            <div class="per-tab-w05">
                <!-- 收藏剧集 -->
                <div class="per-tab-box05 act">
                    <?php if(!$data['favorite']):?>
                    <h4 class="per-zw" name="zt">
                        暂无内容
                    </h4>
                    <?php else :?>
                        <?php foreach ($data['favorite'] as $video):?>
                            <div class="RANbox-list01 id_fav<?=$video['video_id']?>" name="zt">
                                <ul class="RANbox-list-xx per-img">
                                    <li>
                                        <a href="<?= Url::to(['detail', 'video_id' => $video['video_id']])?>"><img src="<?=$video['cover']?>"></a>
                                    </li>
                                    <li>
                                        <div class="RANbox-list01-t">
                                            <a class="RAN-z-box01-name" href="<?= Url::to(['detail', 'video_id' => $video['video_id']])?>" name="zt"><?=$video['video_name']?></a>
                                            <div class="GNbox-type" name="zt">
                                                <?php foreach (explode(' ',$video['category']) as $category): ?>
                                                    <span><?= $category?></span>
                                                <?php endforeach;?>
                                            </div>
                                        </div>
                                        <div class="RANbox-list01-b">
                                            <div>
                                                更新:<span><?=$video['flag']?></span>
                                                状态:<span><?=$video['is_finished']==1? '完结' : '更新中' ?></span>
                                            </div>
                                            <div class="per-mtop">
                                                上传:<span><?=date("Y年m月d日",$video['created_at'])?></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="RANbox-list01-sj per-img">
                                    <ul class="SSjgPJ">
                                        <li><span><?=$video['commentcount']?></span></li>
                                        <li><span>0</span></li>
                                        <li><span>0</span></li>
                                        <li><span><?=$video['total_views']?></span></li>
                                    </ul>
                                </div>
                                <div class="per-btn-tow" name="zt">
                                    <input type="button" name="" onclick="removefavorite(<?=$video['video_id']?>)" value="删除" />
                                </div>
                                <div class="per-btn-cbox" style="border:0px;">
                                    <input type="checkbox" name="per-qx" class="fav_checkbox" data-value="<?=$video['video_id']?>" value="" />
                                </div>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
                <!-- 收藏视频 -->
                <div class="per-tab-box05">
                    <h4 class="per-zw" name="zt">
                        暂无内容
                    </h4>
                    <!--
                    <div class="RANbox-list01" name="zt">
                        <ul class="RANbox-list-xx">
                            <li>
                                <a href="play.html"><img src="/images/newindex/RDimg.jpg" /></a>
                            </li>
                            <li>
                                <div class="RANbox-list01-t">
                                    <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>
                                </div>
                                <div class="RANbox-list01-b">
                                    <div>
                                        上传:<span>2021年06月28日</span> 状态:
                                        <span>发布中</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="RANbox-list01-sj">
                            <ul class="SSjgPJ">
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                            </ul>
                        </div>
                        <div class="per-btn-tow" name="zt">
                            <input type="button" name=""  value="删除" />
                        </div>
                        <div class="per-btn-cbox">
                            <input type="checkbox" name="per-qx"  value="" />
                        </div>
                    </div>
                    <div class="RANbox-list01" name="zt">
                        <ul class="RANbox-list-xx">
                            <li>
                                <a href="play.html"><img src="/images/newindex/RDimg.jpg" /></a>
                            </li>
                            <li>
                                <div class="RANbox-list01-t">
                                    <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>
                                </div>
                                <div class="RANbox-list01-b">
                                    <div>
                                        上传:<span>2021年06月28日</span> 状态:
                                        <span>发布中</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="RANbox-list01-sj">
                            <ul class="SSjgPJ">
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                                <li><span>1212</span></li>
                            </ul>
                        </div>
                        <div class="per-btn-tow" name="zt">
                            <input type="button" name=""  value="删除" />
                        </div>
                        <div class="per-btn-cbox">
                            <input type="checkbox" name="per-qx"  value="" />
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

        <!--tab 播放记录-->
        <div class="per-tab-box c_watchlog" name="zt">
            <!-- 头部导航 -->
            <div class="per-sp-box">
                <ul class="per-tab06" name="zt">
                    <li class="act">剧集</li>
                    <li>视频</li>
                </ul>
                <div class="per-ss" name="zt">
                    <input type="text" id="watchlog_stext" value="" placeholder="搜索" />
                    <input type="button" id="watchlog_search" value="" />
                </div>
                <div class="per-qk" name="zt">
                    <input type="button" onclick="removewatchlog('all');" value="清空记录" />
                </div>
            </div>
            <div class="per-tab-w06">
                <!-- 剧集播放线 -->
                <div class="per-tab-box06 act">
                    <?php if(!$data['watchlog']):?>
                        <h4 class="per-zw" name="zt">
                            暂无内容
                        </h4>
                    <?php else :?>
                        <?php foreach ($data['watchlog'] as $i => $watchdate):?>
                            <?php if($i==0){
                                $act = "act";
                            }else{
                                $act = "";
                            }?>
                            <div class="per-bf-lst">
                                <?php if($data['watchlog'][$i-1]['date']!=$watchdate['date']):?>
                                    <div class="per-bf-lst-btn <?=$act?>"><?=$watchdate['date']?></div>
                                <?php endif;?>
                                <?php foreach ($watchdate['list'] as $video):?>
                                <ul class="per-bof-box id_watchlog_<?=$video['log_id']?>" name="zt">
                                    <li class="per-bof-box-01"><?=$video['show_times']?></li>
                                    <li class="per-bof-box-02" name="zt">
                                        <div class="RANbox-list01" name="zt">
                                            <ul class="RANbox-list-xx per-img">
                                                <li>
                                                    <a href="<?= Url::to(['detail', 'video_id' => $video['video_id']])?>"><img src="<?=$video['cover']?>"></a>
                                                </li>
                                                <li>
                                                    <div class="RANbox-list01-t">
                                                        <a class="RAN-z-box01-name" href="<?= Url::to(['detail', 'video_id' => $video['video_id']])?>" name="zt"><?=$video['title']?></a>
                                                        <div class="GNbox-type" name="zt">
                                                            <?php foreach (explode(' ',$video['category']) as $category): ?>
                                                                <span><?= $category?></span>
                                                            <?php endforeach;?>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="per-btn-tow" name="zt">
                                                <input type="button"  onclick="removewatchlog(<?=$video['log_id']?>);" value="删除">
                                            </div>
                                            <div class="per-bf-bow02">
                                                <div class="per-bf-bow02-h" name="zt">
<!--                                                    更新至：<span>36</span>-->
                                                    <?=$video['flag']?>
                                                </div>
                                                <ul class="per-bf-bow02-h02" name="zt">
                                                    <li class="per-bf-bow02-h02-jd" name="zt">
                                                        <div style="width:<?=$video['watch_percent']?>%;">
                                                            &nbsp;
                                                        </div>
                                                    </li>
                                                    <li><?=$video['play_time']?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <?php endforeach;?>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
                <!-- 视频播放线 -->
                <div class="per-tab-box06">
                    <h4 class="per-zw" name="zt">
                        暂无内容
                    </h4>
                    <!--
                    <div class="per-bf-lst">
                        <div class="per-bf-lst-btn act">今天</div>
                        <ul class="per-bof-box" name="zt">
                            <li class="per-bof-box-01">14:30</li>
                            <li class="per-bof-box-02" name="zt">
                                <div class="RANbox-list01" name="zt">
                                    <ul class="RANbox-list-xx">
                                        <li>
                                            <a href="play.html"><img src="/images/newindex/RDimg.jpg"></a>
                                        </li>
                                        <li>
                                            <div class="RANbox-list01-t">
                                                <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="per-btn-tow" name="zt">
                                        <input type="button" name=""  value="删除">
                                    </div>
                                    <div class="per-bf-bow">
                                        <a href="javascript">测试作者名称</a>
                                        <input type="button" name=""  value="关注" />
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="per-bof-box" name="zt">
                            <li class="per-bof-box-01">14:30</li>
                            <li class="per-bof-box-02" name="zt">
                                <div class="RANbox-list01" name="zt">
                                    <ul class="RANbox-list-xx">
                                        <li>
                                            <a href="play.html"><img src="/images/newindex/RDimg.jpg"></a>
                                        </li>
                                        <li>
                                            <div class="RANbox-list01-t">
                                                <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="per-btn-tow" name="zt">
                                        <input type="button" name=""  value="删除">
                                    </div>
                                    <div class="per-bf-bow">
                                        <a href="javascript">测试作者名称</a>
                                        <input type="button" name=""  value="关注" />
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="per-bf-lst">
                        <div class="per-bf-lst-btn">昨天</div>
                        <ul class="per-bof-box" name="zt">
                            <li class="per-bof-box-01">14:30</li>
                            <li class="per-bof-box-02" name="zt">
                                <div class="RANbox-list01" name="zt">
                                    <ul class="RANbox-list-xx">
                                        <li>
                                            <a href="play.html"><img src="/images/newindex/RDimg.jpg"></a>
                                        </li>
                                        <li>
                                            <div class="RANbox-list01-t">
                                                <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="per-btn-tow" name="zt">
                                        <input type="button" name=""  value="删除">
                                    </div>
                                    <div class="per-bf-bow">
                                        <a href="javascript">测试作者名称</a>
                                        <input type="button" name=""  value="关注" />
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="per-bof-box" name="zt">
                            <li class="per-bof-box-01">14:30</li>
                            <li class="per-bof-box-02" name="zt">

                                <div class="RANbox-list01" name="zt">
                                    <ul class="RANbox-list-xx">
                                        <li>
                                            <a href="play.html"><img src="/images/newindex/RDimg.jpg"></a>
                                        </li>
                                        <li>
                                            <div class="RANbox-list01-t">
                                                <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>

                                            </div>

                                        </li>
                                    </ul>
                                    <div class="per-btn-tow" name="zt">
                                        <input type="button" name=""  value="删除">
                                    </div>
                                    <div class="per-bf-bow">
                                        <a href="javascript">测试作者名称</a>
                                        <input type="button" name=""  value="关注" />
                                    </div>
                                </div>

                            </li>
                        </ul>
                    </div>
                    <div class="per-bf-lst">
                        <div class="per-bf-lst-btn">本周</div>
                        <ul class="per-bof-box" name="zt">
                            <li class="per-bof-box-01">2021-07-07</li>
                            <li class="per-bof-box-02" name="zt">
                                <div class="RANbox-list01" name="zt">
                                    <ul class="RANbox-list-xx">
                                        <li>
                                            <a href="play.html"><img src="/images/newindex/RDimg.jpg"></a>
                                        </li>
                                        <li>
                                            <div class="RANbox-list01-t">
                                                <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="per-btn-tow" name="zt">
                                        <input type="button" name=""  value="删除">
                                    </div>
                                    <div class="per-bf-bow">
                                        <a href="javascript">测试作者名称</a>
                                        <input type="button" name=""  value="关注" />
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="per-bof-box" name="zt">
                            <li class="per-bof-box-01">2021-07-06</li>
                            <li class="per-bof-box-02" name="zt">
                                <div class="RANbox-list01" name="zt">
                                    <ul class="RANbox-list-xx">
                                        <li>
                                            <a href="play.html"><img src="/images/newindex/RDimg.jpg"></a>
                                        </li>
                                        <li>
                                            <div class="RANbox-list01-t">
                                                <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="per-btn-tow" name="zt">
                                        <input type="button" name=""  value="删除">
                                    </div>
                                    <div class="per-bf-bow">
                                        <a href="javascript">测试作者名称</a>
                                        <input type="button" name=""  value="关注" />
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="per-bf-lst">
                        <div class="per-bf-lst-btn">一周前</div>
                        <ul class="per-bof-box" name="zt">
                            <li class="per-bof-box-01">2021-06-25</li>
                            <li class="per-bof-box-02" name="zt">
                                <div class="RANbox-list01" name="zt">
                                    <ul class="RANbox-list-xx">
                                        <li>
                                            <a href="play.html"><img src="/images/newindex/RDimg.jpg"></a>
                                        </li>
                                        <li>
                                            <div class="RANbox-list01-t">
                                                <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="per-btn-tow" name="zt">
                                        <input type="button" name=""  value="删除">
                                    </div>
                                    <div class="per-bf-bow">
                                        <a href="javascript">测试作者名称</a>
                                        <input type="button" name=""  value="关注" />
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="per-bof-box" name="zt">
                            <li class="per-bof-box-01">2021-06-23</li>
                            <li class="per-bof-box-02" name="zt">
                                <div class="RANbox-list01" name="zt">
                                    <ul class="RANbox-list-xx">
                                        <li>
                                            <a href="play.html"><img src="/images/newindex/RDimg.jpg"></a>
                                        </li>
                                        <li>
                                            <div class="RANbox-list01-t">
                                                <a class="RAN-z-box01-name" href="play.html" name="zt">测试视频名称</a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="per-btn-tow" name="zt">
                                        <input type="button" name=""  value="删除">
                                    </div>
                                    <div class="per-bf-bow">
                                        <a href="javascript">测试作者名称</a>
                                        <input type="button" name=""  value="关注" />
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
<!--    <div class="more-load" style="display:none;">加载中,请稍候...</div>-->
</div>
<script src="/js/jquery.js"></script>
<script>
/*-----------公共------------*/
var arrall = {};
arrall['relation1-page'] = 1;
arrall['relation1-total'] = ('<?=$data['follow'][0]['total_page']?>'?parseInt('<?=$data['follow'][0]['total_page']?>'):0);
arrall['relation3-page'] = 1;
arrall['relation3-total'] = ('<?=$data['fans'][0]['total_page']?>'?parseInt('<?=$data['fans'][0]['total_page']?>'):0);
arrall['relation2-page'] = 1;
arrall['relation2-total'] = ('<?=$data['blacklist'][0]['total_page']?>'?parseInt('<?=$data['blacklist'][0]['total_page']?>'):0);
arrall['comment-page'] = 1;
arrall['comment-total'] = ('<?=$data['comment'][0]['total_page']?>'?parseInt('<?=$data['comment'][0]['total_page']?>'):0);
arrall['reply-page'] = 1;
arrall['reply-total'] = ('<?=$data['reply'][0]['total_page']?>'?parseInt('<?=$data['reply'][0]['total_page']?>'):0);
arrall['system_message-page'] = 1;
arrall['system_message-total'] = ('<?=$data['system_message'][0]['total_page']?>'?parseInt('<?=$data['system_message'][0]['total_page']?>'):0);
arrall['favorite-page'] = 1;
arrall['favorite-total'] = ('<?=$data['favorite'][0]['total_page']?>'?parseInt('<?=$data['favorite'][0]['total_page']?>'):0);
arrall['watchlog-page'] = 1;
arrall['watchlog-total'] = ('<?=$data['watchlog'][0]['total_page']?>'?parseInt('<?=$data['watchlog'][0]['total_page']?>'):0);

var favarr = {};
favarr['channel'] = 0;
favarr['is_finished'] = 0;

var relaAr = {};
relaAr['type'] = '1';
relaAr['order'] = 'time';
relaAr['searchword'] = '';
relaAr['tabNum'] = 0;
/*-----------收藏------------*/
//收藏条件切换
$(".per-slt-list-favorite>input").click(function() {
    var perSlt=$(this).val();
    var datavalue=$(this).attr('data-value');
    var datatype=$(this).attr('data-type');
    $(this).addClass("act").siblings().removeClass("act");
    $(this).parents(".per-slt").find(".per-slt-name>input").val(perSlt);
    $('.per-slt-name>input').removeClass("act");
    $('.per-slt-list').removeClass("act");
    favarr[datatype] = datavalue;
    $.get('/video/search-favorite',favarr,function(res){
        arrall['favorite-page'] = 1;
        if(res.errno==0){
            var html = findfavoritelist(res.data);
            $(".per-tab-box05.act").html(html);
        }else{
            $(".per-tab-box05.act").html('<h4 class="per-zw" name="zt">暂无内容</h4>');
        }
        ztBlack();
    });
});
//收藏搜索
$("#fav_searchbtn").click(function (){
    favarr['searchword'] = $("#fav_search").val();
    $.get('/video/search-favorite',favarr,function(res){
        arrall['favorite-page'] = 1;
        if(res.errno==0){
            var html = findfavoritelist(res.data);
            $(".per-tab-box05.act").html(html);
        }else{
            $(".per-tab-box05.act").html('<h4 class="per-zw" name="zt">暂无内容</h4>');
        }
        ztBlack();
    });
});
function findfavoritelist(list){
    var html = "";
    for(var i=0;i<list.length;i++){
        var cat = list[i]['category'].split(' ');
        var catstr = "";
        for(var k=0;k<cat.length;k++){
            catstr += '<span>'+cat[k]+'</span>';
        }
        html += '<div class="RANbox-list01 id_fav'+list[i]['video_id']+'" name="zt">'+
            '<ul class="RANbox-list-xx per-img">'+
                '<li>'+
                    '<a href="/video/detail?video_id='+list[i]['video_id']+'"><img src="'+list[i]['cover']+'"></a>'+
                '</li>'+
                '<li>'+
                    '<div class="RANbox-list01-t">'+
                        '<a class="RAN-z-box01-name" href="/video/detail?video_id='+list[i]['video_id']+'" name="zt">'+list[i]['video_name']+'</a>'+
                        '<div class="GNbox-type" name="zt">'+catstr+
                        '</div>'+
                    '</div>'+
                    '<div class="RANbox-list01-b">'+
                        '<div>'+
                            '更新:<span>'+list[i]['flag']+'</span>'+
                            '状态:<span>'+(list[i]['is_finished']==1? '完结' : '更新中')+'</span>'+
                        '</div>'+
                        '<div class="per-mtop">'+
                            '上传:<span><span>'+list[i]['created_data']+'</span>'+
                        '</div>'+
                    '</div>'+
                '</li>'+
            '</ul>'+
            '<div class="RANbox-list01-sj per-img">'+
                '<ul class="SSjgPJ">'+
                    '<li><span>'+list[i]['commentcount']+'</span></li>'+
                    '<li><span>0</span></li>'+
                    '<li><span>0</span></li>'+
                    '<li><span>'+list[i]['total_views']+'</span></li>'+
                '</ul>'+
            '</div>'+
            '<div class="per-btn-tow" name="zt">'+
                '<input type="button" name="" onclick="removefavorite('+list[i]['video_id']+')" value="删除" />'+
            '</div>'+
            '<div class="per-btn-cbox">'+
                '<input type="checkbox" name="per-qx" class="fav_checkbox"  value="" />'+
            '</div>'+
        '</div>';
    }
    return html;
}
//删除收藏
function removefavorite(videoid){
    var arrindex = {};
    if(videoid=='all'){
        var videoids = '';
        $(".fav_checkbox").each(function(){
            if($(this).is(':checked')){
                videoids += $(this).attr('data-value')+",";
            }
        });
        if(videoids!=''){
            videoids = videoids.substring(0,videoids.length-1);
            arrindex['videoid'] = videoids;
        }
    }else{
        arrindex['videoid'] = videoid;
    }
    $.get('/video/change-favorite',arrindex,function(res){
        if(res.errno==0 && res.data.status==0){
            if(videoid=='all'){
                //$(".per-tab-box05.act").html('<h4 class="per-zw" name="zt">暂无内容</h4>');
                var videoar = videoids.split(",");
                for(var i=0;i<videoar.length;i++){
                    $(".id_fav"+videoar[i]).remove();
                }
                //取消全选样式
                $("#btnQX>input").parents(".per-sp-box02").removeClass("act").siblings(".per-sp-box").removeClass("act");
                $("#btnQX>input").parents(".per-sp-box02").siblings(".per-tab-w05").find(".per-tab-box05.act .per-btn-tow").toggle();
                $("#btnQX>input").parents(".per-sp-box02").siblings(".per-tab-w05").find(".per-tab-box05.act .per-btn-cbox").toggle();
                //取消选择
                $("#btnQX>input").parents(".per-sp-box02").siblings(".per-tab-w05").find(".per-tab-box05.act .per-btn-cbox>input").removeClass("act").removeAttr("checked");
            }else{
                $(".id_fav"+videoid).remove();
            }
            $(".alt-title").text("收藏记录删除成功");
            $("#alt05").show();
        }
    });
}
/*-----------播放记录------------*/
//删除播放记录
function removewatchlog(logid){
    var arrindex = {};
    arrindex['logid'] = logid;
    $.get('/video/remove-watchlog',arrindex,function(res){
        if(res.errno==0 && res.data>0){
            if(logid=='all'){
                $(".per-tab-box06.act").html('<h4 class="per-zw" name="zt">暂无内容</h4>');
            }else{
                $(".id_watchlog_"+logid).remove();
            }
            $(".alt-title").text("播放记录删除成功");
            $("#alt05").show();
        }
    });
}
//播放记录搜索
$(function(){
    $("#watchlog_search").click(function(){
        var str = $("#watchlog_stext").val();
        var arr = {};
        arr['searchword'] = str;
        $.get('/video/search-watchlog', arr,function(res){
            arrall['watchlog-page'] = 1;
            if(res.errno==0){
                var html = findwatchloglist(res.data);
                $(".per-tab-box06.act").html(html);
            }else{
                $(".per-tab-box06.act").html('<h4 class="per-zw" name="zt">暂无内容</h4>');
            }
            ztBlack();
        });
    });
});
function findwatchloglist(list){
    var html = "";
    for(var i=0;i<list.length;i++){
        var act = "";
        if(i==0){
            act = "act";
        }else{
            act = "";
        }
        html +='<div class="per-bf-lst ">'+
                   '<div class="per-bf-lst-btn '+act+'">'+list[i]['date']+'</div>';
        var video = list[i]['list'];
        for(var j=0;j<video.length;j++){
            var cat = video[j]['category'].split(' ');
            var catstr = "";
            for(var k=0;k<cat.length;k++){
                catstr += '<span>'+cat[k]+'</span>';
            }
            html +='<ul class="per-bof-box id_watchlog_'+video[j]['log_id']+'" name="zt">'+
                '<li class="per-bof-box-01">'+video[j]['show_times']+'</li>'+
                '<li class="per-bof-box-02" name="zt">'+
                    '<div class="RANbox-list01" name="zt">'+
                        '<ul class="RANbox-list-xx per-img">'+
                            '<li>'+
                                '<a href="/video/detail?video_id='+video[j]['video_id']+'"><img src="'+video[j]['cover']+'"></a>'+
                            '</li>'+
                            '<li>'+
                                '<div class="RANbox-list01-t">'+
                                    '<a class="RAN-z-box01-name" href="/video/detail?video_id='+video[j]['video_id']+'" name="zt">'+video[j]['title']+'</a>'+
                                    '<div class="GNbox-type" name="zt">'+catstr+'</div>'+
                                '</div>'+
                            '</li>'+
                        '</ul>'+
                        '<div class="per-btn-tow" name="zt">'+
                            '<input type="button"  onclick="removewatchlog('+video[j]['log_id']+');" value="删除">'+
                        '</div>'+
                        '<div class="per-bf-bow02">'+
                            '<div class="per-bf-bow02-h" name="zt">'+video[j]['flag']+'</div>'+
                            '<ul class="per-bf-bow02-h02" name="zt">'+
                                '<li class="per-bf-bow02-h02-jd" name="zt">'+
                                    '<div style="width:'+video[j]['watch_percent']+'%;"> </div>'+
                                '</li>'+
                                '<li>'+video[j]['play_time']+'</li>'+
                            '</ul>'+
                        '</div>'+
                    '</div>'+
                '</li>'+
            '</ul>';
        }
        html += '</div>';
    }
    return html;
}
/*-----------消息------------*/
//点赞
// $(".per-btn-z").click(
function commentAddlikes(that) {
    // var that = this;
    var value = $(that).attr('data-value');
    var arr = {};
    arr['id'] = value;
    if($(that).hasClass("act")){
        arr['cal'] = 'subtract';
    }else{
        arr['cal'] = 'plus';
    }
    $.get('/video/add-likes', arr,function(res){
        if(res.errno==0 && res.data>=0){
            $(that).toggleClass("act").siblings("span").toggleClass("act");
            $(that).parent().find("span").html(res.data);
        }
    });
}
//消息删除
// $(".per-btn-s").click(
function removecomment(that) {
    var value = $(that).attr('data-value');
    var type = $(that).attr('data-type');
    var arr = {};
    arr['id'] = value;
    arr['type'] = type;
    $.get('/video/remove-message', arr,function(res){
        if(res.errno==0 && res.data>0){
            $('.'+type+'_'+value).remove();
        }
    });
}
/*-----------关注------------*/
// 关注页tab  切换
$(".per-tab03>li").click(function() {
    var tabNum = $(this).index();
    relaAr['tabNum'] = tabNum;
    var that = this;
    var type = $(this).attr("data-type");
    relaAr['type'] = type;
    // console.log(relaAr);
    $.get('/video/search-relation',relaAr,function(res){
        arrall['relation'+type+'-page'] = 1;
        if(res.errno==0){
            var html = findrelationlist(res.data,relaAr['type']);
            $(".per-tab-w03>div").eq(relaAr['tabNum']).html(html);
        }else{
            $(".per-tab-box03.act").html('<h4 class="per-zw" name="zt">暂无内容</h4>');
        }
        $(that).addClass("act").siblings().removeClass("act");
        $(".per-tab-w03>div").eq(tabNum).addClass("act").siblings().removeClass("act");
        ztBlack();
    });
});
//关注排序
$(".per-slt-list-relation>input").click(function() {
    var perSlt=$(this).val();
    var datavalue=$(this).attr('data-value');
    $(this).addClass("act").siblings().removeClass("act");
    $(this).parents(".per-slt").find(".per-slt-name>input").val(perSlt);
    $('.per-slt-name>input').removeClass("act");
    $('.per-slt-list').removeClass("act");
    relaAr['order'] = datavalue;
    $.get('/video/search-relation',relaAr,function(res){
        var r = $(".per-tab03>li.act").attr("data-type");
        arrall['relation'+r+'-page'] = 1;
        if(res.errno==0){
            var html = findrelationlist(res.data,relaAr['type']);
            $(".per-tab-w03>div").eq(relaAr['tabNum']).html(html);
        }else{
            $(".per-tab-box03.act").html('<h4 class="per-zw" name="zt">暂无内容</h4>');
        }
        ztBlack();
    });
});
//关注搜索
$("#rela_searchbtn").click(function (){
    relaAr['searchword'] = $("#rela_search").val();
    $.get('/video/search-relation',relaAr,function(res){
        var r = $(".per-tab03>li.act").attr("data-type");
        arrall['relation'+r+'-page'] = 1;
        if(res.errno==0){
            var html = findrelationlist(res.data,relaAr['type']);
            $(".per-tab-w03>div").eq(relaAr['tabNum']).html(html);
        }else{
            $(".per-tab-box03.act").html('<h4 class="per-zw" name="zt">暂无内容</h4>');
        }
        ztBlack();
    });
});
function findrelationlist(list,type){
    var html = "";
    for(var i=0;i<list.length;i++){
        var avastr = "";
        if(list[i]['avatar']!=""){
            avastr = '<img src="'+list[i]['avatar']+'" />';
        }else{
            avastr = '<img src="/images/newindex/logon.png" />';
        }
        var gerstr = "";
        if(list[i]['gender']==2){
            gerstr = '<img src="/images/newindex/nan.png" />';
        }else if(list[i]['gender']==1){
            gerstr = '<img src="/images/newindex/nv.png" />';
        }
        var tabstr = '取消关注';
        var otherurl = list[i]['other_uid'];
        if(type==3){
            otherurl = list[i]['uid'];
            if(list[i]['tab']!=1){
                tabstr = '关注';
            }
        }else if(type==2){
            tabstr = '移除';
        }
        html+='<ul class="per-gz-box relations'+type+'-'+list[i]['uid']+'-'+list[i]['other_uid']+'" name="zt">'+
            '<li>'+
                '<a class="per-gz-h" href="/video/other-home?uid='+otherurl+'">'+avastr+'</a>'+
            '</li>'+
            '<li>'+
                '<div class="per-gz-xx">'+
                    '<a class="per-gz-name" name="zt" href="/video/other-home?uid='+otherurl+'">'+list[i]['nickname']+'</a>'+
                    '<div class="per-gz-xb">'+gerstr+'</div>'+
                    '<div class="per-gz-dz">'+
                        //<img src="/images/newindex/hlp-dz-g.png" /><span>澳大利亚</span>
                    '</div>'+
                '</div>'+
                '<div class="per-gz-qm">'+
                    //测试用户个性签名
                '</div>'+
            '</li>'+
            '<li>粉丝：<span>'+list[i]['fannum']+'</span></li>'+
            '<li>作品：<span>0</span></li>'+
            '<li>获赞：<span>0</span></li>'+
            '<li class="per-li-r" name="zt">'+
                '<input class="per-btn-x" onclick="changerelations(this);" data-value="'+list[i]['uid']+'-'+list[i]['other_uid']+'" data-type="'+type+'" type="button" value="'+tabstr+'" />'+
            '</li>'+
        '</ul>';
    }
    return html;
}
//关注/取消关注
function changerelations(that){
    // var that = this;
    var ids = $(that).attr("data-value").split("-");
    var type = $(that).attr("data-type");
    var arr = {};
    arr['uid'] = ids[0];
    arr['other_uid'] = ids[1];
    arr['type'] = type;
    $.get('/video/change-relations', arr,function(res){
        if(res.errno==0){
            if(type=="3"){
                if(res.data.status==0){
                    $(that).val("关注");
                }else if(res.data.status==1){
                    $(that).val("取消关注");
                }
            }else{
                if(res.data.status==0) {
                    $('.relations'+type+'-'+ids[0]+'-'+ids[1]).remove();
                }
            }
        }
    });
}
/*-----------下拉加载更多------------*/
var progress = false; // 是否正在请求中
var isFlag = true;
$(window).scroll(function () {
    if (($(window).scrollTop()+488) >= $(document).height() - $(window).height()) {
        if(isFlag) {
            var tab = $(".per-tab>li.act").attr("data-value");
            var total = 0;
            var page  = 0;
            var r = "";
            var c = "";
            var params = {};
            params['tab'] = tab;
            if(tab=="favorite" ||tab=="watchlog"){
                total = arrall[tab+'-total'];
                page  = arrall[tab+'-page'];
            }else if(tab=="relation"){
                r = $(".per-tab03>li.act").attr("data-type");
                total = arrall[tab+r+'-total'];
                page  = arrall[tab+r+'-page'];
            }else if(tab=="comment"){
                c = $(".per-tab04>li.act").attr("data-type");
                total = arrall[c+'-total'];
                page  = arrall[c+'-page'];
            }
            if (parseInt(page) < parseInt(total) && !progress) {
                // $(".more-load").show();
                progress = true;
                page++;
                params['page_num'] = page;
                if(tab=="relation"){
                    params = expendObject(params,relaAr);
                    arrall[tab+r+'-page'] = page;
                }else if(tab=="favorite"){
                    params = expendObject(params,favarr);
                    arrall[tab+'-page'] = page;
                }else if(tab=="watchlog"){
                    params['searchword'] = $("#watchlog_stext").val();
                    arrall[tab+'-page'] = page;
                }else if(tab=="comment"){
                    var type = $(".per-tab04>li.act").attr("data-type");
                    params['ctype'] = (type!=""?type:"comment");
                    arrall[c+'-page'] = page;
                }
                //console.log(params);
                $.get('/video/load-more', params, function(res) {
                    // console.log(res);
                    // $(".more-load").hide();
                    if(res.errno==0){
                        var html = "";
                        if(tab=="relation"){
                            html = findrelationlist(res.data,relaAr['type']);
                            // $(".per-tab-w03>div").eq(relaAr['tabNum']).append(html);
                            $(".per-tab-box03.act").append(html);
                        }else if(tab=="favorite"){
                            html = findfavoritelist(res.data);
                            $(".per-tab-box05.act").append(html);
                        }else if(tab=="watchlog"){
                            html = findwatchloglist(res.data);
                            $(".per-tab-box06.act").append(html);
                        }else if(tab=="comment"){
                            html = findcommentlist(res.data,type);
                            $(".per-tab-box04.act").append(html);
                        }
                        ztBlack();
                    }
                    progress = false;
                });
            } else if (page == total) {
                progress = false;
            }
            isFlag = false;
        }
    }else {
        isFlag = true;
    }
});
function findcommentlist(list,type){
    var html = '';
    for(var i=0;i<list.length;i++){
        if(type=="system_message"){
            html += '<ul class="per-now-box message_'+list[i]['message_id']+'" name="zt">'+
                        '<li class="per-now-h"><img src="/images/newindex/admin_avatar.png" /></li>'+
                        '<li>'+
                            '<div class="per-now-box-01"><div>系统管理员</div></div>'+
                            '<div class="per-now-box-02" name="zt">'+list[i]['content']+'</div>'+
                            '<ul class="per-now-box-03" name="zt">'+
                                '<li>'+list[i]['date']+'</li>'+
                                '<li><input class="per-btn-s" onclick="removecomment(this)" type="button" name="" data-value="'+list[i]['message_id']+'" data-type="message" value="删除" /></li>'+
                            '</ul>'+
                        '</li>'+
                    '</ul>';
        }else{
            var avastr = "";
            if(list[i]['avatar']!=""){
                avastr = '<img src="'+list[i]['avatar']+'" />';
            }else{
                avastr = '<img src="/images/newindex/logon.png" />';
            }
            var gerstr = "";
            if(list[i]['gender']==2){
                gerstr = '<img src="/images/newindex/nan.png" />';
            }else if(list[i]['gender']==1){
                gerstr = '<img src="/images/newindex/nv.png" />';
            }
            html += '<ul class="per-now-box comment_'+list[i]['comment_id']+'" name="zt">'+
                    '<li class="per-now-h">'+
                        '<div class="navTopLogonImg">'+
                            '<a href="javascript">'+avastr+'</a>'+
                        '</div>'+
                        '<div class="navTopLogon-GRXX" name="zt">'+
                            '<div class="navTopLogon-GRXX-box">'+
                                '<ul class="navTopLogon-box01">'+
                                    '<li class="navTopLogon-name"><img src="/images/newindex/VIP-1.png" />'+list[i]['username']+'</li>'+
                                    '<li class="navTopLogon-Gender">'+gerstr+'</li>'+
                                '</ul>'+
                                '<ul class="navTopLogon-box02">'+
                                    '<li class="navTopLogon-rank">LV.<span>'+list[i]['grade']+'</span></li>'+
                                    '<li class="navTopLogon-icon01"><img src="/images/newindex/jinbi.png" /></li>'+
                                    '<li class="navTopLogon-text">'+list[i]['score']+'</li>'+
                                    '<li class="per-gz-dz"></li>'+
                                '</ul>'+
                            '</div>'+
                            '<ul class="navTopLogon-box03">'+
                                '<li>'+
                                    '<a class="navTopLogon-A" href="/video/other-home?uid='+list[i]['uid']+'">个人主页</a>'+
                                '</li>'+
                                '<li></li>'+
                            '</ul>'+
                        '</div>'+
                    '</li>'+
                    '<li>'+
                        '<div class="per-now-box-01">'+
                            '<div>'+list[i]['username']+'</div>'+
                            '<img src="/images/newindex/lv_1.png" />'+
                            '<a href="/video/detail?video_id='+list[i]['video_id']+'">'+list[i]['film_name']+'</a>'+
                        '</div>'+
                        '<div class="per-now-box-02" name="zt">'+list[i]['content']+'</div>'+
                        '<ul class="per-now-box-03" name="zt">'+
                            '<li>'+list[i]['date']+'</li>'+
                            '<li><input class="per-btn-z" onclick="commentAddlikes(this)" type="button" data-value="'+list[i]['comment_id']+'" /><span>'+list[i]['likes_num']+'</span></li>'+
                            '<li><input class="per-btn-s" onclick="removecomment(this)" type="button" data-value="'+list[i]['comment_id']+'" data-type="comment" value="删除" /></li>'+
                        '</ul>'+
                    '</li>'+
                '</ul>';
        }
    }
    return html;
}
function expendObject(o,n){
    for (var p in n){
        if(n.hasOwnProperty(p))
            o[p]=n[p];
    }
    return o;
}
</script>