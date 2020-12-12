<?php

use yii\helpers\Html;
use metronic\grid\GridView;
use metronic\widgets\InlineFilterForm;
use admin\models\pay\Goods;
use common\models\RechargeRate;
use common\helpers\Tool;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '充值套餐列表';
$this->params['breadcrumbs'][] = $this->title;

$unit = Yii::$app->setting->get('system.currency_unit');
?>

<div class="portlet light">
    <div class="portlet-title" style="min-height: 0px;">
        <div class="caption" style="padding: 0px;">
            <div class="tabbable-line">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="<?= Url::to(['/goods/recharge'])?>"> 充值套餐列表 </a>
                    </li>
                    <li class="">
                        <a href="<?= Url::to(['/goods/baoyue'])?>"> 会员套餐列表 </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><?= Html::encode($this->title) ?></span>
        </div>

        <div class="actions">
            <?= Html::createButton('充值通道管理', ['/pay-channel/index'], ['class' => ['btn', 'btn-info']]) ?>
            <?= Html::createButton('新增充值套餐', ['goods/recharge/create']) ?>
        </div>
    </div>

    <div class="note note-info">
        <h4 class="block">温馨提示</h4>
        <p>由于iOS和安卓平台支付环境的差异，下列商品是区分iOS和安卓，商品只会在对应的终端显示，即iOS商品只会在iOS端显示，设置了苹果商店商品id的为iOS商品</p>
        <p>商品名和商品描述充值时会在端上显示</p>
        <p>会员赠送表示会员充值时，可以额外赠送一定数量的券</p>
        <p>限充是只此商品每个用户充值次数的上限，超过后则不会在端上显示，设置0表示不限制</p>
        <p>
            注意：设置了<font style="color: red;">苹果商品id</font>的商品只会在iOS端展示
        </p>
    </div>

    <div class="portlet-body">
        <div class="row goods-search">
            <div class="col-md-10">
                <?php $form = InlineFilterForm::begin() ?>
                <?= $form->field($searchModel, 'title') ?>
                <?= InlineFilterForm::end() ?>
            </div>
        </div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                [
                    'label' => '商品名',
                    'format' => 'raw',
                    'value' => function($model) {
                        $html = '';

                        // 第一行：基本信息
                        $html .= '<span class="basic-info">';

                        $html .= "{$model->title}";

                        // 标签
                        if ($model->tag == Goods::TAG_HOT) {
                            $html .= '&nbsp;<span class="label label-xs label-danger">热门</span>';
                        }

                        if ($model->tag == Goods::TAG_RECOMMEND) {
                            $html .= '&nbsp;<span class="label label-xs" style="background-color:#c49f47">推荐</span>';
                        }

                        if ($model->tag == Goods::TAG_FIRST) {
                            $html .= '&nbsp;<span class="label label-xs" style="background-color:#FFC812">限时特惠</span>';
                        }


                        $html .= '</span>';

                        return $html;
                    }
                ],
                [
                    'label' => '商品价格（元）',
                    'attribute' => 'price',
                    'value' => function ($data) {
                        return Tool::moneyFormatYuan($data->price);
                    }
                ],
                [
                    'label' => '商品描述',
                    'value' => function($model) {
                        return $model->desc;
                    }
                ],
                [
                    'label' => '卡券数',
                    'format' => 'raw',
                    'value' => function($model) {
                        return $model->content;
                    }
                ],

                [
                    'label' => '会员赠送',
                    'format' => 'raw',
                    'value' => function($model) {
                        return $model->giving;
                    }
                ],
                [
                    'attribute' => 'apple_id',
                    'value' => function ($data) {
                        if ($data->apple_id) {
                            return $data->apple_id;
                        }
                        return '-';
                    }
                ],
                [
                    'label' => '限充次数',
                    'format' => 'raw',
                    'value' => function($model) {
                        if ($model->limit_num) {
                            return '<font color="#ed6b75">'.$model->limit_num.'</font>次';
                        }
                        return '无限制';
                    }
                ],
                'display_order',
                [
                    'class' => 'metronic\grid\ActionColumn',
                    'template' => '{update}{delete}'
                ],
            ],
        ]); ?>
    </div>
</div>
