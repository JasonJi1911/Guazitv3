<?php
namespace admin\models\video\search;

use admin\models\video\Video;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class VideoSearch extends Video implements SearchInterface
{
    use SearchTrait;

    public $keyword;

    public $order;

    public $flag;  //属性


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['keyword'], 'trim'],
            [['channel_id', 'category_ids', 'area', 'year', 'play_limit', 'status', 'is_finished', 'flag'], 'integer']
        ];
    }

    public function prepareQuery($query)
    {
        //关键词
        if ($this->keyword) {
            $query->andFilterWhere(['like', 'title', $this->keyword]);
        }

        if ($this->status == 2) {
            $this->status = Video::STATUS_DISABLED;
        }

        //筛选
        $query->andFilterWhere(['status' => $this->status])
              ->andFilterWhere(['is_finished' => $this->is_finished])
              ->andFilterWhere(['like', 'category_ids', $this->category_ids])
              ->andFilterWhere(['play_limit' => $this->play_limit])
              ->andFilterWhere(['area' => $this->area])
              ->andFilterWhere(['year' => $this->year]);

        if ($this->channel_id) {
            $query->andFilterWhere(['channel_id' => $this->channel_id]);
        }

        //属性
//        foreach (static::$playLimitMap as $value => $attribute) {
//            if ($this->flag == $value) {
//                if ($attribute == Video::PLAY_LIMIT_FREE) {
//                    $query->andFilterWhere([$attribute=>1]);
//                }elseif ($attribute == Video::PLAY_LIMIT_VIP) {
//                    $query->andFilterWhere([$attribute=>2]);
//                }elseif ($attribute == Video::PLAY_LIMIT_COUPON) {
//                    $query->andFilterWhere([$attribute=>3]);
//                }
//            }
//        }

        // 排序
        switch ($this->order) {
            case 2: $query->orderBy(['updated_at' => SORT_DESC]); break;
            default: $query->orderBy(['id' => SORT_DESC]); break;
        }

    }
}
