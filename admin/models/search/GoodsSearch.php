<?php
namespace admin\models\search;

use admin\models\pay\Goods;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class GoodsSearch extends Goods implements SearchInterface
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string'],
        ];
    }

    public function prepareQuery($query)
    {
        return $query->andWhere(['type' => $this->type])
            ->andFilterWhere(['like', 'title', $this->title])
            ->addOrderBy(['display_order' => SORT_DESC]);
    }
}
