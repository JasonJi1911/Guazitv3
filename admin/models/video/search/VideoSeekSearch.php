<?php
namespace admin\models\video\search;

use admin\models\video\VideoSeek;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class VideoSeekSearch extends VideoSeek implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [];
    }

    public function prepareQuery($query)
    {
        $query->addOrderBy(['created_at' => SORT_DESC]);
    }
}