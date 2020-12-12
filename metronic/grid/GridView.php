<?php

namespace metronic\grid;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\LinkPager;

class GridView extends \yii\grid\GridView
{
    /**
     * @var string the default data column class if the class name is not explicitly specified when configuring a data column.
     */
    public $dataColumnClass = 'metronic\grid\DataColumn';

    public $options = ['class' => 'table grid-view', 'style' => 'overflow-y: hidden;'];
    public $layout = "{items}\n{batchActions}\n{pager}\n{summary}";
    public $batchActions = [];

    /**
     * {@inheritdoc}
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{batchActions}':
                return $this->renderBatchActions();
            default:
                return parent::renderSection($name);
        }
    }

    public function renderBatchActions()
    {
        if (!$this->batchActions) {
            return '';
        }

        \metronic\assets\BatchActionsAsset::register($this->getView());
        
        $html = '<div class="batch-actions">';

        foreach ($this->batchActions as $action) {
            $html .= Html::a($action['label'], $action['url'], ['class' => 'btn ' . $action['class']]);
        }

        $html .= '</div>';

        return $html;
    }

    // protected function createDataColumn($text)
    // {
    //     if (!preg_match('/^([^:]+)(:(\w*))?(:(.*))?$/', $text, $matches)) {
    //         throw new InvalidConfigException('The column must be specified in the format of "attribute", "attribute:format" or "attribute:format:label"');
    //     }

    //     $attribute = $matches[1];

    //     $ch = substr($attribute, -1);
        
    //     if (in_array($ch, ['!', ''])) {
    //         $attribute = substr($attribute, 0, -1);
            
    //         $value = function ($model, $key, $index, $grid) use ($attribute) {
    //             $attribute = $attribute . 'Text';
    //             return $model->$attribute;
    //         };
    //     }

    //     $params = [
    //         'class' => $this->dataColumnClass ?: DataColumn::className(),
    //         'grid' => $this,
    //         'attribute' => $attribute,
    //         'format' => isset($matches[3]) ? $matches[3] : 'text',
    //         'label' => isset($matches[5]) ? $matches[5] : null,
    //     ];

    //     if (!empty($value)) {
    //         $params['value'] = $value;
    //     }

    //     return Yii::createObject($params);
    // }

    /**
     * 分页
     */
    public function renderPager()
    {
        $pagination = $this->dataProvider->getPagination();
        if ($pagination === false || $this->dataProvider->getCount() <= 0) {
            return '';
        }
        /* @var $class LinkPager */
        $pager = $this->pager;
        $class = ArrayHelper::remove($pager, 'class', \metronic\widgets\LinkPager::className());
        $pager['pagination'] = $pagination;
        $pager['view'] = $this->getView();
        $pager['firstPageLabel'] = '首页';
        $pager['lastPageLabel'] = '尾页';

        return $class::widget($pager);
    }
}
