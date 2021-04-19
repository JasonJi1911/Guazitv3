<?php 
use yii\helpers\Url;
?>

<div class="slider slider-for">
    <?php if(!empty($data['banner'])) : ?>
        <?php foreach ($data['banner'] as $banner): ?>
            <div>
                <a href="<?= str_replace("/detail","/detail",$banner['content'])?>"
                   style="background-image: url(<?= $banner['image']?>)">
                    <img src="<?= $banner['image']?>" alt="">
                </a>
            </div>
        <?php endforeach ?>
    <?php endif;?>
</div>
<div class="slider slider-nav qy20-h-carousel_panel-list">
    <?php if(!empty($data['banner'])) : ?>
        <?php foreach ($data['banner'] as $banner): ?>
            <div class="panel-item">
                <a href="<?= str_replace("/detail","/detail",$banner['content'])?>" class="panel-item-link">
                    <p class="panel-item-title">
                        <span class="panel-ico">
                            <img src="/images/NewVideo/83cdbeafb78647f2b7b141e6cb87733a.svg" alt="角标" class="panel-img">
                        </span>
                        <span class="title-main"><?= $banner['title']?></span>
                        <p  class="stitle-main" ><?= $banner['stitle']?></p>
                    </p>
                    <!--                        <p class="panel-item-dec"></p>-->
                </a>
            </div>
        <?php endforeach ?>
    <?php endif;?>
</div>