<?php 
use yii\helpers\Url;
?>
<script src="/js/video/swiper.min.js"></script>
<ul class="swiper-wrapper clearfix">
    <?php if(!empty($data['banner'])) : ?>
        <?php foreach ($data['banner'] as $banner): ?>
            <li class="swiper-slide" data-link="<?= $banner['content']?>">
                <div class="piclist-img" style="height: 3.75rem">
                    <span class="piclist-link" style="background-image:url(<?= $banner['image']?>);">
                        <div class="video-banner-title">
                            <p class="title"><?= $banner['title']?></p>
                        </div>
                    </span>
                </div>
            </li>
        <?php endforeach ?>
    <?php endif;?>
</ul>
<div class="swiper-pagination"></div>
<script src="/js/video/video.js?v=1.0"></script>