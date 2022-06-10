<?php
use yii\helpers\Url;

$this->title = '瓜子TV|澳洲瓜子tv|澳新瓜子|澳新tv|澳新瓜子tv - guazitv.tv';
$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片']);

$js = <<<JS
$(function (){
    /*-----------下拉加载更多------------*/
    var progress = false; // 是否正在请求中
    var isFlag = true;
    $(window).scroll(function () {
        if (($(window).scrollTop()+100) >= $(document).height() - $(window).height()) {
            if(isFlag) {
                var total = $("#w_total").val();
                var page  = $("#w_parpage").val();
                if(parseInt(page) < parseInt(total) && !progress){
                    progress = true;
                    page++;
                    var params = {};
                    params['page_num'] = page;
                    $.get('/video/mycomment-more', params, function(res) {
                        $("#w_more").append(res);
                        $("#w_parpage").val(page);
                        progress = false;
                    });
                } else if (page == total) {
                    $("#no-more").show();
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
    .comment-div{display: grid;grid-template-columns: 20px auto;grid-gap: 10px;margin:10px 0;}
    .comment-avatar{width: 100%;}
    .h-content{height: auto;line-height: 20px; }
</style>
<input type="hidden" value="1" id="w_parpage">
<input type="hidden" value="<?= (isset($data[0]['total_page'])?$data[0]['total_page']:0 )?>" id="w_total">
<div class="display-flex outer-div sms-title pink" >
    <a class="div-box position-r white-arrow" href="<?= Url::to(['/video/personal'])?>">
        <img src="/images/video/icon-fh-1.png">
    </a>
    <div class="text-center title-width">我的评论</div>
    <div class="div-box position-r"></div>
</div>
<?php if(!$data):?>
    <div class="h20 color91 fontW7 text-center mt20">暂无评论</div>
<?php else :?>
    <?php foreach ($data as $comment):?>
        <div class="plr15 comment-div font12">
            <div>
                <img class="comment-avatar" src="<?=$comment['avatar']?>" onerror="this.src='/images/video/touxiang.png'" />
            </div>
            <div>
                <div class="h20 color91"><?=$comment['username']?></div>
                <div class="h20 color91"><?=$comment['date']?></div>
                <div class="h-content"><?=$comment['content']?></div>
                <div class="h20">《<?=$comment['film_name']?>》</div>
                <div class="line mt5" ></div>
            </div>
        </div>
    <?php endforeach;?>
    <div id="w_more"></div>
<?php endif;?>
<div id="no-more" class="h20 color91 font12 fontW7 text-center" style="display: none;">没有更多内容了</div>
