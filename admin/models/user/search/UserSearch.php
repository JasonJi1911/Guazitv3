<?php
namespace admin\models\user\search;

use admin\models\user\User;
use admin\models\user\UserVip;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class UserSearch extends User implements SearchInterface
{
    use SearchTrait;

    /**
     * @var string 关键词
     */
    public $keyword;

    public $vipStatus;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'source',  'gender', 'vipStatus'], 'integer'],
            [['keyword'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function prepareQuery($query)
    {
        $tbU = User::tableName();

        // 关键词
        if ($this->keyword) {
            $query->andFilterWhere([
                'OR',
                ['like', 'nickname', $this->keyword],
                [$tbU.'.uid' => $this->keyword],
                ['like', 'mobile', $this->keyword]
            ]);
        }

        if ($this->gender) {
            $query->andWhere([$tbU.'.gender' => $this->gender]);
        }

        // TODO 优化
        if ($this->vipStatus == 1) {
            $query->leftJoin(UserVip::tableName(), User::tableName() . '.uid=' . UserVip::tableName() . '.uid')
                ->andWhere([UserVip::tableName() . '.status' => $this->vipStatus])
                ->andWhere(['>=', UserVip::tableName() . '.end_time', time()]);
        } else if ($this->vipStatus == 2) { // 用户表和会员表不能直接连接查，只能把会员查出来，再来筛选非会员
            $vipUid = UserVip::find()
                ->select('uid')
                ->where(['>=', 'end_time', time()])
                ->column();
            $query->andWhere(['not in', 'uid', $vipUid]);
        }

        return $query->andFilterWhere([$tbU.'.status' => $this->status])
            ->andFilterWhere([$tbU.'.source' => $this->source])
            ->addOrderBy([$tbU.'.uid' => SORT_DESC]);
    }
}
