<?php
namespace admin\models\stat\search;

use admin\models\stat\UserStat;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class UserStatSearch extends UserStat implements SearchInterface
{
    use SearchTrait;
    /**
     * @var string 开始日期
     */
    public $start_date;
    /**
     * @var string 结束日期
     */
    public $end_date;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_date', 'end_date'], 'safe'],
        ];
    }

    public function prepareQuery($query)
    {
        if (!$this->start_date && !$this->end_date) {
            $this->start_date = date('Y-m-d', strtotime('-6 day'));
            $this->end_date   = date('Y-m-d');
        }
        $query = $query->andFilterWhere(['>=', 'created_at', $this->start_date ? strtotime($this->start_date . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->end_date ? strtotime($this->end_date . ' 23:59:59') : null]);

        return $query->orderBy(['created_at' => SORT_DESC]);
    }
}