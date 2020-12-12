<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@admin', dirname(dirname(__DIR__)) . '/admin');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@metronic', dirname(dirname(__DIR__)) . '/metronic');
Yii::setAlias('@page', dirname(dirname(__DIR__)) . '/page');
Yii::setAlias('@wap', dirname(dirname(__DIR__)) . '/wap');
Yii::setAlias('@pc', dirname(dirname(__DIR__)) . '/pc');

Yii::$classMap['yii\helpers\Html']    = '@metronic/helpers/Html.php';
Yii::$classMap['yii\web\JqueryAsset'] = '@metronic/assets/JqueryAsset.php';
