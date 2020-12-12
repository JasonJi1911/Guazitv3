<?php

use admin\models\user\CancelAccountLog;
use yii\helpers\Html;
use yii\widgets\DetailView;
use admin\models\user\User;

$this->params['breadcrumbs'][] = ['label' => '注销帐号', 'url' => ['index']];
$this->params['breadcrumbs'][] = '用户信息';
?>
<div class="extract-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => '用户名',
                'format' => 'raw',
                'value' => function ($model) {
                    $userInfo = User::findOne(['uid' => $model->uid]);
                    return isset($userInfo->nickname) ? $userInfo->nickname : '';
                }
            ],
            [
                'attribute' => '状态',
                'format' => 'raw',
                'value' => function ($model) {
                    return CancelAccountLog::$statuses[$model->status];
                }
            ],
            'remark',
            'extract_at:datetime',
            'created_at:datetime',
        ],
    ]) ?>

</div>
