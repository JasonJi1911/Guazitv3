<?php

namespace metronic\widgets;

/**
 * 单行筛选表单
 *
 */
class InlineFilterForm extends FilterForm
{
    /**
     * {@inheritdoc}
     */
    public $options = ['class' => 'form-inline'];
    /**
     * {@inheritdoc}
     */
    public $fieldClass = 'metronic\widgets\InlineActiveField';
}
