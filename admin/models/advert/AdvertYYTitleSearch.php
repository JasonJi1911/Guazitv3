<?php

namespace admin\models\advert;

use common\models\traits\SearchInterface;
use admin\models\advert\AdvertYYTitle;
use common\models\traits\SearchTrait;
use yii\db\ActiveQuery;

class AdvertYYTitleSearch extends AdvertYYTitle implements SearchInterface
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    public function prepareQuery($query)
    {
        return $query;
    }
}