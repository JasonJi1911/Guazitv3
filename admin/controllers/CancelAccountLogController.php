<?php
namespace admin\controllers;
use admin\models\user\CancelAccountLog;
use admin\models\user\ExtractRecord;
use admin\models\user\User;
use admin\models\user\UserAssets;
use admin\models\user\UserAuthApp;
use admin\models\user\UserVip;
use common\helpers\Tool;
use Yii;
use yii\base\Exception;

class CancelAccountLogController extends BaseController
{
    public $name = '注销帐号审核';

    public $modelClass = 'admin\models\user\CancelAccountLog';
    public $searchModelClass = 'admin\models\user\search\CancelAccountLogSearch';

    /**
     * @inheritdoc
     */
    public function actionButtons()
    {
        return [];
    }

    public function actionView($id)
    {
        return $this->render('view', ['model' => CancelAccountLog::findOne($id)]);
    }

    /**
     * 审核操作
     * @return \yii\web\Response
     */
    public function actionHandle() {
        $id = Yii::$app->request->get('id');
        $status  = Yii::$app->request->get('status');
        $remark  = Yii::$app->request->get('remark');


        $transaction = Yii::$app->db->beginTransaction();
        try {
            $extractInfo = CancelAccountLog::findOne($id);
            $extractInfo->status = $status;
            if ($status == CancelAccountLog::STATUS_REJECT) {
                $extractInfo->remark = $remark;
            }
            $extractInfo->extract_at = time();
            $extractInfo->admin_id = Yii::$app->user->identity->id;//管理员ID
            $extractInfo->save();

            $user = User::findOne(['uid' => $extractInfo->uid]);
            if (!$user) {
                throw new Exception('empty user');
            }
            // 删除用户信息
            $user->deleted_at = time();
            $user->save();

            // 删除用户资产信息
            $userAssets = UserAssets::findOne(['uid' => $extractInfo->uid]);
            if ($userAssets) {
                $userAssets->deleted_at = time();
                $userAssets->save();
            }
            // 删除QQ微信授权信息
            UserAuthApp::deleteAll(['uid' => $extractInfo->uid]);
            // 删除用户vip信息
            $userVip = UserVip::findOne(['uid' => $extractInfo->uid]);
            if ($userVip) {
                $userVip->deleted_at = time();
                $userVip->save();
            }

            $transaction->commit();
            return Tool::responseJson(1, '操作成功！');
        } catch(\Exception $e) {
            $transaction->rollBack();
            return Tool::responseJson(1, '操作失败！');
        }

    }
}