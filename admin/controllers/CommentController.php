<?php
namespace admin\controllers;

use admin\models\video\Comment;
use Yii;

class CommentController extends BaseController
{
    public $name = '评论';

    public $modelClass = 'admin\models\video\Comment';
    public $searchModelClass = 'admin\models\video\search\CommentSearch';

    /**
     * @inheritdoc
     */
    public function actionButtons()
    {
        return [];
    }



    /**
     * 审核操作
     * @return \yii\web\Response
     */
    public function actionReview() {
        $id = Yii::$app->request->get('id');

        Comment::updateAll(['status' => Comment::STATUS_EXAMINE_YES], ['id' => $id]);
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * 批量审核
     */
    public function actionExamine()
    {
        $ids    = Yii::$app->request->post('ids');
        $result = Yii::$app->db->createCommand()
            ->update(Comment::tableName(), ['status' => Comment::STATUS_EXAMINE_YES], ['id' => $ids])
            ->execute();
        exit($result===false ? '0' : '1');
    }
}