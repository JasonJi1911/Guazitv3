<?php
use yii\helpers\Url;
use api\models\video\Video;

// $this->title = '瓜子TV-澳新华人在线视频分享网站';
$this->title = '瓜子TV|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv - guazitv.tv';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片']);

$js = <<<JS
$(function (){
    // $("input[name='w-video-checkbox']").click(function(){
    //     console.log($(this).is(':checked'));
    // });
    //全选
    $("input[name='w-video-checkbox-all']").click(function(){
        if($(this).is(':checked')){
            $("input[name='w-video-checkbox']").prop("checked",true);
        }else{
            $("input[name='w-video-checkbox']").prop("checked",false);
        }
    });
    //编辑/取消
    $('#w_edit').click(function(){
        var that = this;
        var text = $(that).text();
        if(text=="编辑"){
            $(that).text("取消");
            $('.w-video').addClass('w-video-edit');
            $('.w-checkbox').show();
            $('#w_remove_bottom').show();         
            $('.w-remove ').show();  
            $('.checkbox-div').addClass('checkbox-div-show');
        }else{
            $(that).text("编辑");
            $('.w-video').removeClass('w-video-edit');
            $('.w-checkbox').hide();
            $('#w_remove_bottom').hide();       
            $('.w-remove ').hide();  
            $("input[type='checkbox']").prop("checked",false); 
            $('.checkbox-div').removeClass('checkbox-div-show');
        }
    });
    $("#w_remove").click(function(){
        var ids = "";
        $("input[name='w-video-checkbox']").each(function(){
            if($(this).is(':checked')){
                ids += $(this).attr("data-id")+",";
            }
        });
        
        if(ids!=''){
            var arrIndex = {};
            arrIndex['videoid'] = ids.substring(0,ids.length-1);
            console.log(arrIndex);
            $.get('/video/change-favorite',arrIndex,function(res){
                console.log(res);
                if(res.errno==0 && res.data.status==0){
                    $("input[name='w-video-checkbox']").each(function(){
                        if($(this).is(':checked')){
                           $(this).parent().parent().remove();
                        }
                    });
                    $('#w_edit').text("编辑");
                    $('.w-video').removeClass('w-video-edit');
                    $('.w-checkbox').hide();
                    $('#w_remove_bottom').hide();       
                    $('.w-remove ').hide();   
                    $('.checkbox-div').removeClass('checkbox-div-show');
                    $("input[name='w-video-checkbox']").prop("checked",false);
                    $("#pop-tip").text("删除成功");
                    $("#pop-tip").show().delay(1500).fadeOut();
                }
            });
        }
    });
    
    /*-----------下拉加载更多------------*/
    var progress = false; // 是否正在请求中
    var isFlag = true;
    $(window).scroll(function () {
        if (($(window).scrollTop()+100) >= $(document).height() - $(window).height()) {
            if(isFlag) {
                var total = $("#w_total").val();
                var page  = $("#w_parpage").val();
                var timetitle = $(".w-time:last").text();
                var tab = $('#w_edit').text();
                if(parseInt(page) < parseInt(total) && !progress){
                    progress = true;
                    page++;
                    var params = {};
                    params['page_num'] = page;
                    params['timetitle'] = timetitle;
                    params['tab'] = tab;
                    params['order'] = 'wap-favorite-time';
                    $.get('/video/favorite-more', params, function(res) {
                        $("#w_more").append(res);
                        $("#w_parpage").val(page);
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
});
JS;

$this->registerJs($js);
?>
<style>
    .comment-bottom .bottom-text.checkall{margin-left: 0;}
    .comment-bottom .bottom-left{width: auto;display: block;}
    .comment-bottom.double-bottom{bottom: 0.95rem;}
    .checkbox-div{display:none;position: absolute;width: 100%;height: 100%;z-index: 1;top:0;}
    .checkbox-div-show{display: block;}
</style>
<input type="hidden" value="1" id="w_parpage">
<input type="hidden" value="<?= (isset($data[0]['total_page'])?$data[0]['total_page']:0 )?>" id="w_total">
<div class="display-flex outer-div sms-title pink w-title" >
<?php if($bottom!='bottom'):?>
    <a class="div-box position-r white-arrow" href="<?= Url::to(['/video/personal'])?>">
        <img src="/images/video/icon-fh-1.png">
    </a>
<?php else:?>
    <div style="width: 1rem;"></div>
<?php endif;?>
    <div class="text-center title-width">我的收藏</div>
    <div class="div-box position-r text-right" id="w_edit">编辑</div>
</div>
<div class="outer-div" ></div>
<?php if(!$data):?>
    <div class="no-video plr15">
        <img style="width: 100%;" src="/images/video/favorite_no.png" />
    </div>
<?php else :?>
    <?php foreach ($data as $i => $video):?>
        <?php if($data[$i-1]['favorite_date']!=$video['favorite_date']):?>
            <div class="text-left font14 fontW7 h08 w-time plr15"><?=$video['favorite_date']?></div>
        <?php endif;?>
        <div class="position-r plr15">
            <label class="position-r">
                <div class="w-video position-r">
                    <div class="w-checkbox">
                        <input type="checkbox" name="w-video-checkbox" data-id="<?=$video['video_id']?>"/>
                    </div>
                    <div>
                        <a href="<?= Url::to(['detail', 'video_id' => $video['video_id']])?>">
                            <img src="<?=$video['cover']?>">
                        </a>
                    </div>
                    <div class="position-r w-video-detail">
                        <div class="font14 h05">
                            <a href="<?= Url::to(['detail', 'video_id' => $video['video_id']])?>"><?=$video['video_name']?></a>
                        </div>
                        <div class="category">
                            <span><?=$video['year']?></span>
                            <?php foreach (explode(' ',$video['category']) as $category): ?>
                                <span><?= $category?></span>
                            <?php endforeach;?>
                        </div>
                        <div class="font14 h05 colorB2"><?=$video['is_finished']==1? '完结' : '更新中' ?></div>
                        <div class="font14 h05 colorB2 w-bottom-time"><?=(($video['type']==Video::STATUS_DISABLED)?$video['flag']:'')?></div>
                    </div>
                </div>
                <!-- 编辑遮罩层 -->
                <div class="checkbox-div"></div>
            </label>
        </div>
    <?php endforeach;?>
    <div id="w_more"></div>
<?php endif;?>
<div class="outer-div w-remove" style="display:none;" ></div>
<div id="w_remove_bottom" class="comment-bottom w-remove <?=$bottom=='bottom' ? 'double-bottom' : '' ;?>" style="display:none;" >
    <label class="bottom-left" id="w_checkall">
        <input class="w-checkbox-bottom" type="checkbox" name="w-video-checkbox-all"/>
        <span class="bottom-text checkall">全选</span>
    </label>
    <div class="bottom-right" id="w_remove" >
        <span class="bottom-text" style="color:#FF556E;">删除</span>
    </div>
</div>
<!--底部导航-->
<?php if($bottom=='bottom'):?>
<div style="width:100%;height:1rem;"></div>
<div class="bottom-navi">
    <?php echo $this->render('/video/bottom',[
        'tab' =>    'favorite'
    ]);?>
</div>
<?php endif;?>

