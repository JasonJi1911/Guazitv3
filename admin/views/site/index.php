<?php

/* @var $this yii\web\View 9WotZs8h59rk6QDF*/

use common\models\DrpAnnouncement;

$this->title = Yii::$app->setting->get('system.site_name');


$js = <<<JS
    $('#announce-span').click();
JS;
$this->registerJs($js);

?>

<div class="site-index">

    <div class="jumbotron" style="text-align: center">
        <h2>欢迎使用<?= $this->title?>管理后台</h2>
    </div>
</div>

