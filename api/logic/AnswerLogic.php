<?php
namespace api\logic;

use api\exceptions\ApiException;
use api\helpers\ErrorCode;
use api\models\Feedback;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\helpers\Tool;
use api\data\ActiveDataProvider;
use common\models\Answer;
use yii;

/**
 * 帮助问题逻辑处理层
 * Created by PhpStorm.
 */
class AnswerLogic
{
    /**
     * 添加意见反馈
     * @param string $content
     * @param string $imgs
     * @param string $contact
     * @return bool
     * @throws \api\exceptions\ApiException
     */
    public function addFeedback($content, $contact, $imgs)
    {
        // 并发锁限制
        $lockKey = RedisKey::getApiLockKey('answer/feedback', ['uid' => Yii::$app->user->id]);
        $redis = new RedisStore();
        if ($redis->checkLock($lockKey)) {
            throw new ApiException(ErrorCode::EC_SYSTEM_OPERATING);
        }

        $feedback = new Feedback();
        $feedback->content = $content;
        if ($imgs) { // 如果有图片
            // 格式化处理图片
            $imgs = explode('||', $imgs);
            $feedback->images = json_encode($imgs);
        }
        $feedback->contact = $contact;
        $feedback->uid     = Yii::$app->user->id;
        $feedback->source  = Yii::$app->common->source;
        $feedback->save();

        $redis->releaseLock($lockKey);
        return;
    }
}
