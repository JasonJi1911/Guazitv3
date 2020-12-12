<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
?>



<?= \metronic\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'metronic\grid\SerialColumn'],

        'title',

        'typeLabel:text:类型',
        
        'answer',

        [
            'class' => 'metronic\grid\ActionColumn',
            'template' => ' {update} {delete}',
        ],
    ],

])?>
