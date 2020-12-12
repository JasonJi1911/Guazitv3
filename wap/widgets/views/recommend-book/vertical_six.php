<?php

// 竖排3个

use yii\helpers\Html;
use yii\helpers\Url;
$books = $recommend['list'];
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
            <ul class="books-group-4 books-group-ul">
                <?php for ($i = 3 ; $i < 6; $i++):?>
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
