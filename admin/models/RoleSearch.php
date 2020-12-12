<?php
namespace admin\models;

use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class RoleSearch extends Role implements SearchInterface
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function prepareQuery($query)
    {
        return $query->andFilterWhere(['like', 'name', $this->name]);
    }
}