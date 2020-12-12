<?php

// 横版四个横封面风格

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="index-rec">
    <header class="header header-nospaceing comic-header">
        <h3 class="title"><img src="/images/icon/comic-head-icon.png"><?= $recommend['label'] ?></h3>
    </header>
    <div class="books-group-4n comic-hor">
        <ul class="books-group-4">
            <?php foreach (array_slice($recommend['list'], 0, 2) as $comic): ?>
                <li class="book book-click">
                    <a href="<?= Url::to(['/comic/info', 'id' => $comic['comic_id']]) ?>">
                        <div class="book-cover">
                            <?= Html::img($comic['horizontal_cover'], ['class' => 'book-cover-img-half']) ?>
                            <div class="update-chapter"><?= $comic['flag']?></div>
                        </div>
                        <div class="comic-title"><?= $comic['name'] ?></div>
                            <div class="comic-desc"><?= $comic['description']?></div>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
        <ul class="books-group-4 comic-hor">
            <?php foreach (array_slice($recommend['list'], 2, 2) as $comic): ?>
                <li class="book book-click">
                    <a href="<?= Url::to(['/comic/info', 'id' => $comic['comic_id']]) ?>">
                        <div class="book-cover">
                            <?= Html::img($comic['horizontal_cover'], ['class' => 'book-cover-img-half']) ?>
                            <div class="update-chapter"><?= $comic['flag']?></div>
                        </div>
                        <div class="comic-title"><?= $comic['name'] ?></div>
                        <div class="comic-desc"><?= $comic['description']?></div>
                    </a>
                </li>
            <?php endforeach ?>
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
