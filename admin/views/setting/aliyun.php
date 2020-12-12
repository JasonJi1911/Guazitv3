<?php
/* @var $this yii\web\View*/

use metronic\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['url' => '#', 'label' => '配置管理'];
$this->title = '阿里云基础设置';
?>

<div class="portlet light">
    <div class="portlet-title" style="min-height: 0px;">
        <div class="caption" style="padding: 0px;">
            <div class="tabbable-line">
                <ul class="nav nav-tabs">
                    <?php foreach ($tags as $tag): ?>
                        <li class="<?= '/setting/aliyun' == $tag['route'] ? 'active' : ''?>">
                            <a href="<?= Url::to([$tag['route']])?>"> <?= $tag['label']?> </a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>

    <div class="note note-info">
        阿里云access信息，使用阿里云oss、推送等服务时需要
    </div>
    <div class="portlet-body">
        <div class="row">
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'access_key',
                'access_secret',
                [
                    'label' => '类型',
                    'value' => function($model) {
                        return $model->typeLabel;
                    }
                ],
                [
                    'class' => 'metronic\grid\ActionColumn',
                    'template' => '{update}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::actionButton('修改', ['/setting/aliyun-update','id' => $model->id], 'edit', 'blue');
                        },
                    ]
                ],
            ],
        ]); ?>
    </div>
</div>

