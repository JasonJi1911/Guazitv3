<?php

namespace metronic\widgets;

use Codeception\Lib\Connector\Yii1;
use common\helpers\OssUrlHelper;
use yii\helpers\Html;

class ActiveField extends \yii\widgets\ActiveField
{
    /**
     * @var string
     */
    // public $template = "{label}\n{input}\n";
    /**
     * {@inheritdoc}
     */
    public $labelOptions = ['class' => 'col-md-3 control-label'];
    /**
     * @var array
     */
    public $hintOptions = ['class' => 'help-block'];
    /**
     * @var array
     */
    public $wrapperOptions = ['class' => 'col-md-5'];

    /**
     * @inheritdoc
     */
    public function render($content = null)
    {
        if ($content === null) {
            if (!isset($this->parts['{input}'])) {
                $this->textInput();
            }
            if (!isset($this->parts['{label}'])) {
                $this->label();
            }
            if (!isset($this->parts['{error}'])) {
                $this->error();
            }
            if (!isset($this->parts['{hint}'])) {
                $this->hint(null);
            }

            $wrapperContent  = $this->parts['{input}'];

            if (!$this->model->hasErrors($this->attribute) && strip_tags($this->parts['{hint}'])) {
                $wrapperContent .= $this->parts['{hint}'];
            } else {
                $wrapperContent .= $this->parts['{error}'];
            }

            $content = $this->parts['{label}'] . Html::tag('div', $wrapperContent, $this->wrapperOptions);

        } elseif (!is_string($content)) {
            $content = call_user_func($content, $this);
        }

        return $this->begin() . "\n" . $content . "\n" . $this->end();
    }

    /**
     * 数字输入框
     */
    public function numberInput($options = [])
    {
        $options['type'] = 'number';

        return parent::textInput($options)->wrapper(['width' => 2]);
    }

    /**
     * 金额输入框
     */
    public function moneyInput($options = [])
    {
        $options['type'] = 'number';
        if (!isset($options['min'])) {
            $options['min'] = 0;
        }

        return parent::textInput($options)->wrapper(['width' => 2]);
    }

    /**
     * 标签输入框
     */
    public function tagsInput($options = [])
    {
        \metronic\assets\TagsInputAsset::register($this->form->getView());

        $options['data-role'] = 'tagsinput';
        Html::addCssClass($options, 'form-control input-large');

        return parent::textInput($options);
    }

    /**
     * 富文本输入框
     */
    public function summernote($options = [])
    {
        \metronic\assets\SummerNoteAsset::register($this->form->getView());

        $options['id'] = 'summernote_1';

        return parent::textarea($options)->wrapper(['width' => 9]);
    }

    /**
     * 文件上传控件
     */
    public function imageUpload($options = [])
    {
        \metronic\assets\FileInputAsset::register($this->form->getView());

        $fileType = isset($options['file_type']) ? $options['file_type'] : '1';
        if ($fileType == 2) {
            $fileName = '文件';
        } else {
            $fileName = '图片';
        }

        if (isset($options['width'])) {
            $width = $options['width'];
            unset($options['width']);
        } else {
            $width = 200;
        }

        if (isset($options['height'])) {
            $height = $options['height'];
            unset($options['height']);
        } else {
            $height = 150;
        }

        $this->form->options['enctype'] = 'multipart/form-data';
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        $html = '<div class="fileinput fileinput-new" data-provides="fileinput">';

        $value = $this->model->getAttribute($this->attribute);
        if ($value && ($value instanceof OssUrlHelper)) { // 有值并且要是图片对象
            if (!($value instanceof OssUrlHelper)) {
                $value = OssUrlHelper::set($value);
            }
            $thumb = $value;

            $html .= '<div class="fileinput-new thumbnail" style="">';
            $html .= '<img src="' . $thumb->resize($width, $height) . '" alt=""/>';
            $html .= '</div>';
        }

        $html .= '<div class="fileinput-preview fileinput-exists thumbnail" style="width:' . $width . 'px; height:' . $height . 'px;"></div>';
        $html .= '<div>';
        $html .= '  <span class="btn default btn-file">';
        $html .= '    <span class="fileinput-new">选择'.$fileName.'</span>';
        $html .= '    <span class="fileinput-exists">修改'.$fileName.'</span>';
        $html .=      Html::activeFileInput($this->model, $this->attribute, $options);
        $html .= '  </span>&nbsp;&nbsp;';
        $html .= '  <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">删除</a>';
        $html .= '</div>';

        $html .= '</div>';

        $this->parts['{input}'] = $html;

        return $this;
    }

    /**
     * 日期控件
     */
    public function datePickerInput($options = [])
    {
        \metronic\assets\DatePickerAsset::register($this->form->getView());

        Html::addCssClass($options, 'form-control date-picker');
        return parent::textInput($options)->wrapper(['width' => 3]);
    }

    /**
     * 日期时间控件
     */
    public function datetimePickerInput($options = [])
    {
        \metronic\assets\DateTimePickerAsset::register($this->form->getView());

        Html::addCssClass($options, 'form-control datetime-picker');
        return parent::textInput($options)->wrapper(['width' => 3]);
    }

    /**
     * select2控件
     */
    public function select2($items, $options = [])
    {
        \metronic\assets\Select2Asset::register($this->form->getView());

        Html::addCssClass($options, 'form-control select2');
        return parent::dropDownList($items, $options);
    }

    /**
     * 开关控件
     */
    public function switch($items = null, $options = [])
    {
        \metronic\assets\SwitchAsset::register($this->form->getView());

        if (!$items) {
            $items = [1 => '开', 2 => '关'];
        }

        $checkedValue = key($items);

        next($items);
        $uncheckedValue = key($items);

        $options['data-on-text']   = $items[$checkedValue];
        $options['data-on-value']  = $checkedValue;
        $options['data-off-text']  = $items[$uncheckedValue];
        $options['data-off-value'] = $uncheckedValue;
        $options['checked']        = (Html::getAttributeValue($this->model, $this->attribute) == $checkedValue);
        Html::addCssClass($options, 'make-switch');

        $this->parts['{input}'] = Html::input('checkbox', null, null, $options)
            . Html::activeHiddenInput($this->model, $this->attribute);

        return $this;
    }

    public function wrapper($options = [])
    {
        if (isset($options['width'])) {
            Html::addCssClass($options, 'col-md-' . $options['width']);
            unset($options['width']);
        }

        $this->wrapperOptions = array_merge($this->wrapperOptions, $options);
        return $this;
    }
}
