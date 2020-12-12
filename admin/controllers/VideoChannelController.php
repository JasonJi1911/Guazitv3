<?php
namespace admin\controllers;

use api\exceptions\Exception;
use Yii;
use admin\models\video\VideoChannel;

class VideoChannelController extends BaseController
{
    public $name = '频道';

    public $modelClass = 'admin\models\video\VideoChannel';
    public $searchModelClass = 'admin\models\video\search\VideoChannelSearch';

    /**
     * 设置首页推荐
     * @return \yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionKingkong()
    {
        $id     = Yii::$app->request->get('channel_id');
        $shelve = Yii::$app->request->get('is_kingkong');

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $objGiftInfo = VideoChannel::findOne(['id' => $id]);
            $objGiftInfo->is_kingkong = $shelve;
            $objGiftInfo->save();

            $kingkong = VideoChannel::find()->where(['is_kingkong' => 1])->count('is_kingkong');
//            if ($kingkong > 2 ){
//                throw new  Exception('KingKong No more');
//            }
            $transaction->commit();
        } catch (Exception $e){
            $transaction->rollBack();
            return $this->redirect(Yii::$app->request->referrer);
        }


        return $this->redirect(Yii::$app->request->referrer);
    }
}
