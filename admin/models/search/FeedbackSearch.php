<?php
namespace admin\models\search;

use admin\models\Feedback;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class FeedbackSearch extends Feedback implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [
            [['contact'], 'string']
        ];
    }

    public function prepareQuery($query)
    {
        return $query->andFilterWhere(['like', 'contact', $this->contact]);
    }
}