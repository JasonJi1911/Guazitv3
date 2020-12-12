<?php

namespace common\models\traits;
use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
/**
 * 搜索接口
 */
interface SearchInterface
{
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params);

    /**
     * Prepare search query
     *
     * @param ActiveQuery $query
     * @return ActiveQuery
     */
    public function prepareQuery($query);
}
