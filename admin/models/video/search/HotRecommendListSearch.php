<?php
namespace admin\models\video\search;

use admin\models\video\HotRecommendList;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class HotRecommendListSearch extends HotRecommendList implements SearchInterface
{
    use SearchTrait;

    public $title;

    public function rules()
    {
        return [
            ['title', 'trim'],
            [['recommend_id'], 'integer']
        ];
    }


    public function prepareQuery($query)
    {
        $query->andWhere(['recommend_id' => $this->recommend_id]);
        $query->joinWith('video')
            ->andFilterWhere(['like', 'title', $this->title])
            ->addOrderBy(['display_order' => SORT_DESC]);
    }
}
