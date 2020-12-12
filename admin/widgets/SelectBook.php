<?php

namespace admin\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * 选择作品
 *
 * @since 1.0
 */
class SelectBook extends Widget
{
    /**
     * @var ActiveForm 表单
     */
    public $form;
    /**
     * @var Model 模型
     */
    public $model;
    /**
     * @var string 属性
     */
    public $attribute = 'book_id';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Executes the widget.
     */
    public function run()
    {
        $this->view->registerJsFile('/js/book-select2.js', ['depends' => 'metronic\assets\Select2Asset']);

        $field   = $this->form->field($this->model, $this->attribute)->wrapper(['width' => 7]);
        $book_id = $this->model->getAttribute($this->attribute);
        
        if (!$this->model->isNewRecord) {
            return $field->textInput(['value' => $this->model->book->name . '_' . $this->model->book->author, 'disabled' => true]);
        } else {
            return $field->select2($book_id ? [$book_id => $this->model->book->name . '_' . $this->model->book->author] : [], ['class' => 'book']);
        }
    }
}
