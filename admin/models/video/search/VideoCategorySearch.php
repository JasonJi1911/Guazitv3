<?php
namespace admin\models\video\search;

use admin\models\video\VideoCategory;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class VideoCategorySearch extends VideoCategory implements SearchInterface
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
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['channel_id' => $this->channel_id]);

        return $query;
    }
}
