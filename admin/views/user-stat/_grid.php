<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use admin\models\VideoArea;
use admin\models\VideoChannel;
?>

<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],
        'date',
        'android_incr',
        'apple_incr',
        'total_incr',
        'day_active',
        'recharge_incr',
        'recharge_total',
        'vip_incr',
        'vip_total'
    ],

])?>
