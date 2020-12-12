<?php
namespace api\dao;

use api\data\ActiveDataProvider;
use api\models\Answer;
use api\models\Feedback;
use Yii;
use yii\helpers\ArrayHelper;

class AnswerDao extends BaseDao
{
    /**
     * 问答列表
     */
    public function answerList()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Answer::find()
        ]);

        $data = $dataProvider->toArray();
        $data = ArrayHelper::index($data, null, 'type');
        $list = [];
        foreach ($data as $key => $item) {
            $list[] = [
                'name' => ArrayHelper::getValue(Answer::$typeMap, $key),
                'list' => $item
            ];
        }
        return $list;
    }

    /**
     * 反馈列表
     */
    public function feedbackList()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Feedback::find()
                ->andWhere(['uid' => Yii::$app->user->id])
                ->addOrderBy(['updated_at' => SORT_DESC])
        ]);
        
        return $dataProvider->setPagination()->toArray();
    }
}
