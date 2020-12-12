<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BookChapter */

$this->title = '新增剧集';
$this->params['breadcrumbs'][] = ['label' => '影片管理', 'url' => ['video/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::$app->video->title . '剧集列表', 'url' => ['video-chapter/index', 'video_id' => Yii::$app->video->id, 'id' => $model->id]];
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
        ]) ?>
    </div>
</div>
