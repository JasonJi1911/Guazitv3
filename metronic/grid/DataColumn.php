<?php

namespace metronic\grid;

use common\models\traits\StatusToggleInterface;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class DataColumn extends \yii\grid\DataColumn
{
    /**
     * @var bool
     */
    public $enableSorting = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->attribute[0] == '@') {
            $this->attribute = substr($this->attribute, 1);
            $this->value = function ($model, $key, $index, $grid) {
//                $staticAttribute = lcfirst(Inflector::pluralize(Inflector::camelize($this->attribute)));
                $staticAttribute = $this->attribute . 'Map';
                if (property_exists($model, $staticAttribute)) {

                    $text = ArrayHelper::getValue($model::$$staticAttribute, $model->getAttribute($this->attribute));

                    if ($this->attribute == 'status' && $model instanceof StatusToggleInterface) {
                        $this->format = 'raw';

                        $id = $model->primarykey; //主键

                        if ($model->isEnabled) {
                            return Html::a($text, ['active', 'id' => $id, 'op' => 0], ['class' => 'label label-sm label-success']);
                        } else {
                            return Html::a($text, ['active', 'id' => $id, 'op' => 1], ['class' => 'label label-sm label-danger']);
                        }
                    } else {
                        return $text;
                    }
                }

                if (substr($this->attribute, 0, 3) == 'is_') {
                    $this->format = 'boolean';
                }

                return ArrayHelper::getValue($model, $this->attribute);
            };
        }
    }
}
