<?php
use yii\helpers\Url;
use pc\assets\StyleMap;

$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片']);
//$this->metaTags['keywords'] = '瓜子,tv,瓜子tv,澳洲瓜子tv,澳洲,新西兰,澳新,电影,电视剧,榜单,综艺,动画,记录片';
$this->title = '瓜子TV - 澳新华人在线视频分享平台,海量高清视频在线观看';
StyleMap::register($this);
?>
<style>
    body{ font-family:"Microsoft YaHei", "微软雅黑", "STHeiti", "WenQuanYi Micro Hei", SimSun, sans-serif;}
    .myui-header__top{ position: relative; margin-bottom: 30px;}
    body.active .myui-header__top{ margin-bottom: 0;}	[class*=col-],.myui-content__list li,.myui-vodlist__media.col li{ padding: 10px}
    .btn{ border-radius: 5px;}
    .flickity-prev-next-button.previous{ left: 10px;}
    .flickity-prev-next-button.next{ right: 10px;}
    .myui-sidebar{ padding: 0 0 0 25px;}
    .myui-panel{ margin-bottom: 25px; border-radius: 5px;}
    .myui-panel-mb{ margin-bottom: 25px;}
    .myui-player__item .fixed{ width: 500px;}
    .myui-vodlist__text li a,.myui-vodlist__media li{ padding: 10px 0;}
    .myui-screen__list{ padding: 10px 10px 0;}
    .myui-screen__list li{ margin-bottom: 10px; margin-right: 10px;}
    .myui-page{ padding: 0 10px;}
    .myui-extra{ right: 20px; bottom: 30px;}
    @media (min-width: 1200px){
        .container{ max-width: 1920px;}
        .container{ padding-left: 120px;  padding-right: 120px;}
        .container.min{ width: 1200px; padding: 0;}
    }
    @media (max-width: 767px){
        body,body.active{ padding-bottom: 50px;}
        [class*=col-],.myui-panel,.myui-content__list li{ padding: 5px}
        .flickity-prev-next-button.previous{ left: 5px;}
        .flickity-prev-next-button.next{ right: 5px;}
        .myui-vodlist__text li a,.myui-vodlist__media li{ padding: 10px 0;}
        .myui-screen__list{ padding: 10px 5px 0;}
        .myui-screen__list li{ margin-bottom: 5px; margin-right: 5px;}
        .myui-extra{ right: 20px; bottom: 80px;}
        .myui-page{ padding: 0 5px;}
    }
    .myui-topbg{ position: absolute; top: 0; left: 0; right: 0; width: 100%; 	}
    .mapbody{
        font-family: "Microsoft YaHei", "微软雅黑", "STHeiti", "WenQuanYi Micro Hei", SimSun, sans-serif;
        background: #fff;
        color: #333;
        margin: 0;
        padding: 0;
        font-weight: normal;
        font-size: 14px;
        line-height: 140%;
        -webkit-overflow-scrolling: touch;
        -webkit-transition: .5s;
        -o-transition: .5s;
        -moz-transition: .5s;
        -ms-transition: .5s;
        transition: .5s;
        width: 100%;
        margin-top: 30px;
    }
    
    .browser{
        color: #666;
    }
</style>
<script src="https://kit.fontawesome.com/82b0e30b1b.js" crossorigin="anonymous"></script>
<div class="mapbody">
    <div class="container">
        <div class="row">
            <?php foreach ($channels['list'] as $s_k => $s_v): ?>
                <div class="myui-panel active myui-panel-bg2 clearfix">
                    <div class="myui-panel-box clearfix">
                        <div class="myui-panel_hd">
                            <div class="myui-panel__head clearfix">
                                <h3 class="title"><?= $s_v['channel_name'] ?></h3>
                                <a class="more text-muted" href="<?= Url::to(['list', 'channel_id' => $s_v['channel_id']])?>">
                                    查看
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="myui-panel_bd">
                            <?php foreach ($s_v['search_box'] as $cates): ?>
                                <?php if($cates['label'] != '排序') : ?>
                                    <ul class="myui-screen__list nav-slide clearfix" data-align="left">
                                        <li>
                                            <a class="btn text-muted"><?= $cates['label']?></a>
                                        </li>
                                        <?php foreach ($cates['list'] as $key => $cate): ?>
                                            <?php if($cates['field'] == 'channel_id' && $cate['checked'] == 1) : ?>
                                                <input type="hidden" id="channel-id" value="<?= $cate['value']?>">
                                            <?php endif;?>
                                            <li><a class="btn" href="<?= Url::to(['list', 'channel_id' => $s_v['channel_id'], $cates['field'] => $cate['value']])?>"><?= $cate['display']?></a></li>
                                        <?php endforeach;?>
                                    </ul>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            <?php endforeach?>
        </div>
    </div>
</div>
