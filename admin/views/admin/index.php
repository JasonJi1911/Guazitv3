<?php

use admin\models\Admin;
use admin\models\Role;
use yii\helpers\Html;
use metronic\grid\GridView;
use yii\helpers\ArrayHelper;
use metronic\widgets\InlineFilterForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员列表';
$this->params['breadcrumbs'][] = $this->title;
if (Yii::$app->session->getFlash('un_delete')) {
    \metronic\assets\ToastrAsset::register($this);
    $this->registerJs('toastr.error("有子级代理不可删除", "", {timeOut: 1000});');
}
?>
<div class="note note-info">
    <h4>温馨提示</h4>
    <p>1、管理员是指所有能够登录后台的账号，下方所有账号均可以登录系统后台</p>
    <p>2、每个管理员都有对应的角色，新建时可以选择，不同角色看到的后台会有一些不同，具体内容取决于当前角色的权限，权限可以在角色列表处修改</p>
    <p>3、id为1的是超级管理员，拥有所有权限，属于系统内置管理员，不可禁用或删除</p>
</div>


<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>
        <div class="actions">
            <?= Html::a('新增管理员', '/admin/create', ['class' => 'btn blue']); ?>
        </div>
    </div>

    <?php $form = InlineFilterForm::begin() ?>
    <?= $form->field($searchModel, 'role_id')->dropDownList(ArrayHelper::map(Role::find()->all(), 'id', 'name'), ['prompt' => '全部'])->label('角色') ?>
    <?= $form->field($searchModel, 'status')->dropDownList(Admin::$statuses, ['prompt' => '全部'])->label('状态') ?>
    <?= $form->field($searchModel, 'username')->label('用户名') ?>
    <?= InlineFilterForm::end() ?>
    <div class="portlet-body">
        <div class="row">
        </div>
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
            ]
        ]); ?>
    </div>
</div>

