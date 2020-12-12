<?php

// 竖排3个

use yii\helpers\Html;
use yii\helpers\Url;
$books = array_slice($recommend['list'], 0, 3);
?>

<div class="index-rec">
    <div class="recommend">
        <header class="header header-nospaceing book-header">
            <h3><img src="/images/icon/head-icon.png"><?= $recommend['label'] ?></h3>
        </header>

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
        <div class="book-list" style="margin-top: 0.2rem">
            <?php foreach (array_slice($recommend['list'], 3, 3) as $book): ?>
                <div class="item">
                    <a href="<?= Url::to(['/book/info', 'id' => $book['book_id']]) ?>">
                        <div class="min-imgdiv">
                            <?= Html::img($book['cover'], ['class' => 'min-img']) ?>
                        </div>
                        <div class="min-list">
                            <span class="t"><?= $book['name'] ?></span>
                            <p><?= mb_substr($book['description'], 0, 60) .'...' ?></p>
                            <div class="min-list-author"><?= $book['author']?></div>
                            <ul class="tags">
                                <?php foreach ($book['tag'] as $item):?>
                                    <li style="color: <?= $item['color']?>;">
                                        <?= $item['tab']?>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </a>
                </div>
            <?php endforeach ?>
        </div>

        <div class="foot" recommend-id="<?= $recommend['recommend_id']?>">
            <div class="foot-more">更多<img src="/images/icon/comic_mall_more.png"></div>
            <div class="foot-exchange">换一换<img src="/images/icon/comic_mall_refresh.png"></div>
        </div>
    </div>
</div>
