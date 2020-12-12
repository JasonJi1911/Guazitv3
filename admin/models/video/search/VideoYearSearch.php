<?php
namespace admin\models\video\search;

use admin\models\video\VideoYear;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class VideoYearSearch extends VideoYear implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [
            [['year'],'string'],
        ];
    }

    public function prepareQuery($query)
    {
        return $query->andFilterWhere(['like', 'year', $this->year]);
    }
}