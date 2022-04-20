<?php
use yii\helpers\Url;
use pc\assets\NewIndexStyleAsset;

//$this->title = '吉祥视频';
NewIndexStyleAsset::register($this);

$js = <<<JS
$(function(){
    advertByCity('searchresult');
    var tvNum = 7;//电视剧显示集数
    var page_size = "32";//默认一行8个    
    var kTab = false;
    var arrIndex = {};
    arrIndex['page_num'] = 1;       
    arrIndex['sorttype'] = 'desc';//排序默认倒叙
    arrIndex['page_size'] = page_size;
    $(document).ready(function() {
        //首次加载，结果集为0或非0样式
        var totalnum = $("#id_totalresult1").text();   
        zeroSearch(totalnum);        
        var _width = $(window).width();
        if(_width < 1366){
            tvNum = 5;
            page_size = "24";//一行6个
        }else if(_width <= 1680){
            page_size = "24";//一行6个
        }else if(_width <= 1920){
            page_size = "28";//一行7个
        }   
        
        arrIndex['page_size'] = page_size;
        arrIndex['tvNum'] = tvNum;
        arrIndex['sort']='new';     
        var kword = $('#searchkeywords').val();
        arrIndex['keyword'] = kword;
        if(kword.trim()!=''){//有关键字
            kTab = true;
        }else{//无关键字
            kTab = false;
        }   
        // console.log(kword+","+kTab);
        // console.log(arrIndex); 
        //发送请求，获取数据
        $.get('/video/refresh-video', arrIndex, function(s) {
            $('#searchVideos').html(s); // 更新内容 
            imgdelayLoading();
            $('.totalresult1').text(totalnum); //刷新影片数
            dataloading(kTab);      
            page(1,page_size,totalnum);             
            var bodycolor = $("body").attr("class");
            colorHF(bodycolor);    
        });
    });    
    
    var isFlag = true;
    $(document).on('click', '.videobtn', function() {//cate-list-li
        if(isFlag){  
            isFlag = false;
            var type = $(this).attr('data-type');
            var value = $(this).attr('data-value');
            
            //追加筛选参数
            arrIndex[type] = value;
            
            var kword = $('#searchkeywords').val();
            arrIndex['keyword'] = kword;
            if(kword.trim()!=''){//有关键字
                kTab = true;
            }else{//无关键字
                kTab = false;
            }
            
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
            var that = $(this);   
            if(type == "channel_id"){
                //发送请求，获取数据        
                $.get('/video/refresh-cate', arrIndex, function(s) {
                    refreshCate(s.data.search_box);
                    that.addClass("conditionAct").parents(".conditionType").find(".condition>li>a").removeClass("conditionAct");
                }); 
            }else{
                if(type!="sort"){
                    that.addClass("conditionAct").parents('li').siblings().find('a').removeClass("conditionAct");
                    that.addClass("conditionAct").parents('.conditionType').find('.conditionType-all>a').removeClass("conditionAct");
                }
            }
            // console.log(kword+","+kTab);
            // console.log(arrIndex);         
            //发送请求，获取数据
            $.ajax({
                url: '/video/refresh-video',
                data: arrIndex,
                type:'get',
                cache:false,
                success:function(s) {
                    $('#searchVideos').html(s); // 更新内容
                    imgdelayLoading();
                    var totalnum = $("#parcount").val();
                    zeroSearch(totalnum);
                    $('.totalresult1').text(totalnum); //刷新影片数
                    dataloading(kTab); 
                    //点击非页码，默认页面为1                
                    if(type!="page_num"){            
                       page(1,page_size,totalnum);
                    }else{
                       page(value,page_size,totalnum);
                       scrollPosition('.box02');
                    }            
                    var bodycolor = $("body").attr("class");
                    colorHF(bodycolor); 
                    isFlag = true;
                },
                error : function() {
                    console.log("数据加载失败");
                    isFlag = true;
                }
            });
        }
    });
    
    <!--关闭关键字-->
    $(document).on('click', '#searchkeywords', function() {
        $('#searchkeywords').val('');
        arrIndex['keyword'] = '';        
        dataloading(false);     
        //发送请求，获取数据
        $.get('/video/refresh-video', arrIndex, function(s) {
            $('#searchVideos').html(s); // 更新内容
            imgdelayLoading();
            var totalnum = $("#parcount").val();            
            zeroSearch(totalnum);
            $('.totalresult1').text(totalnum); //刷新影片数 
            page(1,page_size,totalnum); 
            dataloading(false);
            var bodycolor = $("body").attr("class");
            colorHF(bodycolor);            
        });
    });
    
    <!--点击三个点，加载全部-->
    $(document).on('click', '.getnum', function() {
        var value = $(this).attr('data-value');
        $(this).css('display','none');//隐藏...
        $(".hiddennum"+value).css('display','block');//显示全集      
    });    
    
    //加载数据
    function dataloading(tab){        
    /* haskeyword-有关键字样式;nokeyword-沒有关键字样式 */
        if(tab){//有关键字
            if($('.haskeyword').hasClass("hiddenclass")){                
                $('.haskeyword').removeClass("hiddenclass");        
            }            
            $('.nokeyword').addClass("hiddenclass");
        }else{
            if($('.nokeyword').hasClass("hiddenclass")){
                $('.nokeyword').removeClass("hiddenclass");        
            }            
            $('.haskeyword').addClass("hiddenclass");
        }
    }
    
    //刷新筛选条件
    function refreshCate(list){
        var content = '';
        for(var i=0;i<list.length; i++) {
            if(list[i]['label']!='排序' && list[i]['label']!='类型'){
                content += '<div class="conditionType afterhidden">' +
                            '<div class="conditionType-all" name="zt"><a href="javascript:;" >'+list[i]['label']+'</a></div>'+
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
                    content += '<li><a href="javascript:;" class="videobtn '+conditionAct+'" data-value="'+list[i]['list'][j]['value']+'" data-type="'+list[i]['field']+'">'+list[i]['list'][j]['display']+'</a></li>';
                }
                content += '</ul></div>';
            }
        }        
        $('.afterhidden').remove();
        $('#afterinput').after(content);
    }
    
    <!--分页设置-->
    function page(pageindex,page_size,total){
        // var total = $("#searchNum").text();        
        P.initMathod({
            params: {
                elemId: '#Page',
                total: total,
		        pageIndex: pageindex,
                pageSize: page_size
            },
            requestFunction: function() { /*P.config.total = parseInt(Math.random() * 10 + 85);此处模拟总记录变化*/ /*TODO ajax异步请求过程,异步获取到的数据总条数赋值给 P.config.total*/ /*列表渲染自行处理*/
                console.log(JSON.stringify(P.config));
            }
        });
    }
    
    <!--点击页面滚动到指定位置-->
    function scrollPosition(id) {
        var offset= $(id).offset();
       $('body,html').animate({
         scrollTop:offset.top-200
       })
    };
    
    <!--数据重新加载换肤问题-->
    function colorHF(bodycolor){        
        //背景色处理
        // var bodycolor = $("body").attr("class");
        if(bodycolor.indexOf("ZT-black")>=0){
            $(".afterhidden").find("[name='zt']").addClass("ZT-black");
            $(".haskeyword").addClass("ZT-black");
            $(".haskeyword").find("[name='zt']").addClass("ZT-black");
            $(".nokeyword").addClass("ZT-black");
            $(".nokeyword").find("[name='zt']").addClass("ZT-black");
        }else{               
            $(".afterhidden").find("[name='zt']").removeClass("ZT-black");
            $(".haskeyword").removeClass("ZT-black");
            $(".haskeyword").find("[name='zt']").removeClass("ZT-black");
            $(".nokeyword").removeClass("ZT-black");
            $(".nokeyword").find("[name='zt']").removeClass("ZT-black");
        }     
    }
    //结果集为0和非0样式切换
    function zeroSearch(tnum){
        if(tnum==0 || tnum=="0"){
            $('.box03').css("display","none");
            $('.box02').css("display","none");
            $('.ss_no').css("display","block");            
        }else{
            $('.box03').css("display","block");
            $('.box02').css("display","block");
            $('.ss_no').css("display","none");
        }
    }    
});
JS;

$this->registerJs($js);
?>
<style>
    body {
        background-color: #F9F9F9;
    }
    .hiddenclass{display: none}
</style>
<div class="box01 container">
    <div class="conditionBox">
        <!--搜索条件-->
        <div class="SScondition haskeyword">
            <!--按钮点击关闭 class="SScondition"，并切换成筛选结果-->
            <!-- 搜索关键字 -->
            <div class="SScondition-btn">
                <input type="button" name="" id="searchkeywords" value="<?= $keyword?>" />
            </div>
            <div class="scJg" name="zt">
                共有 <span class="totalresult1" id="id_totalresult1"><?= $info['total_count']?></span> 个搜索结果
            </div>
        </div>
        <div class="box01-content">
            <div class="box01-search">
            <input id="afterinput" type="hidden" />
            <!--类型选择-->
            <?php foreach ($info['search_box'] as $cates): ?>
                <?php if($cates['label'] != "排序" && $cates['label'] != "类型") :?>
                    <div class="conditionType afterhidden">
                        <div class="conditionType-all" name="zt">
                            <a href="javascript:;"><?= $cates['label']?>:</a>
                        </div>
                        <ul class="condition">
                            <?php foreach ($cates['list'] as $key => $cate): ?>
                                <?php if($cates['field'] == 'channel_id' && $cate['checked'] == 1) : ?>
                                    <input type="hidden" id="channel-id" value="<?= $cate['value']?>">
                                <?php endif;?>
                                <?php
                                if($cates['field'] != 'channel_id'){//频道
                                    if($cate['checked'] == 1){
                                        $conditionAct = "conditionAct";
                                    }else{
                                        $conditionAct = "";
                                    }
                                }else{//非频道
                                    if($key == 0 ){
                                        $conditionAct = "conditionAct";
                                    } else{
                                        $conditionAct = "";
                                    }
                                }
                                ?>
                                <li>
                                    <a href="javascript:;" class="videobtn <?= $conditionAct?>" data-value="<?= $cate['value']?>" data-type="<?= $cates['field']?>">
                                        <?= $cate['display']?>
                                    </a>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                <?php endif;?>
            <?php endforeach;?>
            </div>
        </div>
    </div>
    <div class="AD-01">
        <!--                --><?php //if(isset($advert['advert_id'])):?>
        <!--                    <a href="--><?//=$advert['ad_skip_url']?><!--" target="_blank"><img src="--><?//=$advert['ad_image']?><!--" /></a>-->
        <!--                --><?php //else :?>
        <!--                    <a href="javascript:;"><img src="/images/newindex/AD0-1.png" /></a>-->
        <!--                --><?php //endif;?>
        <div class="GGtext"></div>
    </div>
</div>

<!--暂无搜索数据-->
<div class="ss_no" name="zt" style="display: none;">
    <h2 class="per-zw-new" name="zt" >
        暂无内容，快去看看精彩视频吧~
    </h2>
</div>
<!--排序-->
<div class="box03 container" style="display: none;">
    <ul class="scPX" name="zt">
<!--        <li><span>更新时间</span></li>-->
        <?php foreach ($info['search_box'] as $cates): ?>
            <?php if($cates['label'] == "排序") :?>
                <li class="scJgAct videobtn" data-value="<?= ($cates['list'])[1]['value']?>" data-type="<?= $cates['field']?>"><span>添加时间</span></li>
                <li class="videobtn" data-value="<?= ($cates['list'])[0]['value']?>" data-type="<?= $cates['field']?>"><span>人气高低</span></li>
                <li class="videobtn" data-value="<?= ($cates['list'])[2]['value']?>" data-type="<?= $cates['field']?>"><span>评分高低</span></li>
            <?php endif;?>
        <?php endforeach;?>
    </ul>
    <!--搜索条件关闭时显示-->
    <div class="scJg hiddenclass nokeyword" name="zt">
        共有 <span class="totalresult1"><?= $info['total_count']?></span> 个筛选结果
    </div>
</div>

<!--筛选结果-->
<div class="box02 box02-new" style="margin:0 40px;display: none;">
    <!--筛选剧集显示列表-->
    <div id="searchVideos" name="zt">

    </div>
    <!--分页-->
    <div class="page" id="Page" name="zt">
        <!--内容全在MyPage.js内-->
    </div>
</div>
<script src="/js/jquery.js"></script>
<script src="/js/video/MyPage.js"></script>
