<?php
namespace console\controllers;

use admin\models\video\Video;
use admin\models\video\VideoChapter;
use admin\models\video\VideoService;
use admin\models\video\VideoUploadTask;
use yii\web\Controller;

class VideoUploadTaskController extends Controller
{
    // 关闭csrf验证
    public $enableCsrfValidation = false;
    //文件锁
//    private $locke_file = './video-upload.lock';

    public function actionRun()
    {

        error_reporting(0);
        echo "\n " . date('Y/m/d H:i:s') . " start \n\n";
//        if (file_exists($this->locke_file)) {
//            exit('程序运行中');
//        }
//        //写文件锁
//        file_put_contents($this->locke_file,'lock');
        //查询任务
        $taskList = VideoUploadTask::find()->andWhere(['status' => VideoUploadTask::STATUS_UNTREATED])->all();

        //执行任务
        foreach ($taskList as $task) {

            $objVideo = Video::find()->andWhere(['id' => $task->video_id])->one();

            if (empty($objVideo)) {
                echo "影视ID" . $task->video_id . "影视不存在\n";
                $task->status = VideoUploadTask::STATUS_DONE;
                $task->save();
                continue;
            }

            //记录处理中
            $task->status = VideoUploadTask::STATUS_IN_HAND;
            $task->save();

            try {
                //判断新传续传
                if ($task->upload_type == VideoUploadTask::UPLOAD_TEXT_NEW) {
                    //清掉已有的剧集
                    VideoChapter::deleteAll(['video_id' => $objVideo->id]);
                }

                //开始上传处理
                $videoService = new VideoService($task->file, $task->video_id);

                $res = $videoService->handleExcel();
                $task->status = VideoUploadTask::STATUS_DONE;
                $task->save();

                //更新视频的总剧集数
                $totalChapter = VideoChapter::find()->andWhere(['video_id' => $task->video_id])->count();
                $objVideo->episode_num = $totalChapter;
                $objVideo->save();

            }catch (\Exception $e) {
                echo $e->getMessage()."\n";
            }

            
        }
        echo "\n " . date('Y/m/d H:i:s') . " end \n\n";
    }
}