<?php
namespace admin\models\video\search;

use admin\models\video\RankVideo;
use admin\models\video\Video;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class RankVideoSearch extends RankVideo implements SearchInterface
{
    use SearchTrait;

    public $title;

    public function rules()
    {
        return [
            ['title', 'trim'],
            [['rank_id', 'period'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function prepareQuery($query)
    {
        $query->andWhere(['rank_id' => $this->rank_id]);
        $query->joinWith('video')
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['period' => $this->period]);
    }
}