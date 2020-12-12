<?php

namespace admin\modules\manager\models;

use common\models\traits\SearchInterface;
use Yii;
use common\models\traits\SearchTrait;

/**
 * PermissionSearch represents the model behind the search form of `admin\modules\manager\models\Permission`.
 */
class PermissionSearch extends Permission implements SearchInterface
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid'], 'integer'],
            [['name'], 'trim'],
        ];
    }

    public function prepareQuery($query)
    {
        return $query->andFilterWhere(['pid' => $this->pid])
            ->andFilterWhere(['like', 'name', $this->name]);
    }
}
