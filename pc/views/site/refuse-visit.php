<?php
?>
<style>
    .refuse {
        width: 100%;
        height: 400px;
        margin-top: 200px;
        text-align: center;
        font-size: 20px;
    }
    .detail {
        margin-top: 20px;
        font-size: 13px;
        line-height: 35px;
    }
</style>

<div class="refuse">
    <?= $data['title'] . $data['msg']?><br>
    <div class="detail">
        <?php foreach ($data['detail'] as $value) : ?>
            <?= $value?><br>
        <?php endforeach;?>
    </div>
</div>
