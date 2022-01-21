<?php

namespace admin\models\video\search;

use admin\models\video\VideoUpdate;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class VideoUpdateSearch extends VideoUpdate implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [
            [['video_update_title_id'], 'integer'],
            [['status'], 'string'],
        ];
    }

    public function prepareQuery($query)
    {
        $query->andFilterWhere(['video_update_title_id' => $this->video_update_title_id, 'status' => $this->status]);

        return $query;
    }
}
