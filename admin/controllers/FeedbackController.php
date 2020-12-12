<?php
namespace admin\controllers;

use admin\models\Feedback;
use admin\models\user\UserMessage;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use Yii;
use common\helpers\Tool;

class FeedbackController extends Controller
{
    public $name = '意见反馈';

    public $modelClass = 'admin\models\Feedback';
    public $searchModelClass = 'admin\models\search\FeedbackSearch';

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Feedback::find()
                ->orderBy('created_at desc')
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }


    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        $model = Feedback::findOne($id);
        if ($model) {
            $model->delete();
        }

        return $this->redirect('index');
    }

    // 回复
    public function actionReply()
    {
        $id = Yii::$app->request->get('id');
        $replyContent = Yii::$app->request->get('reply_content');  //回复内容
        $adminId = Yii::$app->user->identity->id; //管理员ID

        $feedbackInfo = Feedback::findOne(['id' => $id]);

        $t = Yii::$app->db->beginTransaction();
        try {
            Feedback::updateAll(['reply' => $replyContent, 'admin_id' => $adminId], ['id' => $id]);
            // 写入用户消息通知
           /* $content = $feedbackInfo->content;
            if(mb_strlen($content) > 20){
                $content = mb_substr($content, 0 , 20, 'UTF8') . '...';
            }*/

            UserMessage::sendMessageNotice($feedbackInfo->uid, UserMessage::TYPE_FEEDBACK_REPLY, $replyContent);
            $t->commit();
            return Tool::responseJson(0, '操作成功！');
        } catch(\Exception $e) {
            $t->rollBack();
            return Tool::responseJson(1, '操作失败！');
        }
    }
}
