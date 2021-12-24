<?php

namespace admin\models\video\search;

use admin\models\video\Trailer;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class TrailerSearch extends Trailer implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [
            [['trailer_title_id'], 'integer'],
            [['status'], 'string'],
        ];
    }

    public function prepareQuery($query)
    {
        $query->andFilterWhere(['trailer_title_id' => $this->trailer_title_id, 'status' => $this->status]);

        return $query;
    }
}