<?php
namespace admin\models\video\search;


use admin\models\video\VideoChapter;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class VideoChapterSearch extends VideoChapter implements SearchInterface
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'trim'],
            [['video_id'], 'integer'],
            [['display_order'], 'string']
        ];
    }


    public function prepareSort()
    {
        return [];
    }


    public function prepareQuery($query)
    {
        //排序
        $order = 'display_order asc';
        if ($this->display_order == 'desc') {
            $order = 'display_order desc';
        }

        return $query->andFilterWhere(['video_id' => $this->video_id])
            ->andFilterWhere(['like', 'title', $this->title])
            ->orderBy($order);
    }
}