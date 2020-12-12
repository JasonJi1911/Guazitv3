<?php
//加载loading页
/* @var $this yii\web\View*/
?>

<style>
    #classList_in {
        margin-bottom: 1rem;
    }
    .more-none {
        margin: .24rem;
        height: .7rem;
        line-height: .7rem;
        color: #999;
        text-align: center;
        border-radius: .04rem;
        font-size: .24rem;
    }
</style>

<div id="classList_in">

    <div id="loading" class="more-none loading" style="display: none;">
        正在加载中，请稍候...
    </div>
    <div class="more-none none error" style="display: none;">
        网络异常，请检查网络后...
            <span class="reload">
                重试
            </span>
    </div>
    <div class="more-none none fail" style="display: none;">
        <p class="loading-txt">
            暂无页面数据，请稍候...
            <span class="reload">重试</span>
        </p>
    </div>
    <div  id="no-more" class="more-none" style="display: none;">
        没有更多了...
    </div>
</div>
