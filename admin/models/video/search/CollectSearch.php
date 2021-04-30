<?php

namespace admin\models\video\search;

use admin\models\collect\Collect;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class CollectSearch extends Collect implements SearchInterface
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['collect_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function prepareQuery($query)
    {
        $query->andFilterWhere(['collect_id' => $this->collect_id]);

        return $query;
    }
}