<?php

namespace common\models\traits;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * 搜索Trait
 */
trait SearchTrait
{
    /**
     * 把搜索表单的名称置为空
     */
    public function formName()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function search($params)
    {
        $query = static::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => $this->prepareSort(),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query = $this->prepareQuery($query);

        return $dataProvider;
    }

    /**
     * @inheritdoc
     */
    public function prepareSort()
    {
        $sort = [];

        if ($this->hasAttribute('display_order')) { // 如果有display order，按照order 和 update 排序
            $sort['display_order'] = SORT_DESC;
        }

        if ($this->hasAttribute('updated_at')) {
//            $sort['updated_at'] = SORT_DESC;
        }

        if ($sort) { // 设置默认排序
            return [
                'defaultOrder' => $sort
            ];
        }

        return [];
    }

    /**
     * @inheritdoc
     */
    public function prepareQuery($query)
    {
        return $query;
    }

    public function searchModel($params)
    {
        $query = static::find();

        $this->load($params);

        $query = $this->prepareQuery($query);

        return $query->asArray()->all();
    }
}
