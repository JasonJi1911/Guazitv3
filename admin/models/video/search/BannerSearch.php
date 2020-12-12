<?php
namespace admin\models\video\search;

use admin\models\video\Banner;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class BannerSearch extends Banner implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [
            [['status', 'action'], 'string']
        ];
    }

    public function prepareQuery($query)
    {
        return $query->andFilterWhere(['status' => $this->status, 'action' => $this->action]);
    }
}