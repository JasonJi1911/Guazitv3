<?php
namespace admin\models\search;

use admin\models\Announcement;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class AnnouncementSearch extends Announcement implements SearchInterface
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function prepareQuery($query)
    {
        return $query->andFilterWhere(['like', 'title', $this->title])
            ->orderBy(['updated_at' => SORT_DESC]);
    }
}