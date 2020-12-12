<?php
namespace admin\models\video\search;

use admin\models\video\Actor;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class ActorSearch extends Actor implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [
            [['area_id'], 'integer'],
            [['actor_name'],'string']
        ];
    }

    public function prepareQuery($query)
    {
        return $query->andFilterWhere(['area_id' => $this->area_id])
            ->andFilterWhere(['like','actor_name',$this->actor_name])
            ->addOrderBy(['weight' => SORT_DESC]);
    }
}
