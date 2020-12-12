<?php

namespace metronic\grid;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class ActionColumn extends \yii\grid\ActionColumn
{
    public $note;


    protected function initDefaultButtons()
    {
        $this->initDefaultButton2('view', 'eye', 'blue');
        $this->initDefaultButton2('update', 'edit', 'purple');
        $this->initDefaultButton2('delete', 'trash-o', 'dark', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
        $this->initDefaultButton2('toggle', '', 'purple');
        $this->initDefaultButton2('up', '', 'blue');
    }

    protected function initDefaultButton2($name, $iconName, $color, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $color, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = '编辑';
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        break;

                    case 'toggle': // 切换状态
                        if ($model->isEnabled) {  //启用状态
                            $title = '下线';
                            $iconName = 'times';
                            $color = 'red';
                            $url = Url::to(['active', 'id' => $model->primarykey, 'op' => 0]);
                        } else {
                            $title = '上线';
                            $iconName = 'plus';
                            $color = 'green';
                            $url = Url::to(['active', 'id' => $model->primarykey, 'op' => 1]);
                        }
                        break;

                    case 'up': // 置顶
                        $iconName = 'arrow-up';
                        $title = '置顶';
                        $url = Url::to(['up', 'id' => $model->primarykey]);
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                    'class' => 'btn btn-outline btn-circle btn-xs ' . $color,
//                    'check-permission' => true,
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('i', ' ' . $title, ['class' => "fa fa-$iconName"]);
                return Html::a($icon, $url, $options);
            };
        }
    }


    public function renderHeaderCell()
    {
        if ($this->note) { // 渲染提示信息
            $headContent = '<span class="data-column-span">' . $this->renderHeaderCellContent() . '</span>';
            $headContent .= '<img src="/images/note.png" class="data-column" title=' . $this->note .'>';
            return Html::tag('th', $headContent, $this->headerOptions);
        }
        return Html::tag('th', $this->renderHeaderCellContent(), $this->headerOptions);
    }
}
