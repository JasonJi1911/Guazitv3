<?php
namespace admin\widgets;
use yii\data\ArrayDataProvider;

class MyArrayDataProvider extends ArrayDataProvider
{
    protected function prepareModels()
    {
        if (($models = $this->allModels) === null) {
            return [];
        }

        if (($sort = $this->getSort()) !== false) {
            $models = $this->sortModels($models, $sort);
        }

        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $this->getTotalCount();

            if ($pagination->getPageSize() > 0) {
                // $models = array_slice($models, $pagination->getOffset(), $pagination->getLimit(), true);
                $models = array_slice($models, 0, $pagination->getLimit(), true);
            }
        }

        return $models;
    }
}