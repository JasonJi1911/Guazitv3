<?php

// 竖行六个风格

use yii\helpers\Html;
use yii\helpers\Url;
$comics = $recommend['list'];
?>

<div class="index-rec">
    <header class="header header-nospaceing comic-header">
        <h3 class="title"><img src="/images/icon/comic-head-icon.png"><?= $recommend['label'] ?></h3>
    </header>
    <div class="books-group-4n">
        <ul class="books-group-4">
            <?php for ($i = 0; $i < 3; $i++):?>
                <?php if(isset($comics[$i])):?>
                    <li class="book book-click comic-cover">
                        <a href="<?= Url::to(['/comic/info', 'id' => $comics[$i]['comic_id']]) ?>">
                            <div class="book-cover">
                                <?= Html::img($comics[$i]['vertical_cover'], ['class' => 'book-cover-img-third']) ?>
                                <div class="update-chapter"><?= $comics[$i]['flag']?></div>
                            </div>
                            <div class="comic-title"><?= $comics[$i]['name'] ?></div>
                            <div class="comic-desc"><?= implode(' ', array_column($comics[$i]['tag'], 'tab'))?></div>
                        </a>
                    </li>
                <?php else:?>
                    <li class="book book-click comic-cover"></li>
                <?php endif;?>
            <?php endfor;?>
        </ul>
        <ul class="books-group-4">
            <?php for ($i = 3; $i < 6; $i++):?>
                <?php if(isset($comics[$i])):?>
                    <li class="book book-click comic-cover">
                        <a href="<?= Url::to(['/comic/info', 'id' => $comics[$i]['comic_id']]) ?>">
                            <div class="book-cover">
                                <?= Html::img($comics[$i]['vertical_cover'], ['class' => 'book-cover-img-third']) ?>
                                <div class="update-chapter"><?= $comics[$i]['flag']?></div>
                            </div>
                            <div class="comic-title"><?= $comics[$i]['name'] ?></div>
                            <div class="comic-desc"><?= implode(' ', array_column($comics[$i]['tag'], 'tab'))?></div>
                        </a>
                    </li>
                <?php else:?>
                    <li class="book book-click comic-cover"></li>
                <?php endif;?>
            <?php endfor;?>
        </ul>

        <div class="recommend">
            <div class="foot" recommend-id="<?= $recommend['recommend_id']?>">
                <div class="foot-more">更多<img src="/images/icon/comic_mall_more.png"></div>
                <div class="foot-exchange">换一换<img src="/images/icon/comic_mall_refresh.png"></div>
            </div>
        </div>
    </div>
<!--    <div class="seperator"></div>-->
</div>
