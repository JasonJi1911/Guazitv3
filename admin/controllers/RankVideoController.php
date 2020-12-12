<?php
namespace admin\controllers;

use Yii;
use admin\models\video\Rank;

class RankVideoController extends BaseController
{
    public $name = '排行榜影片';

    public $modelClass = 'admin\models\video\RankVideo';
    public $searchModelClass = 'admin\models\video\search\RankVideoSearch';


    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions =  parent::actions();

        $actions['create']['redirect'] = ['index', 'rank_id' => $this->rank->id];
        $actions['update']['redirect'] = ['index', 'rank_id' => $this->rank->id];

        return $actions;
    }

    /**
     * @inheritdoc
     */
    public function breadcrumbs()
    {
        $breadcrumbs = [];

        $rank = $this->rank;
        $this->name = '影片' . $this->name;

        foreach (['index', 'create', 'update'] as $actionID) {
            $breadcrumbs[$actionID][] = ['label' => '榜单管理', 'url' => ['rank/index']];
            $breadcrumbs[$actionID][] = ['label' => $rank->channel->channel_name, 'url' => ['index', 'rank_id' => $rank->id]];
            $breadcrumbs[$actionID][] = $this->getPageTitle($actionID);

        }


        return $breadcrumbs;
    }

    /**
     * @inheritdoc
     */
    public function actionButtons()
    {
        return [
            [
                'label'   => '新增排行榜影片',
                'url'     => ['create', 'rank_id' => $this->rank->id, 'channel_id' => $this->rank->channel_id],
                'options' => ['class' => 'btn green'],
            ],
        ];
    }

    public function actionEditButtons()
    {
        return [];
    }

    /**
     * 获取榜单
     * @return Rank
     */
    protected function getRank()
    {
        return Rank::findOne(Yii::$app->request->get('rank_id'));
    }

}
