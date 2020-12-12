<?php
namespace admin\models\search;

use admin\models\user\UserMessage;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class UserMessageSearch extends UserMessage implements SearchInterface
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function prepareQuery($query)
    {
        $query->andFilterWhere(['type' => $this->type]);
        return $query->orderBy(['created_at' => SORT_DESC]);
    }
}
