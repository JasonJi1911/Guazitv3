<?php
namespace admin\models\video\search;

use admin\models\video\HotRecommend;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class HotRecommendSearch extends HotRecommend implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [
            [['title'],'string'],
        ];
    }

    public function prepareQuery($query)
    {
        return $query->andFilterWhere(['like','title' , $this->title])
            ->addOrderBy(['display_order' => SORT_DESC]);
    }
}
