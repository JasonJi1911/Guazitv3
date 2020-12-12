<?php
namespace  admin\controllers;

use admin\models\user\UserWatchLog;
use admin\models\video\Actor;
use admin\models\video\Banner;
use admin\models\video\Comment;
use admin\models\video\TopicVideo;
use admin\models\video\Video;
use admin\models\video\VideoActor;
use admin\models\video\VideoCategory;
use admin\models\video\VideoFavorite;
use admin\models\video\VideoUploadTask;
use api\exceptions\Exception;
use common\helpers\RedisKey;
use common\helpers\Tool;
use Yii;
use yii\web\Response;
use yii\web\UploadedFile;

class VideoController extends BaseController
{
    public $name = '影片';

    public $modelClass = 'admin\models\video\Video';
    public $searchModelClass = 'admin\models\video\search\VideoSearch';


    /**
     * 搜索、用于推荐位等处
     */
    public function actionSearch()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $keyword = Yii::$app->request->get('name');
        $channel_id = Yii::$app->request->get('channel_id', '');

        // 防止有0传入
        if (empty($channel_id)) {
            $channel_id = '';
        }

        $video = Video::find()
            ->andFilterWhere(['like', 'title', $keyword])
            ->andFilterWhere(['channel_id' => $channel_id])
            ->andWhere(['status' => Video::STATUS_ENABLED])
            ->orderBy(['id' => SORT_DESC]);
        // 检索词为空时，支取20条数据，防止一次性查出，页面卡顿，当有检索词时，返回所有符合条件数据
        if (empty($keyword)) {
            $video = $video->limit(20);
        }

        return $video->all();

    }

    /**
     * 搜索演员、用于视频处
     */
    public function actionActorSearch()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $actor_name = Yii::$app->request->get('q');

        $actors = Actor::find()
            ->andFilterWhere(['like', 'actor_name', $actor_name])
            ->orderBy(['weight' => SORT_DESC])
            ->limit(20)
            ->all();

        return [
            'incomplete_results' => false,
            'total_count' => count($actors),
            'items' => $actors
        ];
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     * 检索视频标签
     */
    public function actionCategorySearch()
    {
        $channelId = Yii::$app->request->post('channel_id');
        $data = VideoCategory::find()
            ->select('id, title')
            ->where(['channel_id' => $channelId])
            ->asArray()
            ->all();
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 影片上下架
     * @return Response
     * @throws \yii\db\Exception
     */
    public function actionShelve()
    {
        $id     = Yii::$app->request->get('video_id');
        $shelve = Yii::$app->request->get('shelve');

        $transaction = Yii::$app->db->beginTransaction();
        try {
            /**
             * @var $objVideo Video
             */
            $objVideo = Video::findOne(['id' => $id]);
            $objVideo->status = $shelve;
            if ($shelve == Video::STATUS_ENABLED) {
                $objVideo->issue_date = time();
            }
            $objVideo->save();
            //视频下架时 清理掉相关banner缓存
            $banner = Banner::find()->where(['action' => Banner::ACTION_VIDEO, 'content' => $id])->one();
            if ($banner) {
                Tool::clearCache(RedisKey::videoBanner($banner->channel_id));
            }
            
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * 批量操作
     */
    public function actionBatch()
    {
        $action = Yii::$app->request->get('action');
        $ids    = Yii::$app->request->post('ids');

        switch ($action) {

            case 'shelve':
                // 批量上架
                $result = Yii::$app->db->createCommand()->update(Video::tableName(), ['status' => Video::STATUS_ENABLED], ['id' => $ids])->execute();
                break;

            case 'unshelve':
                // 批量下架
                $result = Yii::$app->db->createCommand()->update(Video::tableName(), ['status' => Video::STATUS_DISABLED], ['id' => $ids])->execute();
                $this->clearVideoSeriesRel($ids);
                break;
            default:
                $result = false;
        }

        exit($result===false ? '0' : '1');
    }


    /**
     * 清理作品关联信息
     * @param $ids
     */
    private function clearVideoSeriesRel($ids)
    {
        VideoActor::deleteAll(['video_id' => $ids]); // 视频演员
        UserWatchLog::deleteAll(['video_id' => $ids]); // 观影记录
        VideoFavorite::deleteAll(['video_id' => $ids]); // 收藏
        Comment::deleteAll(['video_id' => $ids]); // 评论
        TopicVideo::deleteAll(['video_id' => $ids]); // 专题影视
    }


    /**
     * 上传作品
     * @return string
     */
    public function actionUpload()
    {
        set_time_limit(0);
        $model = new VideoUploadTask();

        $videoId = isset($_GET['video_id']) ? $_GET['video_id'] : 0;
        if (empty($videoId)) {
            return $this->redirect('/video-upload');
        }

        if ($model->load(Yii::$app->request->post())) {
            //作品上传操作
            $file = UploadedFile::getInstance($model, 'upload_file');
            if (!$file) {
                $model->addError('upload_file', '请上传一个文件');
                return $this->render('_upload', [
                    'model' => $model,
                ]);
            }

            // 截取后缀 带.
            $extension = substr($file->name, strrpos($file->name, '.'));
            $fileName = ROOT_DIR.'/uploads/'.md5(time()) . $extension;
            //将临时放到指定目录
            move_uploaded_file($file->tempName, $fileName);

            //记录章节分章任务
            $model->video_id = $videoId;
            $model->file     = $fileName;

            $model->save();

            $this->redirect(['/video-chapter/index', 'video_id' => $videoId,]);
        }

        return $this->render('_upload', [
            'model' => $model,
        ]);
    }


}
