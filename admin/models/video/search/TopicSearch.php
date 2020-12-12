<?php
namespace admin\models\video\search;

use admin\models\video\Topic;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class TopicSearch extends Topic implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [
            [['name'], 'string']
        ];
    }

    public function prepareQuery($query)
    {
        return $query->andFilterWhere(['like', 'name', $this->name])
            ->addOrderBy(['display_order' => SORT_DESC]);
    }
}
