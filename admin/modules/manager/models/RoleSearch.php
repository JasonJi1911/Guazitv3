<?php

namespace admin\modules\manager\models;

use Yii;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

/**
 * RoleSearch represents the model behind the search form of `admin\modules\manager\models\Role`.
 */
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
        return $query->andFilterWhere(['like', 'name', $this->name])
            ->orderBy(['id' => SORT_ASC]);
    }
}
