<?php
namespace admin\models\user\search;

use admin\models\user\UserWatchLog;
use admin\models\video\Video;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class UserWatchLogSearch extends UserWatchLog implements SearchInterface
{
    use SearchTrait;

    /**
     * @var string 搜索关键词
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
        $tbV = Video::tableName();
        $tbL = UserWatchLog::tableName();
        $query->joinWith('video');

        // 关键词
        if ($this->keyword) {
            $query->andFilterWhere([
                'OR',
                ['like', $tbV . '.title', $this->keyword],
                ['uid' => $this->keyword]
            ]);
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
        };

        $query = $query->andFilterWhere(['>=', $tbL . '.created_at', $this->start_date ? strtotime($this->start_date . ' 00:00:00') : null])
                       ->andFilterWhere(['<=', $tbL . '.created_at', $this->end_date ? strtotime($this->end_date . ' 23:59:59') : null]);

        return $query->addOrderBy(['updated_at' => SORT_DESC]);
    }
}