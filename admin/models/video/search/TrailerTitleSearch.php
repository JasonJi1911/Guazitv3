<?php

namespace admin\models\video\search;

use admin\models\video\TrailerTitle;
use admin\models\video\VideoChannel;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class TrailerTitleSearch extends TrailerTitle implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [
            [['status'], 'string'],
            [['channel_id'], 'integer'],
        ];
    }

    public function prepareQuery($query)
    {
//        $tvc = VideoChannel::tableName();
        $tvr = TrailerTitle::tableName();
        $query = $query->joinWith('channel');
        return $query->andFilterWhere([$tvr . '.status' => $this->status])
            ->andFilterWhere(['channel_id' => $this->channel_id])
            ->orderBy(['channel_id' => SORT_ASC, $tvr . '.display_order' => SORT_DESC]);
    }
}