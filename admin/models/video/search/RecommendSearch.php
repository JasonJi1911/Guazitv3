<?php
namespace admin\models\video\search;

use admin\models\video\Recommend;
use admin\models\video\VideoChannel;
use common\models\traits\SchemeTrait;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class RecommendSearch extends Recommend implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [
            [['title'], 'string'],
            [['channel_id'], 'integer'],
        ];
    }

    public function prepareQuery($query)
    {
        $tvc = VideoChannel::tableName();
        $tvr = Recommend::tableName();

        $query = $query->joinWith('channel');
        return $query->andWhere([$tvc . '.status' => VideoChannel::STATUS_ENABLED])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['channel_id' => $this->channel_id])
            ->orderBy(['channel_id' => SORT_ASC, $tvr . '.display_order' => SORT_DESC]);
    }
}