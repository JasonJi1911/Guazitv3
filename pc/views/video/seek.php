<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

//$this->title = '求片';
NewIndexStyleAsset::register($this);

$js = <<<JS
$(function(){
    var arrIndex = {};
    var seekflag = true;
    $("#v_submit").click(function(){
        if(seekflag){
            seekflag = false;
            var tab = true;
            var str = '提交成功';
            if($("#v_videoname").val().trim() == ''){
                tab = false;
                str = '请填写影片名';
                seekflag = true;
            }else if($("#v_year").val().trim() == ''){
                tab = false;
                str = '请正确输入年代';
                seekflag = true;
            }else if($("#v_director").val().length>32){
                tab = false;
                str = '导演名称长度超出范围';
                seekflag = true;
            }else if($("#v_actors").val().length>50){
                tab = false;
                str = '演员名称长度超出范围';
                seekflag = true;
            }
            if(tab){
                arrIndex['video_name'] = $("#v_videoname").val();         
                arrIndex['channel_id'] = $("#v_channelid").val();    
                arrIndex['area_id'] = $("#v_areaid").val();    
                arrIndex['year'] = $("#v_year").val();    
                arrIndex['director_name'] = $("#v_director").val();    
                arrIndex['actor_name'] = $("#v_actors").val();   
                //发送请求，获取数据     
                $.get('/video/save-seek', arrIndex, function(s) {
                    // console.log(arrIndex);
                    if(s>0){
                        //插入成功，所有值置空
                        $("#v_videoname").val(''); 
                        $("#v_channelid").find("option").eq(0).prop("selected",true);
                        $("#v_areaid").find("option").eq(0).prop("selected",true);  
                        $("#v_year").find("option").eq(0).prop("selected",true);  
                        $("#v_director").val(''); 
                        $("#v_actors").val('');  
                        str = "提交成功";
                    }else{
                        str = "提交失败";
                    }                
                    seekflag = true;
                });
            }
            $(".alt-title").text(str);        
            $("#alt05").show(); 
        }               
    });
});
JS;

$this->registerJs($js);
?>
<style>
    body {
        background-color: #F9F9F9;
    }
</style>
<!--求片-->
<div class="seekbox">
    <div class="RANbox-title-icon">
        <img src="/images/Index/dianying-5.png" />
    </div>
    <div class="RANbox-title-name">
        <span class="RANbox-title-line"></span> 求片 <span class="RANbox-title-line"></span>
    </div>
    <div class="seekbox02" name="zt">
        <div class="seekbox02-text seekbox-title" name="zt">
            片名
        </div>
        <div class="seekbox-ipt">
            <input type="text" name="zt" id="v_videoname" placeholder="输入片名" value="" />
        </div>
        <div class="seekbox-tip">目前只提供旧片</div>
        <ul class="seekbox02-ul seek-bottom">
            <?php if(!empty($data)) :?>
                <li>
                    <select class="seek-slk" name="zt" id="v_channelid">
                        <?php foreach ($data['channels'] as $channel) :?>
                            <?php if($channel['channel_name'] != '首页') :?>
                                <option value="<?=$channel['channel_id']?>"><?=$channel['channel_name']?></option>
                            <?php endif; ?>
                        <?php endforeach;?>
                    </select>
                </li>
                <li>
                    <select class="seek-slk" name="zt" id="v_areaid">
                        <?php foreach ($data['areas'] as $area) :?>
                            <option value="<?=$area['area_id']?>"><?=$area['area']?></option>
                        <?php endforeach;?>
                    </select>
                </li>
            <?php endif;?>
            <li>
                <!--                <div class="seekbox-ipt">-->
                <!--                    <input type="text" name="zt" id="v_year" placeholder="输入片名年份" value="" />-->
                <!--                </div>-->

                <select class="seek-slk" name="zt" id="v_year">
                    <?php foreach ($data['years'] as $year) :?>
                        <option value="<?=$year['year']?>"><?=$year['year']?></option>
                    <?php endforeach;?>
                </select>
            </li>
        </ul>

        <div class="seekbox02-text seekbox-title" name="zt">
            导演
        </div>
        <div class="seekbox-ipt seek-bottom">
            <input type="text" name="zt" id="v_director" placeholder="请输入导演姓名" value="" />
        </div>
        <div class="seekbox-tip">人名之间用逗号隔开</div>

        <div class="seekbox02-text seekbox-title" name="zt">
            演员
        </div>
        <div class="seekbox-ipt seek-bottom">
            <input type="text" name="zt" id="v_actors" placeholder="请输入演员姓名" value="" />
        </div>
        <div class="seekbox-tip">人名之间用逗号隔开</div>
        <div class="seekbox-text03" name="zt">
            <span class="seekbox-title"> </span><input class="seek-btn" type="button" name="" id="v_submit" value="提交">
        </div>
        <div class="seekbox-tips">完善影片信息，求片成功率会更高</div>
    </div>
</div>
