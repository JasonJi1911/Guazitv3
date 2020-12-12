<?php

namespace metronic\widgets;

use yii\helpers\Html;

/**
 * 筛选表单
 *
 */
class FilterForm extends \yii\widgets\ActiveForm
{
    /**
     * {@inheritdoc}
     */
    public $options = ['class' => 'form-horizontal'];
    /**
     * {@inheritdoc}
     */
    public $method = 'get';
    /**
     * {@inheritdoc}
     */
    public $fieldClass = 'metronic\widgets\ActiveField';

    /**
     * {@inheritdoc}
     */
    public static function end()
    {
        echo Html::submitButton('搜索', ['class' => 'btn green']);

        parent::end();
    }
}
