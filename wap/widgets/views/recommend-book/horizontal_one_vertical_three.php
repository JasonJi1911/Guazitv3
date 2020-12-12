<?php

// 竖排3个

use yii\helpers\Html;
use yii\helpers\Url;
$first_book = $recommend['list'][0];
$books = array_slice($recommend['list'], 1, 3);
?>

<div class="index-rec">
    <div class="recommend">
        <header class="header header-nospaceing book-header">
            <h3><img src="/images/icon/head-icon.png"><?= $recommend['label'] ?></h3>
        </header>
        <div class="book-list">
            <div class="item" style="margin-top: -0.2rem;margin-bottom: 0.2rem">
                <a href="<?= Url::to(['/book/info', 'id' => $first_book['book_id']]) ?>">
                    <div class="min-imgdiv">
                        <?= Html::img($first_book['cover'], ['class' => 'min-img']) ?>
                    </div>
                    <div class="min-list">
                        <span class="t"><?= $first_book['name'] ?></span>
                        <p><?= mb_substr($first_book['description'], 0, 60) .'...' ?></p>

                        <div class="min-list-author"><?= $first_book['author']?></div>
                        <ul class="tags">
                            <?php foreach ($first_book['tag'] as $item):?>
                                <li style="color: <?= $item['color']?>;">
                                    <?= $item['tab']?>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </a>
            </div>
        </div>
        <div class="books-group-with-list">
            <ul class="books-group-4 books-group-ul">
                <?php for ($i = 0 ; $i < 3; $i++):?>
                    <?php if (isset($books[$i])):?>
                        <li class="book book-click">
                            <a href="<?= Url::to(['/book/info', 'id' => $books[$i]['book_id']]) ?>">
                                <div class="book-cover-xiaoshuo">
                                    <?= Html::img($books[$i]['cover'], ['class' => 'book-cover-img-third']) ?>
                                </div>
                                <div class="comic-title"><?= $books[$i]['name'] ?></div>
                                <div class="comic-desc"><?= implode(' ', array_column($books[$i]['tag'], 'tab'))?></div>
                            </a>
                        </li>
                    <?php else:?>
                        <li class="book book-click"></li>
                    <?php endif;?>
                <?php endfor;?>
            </ul>
        </div>

        <div class="foot" recommend-id="<?= $recommend['recommend_id']?>">
            <div class="foot-more">更多<img src="/images/icon/comic_mall_more.png"></div>
            <div class="foot-exchange">换一换<img src="/images/icon/comic_mall_refresh.png"></div>
        </div>
    </div>
</div>
