<?php
namespace admin\models\video\search;

use admin\models\video\VideoChannel;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class VideoChannelSearch extends VideoChannel implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [
            [['channel_name','is_kingkong'], 'string']
        ];
    }


    public function prepareQuery($query)
    {
        return $query->andFilterWhere(['is_kingkong' => $this->is_kingkong])
            ->andFilterWhere(['like', 'channel_name' , $this->channel_name])
            ->orderBy(['display_order' => SORT_DESC]);
    }

}