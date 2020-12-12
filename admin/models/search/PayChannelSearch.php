<?php
namespace admin\models\search;

use admin\models\pay\PayChannel;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class PayChannelSearch extends PayChannel implements SearchInterface
{
    use SearchTrait;

    public $pid;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid',], 'integer'],
            [['pid'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function prepareQuery($query)
    {
        if ($this->pid) {
            $query->andWhere(['pid' => $this->pid]);
        } else {
            $query->andWhere(['pid' => 0]);
        }

        return $query;
    }
}