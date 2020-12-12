<?php
/* @var $this yii\web\View*/
use yii\helpers\Url;

if (Yii::$app->session->getFlash('updated')) {
    \metronic\assets\ToastrAsset::register($this);
    $this->registerJs('toastr.success("保存成功", "", {timeOut: 1000});');
}

$this->params['breadcrumbs'] = [];
foreach ($tags as $tag) {
    if (Yii::$app->request->getUrl() == $tag['route']) {
        $this->title = $tag['label'];
    }
}
$this->params['breadcrumbs'][] = ['url' => '#', 'label' => '配置管理'];
?>

<div class="portlet light">
    <div class="portlet-title" style="min-height: 0px;">
        <div class="caption" style="padding: 0px;">
            <div class="tabbable-line">
                <ul class="nav nav-tabs">
                    <?php foreach ($tags as $tag): ?>
                        <li class="<?= Yii::$app->request->getUrl() == $tag['route'] ? 'active' : ''?>">
                            <a href="<?= Url::to([$tag['route']])?>"> <?= $tag['label']?> </a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>

    <?= $this->render($group, ['model' => $model])?>

</div>
