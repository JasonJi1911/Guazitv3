<?php
namespace admin\models\user\search;

use admin\models\user\TaskInfo;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class TaskInfoSearch extends TaskInfo implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [
            [['title'], 'trim'],
            [['task_type'], 'integer']
        ];
    }

    public function prepareQuery($query)
    {
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['task_type' => $this->task_type]);
    }
}
