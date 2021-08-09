<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BookChapter */

$this->title = '更新剧集：' . Yii::$app->video->title;
$this->params['breadcrumbs'][] = ['label' => '影片管理', 'url' => ['video/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::$app->video->title . '剧集列表', 'url' => ['video-chapter/index', 'video_id' => Yii::$app->video->id, 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;;
?>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>

        </div>
        <span style="float:right;margin-right: 0px">
                <?php if (isset($lastVideo)) { ?>
                    <a href="/video-chapter/update?video_id=<?= $model->video_id; ?>&id=<?= $lastVideo->id; ?>" class="btn green btn-sm">上一集</a>
                <?php } ?>
            <?php if (isset($nextVideo)) { ?>
                <a href="/video-chapter/update?video_id=<?= $model->video_id; ?>&id=<?= $nextVideo->id; ?>" class="btn green btn-sm">下一集</a>
            <?php } ?>
            </span>
    </div>
    <div class="portlet-body">
        <?= $this->render('_form', [
            'model' => $model,
            'lastVideo' => $lastVideo,
            'nextVideo' => $nextVideo
        ]) ?>
    </div>
</div>
