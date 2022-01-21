<?php

namespace admin\models\video\search;

use admin\models\video\VideoUpdateTitle;
use admin\models\video\VideoChannel;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class VideoUpdateTitleSearch extends VideoUpdateTitle implements SearchInterface
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
        $tvr = VideoUpdateTitle::tableName();
        $query = $query->joinWith('channel');
        return $query->andFilterWhere([$tvr . '.status' => $this->status])
            ->andFilterWhere(['channel_id' => $this->channel_id])
            ->orderBy(['channel_id' => SORT_ASC, $tvr . '.display_order' => SORT_DESC]);
    }
}
