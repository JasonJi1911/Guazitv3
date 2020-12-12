<?php

use admin\models\user\UserVip;
use yii\helpers\Html;

// 筛选
function printFilters($model, $attribute, $items)
{
    $params = Yii::$app->request->queryParams;

    unset($params['page']);

    unset($params[$attribute]);

    if (is_null($model->$attribute)) {
        echo Html::a('全部', ['index'] + $params, ['class' => 'btn btn-xs green']);
    } else {
        echo Html::a('全部', ['index'] + $params, ['class' => 'btn btn-link']);
    }

    foreach ($items as $id => $text) {

        $params[$attribute] = $id;

        if (!is_null($model->$attribute) && ($model->$attribute == $id)) {
            echo Html::a($text, ['index'] + $params, ['class' => 'btn btn-xs green']);
        } else {
            echo Html::a($text, ['index'] + $params, ['class' => 'btn btn-link']);
        }
    }
}
?>

<form class="form-horizontal filter-form" >
    <div class="form-group">
        <label class="control-label col-md-1">搜索:</label>
        <div class="col-md-7">
            <?= Html::activeTextInput($searchModel, 'keyword', ['class' => 'form-control', 'placeholder' => 'UID/昵称/手机号', 'style' => 'width:50%; float:left; margin-right:5px;']) ?>
            <button class="btn btn-primary">搜索</button>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-1">来源:</label>
        <div class="col-md-11">
            <?= printFilters($searchModel, 'source', $searchModel::$sourceMap) ?>
            <?= Html::activeHiddenInput($searchModel, 'source') ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-1">性别:</label>
        <div class="col-md-11">
            <?= printFilters($searchModel, 'gender', $searchModel::$genderMap) ?>
            <?= Html::activeHiddenInput($searchModel, 'gender') ?>
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
        <label class="control-label col-md-1">会员状态:</label>
        <div class="col-md-11">
            <?= printFilters($searchModel, 'vipStatus', UserVip::$statusMap) ?>
            <?= Html::activeHiddenInput($searchModel, 'vipStatus') ?>
        </div>
    </div>

</form>


