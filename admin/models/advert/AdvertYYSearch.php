<?php

namespace admin\models\advert;

use admin\models\advert\AdvertYY;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;
use yii\db\ActiveQuery;

class AdvertYYSearch extends AdvertYY implements SearchInterface
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['yy_id'], 'integer'],
        ];
    }

    public function prepareQuery($query)
    {
        $query->andFilterWhere(['yy_id' => $this->yy_id]);
        return $query;
    }
}