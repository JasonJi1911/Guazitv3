<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BookChapter */

$this->title = '更新剧集：' ;
$this->params['breadcrumbs'][] = ['label' => '影片管理', 'url' => ['topic/index']];
$this->params['breadcrumbs'][] = ['label' => '剧集列表', 'url' => ['topic-video/index', 'topic_id' => Yii::$app->topic->id]];
$this->params['breadcrumbs'][] = $this->title;;
?>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>

        </div>

    </div>
    <div class="portlet-body">
        <?= $this->render('_form', [
            'model' => $model,
            'lastVideo' => $lastVideo,
            'nextVideo' => $nextVideo
        ]) ?>
    </div>
</div>
