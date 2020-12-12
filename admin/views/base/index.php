<?php

use yii\helpers\Html;

$viewBasePath = Yii::$app->controller->viewBasePath;

$this->title = Yii::$app->controller->pageTitle;
$this->params['breadcrumbs'] = Yii::$app->controller->breadcrumbs;
?>

<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>
        <div class="actions">
            <?php foreach (Yii::$app->controller->actionButtons() as $button): ?>
            <?= Html::a($button['label'], $button['url'], $button['options']); ?>
            <?php endforeach ?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <?= $this->render("$viewBasePath/_search", [
                        'searchModel' => $searchModel,
                    ]) ?>
            </div>
        </div>
        <?= $this->render("$viewBasePath/_grid", [
                'dataProvider' => $dataProvider,
            ]) ?>
    </div>
</div>
