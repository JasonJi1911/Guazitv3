<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

$this->title = '求片';
NewIndexStyleAsset::register($this);

$js = <<<JS
$(function(){
    var arrIndex = {};
    $("#v_submit").click(function(){
        var tab = true;
        var str = '提交成功';
        if($("#v_videoname").val().trim() == ''){
            tab = false;
            str = '请填写影片名';
        }else if(isNaN($("#v_year").val())){
            tab = false;
            str = '请正确输入年代';
        }else if($("#v_director").val().length>32){
            tab = false;
            str = '导演名称长度超出范围';
        }else if($("#v_actors").val().length>50){
            tab = false;
            str = '演员名称长度超出范围';
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
                    $("#v_year").val('');  
                    $("#v_director").val(''); 
                    $("#v_actors").val('');  
                    str = "提交成功";
                }else{
                    str = "提交失败";
                }                
            });
        }
        $(".alt-title").text(str);        
        $("#alt05").show();        
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
        <img src="/images/newindex/pianku-w.png" />
    </div>
    <div class="RANbox-title-name">
        —— 求片 ——
    </div>
    <div class="seekbox-img">
        <img src="/images/newindex/bj-03.png" />
    </div>
    <!--求片填选内容-->
    <div class="seekbox02" name="zt">
        <div class="seekbox02-text clrOrangered">
            填写影片名称(只提供旧片)
        </div>
        <div class="seekbox-ipt">
            <input type="text" name="zt" id="v_videoname" placeholder="输入片名" value="" />
        </div>
        <div class="seekbox02-text02" name="zt">
            <span>以下信息选填</span>
        </div>
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
            <li name="zt">
                年份
            </li>
            <li>
                <div class="seekbox-ipt">
                    <input type="text" name="zt" id="v_year" placeholder="输入片名年份" value="" />
                </div>
            </li>
        </ul>

        <div class="seekbox02-text" name="zt">
            导演
        </div>
        <div class="seekbox-ipt seek-bottom">
            <input type="text" name="zt" id="v_director" placeholder="输入导演" value="" />
        </div>

        <div class="seekbox02-text" name="zt">
            演员
        </div>
        <div class="seekbox-tta seek-bottom">
            <textarea placeholder="请输入演员 最多50字" name="zt" id="v_actors"></textarea>
        </div>

        <div class="seekbox-text03 seek-bottom" name="zt">
            <span class="clrOrangered">*</span>完善影片信息能够提高求片的成功率哦！
            <input class="seek-btn" type="button" name="" id="v_submit" value="提交" />
        </div>
    </div>
</div>
<!--提交成功弹出层-->
<div class="alt" id="alt05">
    <div class="alt05-box" name="zt">
        <!--报错也用这个弹出层-->
        <p class="alt-title" name="zt">求片成功</p>
        <!--多余的可以删除-->
        <div class="alt-bth-box" name="zt">
<!--            <input class="alt-bth-off closealt05" type="button" name="" id="" value="取消" />-->
            <input class="alt-bth-on" type="button" name="" id="closealt05" value="确定" />
        </div>
    </div>

    <!--关闭按钮-->
    <input class="alt-GB" type="button" id="" value="X" />
</div>