<?php
namespace admin\controllers;

use Yii;
use admin\models\video\HotRecommend;

class HotRecommendListController extends BaseController
{
    public $name = '热词';

    public $modelClass = 'admin\models\video\HotRecommendList';
    public $searchModelClass = 'admin\models\video\search\HotRecommendListSearch';


    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();

        $actions['create']['redirect'] = ['index', 'recommend_id' => $this->hot->recommend_id];
        $actions['update']['redirect'] = ['index', 'recommend_id' => $this->hot->recommend_id];

        return $actions;
    }


    public function actionButtons()
    {
        $recommend = Yii::$app->request->get('recommend_id');
        return [
            [
                'label'   => '新增影片',
                'url'     => ['create', 'recommend_id' => $recommend],
                'options' => ['class' => 'btn green'],
            ],
        ];
    }


    public function actionEditButtons()
    {
        return [];
    }


    /**
     * @inheritdoc
     */
    public function breadcrumbs()
    {
        $breadcrumbs = [];

        foreach (['index', 'create', 'update'] as $actionID) {
            $breadcrumbs[$actionID][] = ['label' => '热门搜索位管理', 'url' => ['hot-recommend/index']];
            $breadcrumbs[$actionID][] = '热词列表';
        }

        return $breadcrumbs;
    }

    /**
     * 获取热门
     *
     */
    protected function getHot()
    {
        return HotRecommend::findOne(Yii::$app->request->get('recommend_id'));
    }
}
