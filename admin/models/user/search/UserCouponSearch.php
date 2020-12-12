<?php
namespace admin\models\user\search;

use admin\models\user\UserCoupon;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class UserCouponSearch extends UserCoupon implements SearchInterface
{
    use SearchTrait;

    /**
     * @var string 关键词
     */
    public $keyword;
    /**
     * @var int 下单时间
     */
    public $time;
    /**
     * @var string 下单开始日期
     */
    public $start_date;
    /**
     * @var string 下单结束日期
     */
    public $end_date;

    /**
     * @var array 下单时间数组
     */
    public static $times = [1 => '今天', '昨天', '最近7天', '最近30天', '自定义时间'];


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['keyword'], 'trim'],
            [['time'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function prepareQuery($query)
    {
        // 关键词
        if ($this->keyword) {
            if (strlen($this->keyword) > 16) {
                $query->andWhere(['expend_no' => $this->keyword]);
            } else {
                $query->andWhere(['uid' => $this->keyword]);
            }
        }

        // 下单时间
        if (!$this->start_date && !$this->end_date) {
            switch ($this->time) {
                case 1:
                    $this->start_date = $this->end_date = date('Y-m-d');
                    break;

                case 2:
                    $this->start_date = $this->end_date = date('Y-m-d', strtotime('-1 day'));
                    break;

                case 3:
                    $this->start_date = date('Y-m-d', strtotime('-7 day'));
                    $this->end_date   = date('Y-m-d');
                    break;

                case 4:
                    $this->start_date = date('Y-m-d', strtotime('-30 day'));
                    $this->end_date   = date('Y-m-d');
                    break;

                default:
                    break;
            }
        } else {
            $this->time = 5;
        }

        // 其他搜索条件
        $query = $query->andFilterWhere(['type' => $this->type])
            ->andFilterWhere(['>=', 'created_at', $this->start_date ? strtotime($this->start_date . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->end_date ? strtotime($this->end_date . ' 23:59:59') : null]);

        return $query->orderBy(['created_at' => SORT_DESC]);
    }

}