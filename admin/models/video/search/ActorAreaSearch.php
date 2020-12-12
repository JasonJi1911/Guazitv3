<?php
namespace admin\models\video\search;

use admin\models\video\ActorArea;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class ActorAreaSearch extends ActorArea implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [];
    }

    public function prepareQuery($query)
    {
        $query->addOrderBy(['display_order' => SORT_DESC]);
    }
}