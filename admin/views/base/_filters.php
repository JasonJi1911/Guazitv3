<?php

use yii\helpers\Html;

// 筛选
function printFilters($model, $attribute, $items)
{
    $params = Yii::$app->request->queryParams;
    $route  = '/'.Yii::$app->requestedRoute;

    unset($params['page'], $params[$attribute]);

    if ($attribute == 'time') {
        unset($params['start_date'], $params['end_date']);
    }

    if (!$model->$attribute) {
        echo Html::a('全部', [$route] + $params, ['class' => 'btn btn-xs green']);
    } else {
        echo Html::a('全部', [$route] + $params, ['class' => 'btn btn-link']);
    }

    foreach ($items as $id => $text) {
        $params[$attribute] = $id;
        if ($model->$attribute == $id) {
            echo Html::a($text, [$route] + $params, ['class' => 'btn btn-xs green']);
        } else {
            echo Html::a($text, [$route] + $params, ['class' => 'btn btn-link']);
        }
    }
}

$this->registerJs('
    $(document).on("click", ".range_inputs>.applyBtn", function() {

        setTimeout(function() {
            var parts = location.href.split("?");

            var params = {};
            if (parts.length == 2) {
                $.each(parts[1].split("&"), function(index, param) {
                    if (param == "") {
                        return;
                    }

                    var arr = param.split("=");
                    if (arr.length == 1) {
                        arr.push("");
                    }
                    params[arr[0]] = arr[1];
                });
            }

            params.time       = 5;
            params.start_date = $(".daterange-picker :input:eq(1)").val();
            params.end_date   = $(".daterange-picker :input:eq(2)").val();

            var query = "";
            var ch = "?";
            $.each(params, function(key, val) {
                query += ch + key + "=" + val;
                ch = "&";
            });

            location.href = parts[0] + query;
        }, 100);
    });

    $(".picker-time").on("click", "a", function() {
        var $this = $(this);

        if ($this.text() == "自定义时间") {
            if (!$this.hasClass("btn-xs")) {
                $this.toggleClass("btn-xs green btn-link").siblings(".btn-xs").toggleClass("btn-xs green btn-link");
            }

            $(".daterange-picker").show().click();
            return false;
        }
    });
');
