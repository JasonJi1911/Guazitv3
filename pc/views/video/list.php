<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

//$this->title = '筛选结果';
NewIndexStyleAsset::register($this);

$js = <<<JS
$(function(){
    //筛选影片
    var page_size = "28";//默认一行8个
    var arrIndex = {};
    arrIndex['page_num'] = 1;       
    arrIndex['sorttype'] = 'desc';//排序默认倒叙
    arrIndex['channel_id'] = $('#channel-id').val();
    arrIndex['tag'] = $('#tag-id').val();
    arrIndex['area'] = $('#area-id').val();  
    arrIndex['year'] = $('#year-id').val();   
    arrIndex['page_size'] = page_size;
    //首次加载
    $(document).ready(function() {
        //根据屏幕确认page_size
        var _width = $(window).width();
        if(_width < 1680){
            page_size = "24";//一行6个
        }else if(_width < 1900){
            page_size = "28";//一行7个
        }        
        arrIndex['page_size'] = page_size;
        arrIndex['sort']='hot';
        
        //发送请求，获取数据     
            //console.log(arrIndex);
        $.get('/video/refresh-cate', arrIndex, function(s) {
            //console.log(s);
            var data = s.data.list;
            var content = refreshVideo(data);//加载影片数据
            $('#searchVideos').html(content); // 更新内容
            $('#searchNum').text(s.data.total_count); //刷新影片数  
            //背景色处理
            var bodycolor = $("body").attr("class");
            if(bodycolor.indexOf("ZT-black")>=0){
                $("#searchVideos").find("[name='zt']").addClass("ZT-black");
                $(".conditionBox").addClass("ZT-black");
                $(".conditionBox").find("[name='zt']").addClass("ZT-black");
            }else{               
                $("#searchVideos").find("[name='zt']").removeClass("ZT-black");                
                $(".conditionBox").removeClass("ZT-black");
                $(".conditionBox").find("[name='zt']").removeClass("ZT-black");
            }              
            page(1,page_size);           
        });
    });
    
    //筛选条件点击加载
    var isFlag = true;
    $(document).on('click', '.videobtn', function() {
        if(isFlag){  
            isFlag = false;
            var type = $(this).attr('data-type');
            var value = $(this).attr('data-value');        
            
            //追加筛选参数
            arrIndex[type] = value;
            //点击非页码，默认页面为1
            if(type!="page_num"){            
               arrIndex['page_num']= 1; 
            }        
            if(type=="sort"){//排序样式
                if($(this).hasClass("scJgAct")) {
                    $(this).find("span").toggleClass("pxBj");//箭头切换
                    if($(this).find("span").hasClass("pxBj")){
                        arrIndex['sorttype'] = 'asc';//排序正序
                    }else{
                        arrIndex['sorttype']='desc';
                    }  
                } else {
                    $(this).addClass("scJgAct").siblings().removeClass("scJgAct");
                    $(this).siblings().find("span").removeClass("pxBj");                
                    arrIndex['sorttype']='desc';
                }
            }        
            // console.log("条件");    
            // console.log(arrIndex); 
            var that = $(this);        
            if(type!="sort"){//不重新加载条件
                that.addClass("conditionAct").parents('li').siblings().find('a').removeClass("conditionAct");
                that.addClass("conditionAct").parents('.conditionType').find('.conditionType-all>a').removeClass("conditionAct");
            }
            //发送请求，获取数据   
            $.ajax({
                url: '/video/refresh-cate',
                data: arrIndex,
                type:'get',
                cache:false,
                dataType:'json',
                success:function(s) {  
                    var data = s.data.list;
                    var content = refreshVideo(data);                
                    if(type == "channel_id"){
                        refreshCate(s.data.search_box);//加载筛选条件
                        that.addClass("conditionAct").parents(".conditionType").find(".condition>li>a").removeClass("conditionAct");
                    }
                    $('#searchVideos').html(content); // 更新内容
                    $('#searchNum').text(s.data.total_count); //刷新影片数
                    //背景色处理
                    var bodycolor = $("body").attr("class");
                    if(bodycolor.indexOf("ZT-black")>=0){
                        $("#searchVideos").find("[name='zt']").addClass("ZT-black");
                        $(".conditionBox").find("[name='zt']").addClass("ZT-black");
                    }else{               
                        $("#searchVideos").find("[name='zt']").removeClass("ZT-black");
                        $(".conditionBox").find("[name='zt']").removeClass("ZT-black");
                    }  
                    //点击非页码，默认页面为1                
                    if(type!="page_num"){            
                       page(1,page_size);
                    }else{
                       page(value,page_size);
                       scrollPosition('.box02');
                    }
                    // console.log("结果");   
                    // console.log(s.data.total_count+","+data[0]['video_name']); 
                    isFlag = true;
                },
                error : function() {
                    console.log("数据加载失败");
                    isFlag = true;
                }
            }); 
        }
    });        
    
    //筛选条件
    function refreshCate(list){
        var content = '';
        for(var i=0;i<list.length; i++) {
            if(list[i]['label']!='排序'){
                content += '<div class="conditionType">' +
                            '<div class="conditionType-all" name="zt"><a href="javascript:;">'+list[i]['label']+'</a></div>'+
                            '<ul class="condition" name="zt">';                
                for(var j=0;j<list[i]['list'].length;j++){
                    if(list[i]['field'] == 'channel_id' && list[i]['list'][j]['checked'] == 1){
                        content += "<input type='hidden' id='channel-id' value='"+list[i]['list'][j]['value']+"'>";
                    }
                    var conditionAct = "";
                    if((list[i]['field'] == 'channel_id' && list[i]['list'][j]['checked'] == 1)
                    || (list[i]['field'] == 'tag' && list[i]['list'][j]['checked'] == 1)
                    || (list[i]['field'] == 'area' && list[i]['list'][j]['checked'] == 1)
                    || (list[i]['field'] == 'year' && list[i]['list'][j]['checked'] == 1)
                    || (list[i]['field'] == 'status' && list[i]['list'][j]['checked'] == 1)){
                        conditionAct = "conditionAct";
                    }else{
                        conditionAct = "";
                    }
                    if(!(list[i]['field']=='channel_id' && list[i]['list'][j]['display']=='全部')){
                        content += '<li><a href="javascript:;" class="videobtn '+conditionAct+'" data-value="'+list[i]['list'][j]['value']+'" data-type="'+list[i]['field']+'">'+list[i]['list'][j]['display']+'</a></li>';
                    }                    
                }
                content += '</ul></div>';
            }
        }        
        $('.box01-search').html(content);
    }
    
    //刷新影片内容
    function refreshVideo(data) {
        var content = '';
        for (var i=0; i<data.length; i++) { //拼接换一换内容
            var actors = '';
            var intro="";
            if (data[i]['actors'] != undefined) {
                for (var j=0; j<data[i]['actors'].length; j++) {  
                    // if(j >5){break;}
                    if(data[i]['actors'] !=''){
                        if(j==0){
                            actors += data[i]['actors'][j]['actor_name'];
                        }else{
                            actors += " / "+data[i]['actors'][j]['actor_name'];
                        }
                    }
                }
            }
            var categorylist = "";
            var categorylist2 = "";
            if (data[i]['category'] != undefined) {
                var arr = data[i]['category'].split(/[ ]+/);//以空格分开
                for (var j=0; j<arr.length; j++) { 
                    categorylist += "<li>"+arr[j]+"</li>"
                    categorylist2 += "<span>"+arr[j]+"</span>";
                    
                }
            }
            content += "<li class='Movie-list'>"+
                            "<a class='Movie' href='/video/detail?video_id="+data[i]['video_id']+ "' >"+
                                "<img class='Movie-img i_background_errorimg' src='"+data[i]['cover']+"' />" +
                                // "<div class='oth-time'>"+data[i]['score']+"</div>"+
                                "<div class='palyBtn'><img src='/images/newindex/bofang.png' /></div>" +
                                "<div class='Movie-details' name='zt'>" +
                                    "<div class='Movie-name01' name='zt'>"+data[i]['video_name']+"</div>" +
                                    "<ul class='Movie-type' name='zt'>"+categorylist+"</ul>" +
                                    "<div class='Movie-star' name='zt'>主演：<span>"+ actors +"</span></div>" +
                                    "<div class='Movie-content' name='zt'>简介：<span>"+data[i]['intro']+"</span></div>" +
                                    "<ul class='Movie-btm' name='zt'><li>"+data[i]['play_times']+"</li></ul>" +
                                "</div>"+
                            "</a>"+
                            "<a class='Movie-name02' name='zt' href='/video/detail?video_id="+data[i]['video_id']+ "' >"+data[i]['video_name']+"</a>"+
                            "<div class='Movie-type02' name='zt'>"+
                                "<div>"+categorylist2+"</div>"+      
                                "<div>"+data[i]['flag']+"</div>"+
                            "</div>"+
                       "</li>";
        };        
        return content;
    }  
    
    <!--点击页面滚动到指定位置-->
    function scrollPosition(id) {
        var offset= $(id).offset();
       $('body,html').animate({
         scrollTop:offset.top-200
       })
    };
    
// "<div class='Movie-J'><img src='/images/newindex/tuijian.png' /></div><div class='Movie-X'>新</div>"+
    <!--分页设置-->
    function page(pageindex,page_size){
        var total = $("#searchNum").text();        
        P.initMathod({
            params: {
                elemId: '#Page',
                total: total,
		        pageIndex: pageindex,
                pageSize: page_size
            },
            requestFunction: function() { /*P.config.total = parseInt(Math.random() * 10 + 85);此处模拟总记录变化*/ /*TODO ajax异步请求过程,异步获取到的数据总条数赋值给 P.config.total*/ /*列表渲染自行处理*/
                // console.log(JSON.stringify(P.config));
            }
        });
    }
    
});
JS;

$this->registerJs($js);
?>

<style>
    body {
        background-color: #F9F9F9;
    }
</style>
<!--筛选条件-->
<div class="box01" name="zt">
    <div class="conditionBox" name="zt">
        <div class="box02-content">
            <div class="box01-search">
                <!--类型选择-->
                <?php foreach ($info['search_box'] as $cates): ?>
                    <?php if($cates['label'] != "排序") :?>
                        <div class="conditionType">
                            <div class="conditionType-all" name="zt">
                                <a href="javascript:;"><?= $cates['label']?>:</a>
                            </div>
                            <ul class="condition" name="zt">
                                <?php foreach ($cates['list'] as $key => $cate): ?>
                                    <?php if($cates['field'] == 'channel_id' && $cate['checked'] == 1) : ?>
                                        <input type="hidden" id="channel-id" value="<?= $cate['value']?>">
                                    <?php endif;?>
                                    <?php if($cates['field'] == 'tag' && $cate['checked'] == 1) : ?>
                                        <input type="hidden" id="tag-id" value="<?= $cate['value']?>">
                                    <?php endif;?>
                                    <?php if($cates['field'] == 'area' && $cate['checked'] == 1) : ?>
                                        <input type="hidden" id="area-id" value="<?= $cate['value']?>">
                                    <?php endif;?>
                                    <?php if($cates['field'] == 'year' && $cate['checked'] == 1) : ?>
                                        <input type="hidden" id="year-id" value="<?= $cate['value']?>">
                                    <?php endif;?>
                                    <?php if(!($cates['field'] == 'channel_id' && $cate['display']=='全部')):?><!--频道的全部不要-->
                                        <li>
                                            <a href="javascript:;" class="videobtn
                                            <?php if(($cates['field'] == 'channel_id' && $cate['checked'] == 1)
                                                || ($cates['field'] == 'tag' && $cate['checked'] == 1)
                                                || ($cates['field'] == 'area' && $cate['checked'] == 1)
                                                || ($cates['field'] == 'year' && $cate['checked'] == 1)
                                                || ($cates['field'] == 'status' && $cate['checked'] == 1)) :?>
                                             conditionAct
                                            <?php endif; ?>" data-value="<?= $cate['value']?>" data-type="<?= $cates['field']?>">
                                                <?= $cate['display']?>
                                            </a>
                                        </li>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>

<!--排序-->
<div class="box03">
    <ul class="scPX" name="zt">
        <?php foreach ($info['search_box'] as $cates): ?>
            <?php if($cates['label'] == "排序") :?>
                <?php $scJgAct0 = "scJgAct";$scJgAct1 = "";$scJgAct2 = "";
                foreach ($cates['list'] as $key => $cate) {
                    if($cates['field'] == 'sort' && $cate['checked'] == 1){
                        if($key == 0){
                            $scJgAct0 = "scJgAct";
                            $scJgAct1 = "";
                            $scJgAct2 = "";
                        }else if($key == 1){
                            $scJgAct0 = "";
                            $scJgAct1 = "scJgAct";
                            $scJgAct2 = "";
                        }else if($key == 2){
                            $scJgAct0 = "";
                            $scJgAct1 = "";
                            $scJgAct2 = "scJgAct";
                        }
                    }
                }
                //默认人气高低
                $scJgAct0 = "scJgAct";
                $scJgAct1 = "";
                $scJgAct2 = "";
                ?>
                <li class="videobtn <?=$scJgAct1?>" data-value="<?= ($cates['list'])[1]['value']?>" data-type="<?= $cates['field']?>"><span>添加时间</span></li>
                <li class="videobtn <?=$scJgAct0?>" data-value="<?= ($cates['list'])[0]['value']?>" data-type="<?= $cates['field']?>"><span>人气高低</span></li>
                <li class="videobtn <?=$scJgAct2?>" data-value="<?= ($cates['list'])[2]['value']?>" data-type="<?= $cates['field']?>"><span>评分高低</span></li>
            <?php endif;?>
        <?php endforeach;?>


    </ul>
    <div class="scJg" name="zt">
        共有 <span id="searchNum"><?= $info['total_count']?></span> 个筛选结果
    </div>
</div>
<!--筛选结果-->
<div class="box02">
    <!--筛选剧集显示列表-->
    <ul class="Sports-box" id="searchVideos" name="zt">

    </ul>
    <!--分页-->
    <div class="page" id="Page" name="zt">
        <!--内容全在MyPage.js内-->
    </div>
</div>
<!--暂无搜索数据-->
<div class="ss_no" name="zt" style="display: none;">
    <h2 class="per-zw-new" name="zt" >
        暂无内容，快去看看精彩视频吧~
    </h2>
</div>
<script src="/js/jquery.js"></script>
<script src="/js/video/MyPage.js"></script>

