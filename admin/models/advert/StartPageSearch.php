<?php
namespace admin\models\advert;

use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class StartPageSearch extends StartPage implements SearchInterface
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function prepareQuery($query)
    {
        return [];
    }
}