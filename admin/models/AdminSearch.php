<?php
namespace admin\models;

use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class AdminSearch extends Admin implements SearchInterface
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'trim'],
            [['role_id', 'status'], 'integer'],
        ];
    }

    public function prepareQuery($query)
    {
        // 关键词
        if ($this->username) {
            $query->andFilterWhere(['like', 'username', $this->username]);
        }
        return $query->andFilterWhere(['role_id' => $this->role_id])
            ->andFilterWhere(['status' => $this->status])
            ->addOrderBy(['created_at' => SORT_DESC]);
    }
}