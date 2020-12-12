<?php
namespace admin\models\video\search;

use admin\models\video\VideoArea;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class VideoAreaSearch extends VideoArea implements SearchInterface
{
    use SearchTrait;

    public function rules()
    {
        return [
            [['area'], 'string']
        ];
    }

    public function prepareQuery($query)
    {
        return $query->andFilterWhere(['like', 'area', $this->area])
                ->addOrderBy(['display_order' => SORT_DESC]);
    }
}
