<?php

namespace metronic\widgets;

use yii\helpers\Html;

class InlineActiveField extends ActiveField
{
    /**
     * @var string
     */
    public $template = "{input}\n";

    /**
     * {@inheritdoc}
     */
    public function render($content = null)
    {
        if (!isset($this->parts['{label}'])) {
            $this->label();
        }
        if (!isset($this->parts['{input}'])) {
            $this->textInput();
        }

        $label = $this->parts['{label}'] ? strip_tags($this->parts['{label}']) : $this->model->getAttributeLabel($this->attribute);

        return Html::tag('label', Html::encode($label) . '：' . $this->parts['{input}']) . '&nbsp;&nbsp;';
    }
}
