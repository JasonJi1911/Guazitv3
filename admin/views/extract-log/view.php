<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\WxSetting */

$this->params['breadcrumbs'][] = ['label' => '提现', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                    $userInfo = $model->user;
                    return $userInfo->nickname ? $userInfo->nickname : $userInfo->user_name;
                }
            ],
            'trade_no',
            'mobile',
            'total_fee',
            'gold_num',
            'openid',
            'out_trade_no',
            [
                'attribute' => '状态',
                'format' => 'raw',
                'value' => function ($model) {
                    return \common\models\ExtractLog::$statuses[$model->status];
                }
            ],
            'remark',
            'extract_at:datetime',
            'created_at:datetime',
        ],
    ]) ?>

</div>
