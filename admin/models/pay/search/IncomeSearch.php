<?php
namespace admin\models\pay\search;

use admin\models\pay\Order;
use yii\base\Model;
use yii\data\ArrayDataProvider;

class IncomeSearch extends Model
{
    /**
     * @var string 日期
     */
    public $date;
    /**
     * @var string 开始日期
     */
    public $start_date;
    /**
     * @var string 结束日期
     */
    public $end_date;

    private $_recharge;

    /**
     * 把搜索表单的名称置为空
     */
    public function formName()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_date', 'end_date'], 'safe'],
        ];
    }


    public function getRecharge()
    {
        if (!$this->_recharge) {
            $timestamp = strtotime($this->date);
            $recharges = Order::find()->select('total_fee')
                ->andWhere(['status' => Order::STATUS_SUCCESS, 'type' => Order::TYPE_COUPON])
                ->andWhere(['>=', 'created_at', $timestamp])
                ->andWhere(['<', 'created_at', $timestamp + 86400])
                ->column();

            $this->_recharge = [
                'times' => count($recharges),
                'fee'   => array_sum($recharges)
            ];
        }

        return $this->_recharge;
    }

    /**
     * 获取充值次数
     * @return integer
     */
    public function getRechargeTimes()
    {
        return $this->getRecharge()['times'];
    }

    /**
     * 获取充值金额
     * @return integer
     */
    public function getRechargeFee()
    {
        return $this->getRecharge()['fee'];
    }

    private $_vip;

    public function getVip()
    {
        if (!$this->_vip) {
            $timestamp = strtotime($this->date);

            $recharges = Order::find()->select('total_fee')
                ->andWhere(['status' => Order::STATUS_SUCCESS, 'type' => Order::TYPE_VIP])
                ->andWhere(['>=', 'created_at', $timestamp])
                ->andWhere(['<', 'created_at', $timestamp + 86400])
                ->column();

            $this->_vip = [
                'times' => count($recharges),
                'fee'   => array_sum($recharges)
            ];
        }

        return $this->_vip;
    }

    /**
     * 获取会员次数
     * @return integer
     */
    public function getVipTimes()
    {
        return $this->getVip()['times'];
    }

    /**
     * 获取会员金额
     * @return integer
     */
    public function getVipFee()
    {
        return $this->getVip()['fee'];
    }

    /**
     * 获取总金额
     * @return integer
     */
    public function getTotalFee()
    {
        return $this->rechargeFee + $this->vipFee;
    }

    public static function findByDate($start_date, $end_date)
    {
        $models = [];

        for ($timestamp = strtotime($end_date), $end = strtotime($start_date);
             $timestamp >= $end; $timestamp -= 86400) {

            $model = new static;
            $model->date = date('Y-m-d', $timestamp);

            $models[] = $model;
        }

        return $models;
    }

    /**
     * @inheritdoc
     */
    public function search($params)
    {
        $this->load($params);

        // 默认取最近20天（一页）
        if (!$this->start_date && !$this->end_date) {
            $this->start_date = date('Y-m-d', strtotime('-20 day'));
            $this->end_date   = date('Y-m-d');
        }

        $dataProvider = new ArrayDataProvider();
        $dataProvider->allModels = static::findByDate($this->start_date, $this->end_date);

        return $dataProvider;
    }

    /**
     * 分type统计总金额
     * @param $type
     * @return mixed
     */
    public function totalRecharge($type = '')
    {
        return Order::find()->select('total_fee')
            ->andWhere(['status' => Order::STATUS_SUCCESS])
            ->andFilterWhere(['type' => $type])
            ->sum('total_fee');
    }
}