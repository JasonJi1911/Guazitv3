<?php
namespace admin\models\video\search;

use admin\models\video\Rank;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class RankSearch extends Rank implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [
            ['title', 'trim']
        ];
    }

    public function prepareQuery($query)
    {
        $query->andFilterWhere(['like', 'title', $this->title])
            ->addOrderBy(['display_order' => SORT_DESC]);
    }
}