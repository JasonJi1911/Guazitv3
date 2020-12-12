<?php
namespace admin\models\video\search;


use admin\models\video\Comment;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class CommentSearch extends Comment implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [
            [['source'], 'integer'],
        ];
    }


    public function prepareQuery($query)
    {
        return $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['source' => $this->source]);
    }

}