<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

NewIndexStyleAsset::register($this);
?>
<style>
    body {
        background-color: #F9F9F9;
    }
</style>
<div class="per-box">
    <!--头部样式-->
    <div class="per-top">
        <!--个人信息-->
        <?php if($data['user']):?>
            <div class="per-xx">
                <!--头像-->
                <div class="per-h">
                    <a href="javascript:;">
                        <?php if($data['user']['avatar']):?>
                            <img src="<?=$data['user']['avatar']?>>" />
                        <?php else:?>
                            <img src="/images/newindex/logon.png" />
                        <?php endif;?>
                    </a>
                    <!--会员标识-->
                    <img class="per-h-vip" src="/images/newindex/VIP-1.png" />
                </div>
                <!--个人信息-->
                <div class="per-j">
                    <!--第一行-->
                    <div class="per-j-01 mt-20">
                        <h4 class="per-name"><?=$data['user']['nickname']?></h4>
                        <div class="per-xb">
                            <?php if($data['user']['gender']==2):?>
                                <img src="/images/newindex/nan.png" />
                            <?php elseif($data['user']['gender']==1):?>
                                <img src="/images/newindex/nv.png" />
                            <?php endif;?>
                        </div>
                        <div class="per-dj">
                            <img src="/images/newindex/lv_1.png" />
                        </div>
                        <!--<div class="per-dz">
                            <img src="/images/newindex/hlp-dz-w.png" />
                            <span class="per-d">澳大利亚</span>
                        </div>-->
                    </div>
                    <!--第二行  个性签名
                    <div class="per-qm">
                        测试个人签名
                    </div>-->
                </div>
            </div>
            <!--主页按钮     他人主页显示    个人主页删除-->
            <div class="oth-bth-box">
                <!--            <a class="oth-btn-a" href="javascript:;">私信</a>-->
                <?php if($data['user']['uid'] != $data['main_uid']):?>
                    <?php $tab = false;
                    if($data['relation']){
                        if($data['main_uid']==$data['relation']['uid']){
                            $tab=true;
                        }
                    }?>
                    <input class="oth-btn-off <?=$tab==true?'act':''?>" type="button" value="已关注" />
                    <input class="oth-btn-on <?=$tab==true?'':'act'?>" type="button" value="+关注" />
                <?php endif;?>
            </div>
        <?php endif;?>
        <!--tab切换-->
        <ul class="per-tab oth">
            <li class="act">视频</li>
            <li>剧集</li>
        </ul>
        <!--粉丝  作品数量  点赞数量-->
        <ul class="oth-sj">
            <li>粉丝：<span><?=$data['user']['fans']?></span></li>
            <li>作品：<span>0</span></li>
            <li>获赞：<span>0</span></li>
        </ul>
    </div>

    <div class="per-tab-w">
        <!--tab 视频-->
        <div class="per-tab-box act" name="zt">
            <div class="per-sp-box">
                <div class="per-slt">
                    <div class="per-slt-name" name="zt">
                        <input type="button" name="" id="" value="最近上传" />
                    </div>
                    <div class="per-slt-list" name="zt">
                        <input class="act" type="button" name="" id="" value="最近上传" />
                        <input type="button" name="" id="" value="人气最高" />
                        <input type="button" name="" id="" value="点赞最多" />
                        <input type="button" name="" id="" value="点踩最多" />
                    </div>
                </div>
                <!--个人主页显示  他人主页删除-->
                <div class="per-slt">
                    <div class="per-slt-name" name="zt">
                        <input type="button" name="" id="" value="全部" />
                    </div>
                    <div class="per-slt-list" name="zt">
                        <input class="act" type="button" name="" id="" value="全部" />
                        <input type="button" name="" id="" value="转码中" />
                        <input type="button" name="" id="" value="审核中" />
                        <input type="button" name="" id="" value="已发布" />
                        <input type="button" name="" id="" value="错误" />
                        <input type="button" name="" id="" value="上传中" />
                    </div>
                </div>
                <div class="per-ss" name="zt">
                    <input type="text" name="" id="searchvideo" value="" placeholder="搜索" />
                    <input type="button" id="" value="" />
                </div>
            </div>

            <!-- 视频 作品列表-->
            <h4 class="per-zw mt-80" name="zt">
                暂无内容
            </h4>
            <ul class="oth-list" name="zt" style="display: none;">
                <!-- li标签循环 -->
                <li>
                    <div class="oth-img-box othSp">
                        <a href="javascript:;">
                            <img src="/images/newindex/test-01.jpg" />
                            <div class="oth-time">
                                00:12:31
                            </div>
                            <div class="oth-name">
                                测试名称测试名称测试名称名称测试名称
                            </div>
                        </a>
                    </div>
                    <div class="oth-box-bow">
                        <div class="oth-box-l">
                            <img src="/images/newindex/huo.png" />
                            <span>1212</span>
                        </div>
                        <div class="oth-box-r">
                            <span>2021-07-26</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <!--tab 剧集-->
        <div class="per-tab-box" name="zt">
            <div class="per-sp-box">
                <div class="per-slt">
                    <div class="per-slt-name" name="zt">
                        <input type="button" name="" id="" value="最近上传" />
                    </div>
                    <div class="per-slt-list" name="zt">
                        <input class="act" type="button" name="" id="" value="最近上传" />
                        <input type="button" name="" id="" value="人气最高" />
                        <input type="button" name="" id="" value="点赞最多" />
                        <input type="button" name="" id="" value="点踩最多" />
                    </div>
                </div>
                <!--个人主页显示  他人主页删除-->
                <div class="per-slt">
                    <div class="per-slt-name" name="zt">
                        <input type="button" name="" id="" value="全部" />
                    </div>
                    <div class="per-slt-list" name="zt">
                        <input class="act" type="button" name="" id="" value="全部" />
                        <input type="button" name="" id="" value="转码中" />
                        <input type="button" name="" id="" value="审核中" />
                        <input type="button" name="" id="" value="已发布" />
                        <input type="button" name="" id="" value="错误" />
                        <input type="button" name="" id="" value="上传中" />
                    </div>
                </div>
                <div class="per-ss" name="zt">
                    <input type="text" name="" id="searchsmallvideo" value="" placeholder="搜索" />
                    <input type="button" id="" value="" />
                </div>
            </div>
            <!-- 剧集 作品列表-->
            <h4 class="per-zw mt-80" name="zt">
                暂无内容
            </h4>
            <ul class="oth-list" name="zt" style="display: none;">
                <!-- li标签循环 -->
                <li>
                    <div class="oth-img-box othJj">
                        <a href="javascript:;">
                            <img src="/images/newindex/RDbanner-01.jpg" />
                            <div class="oth-time">
                                <!--评分-->
                                9.6
                            </div>
                            <div class="oth-name">
                                测试名称测试名称测试名称名称测试名称
                            </div>
                        </a>
                    </div>
                    <div class="oth-box-bow">
                        <div class="oth-box-l">
                            <span>爱情</span>
                            <span>爱情</span>
                            <span>爱情</span>
                        </div>
                        <div class="oth-box-r">
                            更新：<span>50</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!--分页-->
    <div class="oth-box-02" name="zt">
        <div class="page" id="Page" name="zt">
            <!--内容全在MyPage.js内-->
        </div>
    </div>
</div>
<!--分页设置-->
<script type="text/javascript">
    // P.initMathod({
    //     params: {
    //         elemId: '#Page',
    //         total: '200',
    //         pageSize: '10'
    //     },
    //     requestFunction: function() { /*P.config.total = parseInt(Math.random() * 10 + 85);此处模拟总记录变化*/ /*TODO ajax异步请求过程,异步获取到的数据总条数赋值给 P.config.total*/ /*列表渲染自行处理*/
    //         console.log(JSON.stringify(P.config));
    //     }
    // });

    //他人主页
    $(document).ready(function() {
        //	关注按钮切换样式
        $('.oth-bth-box>input').click(function() {
            var ar = {};
            ar['other_uid'] = '<?=$data['user']['uid']?>';
            ar['type'] = 1;
            var that = this;
            $.get('/video/change-relations',ar,function(res){
                if(res.errno==0){
                    $(that).toggleClass("act").siblings("input").toggleClass("act");
                }
            });
        });
    });
</script>
