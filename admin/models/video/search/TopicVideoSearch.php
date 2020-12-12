<?php
namespace admin\models\video\search;


use admin\models\video\TopicVideo;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class TopicVideoSearch extends TopicVideo implements SearchInterface
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topic_id'], 'integer'],
            [['display_order'], 'string']
        ];
    }


    public function prepareSort()
    {
        return [];
    }

    public function prepareQuery($query)
    {
        $display_order = 'display_order desc';
        if ($this->display_order == 'asc') {
            $display_order = 'display_order asc';
        }
        return $query->andFilterWhere(['topic_id' => $this->topic_id])
            ->addOrderBy($display_order);
    }
}
