<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use admin\models\video\VideoCategory;
use admin\models\video\VideoChannel;

/* @var $searchModel admin\models\video\search\VideoSearch*/
// 筛选
function printFilters($model, $attribute, $items)
{
    $params = Yii::$app->request->queryParams;

    unset($params['page']);

    $where = $params;

    unset($params[$attribute]);

    if ($attribute != 'status') {
        if (!$model->$attribute) {
            echo Html::a('全部', ['index'] + $params, ['class' => 'btn btn-xs green']);
        } else {
            echo Html::a('全部', ['index'] + $params, ['class' => 'btn btn-link']);
        }
    } else {
        if (isset($where['status']) && $where['status']) {
            echo Html::a('全部', ['index'] + $params, ['class' => 'btn btn-link']);
        } else {
            echo Html::a('全部', ['index'] + $params, ['class' => 'btn btn-xs green']);
        }
    }

    foreach ($items as $id => $text) {

        $params[$attribute] = $id;

        if ($attribute != 'status') {
            if ($model->$attribute == $id) {
                echo Html::a($text, ['index'] + $params, ['class' => 'btn btn-xs green']);
            } else {
                echo Html::a($text, ['index'] + $params, ['class' => 'btn btn-link']);
            }
        } else {
            if (isset($where['status']) && $where['status'] == $id) {
                echo Html::a($text, ['index'] + $params, ['class' => 'btn btn-xs green']);
            } else {
                echo Html::a($text, ['index'] + $params, ['class' => 'btn btn-link']);
            }
        }
    }
}
?>

<form class="form-horizontal filter-form" >
    <div class="form-group">
        <label class="control-label col-md-1">搜索:</label>
        <div class="col-md-7">
            <?= Html::activeTextInput($searchModel, 'keyword', ['class' => 'form-control', 'placeholder' => '影视名称', 'style' => 'width:50%; float:left; margin-right:5px;']) ?>
            <button class="btn btn-primary">搜索</button>
        </div>
    </div>
        <div class="form-group">
            <label class="control-label col-md-1">频道:</label>
            <div class="col-md-11">
                <?= printFilters($searchModel, 'channel_id', ArrayHelper::map(VideoChannel::find()->orderBy('display_order desc')->all(), 'id', 'channel_name')) ?>
                <?= Html::activeHiddenInput($searchModel, 'channel_id') ?>
            </div>
        </div>
    <div class="form-group">
        <label class="control-label col-md-1">分类:</label>
        <div class="col-md-11">
            <?= printFilters($searchModel, 'category_ids', ArrayHelper::map(VideoCategory::find()->andFilterWhere(['channel_id' => $searchModel->channel_id])->orderBy('display_order desc')->all(), 'id', 'title')) ?>
            <?= Html::activeHiddenInput($searchModel, 'category_ids') ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-1">状态:</label>
        <div class="col-md-11">
            <?= printFilters($searchModel, 'status', $searchModel::$statusMap) ?>
            <?= Html::activeHiddenInput($searchModel, 'status') ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-1">年代:</label>
        <div class="col-md-11">
            <?= printFilters($searchModel, 'year', ArrayHelper::map(\admin\models\video\VideoYear::find()->all(),'id', 'year')) ?>
            <?= Html::activeHiddenInput($searchModel, 'year') ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-1">地区:</label>
        <div class="col-md-11">
            <?= printFilters($searchModel, 'area', ArrayHelper::map(\admin\models\video\VideoArea::find()->all(),'id', 'area')) ?>
            <?= Html::activeHiddenInput($searchModel, 'area') ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-1">连载:</label>
        <div class="col-md-11">
            <?= printFilters($searchModel, 'is_finished', $searchModel::$finishedStatus) ?>
            <?= Html::activeHiddenInput($searchModel, 'is_finished') ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-1">属性:</label>
        <div class="col-md-11">
            <?= printFilters($searchModel, 'play_limit', $searchModel::$playLimitMap) ?>
            <?= Html::activeHiddenInput($searchModel, 'play_limit') ?>
        </div>
    </div>

</form>