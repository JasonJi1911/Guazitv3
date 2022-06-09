<?php

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
        <label class="control-label col-md-1">平台:</label>
        <div class="col-md-11">
            <?= printFilters($searchModel, 'platform', $searchModel::$platformmap) ?>
            <?= Html::activeHiddenInput($searchModel, 'platform') ?>
        </div>
    </div>
</form>


