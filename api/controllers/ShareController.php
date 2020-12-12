<?php
namespace api\controllers;

use api\dao\CommonDao;
use api\dao\VideoDao;
use api\logic\CommonLogic;
use api\logic\TaskLogic;
use api\logic\VideoLogic;
use api\models\user\TaskInfo;
use api\models\video\Actor;
use Yii;

class ShareController extends BaseController
{
    /**
     * 分享APP
     */
    public function actionApp()
    {
        $commonLogic = new CommonLogic();
        return [
            'title' => '立即扫码',
            'desc' => '海量热片,等你来看!',
            'qr_code' => $commonLogic->getDomain() . '/site/share-down',
            'button_word' => '若扫码失败,请输入网址' . $commonLogic->getDomain() . '/site/share-down',
        ];
    }

    /**
     * 分享奖励
     */
    public function actionAward()
    {
        $uid = Yii::$app->user->id;
        if ($uid) {
            $taskLogic = new TaskLogic();
            $taskLogic->finishTask(TaskInfo::TASK_ACTION_SHARE_APP, $uid);
        }
        return [
            'tip' => '分享成功'
        ];
    }

    /**
     * 影视分享
     * @return array
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionVideo()
    {
        $videoId = $this->getParamOrFail('video_id');

        $videoDao = new VideoDao();
        // 影视信息
        $videoInfo = $videoDao->videoInfo($videoId);
        // 演员信息
        $actorInfo = $videoDao->actorsInfo(explode(',', $videoInfo['actors_id']));

        $director = $actors = [];
        foreach ($actorInfo as &$actor) {  //循环影片所有的演员信息
            if ($actor['type'] == Actor::TYPE_ACTOR) {
                $actors[]   = $actor['actor_name'];
            } else {
                $director[] = $actor['actor_name'];
            }
        }

        $director = '导演:' . implode(' ', $director);
        $actors   = '演员:' . implode(' ', $actors);

        $commonLogic = new CommonLogic();
        return [
            'video_name' => $videoInfo['video_name'],
            'intro'      => $videoInfo['intro'],
            'cover'      => $videoInfo['cover'],
            'actors'     => $actors,
            'category'   => implode('/', explode(' ', $videoInfo['category'])),
            'qr_code'    => $commonLogic->getDomain() . '/site/share-down',
        ];
    }
}
