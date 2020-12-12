<?php

use yii\helpers\Html;
use metronic\grid\GridView;
if (Yii::$app->session->getFlash('un_delete')) {
    \metronic\assets\ToastrAsset::register($this);
    $this->registerJs('toastr.error("有子级代理不可删除", "", {timeOut: 1000});');
}
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'username',
        [
            'attribute' => 'role_id',
            'value' => 'role.name',
        ],
        '@status',
        'updated_at:datetime',

        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => '{update} {toggle} {delete}',
            'visibleButtons' => [
                'toggle' => function ($model, $key, $index) {
                    // 管理员不能删除
                    return $model->id != 1;
                },
                'delete' => function ($model, $key, $index) {
                    // 管理员不能删除
                    return $model->id != 1;
                }
            ],
        ],
    ],
]); ?>
