<?php
namespace admin\models\video\search;


use admin\models\advert\Advert;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class AdvertSearch extends Advert implements SearchInterface
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position_id'], 'integer'],
            [['platform'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function prepareQuery($query)
    {
        $query->andFilterWhere(['position_id' => $this->position_id])
            ->andFilterWhere(['platform' => $this->platform]);

        return $query;
    }
}